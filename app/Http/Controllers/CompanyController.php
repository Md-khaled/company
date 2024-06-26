<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateReques;
use App\Services\CompanyService;

class CompanyController extends Controller
{
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index()
    {
        $companies = $this->companyService->index();
        return view('company.index', compact('companies'));
    }

    public function create()
    {
        return $this->companyService->create();
    }

    public function store(CompanyCreateRequest $request)
    {
        $company = $this->companyService->store($request);
        return redirect()->route('company.index')->with('success', 'Company added successfully.');
    }

    public function show($id)
    {
        $company = $this->companyService->show($id);
        return view('company.show', compact('company'));
    }

    public function edit($id)
    {
        $company = $this->companyService->edit($id);
        return view('company.edit', compact('company'));
    }

    public function update(CompanyUpdateReques $request, $id)
    {
        $company = $this->companyService->update($request, $id);
        return redirect()->route('company.index')->with('success', 'Company updated successfully.');
    }

    public function destroy($id)
    {
        $this->companyService->destroy($id);
        return redirect()->back()->with('success', 'Company deleted successfully.');
    }
}
