<?php

namespace App\Services;

use App\Models\Company;
use App\Models\CustomField;
use Illuminate\Http\Request;

class CompanyService
{
    private $pagination = 10; // Example pagination value, adjust as needed

    public function index()
    {
        return Company::with('customFields')->paginate($this->pagination);
    }

    public function create()
    {
        return view('company.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        $company = Company::create($request->only('name', 'address'));

        $this->saveCustomFields($company, $request->custom_fields);

        return $company;
    }

    public function show($id)
    {
        return Company::with('customFields')->findOrFail($id);
    }

    public function edit($id)
    {
        return Company::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        $company = Company::findOrFail($id);
        $company->update($request->only('name', 'address'));

        $this->saveCustomFields($company, $request->custom_fields);

        return $company;
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        $company->customFields()->delete();
    }

    private function saveCustomFields(Company $company, $customFields)
    {
        if ($customFields) {
            foreach ($customFields as $field) {
                $company->customFields()->updateOrCreate(
                    ['id' => $field['field_id'] ?? null],
                    [
                        'field_name' => $field['field_name'],
                        'field_type' => $field['field_type'],
                        'field_value' => $field['field_value'],
                    ]
                );
            }
        }
    }
}
