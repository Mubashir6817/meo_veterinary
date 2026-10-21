@extends('layouts.app')
@section('title')
    CUSTOMER (CREATE)
@endsection
@section('button')
    <a type="button" class="btn btn-primary" href="{{ route('customers.index') }}">
        <i class="fa fa-arrow-left"></i> Back
    </a>
@endsection
@section('content')
    <div class="card">
        <form action="{{ route('customers.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" class="form-control" placeholder="Enter Customer Name"
                                value="{{ old('name') }}" name="name" id="name">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="phone_no">Phone No</label>
                            <input type="number" class="form-control" placeholder="Enter Phone No"
                                value="{{ old('phone_no') }}" name="phone_no" id="phone_no">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="address">Address</label>
                            <input type="text" class="form-control" placeholder="Enter Address" value="{{ old('address') }}"
                                name="address" id="address">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection