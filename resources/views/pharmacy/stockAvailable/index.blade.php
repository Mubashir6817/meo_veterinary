@extends('layouts.app')
@section('title')
    STOCK-AVAILABLE (LIST)
@endsection
@section('button')
    
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
                            <th>Quantity</th>
                            <th>Rack No</th>
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
                    url: "{{ route('stock_available.index') }}"
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'medicines.name', name: 'medicinesname' },
                    { data: 'quantity', name: 'quantity' },
                    { data: 'rack_no', name: 'rack_no' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'd-flex' },
                ],
                initComplete: function () {
                    this.api().columns([1,2,3]).every(function () {
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