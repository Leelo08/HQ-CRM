<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Company;
use App\User;
use DataTables;
use Validator;
use DB;

class EmployeeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = Employee::latest()->get();
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
        return view('employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();

        $employee = new Employee();

        return view('employee.create', compact('employee', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Employee::class);

        $newEmployee = Employee::create($this->createValidateRequest());

        $fullname = $newEmployee->firstname . ' ' . $newEmployee->lastname;
        $user = new User();
        $user->id = $newEmployee->id;
        $user->name = $fullname;
        $user->email = $newEmployee->email;
        $user->password = $newEmployee->password;
        $user->remember_token = $newEmployee->company_id;
        $user->save();

        return redirect('employee');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return view('employee.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $companies = Company::all();

        return view('employee.edit', compact('employee', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Employee $employee)
    {
        $this->authorize('update', $employee);
        
        $employee->update($this->updateValidateRequest($employee));

        $user = User::where('id', '=', $employee->id)->firstOrFail();

        $user->email = $employee->email;
        $user->password = $employee->password;
        $user->remember_token = $employee->company_id;
        $user->save(); 

        return redirect('employee/' . $employee->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Employee::findOrFail($id));
        
        $data = Employee::findOrFail($id);
       
        DB::delete('DELETE FROM users WHERE id = "'.$id.'"');

        $data->delete();
    }

    private function createValidateRequest()
    {
        return request()->validate([
            'firstname' => 'required|max:191',
            'lastname' => 'required|max:191',
            'email' => 'required|email|unique:employees|unique:users',
            'company_id' => 'required',
            'password' => 'required|min:6',
            'phone' => 'required|phone:PH',
        ]);
    }

    private function updateValidateRequest($employee){
        
        return request()->validate([
            'firstname' => 'required|max:191',
            'lastname' => 'required|max:191',
            'email' => 'required|email|unique:employees,email,'.$employee->id,
            'email' => 'unique:users,email,'.$employee->id,
            'company_id' => 'required',
            'password' => 'sometimes|min:6',
            'phone' => 'phone:PH',
        ]);
    }
}
