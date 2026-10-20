<?php

namespace App\Http\Controllers;

use App\Models\AvailableStock;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AvailableStockController extends Controller
{
    //

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $stock_available = AvailableStock::select('available_stocks.id', 'available_stocks.medicines_id', 'available_stocks.quantity', 'available_stocks.rack_no')->with('medicines');
            return DataTables::eloquent($stock_available)->addIndexColumn()
                ->addColumn('action', function ($stock_available) {
                    return '
                    <a href="' . route('stock_available.edit', $stock_available->id) . '" class="btn btn-primary btn-rounded btn-sm"><i class="fa fa-pencil-square"></i></a> 
                ';
                })
                ->filterColumn('medicinesname', function ($query, $keyword) {
                    $query->whereHas('medicines', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->make(true);
        }
        return view('pharmacy.stockAvailable.index');
    }

    public function edit($id){
        $stock_available = AvailableStock::find($id);
        return view('pharmacy.stockAvailable.edit', compact('stock_available'));
    }

    public function update(Request $request, $id)
    {
        $stock_available = AvailableStock::find($id);
        $stock_available->rack_no = $request->rack_no;
        $stock_available->save();
        return redirect()->route('stock_available.index')->with('custom_success', 'Stock Available has been Updated Successfully!');
    }
}
