@extends('layouts.app')
@section('title')
    SALE (CREATE)
@endsection
@section('button')
    <a type="button" class="btn btn-primary" href="{{ route('sales.index') }}">
        <i class="fa fa-arrow-left"></i> Back
    </a>
@endsection
@section('content')
    <div class="card">
        <form action="{{ route('sales.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="customers_id">Customer</label>
                            <select class="form-select" name="customers_id" id="customers_id">
                                <option value="">Walk-in Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customers_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="sale_date">Sale Date</label>
                            <input type="date" class="form-control" value="{{ old('sale_date', date('Y-m-d')) }}"
                                name="sale_date" id="sale_date">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="items-table">
                        <thead>
                            <tr>
                                <th style="width:35%">Medicine</th>
                                <th>Available Qty</th>
                                <th>Sale Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="items-body">
                        </tbody>
                    </table>
                </div>

                <div class="mb-3">
                    <button type="button" class="btn btn-success btn-sm" id="add-row">
                        <i class="fa fa-plus"></i> Add Medicine
                    </button>
                </div>

                <div class="row justify-content-end">
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label">Total Amount</label>
                            <input type="number" class="form-control" id="total_amount" value="0" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="discount">Discount</label>
                            <input type="number" class="form-control" id="discount" name="discount"
                                value="{{ old('discount', 0) }}" min="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Net Amount</label>
                            <input type="number" class="form-control" id="net_amount" value="0" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="paid_amount">Paid Amount</label>
                            <input type="number" class="form-control" id="paid_amount" name="paid_amount"
                                value="{{ old('paid_amount', 0) }}" min="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Due Amount</label>
                            <input type="number" class="form-control" id="due_amount" value="0" readonly>
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

@push('scripts')
    <script>
        $(document).ready(function () {

            function initMedicineSelect(selectEl) {
                $(selectEl).select2({
                    placeholder: 'Select The Medicine',
                    ajax: {
                        url: "{{ route('getMedicine.all') }}",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return { term: params.term };
                        },
                        processResults: function (data) {
                            return { results: data.results };
                        },
                        cache: true
                    }
                });
            }

            function addRow() {
                let row = `
                    <tr class="item-row">
                        <td>
                            <select class="form-select medicine-select" style="width:100%;" name="medicines_id[]"></select>
                        </td>
                        <td>
                            <input type="number" class="form-control available-qty" value="0" readonly>
                        </td>
                        <td>
                            <input type="number" class="form-control sale-price" name="sale_price[]" value="0" min="0">
                        </td>
                        <td>
                            <input type="number" class="form-control quantity" name="quantity[]" value="1" min="1">
                        </td>
                        <td>
                            <input type="number" class="form-control subtotal" value="0" readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-row">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                $('#items-body').append(row);
                initMedicineSelect($('#items-body .item-row:last .medicine-select'));
            }

            function calculateTotals() {
                let total = 0;
                $('.item-row').each(function () {
                    let qty = parseInt($(this).find('.quantity').val()) || 0;
                    let price = parseInt($(this).find('.sale-price').val()) || 0;
                    let subtotal = qty * price;
                    $(this).find('.subtotal').val(subtotal);
                    total += subtotal;
                });

                let discount = parseInt($('#discount').val()) || 0;
                let net = total - discount;
                if (net < 0) net = 0;
                let paid = parseInt($('#paid_amount').val()) || 0;

                $('#total_amount').val(total);
                $('#net_amount').val(net);
                $('#due_amount').val(net - paid);
            }

            // First row on page load
            addRow();

            $('#add-row').on('click', function () {
                addRow();
            });

            $(document).on('click', '.remove-row', function () {
                if ($('.item-row').length > 1) {
                    $(this).closest('.item-row').remove();
                    calculateTotals();
                }
            });

            // When a medicine is selected, load its available qty + latest sale price
            $(document).on('change', '.medicine-select', function () {
                let row = $(this).closest('.item-row');
                let medicineId = $(this).val();
                if (!medicineId) return;

                let infoUrl = "{{ route('sales.medicineInfo', ':id') }}".replace(':id', medicineId);

                $.get(infoUrl, function (data) {
                    row.find('.available-qty').val(data.available_quantity);
                    row.find('.sale-price').val(data.sale_price);
                    calculateTotals();
                });
            });

            $(document).on('input', '.quantity, .sale-price, #discount, #paid_amount', function () {
                calculateTotals();
            });

            calculateTotals();
        });
    </script>
@endpush
