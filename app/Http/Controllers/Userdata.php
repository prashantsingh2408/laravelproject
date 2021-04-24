<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class Userdata extends Controller
{
    function getdata(){
    
    	$data = Employee::all();
    	return  ['amar' => 'is name', 'soni' =>['id' => '10']];


    }
}
