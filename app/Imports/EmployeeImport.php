<?php

namespace App\Imports;

use App\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Validator;

class EmployeeImport implements ToCollection, WithHeadingRow
{

    protected $id;

    function __construct($id) {

            $this->id = $id;
    }


    public function collection(Collection  $rows)
    {

        Validator::make($rows->toArray(), [
            '*.firstname' => 'required|max:191',
            '*.lastname' => 'required|max:191',
            '*.email' => 'required|unique:employees',
            '*.password' => 'required|min:6',
            '*.phone' => 'phone:PH',
        ])->validate();

        // If validation fails, it won't reach the next statement.

        foreach ($rows as $row) {
            Employee::create([
                'firstname'     => $row['firstname'],
                'lastname'     => $row['lastname'],
                'email'    => $row['email'], 
                'password' => Hash::make($row['password']),
                'phone'     => $row['phone'],
                'company_id' => $this->id
            ]);
        }
    }
}
