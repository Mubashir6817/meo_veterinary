@extends('layouts.app')
@section('title')
    SALE (VIEW) - INVOICE #{{ $sale->id }}
@endsection
@section('button')
    <a type="button" class="btn btn-primary" href="{{ route('sales.index') }}">
        <i class="fa fa-arrow-left"></i> Back
    </a>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label">Customer</label>
                        <input type="text" class="form-control"
                            value="{{ $sale->customer ? $sale->customer->name : 'Walk-in Customer' }}" disabled>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label">Sale Date</label>
                        <input type="text" class="form-control" value="{{ $sale->sale_date }}" disabled>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Medicine</th>
                            <th>Sale Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->items as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->medicines ? $item->medicines->name : '' }}</td>
                                <td>{{ $item->sale_price }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->subtotal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end">
                <div class="col-sm-4">
                    <div class="mb-3">
                        <label class="form-label">Total Amount</label>
                        <input type="number" class="form-control" value="{{ $sale->total_amount }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Discount</label>
                        <input type="number" class="form-control" value="{{ $sale->discount }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Net Amount</label>
                        <input type="number" class="form-control" value="{{ $sale->net_amount }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Paid Amount</label>
                        <input type="number" class="form-control" value="{{ $sale->paid_amount }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Due Amount</label>
                        <input type="number" class="form-control" value="{{ $sale->due_amount }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Status</label>
                        <input type="text" class="form-control" value="{{ $sale->payment_status }}" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
