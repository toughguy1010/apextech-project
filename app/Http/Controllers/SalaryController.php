<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalaryController extends Controller
{
    //
    public function createMonthSalary(){
        return view("layouts.salary.create-salary-month");
    }
    
}
