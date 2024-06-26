<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CustomField;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $pagination = 2;
    public function index()
    {
        $companies = Company::with('customFields')
            ->paginate($this->pagination);
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Responses
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address'     =>  'required',
        ]);

        $company = Company::create($request->only('name', 'address'));

        foreach ($request->custom_fields as $field) {
            CustomField::create([
                'company_id' => $company->id,
                'field_name' => $field['field_name'],
                'field_type' => $field['field_type'],
            ]);
        }

        return redirect()->route('company.index')->with('success', 'Company Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);
        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);
        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'address'     =>  'required',
        ]);

        $company = Company::findOrFail($id);
        foreach ($request->custom_fields as $fieldData) {
            $company->customFields()->updateOrCreate(
                ['id' => $fieldData['field_id'] ?? null],
                ['field_name' => $fieldData['field_name'], 'field_type' => $fieldData['field_type']]
            );
        }
        $company->update($request->only('name', 'address'));

        return redirect()->route('company.index')->with('success', 'Company Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        $company->delete();

        return redirect()->back()->with('success', 'Company Deleted successfully.');
    }
}
