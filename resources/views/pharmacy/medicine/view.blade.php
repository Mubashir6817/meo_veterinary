@extends('layouts.app')
@section('title')
    MEDICINE (VIEW)
@endsection
@section('button')
    <a type="button" class="btn btn-primary" href="{{ route('medicines.index') }}">
        <i class="fa fa-arrow-left"></i> Back
    </a>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" class="form-control" value="{{ $medicines->name }}" name="name" id="name" disabled>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label" for="company_name">Company Name</label>
                        <input type="text" class="form-control" value="{{ $medicines->company_name }}" name="company_name"
                            id="company_name" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection