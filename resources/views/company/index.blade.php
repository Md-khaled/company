@extends('layouts.master')

@section('content')

    @if($message = Session::get('success'))

        <div class="alert alert-success">
            {{ $message }}
        </div>

    @endif


    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6"><b>Company Details</b></div>
                <div class="col col-md-6">
                    <a href="{{ route('company.create') }}" class="btn btn-success btn-sm float-end">Add</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Fields Name</th>
                    <th width="30%">Action</th>
                </tr>
                @if(count($companies) > 0)

                    @foreach($companies as $company)

                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $company->name }}</td>

                            <td>{{ $company->address }}</td>
                            <td>
                                @if($company->customFields->count())
                                    {{ $company->customFields->pluck('field_name')->implode(', ') }}
                                @endif
                            </td>
                            <td>
                                <form method="post" action="{{ route('company.destroy', $company->id) }}" onsubmit="return confirm('Are you sure?')">
                                    <a href="{{ route('company.show', $company->id) }}"
                                       class="btn btn-primary btn-sm">View</a>
                                    <a href="{{ route('company.edit', $company->id) }}"
                                       class="btn btn-warning btn-sm">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-danger btn-sm" value="Delete"/>
                                </form>

                            </td>
                        </tr>

                    @endforeach

                @else
                    <tr>
                        <td colspan="5" class="text-center">No Data Found</td>
                    </tr>
                @endif
            </table>
            {!! $companies->links() !!}
        </div>
    </div>

@endsection
