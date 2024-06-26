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
                <fieldset>

                    @if (isset($company) && $company->customFields->isNotEmpty())
                        @foreach ($company->customFields as $index => $field)

                            <div class="row mb-3">
                                <label class="col-sm-2 col-label-form">Field Name {{$loop->index + 1}}</label>
                                <div  class="col-sm-10">
                                    <input type="hidden" name="custom_fields[{{ $index }}][field_id]" class="form-control" value="{{ $field->id }}" required>
                                    <input type="text" name="custom_fields[{{ $index }}][field_name]" class="form-control" value="{{ $field->field_name }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-label-form">Field Type {{$loop->index + 1}}</label>
                                <div class="col-sm-10">
                                    <select name="custom_fields[{{ $index }}][field_type]" class="form-control">
                                        @foreach (config('custom_fields.field_types') as $value => $label)
                                            <option value="{{ $value }}" {{ $field->field_type == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    @else
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
                    @endif

                </fieldset>
                <div id="custom-fields"></div>
                <button type="button" class="btn btn-secondary float-left" id="add-custom-field">Add Custom Field</button>
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="Update" />
                </div>
            </form>
        </div>
    </div>
@endsection('content')

@push('scripts')
    <script>
        $(document).ready(function() {
            let customFieldIndex = {{ isset($company) ? $company->customFields->count() + 1 : 1 }};
            console.log(customFieldIndex)

            $('#add-custom-field').click(function() {
                const customFieldHtml = `
                <div class="form-group mb-1 custom-field">
                 <div class="row mb-3">
                        <label class="col-sm-2 col-label-form">Field Nam - ${customFieldIndex}</label>
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
