@extends('layouts.app')
@section('title')
    STOCK-IN (EDIT)
@endsection
@section('button')
    <a type="button" class="btn btn-primary" href="{{ route('stock_in.index') }}">
        <i class="fa fa-arrow-left"></i> Back
    </a>
@endsection
@section('content')
    <div class="card">
        <form action="{{ route('stock_in.update', $stock_in->id) }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="medicine_name">Medicined Name</label>
                            <select id="single-select" class="form-select medicine_name" style="width:100%;" name="medicines_id">
                                    @foreach ($medicines as $supplier)
                                        <option value="{{ $supplier->id }}" @selected($stock_in->medicines_id == $supplier->id)>{{ $supplier->name }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="batch_no">Batch No</label>
                            <input type="text" class="form-control" placeholder="Enter Batch No"
                                value="{{ $stock_in->batch_no }}" name="batch_no" id="batch_no">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="stock_in_date">Stock-In Date</label>
                            <input type="date" class="form-control" placeholder="Enter Stock-In Date" value="{{ $stock_in->stock_in_date }}"
                                name="stock_in_date" id="stock_in_date">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="expiry_date">Med Expiry Date</label>
                            <input type="date" class="form-control bt-datepicker solid" placeholder="Enter Expiry Date" value="{{ $stock_in->expiry_date }}"
                                name="expiry_date" id="expiry_date">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="purchase_price">Purchase Price</label>
                            <input type="number" class="form-control" placeholder="Enter Purchase Price" value="{{ $stock_in->purchase_price }}"
                                name="purchase_price" id="purchase_price">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="sale_price">Sale Price</label>
                            <input type="number" class="form-control" placeholder="Enter Sale Price" value="{{ $stock_in->sale_price }}"
                                name="sale_price" id="sale_price">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="quantity">Quantity</label>
                            <input type="number" class="form-control" placeholder="Enter Quantity" value="{{ $stock_in->quantity }}"
                                name="quantity" id="quantity">
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


@push('scripts')
    <script>
        $(document).ready(function () {
            $('.medicine_name').select2({
                placeholder: 'Select The Medicine',
                ajax: {
                    url: "{{ route('getMedicine.all') }}", 
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term 
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@endpush