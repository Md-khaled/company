@extends('layouts.master')

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6"><b>Edit Company</b></div>
                <div class="col col-md-6">
                    <a href="{{ route('company.index') }}" class="btn btn-primary btn-sm float-end">Back</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('company.update', $company->id) }}">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" value="{{ $company->name }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Address</label>
                    <div class="col-sm-10">
                        <textarea name="address" class="form-control">{{ $company->address }}</textarea>
                    </div>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="Update" />
                </div>
            </form>
        </div>
    </div>
@endsection('content')
