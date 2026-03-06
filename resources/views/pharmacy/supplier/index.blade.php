@extends('layouts.app')
@section('title')
    SUPPLIERS (LIST)
@endsection
@section('button')
    <a type="button" class="btn btn-primary" href="{{ route('suppliers.create') }}">
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
                            <th>Phone No.</th>
                            <th>Address</th>
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
                    url: "{{ route('suppliers.index') }}"
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'phone_no', name: 'phone_no' },
                    { data: 'address', name: 'address' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
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