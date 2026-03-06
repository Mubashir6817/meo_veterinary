<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use function Laravel\Prompts\select;

class MedicineController extends Controller
{
    //

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $medicines = Medicine::query();
            return DataTables::eloquent($medicines)->addIndexColumn()
                ->addColumn('action', function ($medicines) {
                    return '
                    <a href="' . route('medicines.edit', $medicines->id) . '" class="btn btn-primary btn-rounded btn-sm"><i class="fa fa-pencil-square"></i></a>
                    <a href="' . route('medicines.view', $medicines->id) . '" class="btn btn-success btn-rounded btn-sm"><i class="fa fa-eye"></i></a>
                    <form action="' . route('medicines.destroy', $medicines->id) . '" method="POST"
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
        return view('pharmacy.medicine.index');
    }
    public function create()
    {
        return view('pharmacy.medicine.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'company_name' => [
                'required',
                Rule::unique('medicines')->where(function ($query) use ($request) {
                    $query->where('name', $request->name);
                }),
            ]
        ]);

        $medicine = new Medicine();
        $medicine->name = $request->name;
        $medicine->company_name = $request->company_name;
        $medicine->save();
        return redirect()->route('medicines.index')->with('custom_success', ' Medicine has been Added Successfully!');
    }


     public function edit($id)
    {
        $medicines = Medicine::find($id);
        return view('pharmacy.medicine.edit', compact('medicines'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'company_name' => [
                'required',
                Rule::unique('medicines')->where(function ($query) use ($request) {
                    $query->where('name', $request->name);
                }),
            ]
        ]);

        $medicine = Medicine::find($id);
        $medicine->name = $request->name;
        $medicine->company_name = $request->company_name;
        $medicine->save();
        return redirect()->route('medicines.index')->with('custom_success', ' Medicine has been Updated Successfully!');
    }

      public function view($id)
    {
        $medicines = Medicine::find($id);
        return view('pharmacy.medicine.view', compact('medicines'));
    }
    public function destroy($id)
    {
        $medicine = Medicine::find($id);
        $medicine->delete();
        return redirect()->route('medicines.index')->with('custom_success', ' Medicine has been Deleted Successfully!');
    }



}
