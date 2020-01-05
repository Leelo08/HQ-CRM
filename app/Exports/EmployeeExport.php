<?php

namespace App\Exports;

use App\Employee;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromQuery, WithHeadings
{
    protected $id;

    function __construct($id) {

            $this->id = $id;
    }

    public function query()
    {
        return Employee::where('company_id', '=', $this->id)
                        ->select('firstname', 'lastname', 'email', 'password', 'phone');
    }

    public function headings(): array
    {
        return
        [  
            'firstname',
            'lastname',
            'email',
            'password',
            'phone',
        ];
    }

}
