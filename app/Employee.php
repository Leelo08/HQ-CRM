<?php

namespace App;
use App\Company;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function setPasswordAttribute($pass){

        $this->attributes['password'] = Hash::make($pass);
        }
}
