@extends('layouts.app')
@section('title')
    SALES (LIST)
@endsection
@section('button')
    <a type="button" class="btn btn-primary" href="{{ route('sales.create') }}">
        <i class="fa fa-arrow-right"></i> Create
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered m-0 datatable">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Sale Date</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Discount</th>
                            <th>Net Amount</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function () {
            let table = $('#datatable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('sales.index') }}"
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'sale_date', name: 'sale_date' },
                    { data: 'customer_name', name: 'customername' },
                    { data: 'total_amount', name: 'total_amount' },
                    { data: 'discount', name: 'discount' },
                    { data: 'net_amount', name: 'net_amount' },
                    { data: 'paid_amount', name: 'paid_amount' },
                    { data: 'due_amount', name: 'due_amount' },
                    { data: 'payment_status', name: 'payment_status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'd-flex' },
                ],
                initComplete: function () {
                    this.api().columns([1, 2, 8]).every(function () {
                        var column = this;
                        var input = $('<input type="text" class="bg-transparent color" placeholder="Search ' + column.header().textContent + '" />')
                            .appendTo($(column.footer()).empty())
                            .on('keyup change clear', function () {
                                if (column.search() !== this.value) {
                                    column.search(this.value).draw();
                                }
                            });
                    });
                }
            });

            $(document).on("submit", ".delete-form", function (e) {
                e.preventDefault();
                let form = this;

                confirmDelete(() => {
                    form.submit();
                });
            });

        });
    </script>
@endpush
