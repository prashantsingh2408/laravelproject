<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Validator;

class Userdata extends Controller
{
    function getdata($name = null){
    
    	$data = Employee::select('*')->get();
    	return  $data;


    }

    function savedata(Request $req){

    	$data = new Employee;

    	$data->name = $req->name;
    	$data->email = $req->email;

    	$result = $data->save();
    	if ($result) {
    		return ['status'=>'success'];
    	}else{
    		return ['status'=>'failed'];
    	}

    }

    function updatedata(Request $req){
    	$data = Employee::find($req->id);
    	$data->name = $req->name;
    	$data->email= $req->email;
    	$result = $data->save();
    	if ($result) {
    		return ['status'=>'success'];
    	}else{
    		return ['status'=>'failed'];
    	}
    }

    function apivalidation_f(Request $req){
    	$rules  = array('name' => 'required');

    	$validator = Validator::make($req->all(),$rules);
    	if ($validator->fails()) {
    		return $validator->errors();
    	}else{
    		return ['status'=>'success'];
    	}
    }
}
