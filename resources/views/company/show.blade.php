@extends('layouts.master')

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6"><b>Company Details</b></div>
                <div class="col col-md-6">
                    <a href="{{ route('company.index') }}" class="btn btn-primary btn-sm float-end">View All</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <label class="col-sm-2 col-label-form"><b>Name</b></label>
                <div class="col-sm-10">
                    {{ $company->name }}
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-label-form">Address</label>
                <div class="col-sm-10">
                    <textarea name="address" class="form-control" readonly>{{ $company->address }}</textarea>
                </div>
            </div>
        </div>
    </div>

@endsection('content')
