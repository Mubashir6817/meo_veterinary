<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $customers = Customer::query();
            return DataTables::eloquent($customers)->addIndexColumn()
                ->addColumn('action', function ($customers) {
                    return '
                    <a href="' . route('customers.edit', $customers->id) . '" class="btn btn-primary btn-rounded btn-sm"><i class="fa fa-pencil-square"></i></a>
                    <a href="' . route('customers.view', $customers->id) . '" class="btn btn-success btn-rounded btn-sm"><i class="fa fa-eye"></i></a>
                    <form action="' . route('customers.destroy', $customers->id) . '" method="POST"
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
        return view('pharmacy.customer.index');
    }

    public function create()
    {
        return view('pharmacy.customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->phone_no = $request->phone_no;
        $customer->address = $request->address;
        $customer->save();
        return redirect()->route('customers.index')->with('custom_success', 'Customer has been Added Successfully!');
    }

    public function edit($id)
    {
        $customers = Customer::find($id);
        return view('pharmacy.customer.edit', compact('customers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->phone_no = $request->phone_no;
        $customer->address = $request->address;
        $customer->save();
        return redirect()->route('customers.index')->with('custom_success', 'Customer has been Updated Successfully!');
    }

    public function view($id)
    {
        $customers = Customer::find($id);
        return view('pharmacy.customer.view', compact('customers'));
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);

        // Check if exists in sales
        if ($customer->sales()->exists()) {
            return redirect()->route('customers.index')
                ->with('custom_errors', 'Cannot delete! This customer is already used in sales.');
        }

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('custom_success', 'Customer has been Deleted Successfully!');
    }
}
