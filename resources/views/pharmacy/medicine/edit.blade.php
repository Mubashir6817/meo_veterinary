@extends('layouts.app')
@section('title')
    MEDICINE (EDIT)
@endsection
@section('button')
    <a type="button" class="btn btn-primary" href="{{ route('medicines.index') }}">
        <i class="fa fa-arrow-left"></i> Back
    </a>
@endsection
@section('content')
    <div class="card">
        <form action="{{ route('medicines.update', $medicines->id) }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" class="form-control" value="{{ $medicines->name }}" name="name" id="name">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="company_name">Company Name</label>
                            <input type="text" class="form-control" value="{{ $medicines->company_name }}" name="company_name" id="company_name">
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
