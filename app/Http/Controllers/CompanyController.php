<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Events\NewCompanyEvent;
use Illuminate\Http\Request;
use App\Mail\NewCompanyMail;
use App\Employee;
use App\Company;
use App\User;
use DataTables;
use Validator;
use DB;
;


class CompanyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = Company::latest()->get();
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<button type="button"
                        name="show" id="'.$data->id.'"
                        class="show btn btn-primary
                        btn-sm">Show details</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('company.index');
    }

    
    public function create()
    {
        $company = new Company();

        return view('company.create', compact('company'));
    }

    public function store(Request $request)
    {     
        $this->authorize('create', Company::class);

        $newCompany = Company::create($this->createValidateRequest());

        $this->createStoreImage($newCompany);

        event(new NewCompanyEvent($newCompany));

        return redirect('company');
    }

    public function show(Company $company)
    {
        return view('company.show', compact('company'));
    }

    public function edit(Company $company)
    {
       return view('company.edit', compact('company'));
    }

    public function update(Company $company)
    {
        $this->authorize('update', $company);

        $company->update($this->updateValidateRequest($company));

        $this->updateStoreImage($company);

        return redirect('company/' . $company->id);
    }

    public function destroy($id)
    {
       $this->authorize('delete', Company::findOrFail($id));

       $data = Company::findOrFail($id);
       
       DB::delete('DELETE FROM employees WHERE company_id = "'.$id.'"');
       
       DB::delete('DELETE FROM users WHERE remember_token = "'.$id.'"');

       unlink(public_path('storage/') . $data->image);

       $data->delete();
    }

    private function createValidateRequest()
    {
        return request()->validate([
            'name' => 'required|max:191',
            'email' => 'required|email|unique:companies',
            'image' => 'required|file|image|max:2000|dimensions:width=100,height=100',
            'website' => 'required|max:191'
        ]);
    }

    private function updateValidateRequest($company){
        
        return tap(request()->validate([
            'name' => 'required|max:191',
            'email' => 'required|email|unique:companies,email,'.$company->id,
            'website' => 'required|max:191'

        ]), function()
            {
                if(request()->hasFile('image'))
                {
                    request()->validate([
                        'image' => 'file|image|max:2000|dimensions:width=100,height=100',
                    ]);
                }
            });
    }

    private function createStoreImage($company)
    {
        if(request()->has('image'))
        {   
            $company->update([
                'image' => request()->image->store('uploads','public'),
            ]);
        }
    }

    private function updateStoreImage($company)
    {
        if(request()->has('image'))
        {   
            unlink(public_path('storage/') . $company->image);
            $company->update([
                'image' => request()->image->store('uploads','public'),
            ]);
        }
    }
}
