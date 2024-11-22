<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_no')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('birthdate');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('address');
            $table->string('department');
            $table->string('payroll_position');
            $table->string('designation');
            $table->string('place_of_assignment');
            $table->string('office_mail')->nullable();
            $table->string('personal_mail');
            $table->string('mobile_number')->nullable();
            $table->string('tin')->nullable();
            $table->string('gsis')->nullable();
            $table->string('crn')->nullable();
            $table->string('sss')->nullable();
            $table->string('philhealth')->nullable();
            $table->date('date_employed');
            $table->string('employment_status');

            // Add a column for the photo
            $table->string('photo')->nullable(); // Add this line

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('employees');
    }
}


