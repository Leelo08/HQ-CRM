<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function export($id) 
    {
        $company = Company::findOrFail($id);
        return Excel::download(new EmployeeExport($id), $company->name . '.xlsx');
    }

    public function import($id) 
    {
        $this->authorize('create', Company::class);

        $this->ValidateRequest($id);

        return back();
    }

    private function ValidateRequest($id){
        
        if(request()->hasFile('file'))
        {
            Excel::import(new EmployeeImport($id),request()->file('file'));
        }
        else
        {
            request()->validate([
                'file' => 'file|required',
            ]);
        }
    }
}
