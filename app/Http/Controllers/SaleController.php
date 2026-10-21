<?php

namespace App\Http\Controllers;

use App\Models\AvailableStock;
use App\Models\Customer;
use App\Models\Medicine;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sales = Sale::select('sales.id', 'sales.customers_id', 'sales.sale_date', 'sales.total_amount', 'sales.discount', 'sales.net_amount', 'sales.paid_amount', 'sales.due_amount', 'sales.payment_status')->with('customer');
            return DataTables::eloquent($sales)->addIndexColumn()
                ->addColumn('customer_name', function ($sale) {
                    return $sale->customer ? $sale->customer->name : 'Walk-in Customer';
                })
                ->addColumn('action', function ($sale) {
                    return '
                    <a href="' . route('sales.view', $sale->id) . '" class="btn btn-success btn-rounded btn-sm mx-1"><i class="fa fa-eye"></i></a>
                    <form action="' . route('sales.destroy', $sale->id) . '" method="POST"
                        style="display:inline-block;" class="delete-form">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-rounded btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                ';
                })
                ->filterColumn('customername', function ($query, $keyword) {
                    $query->whereHas('customer', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->make(true);
        }
        return view('pharmacy.sale.index');
    }

    public function create()
    {
        $customers = Customer::select('id', 'name')->orderBy('name')->get();
        return view('pharmacy.sale.create', compact('customers'));
    }

    // Used by the sale create screen: when a medicine is selected,
    // return its available quantity and its latest sale price.
    public function getMedicineInfo($id)
    {
        $available = AvailableStock::where('medicines_id', $id)->first();
        $latestStockIn = StockIn::where('medicines_id', $id)->orderBy('id', 'desc')->first();

        return response()->json([
            'available_quantity' => $available ? (int) $available->quantity : 0,
            'sale_price' => $latestStockIn ? (int) $latestStockIn->sale_price : 0,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_date' => 'required|date',
            'customers_id' => 'nullable|exists:customers,id',
            'medicines_id' => 'required|array|min:1',
            'medicines_id.*' => 'required|exists:medicines,id',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',
            'sale_price' => 'required|array|min:1',
            'sale_price.*' => 'required|integer|min:0',
            'discount' => 'nullable|integer|min:0',
            'paid_amount' => 'nullable|integer|min:0',
        ]);

        // Server-side totals: never trust the totals coming from the browser.
        $totalAmount = 0;
        foreach ($request->medicines_id as $i => $medicineId) {
            $totalAmount += ((int) $request->quantity[$i]) * ((int) $request->sale_price[$i]);
        }

        $discount = (int) ($request->discount ?? 0);
        $paidAmount = (int) ($request->paid_amount ?? 0);
        $netAmount = $totalAmount - $discount;

        if ($discount > $totalAmount) {
            return redirect()->back()->withInput()
                ->with('custom_errors', 'Discount cannot be greater than the total amount.');
        }

        if ($paidAmount > $netAmount) {
            return redirect()->back()->withInput()
                ->with('custom_errors', 'Paid amount cannot be greater than the net amount.');
        }

        // Check stock for every item BEFORE deducting anything.
        // The same medicine can appear in more than one row, so add its rows together.
        $needed = [];
        foreach ($request->medicines_id as $i => $medicineId) {
            $needed[$medicineId] = ($needed[$medicineId] ?? 0) + (int) $request->quantity[$i];
        }

        foreach ($needed as $medicineId => $qty) {
            $available = AvailableStock::where('medicines_id', $medicineId)->first();
            $availableQty = $available ? (int) $available->quantity : 0;

            if ($qty > $availableQty) {
                $medicine = Medicine::find($medicineId);
                $medicineName = $medicine ? $medicine->name : 'Medicine';
                return redirect()->back()->withInput()
                    ->with('custom_errors', 'Not enough stock for ' . $medicineName . '. Available: ' . $availableQty . ', Required: ' . $qty . '.');
            }
        }

        if ($paidAmount >= $netAmount) {
            $paymentStatus = 'Paid';
        } elseif ($paidAmount > 0) {
            $paymentStatus = 'Partial';
        } else {
            $paymentStatus = 'Unpaid';
        }

        DB::transaction(function () use ($request, $totalAmount, $discount, $netAmount, $paidAmount, $paymentStatus) {
            $sale = new Sale();
            $sale->customers_id = $request->customers_id;
            $sale->sale_date = $request->sale_date;
            $sale->total_amount = $totalAmount;
            $sale->discount = $discount;
            $sale->net_amount = $netAmount;
            $sale->paid_amount = $paidAmount;
            $sale->due_amount = $netAmount - $paidAmount;
            $sale->payment_status = $paymentStatus;
            $sale->save();

            foreach ($request->medicines_id as $i => $medicineId) {
                $qty = (int) $request->quantity[$i];
                $price = (int) $request->sale_price[$i];

                $item = new SaleItem();
                $item->sales_id = $sale->id;
                $item->medicines_id = $medicineId;
                $item->quantity = $qty;
                $item->sale_price = $price;
                $item->subtotal = $qty * $price;
                $item->save();

                // Stock out: decrease the available stock.
                $available = AvailableStock::where('medicines_id', $medicineId)->first();
                $available->quantity = (int) $available->quantity - $qty;
                $available->save();
            }
        });

        return redirect()->route('sales.index')->with('custom_success', 'Sale has been Added Successfully!');
    }

    public function view($id)
    {
        $sale = Sale::with(['customer', 'items.medicines'])->find($id);
        return view('pharmacy.sale.view', compact('sale'));
    }

    public function destroy($id)
    {
        $sale = Sale::with('items')->find($id);

        DB::transaction(function () use ($sale) {
            // Give every sold quantity back to the available stock.
            foreach ($sale->items as $item) {
                $available = AvailableStock::where('medicines_id', $item->medicines_id)->first();
                if ($available) {
                    $available->quantity = (int) $available->quantity + (int) $item->quantity;
                    $available->save();
                } else {
                    $newStock = new AvailableStock();
                    $newStock->medicines_id = $item->medicines_id;
                    $newStock->quantity = $item->quantity;
                    $newStock->save();
                }
            }

            // sale_items are deleted automatically (onDelete cascade in the migration).
            $sale->delete();
        });

        return redirect()->route('sales.index')->with('custom_success', 'Sale has been Deleted Successfully and its stock has been restored!');
    }
}
