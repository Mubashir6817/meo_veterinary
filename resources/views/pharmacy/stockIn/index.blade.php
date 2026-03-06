@extends('layouts.app')
@section('title')
    STOCK-IN (LIST)
@endsection
@section('button')
    <a type="button" class="btn btn-primary" href="{{ route('stock_in.create') }}">
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
                            <th>Name</th>
                            <th>Batch No</th>
                            <th>Stock In Date</th>
                            <th>Expiry Date</th>
                            <th>Purchase Price</th>
                            <th>Sale Price</th>
                            <th>Quantity</th>
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
                    url: "{{ route('stock_in.index') }}"
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'medicines.name', name: 'medicinesname' },
                    { data: 'batch_no', name: 'batch_no' },
                    { data: 'stock_in_date', name: 'stock_in_date' },
                    { data: 'expiry_date', name: 'expiry_date' },
                    { data: 'purchase_price', name: 'purchase_price' },
                    { data: 'sale_price', name: 'sale_price' },
                    { data: 'quantity', name: 'quantity' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'd-flex' },
                ],
                initComplete: function () {
                    this.api().columns([1,2,3,4,5,6,7]).every(function () {
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