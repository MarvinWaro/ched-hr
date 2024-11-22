<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_no',
        'first_name',
        'middle_name',
        'last_name',
        'birthdate',
        'gender',
        'marital_status',
        'address',
        'department',
        'payroll_position',
        'designation',
        'place_of_assignment',
        'office_mail',
        'personal_mail',
        'mobile_number',
        'tin',
        'gsis',
        'crn',
        'sss',
        'philhealth',
        'date_employed',
        'employment_status',
        'photo',  // Add photo field here
    ];

}



