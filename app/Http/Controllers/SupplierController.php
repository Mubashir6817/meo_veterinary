<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    //

    public function index(Request $request) {
         if ($request->ajax()) {
            $suppliers = Supplier::query();
            return DataTables::eloquent($suppliers)->addIndexColumn()
                ->addColumn('action', function ($suppliers) {
                    return '
                    <a href="' . route('suppliers.edit', $suppliers->id) . '" class="btn btn-primary btn-rounded btn-sm"><i class="fa fa-pencil-square"></i></a>
                    <a href="' . route('suppliers.view', $suppliers->id) . '" class="btn btn-success btn-rounded btn-sm"><i class="fa fa-eye"></i></a>
                    <form action="' . route('suppliers.destroy', $suppliers->id) . '" method="POST"
                        style="display:inline-block;" class="delete-form">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-rounded btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>   
                ';
                })
                ->make(true);
        }
        return view('pharmacy.supplier.index');
    }
    public function create() {
        return view('pharmacy.supplier.create');
    }
    public function store(Request $request) {
        $request->validate([
            'name' => 'required'
        ]);

        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->phone_no = $request->phone_no;
        $supplier->address = $request->address;
        $supplier->save();
        return redirect()->route('suppliers.index')->with('custom_success','Supplier has been Added Successfully!');
    }
    public function edit($id) {
        $suppliers = Supplier::find($id);
        return view('pharmacy.supplier.edit', compact('suppliers'));
    }
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required'
        ]);

        $supplier = Supplier::find($id);
        $supplier->name = $request->name;
        $supplier->phone_no = $request->phone_no;
        $supplier->address = $request->address;
        $supplier->save();
        return redirect()->route('suppliers.index')->with('custom_success','Supplier has been Update Successfully!');
    }

     public function view($id) {
        $suppliers = Supplier::find($id);
        return view('pharmacy.supplier.view', compact('suppliers'));
    }
     public function destroy($id) {
        $suppliers = Supplier::find($id);
        $suppliers->delete();
        return redirect()->route('suppliers.index')->with('custom_success','Supplier has been Delete Successfully!');
    }
}
