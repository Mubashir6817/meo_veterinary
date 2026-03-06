@extends('layouts.app')
@section('title')
    SUPPLIER (VIEW)
@endsection
@section('button')
    <a type="button" class="btn btn-primary" href="{{ route('suppliers.index') }}">
        <i class="fa fa-arrow-left"></i> Back
    </a>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" class="form-control" placeholder="Enter Medicine Name"
                            value="{{ $suppliers->name }}" name="name" id="name" disabled>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label" for="phone_no">Phone No</label>
                        <input type="number" class="form-control" placeholder="Enter Phone No"
                            value="{{ $suppliers->phone_no }}" name="phone_no" id="phone_no" disabled>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label" for="address">Address</label>
                        <input type="text" class="form-control" placeholder="Enter Address"
                            value="{{ $suppliers->address }}" name="address" id="address" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection