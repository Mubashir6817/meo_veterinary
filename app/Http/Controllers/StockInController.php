<?php

namespace App\Http\Controllers;

use App\Models\AvailableStock;
use App\Models\Medicine;
use App\Models\StockIn;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StockInController extends Controller
{
    //

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $stock_in = StockIn::select('stock_ins.id', 'stock_ins.medicines_id', 'stock_ins.batch_no', 'stock_ins.stock_in_date', 'stock_ins.expiry_date', 'stock_ins.purchase_price', 'stock_ins.sale_price', 'stock_ins.quantity')->with('medicines');
            return DataTables::eloquent($stock_in)->addIndexColumn()
                ->addColumn('action', function ($stock_in) {
                    return '
                    <a href="' . route('stock_in.edit', $stock_in->id) . '" class="btn btn-primary btn-rounded btn-sm"><i class="fa fa-pencil-square"></i></a>
                    <a href="' . route('stock_in.view', $stock_in->id) . '" class="btn btn-success btn-rounded btn-sm mx-1"><i class="fa fa-eye"></i></a>
                    <form action="' . route('stock_in.destroy', $stock_in->id) . '" method="POST"
                        style="display:inline-block;" class="delete-form">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-rounded btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>   
                ';
                })
                ->filterColumn('medicinesname', function ($query, $keyword) {
                    $query->whereHas('medicines', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->make(true);
        }
        return view('pharmacy.stockIn.index');
    }

    public function getMedicine(Request $request)
    {
        $search = $request->input('term');

        $data = Medicine::when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
            ->limit(10)
            ->get(['id', 'name as text']);

        return response()->json(['results' => $data]);
    }

    public function create()
    {
        return view('pharmacy.stockIn.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'medicines_id' => 'required',
            'stock_in_date' => 'required',
            'expiry_date' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'quantity' => 'required'
        ]);

        $stock_in = new StockIn();
        $stock_in->medicines_id = $request->medicines_id;
        $stock_in->batch_no = $request->batch_no;
        $stock_in->stock_in_date = $request->stock_in_date;
        $stock_in->expiry_date = $request->expiry_date;
        $stock_in->purchase_price = $request->purchase_price;
        $stock_in->sale_price = $request->sale_price;
        $stock_in->quantity = $request->quantity;
        $stock_in->save();





        // Step 2: Check in available stock
        $available = AvailableStock::where('medicines_id', $request->medicines_id)->first();

        if ($available) {
            // Already exists → increase quantity
            $available->quantity += $request->quantity;
            $available->save();
        } else {
            // Not exists → create new
            
            $newStock = new AvailableStock();
            $newStock->medicines_id = $request->medicines_id;
            $newStock->quantity = $request->quantity;
            $newStock->save();
        }




        return redirect()->route('stock_in.index')->with('custom_success', 'Stock In has been Added Successfully!');
    }


    public function edit($id)
    {
        $stock_in = StockIn::find($id);
        $medicines = Medicine::select('id', 'name')->get();
        return view('pharmacy.stockIn.edit', compact('medicines', 'stock_in'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'medicines_id' => 'required',
            'stock_in_date' => 'required',
            'expiry_date' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'quantity' => 'required'
        ]);

        $stock_in = StockIn::find($id);
        $stock_in->medicines_id = $request->medicines_id;
        $stock_in->batch_no = $request->batch_no;
        $stock_in->stock_in_date = $request->stock_in_date;
        $stock_in->expiry_date = $request->expiry_date;
        $stock_in->purchase_price = $request->purchase_price;
        $stock_in->sale_price = $request->sale_price;
        $stock_in->quantity = $request->quantity;
        $stock_in->save();


                // Step 2: Check in available stock
        $available = AvailableStock::where('medicines_id', $request->medicines_id)->first();

        if ($available) {
            // Already exists → increase quantity
            $available->quantity += $request->quantity;
            $available->save();
        } else {
            // Not exists → create new
            
            $newStock = new AvailableStock();
            $newStock->medicines_id = $request->medicines_id;
            $newStock->quantity = $request->quantity;
            $newStock->save();
        }


        return redirect()->route('stock_in.index')->with('custom_success', 'Stock In has been Updated Successfully!');
    }

    public function destroy($id)
    {
        $stock_in = StockIn::find($id);
        $stock_in->delete();
        return redirect()->route('stock_in.index')->with('custom_success', 'Stock In has been Deleted Successfully!');
    }
}
