@extends('layouts.master')

@section('content')

    @if($errors->any())

        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

    @endif

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6"><b>Add Company</b></div>
                <div class="col col-md-6">
                    <a href="{{ route('company.index') }}" class="btn btn-primary btn-sm float-end">Back</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('company.store') }}">
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form"><Com></Com> Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Address</label>
                    <div class="col-sm-10">
                        <textarea name="address" class="form-control"></textarea>
                    </div>
                </div>
                <fieldset id="address-fields">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-label-form">Field Name</label>
                        <div  class="col-sm-10">
                            <input type="text" name="custom_fields[0][field_name]" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-label-form">Field Type</label>
                        <div class="col-sm-10">
                            <select name="custom_fields[0][field_type]" class="form-control">
                                @foreach (config('custom_fields.field_types') as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-label-form">Field Value</label>
                        <div  class="col-sm-10">
                            <input type="text" name="custom_fields[0][field_value]" class="form-control" required>
                        </div>
                    </div>
                    <div id="custom-fields"></div>

                    <button type="button" class="btn btn-secondary pull-right" id="add-custom-field">Add Custom Field</button>
                </fieldset>

                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="Add" />
                </div>
            </form>
        </div>
    </div>
@endsection('content')

@push('scripts')
    <script>
        $(document).ready(function() {
            let customFieldIndex = {{ isset($company) ? $company->customFields->count() : 1 }};

            $('#add-custom-field').click(function() {
                const customFieldHtml = `
                <div class="form-group mb-1 custom-field">
                 <div class="row mb-3">
                        <label class="col-sm-2 col-label-form">Field Name - ${customFieldIndex}</label>
                        <div  class="col-sm-10">
                            <input type="text" name="custom_fields[${customFieldIndex}][field_name]" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-label-form">Field Type - ${customFieldIndex}</label>
                        <div class="col-sm-10">
                            <select name="custom_fields[${customFieldIndex}][field_type]" class="form-control">
                        @foreach (config('custom_fields.field_types') as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                </select>
        </div>
        <div class="row mb-3">
                        <label class="col-sm-2 col-label-form">Field Value - ${customFieldIndex}</label>
                        <div  class="col-sm-10">
                            <input type="text" name="custom_fields[${customFieldIndex}][field_value]" class="form-control" required>
                        </div>
                    </div>
    </div>
                <button type="button" class="btn btn-sm btn-danger mt-2 float-end remove-custom-field">Remove</button>

                </div>


`;
                $('#custom-fields').append(customFieldHtml);
                customFieldIndex++;
            });

            $(document).on('click', '.remove-custom-field', function() {
                $(this).parent('.custom-field').remove();
            });
        });
    </script>
@endpush
