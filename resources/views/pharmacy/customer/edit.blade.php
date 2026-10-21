@extends('layouts.app')
@section('title')
    CUSTOMER (EDIT)
@endsection
@section('button')
    <a type="button" class="btn btn-primary" href="{{ route('customers.index') }}">
        <i class="fa fa-arrow-left"></i> Back
    </a>
@endsection
@section('content')
    <div class="card">
        <form action="{{ route('customers.update', $customers->id) }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" class="form-control" placeholder="Enter Customer Name"
                                value="{{ $customers->name }}" name="name" id="name">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="phone_no">Phone No</label>
                            <input type="number" class="form-control" placeholder="Enter Phone No"
                                value="{{ $customers->phone_no }}" name="phone_no" id="phone_no">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="address">Address</label>
                            <input type="text" class="form-control" placeholder="Enter Address" value="{{ $customers->address }}"
                                name="address" id="address">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection