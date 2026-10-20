@extends('layouts.app')
@section('title')
    STOCK-AVAILABLE (EDIT)
@endsection
@section('button')
    <a type="button" class="btn btn-primary" href="{{ route('stock_available.index') }}">
        <i class="fa fa-arrow-left"></i> Back
    </a>
@endsection
@section('content')
    <div class="card">
        <form action="{{ route('stock_available.update', $stock_available->id) }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="rack_no">Rack No.</label>
                            <input type="text" class="form-control" placeholder="Enter Medicine Name"
                                value="{{ $stock_available->rack_no }}" name="rack_no" id="rack_no">
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