<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Userdata extends Controller
{
    function login(Request $request){
    
    	$rules =  array('checksum' =>'required' ,'value' => 'required');
    	$validate_req = Validator::make($request->all(),$rules);
    	if ($validate_req->fails()) {
    		return response($validate_req->errors());
    	}else{	

    	$decrypted_data = $this->datadecrypt($request->value);

    	if ($decrypted_data) {
    		$checksum_verify= $this->checksum_verify($decrypted_data,$request->checksum);
    		if ($checksum_verify) {
    			
    			$data_array =  json_decode($decrypted_data);


    			$user = User::where('mobile', $data_array->mobile)->first();

		            if (!$user || !Hash::check($data_array->pwd, $user->password)) {
		                return response([
		                    'message' => ['These credentials do not match our records.']
		                ], 404);
		            }
        
		            $token = $user->createToken($user['id'])->plainTextToken;
		        
		            $return_data = [
		                "responseStatus"=>"0",
		                "successOrErrorMsg"=>"Success",
		                'id' =>base64_encode($user['id']),
		                'tokenResponse' => ['token'=> $token , 'tokenType' => '', 'message' => 'Success']
		            ];

		            $encrypted_data = $this->dataencrypt(json_encode($return_data));
		            $checksum_generate = $this->checksum_generate(json_encode($return_data));
		            $response = [
		            	"code"=>200,
		            	"checkSum" => $checksum_generate,
		            	"apiKey" => null,
		            	"errOrSuccessMessage" => "Success",
		            	"value" => $encrypted_data,
		            	"localDateTime"=>time()
		            ];


             		return response($response, 200);
             
    		}else{
    			return ['error'=>'Something went wrong!!'];
    		}
    	}else{
    		return ['error'=>'Something went wrong!!'];
    
}
}
}

    

    private function checksum_verify($data,$checksum){
    	$stringify_jsondata = $data;
		$checksum = openssl_digest($stringify_jsondata , "sha256");

		if (strtoupper($checksum) == strtoupper($checksum)) {
			return true;
		}else{
			return false;
		}

	}
	  private function checksum_generate($data){
    	$stringify_jsondata = $data;
		$checksum = openssl_digest($stringify_jsondata , "sha256");
		if ($checksum) {
			return strtoupper($checksum);
		}else{
			return false;
		}

	}
	private function datadecrypt($data){
			$encryptionKey = env('SECRET_KEY');
			$iv = env('SECRET_VI');
			$result = openssl_decrypt(base64_decode($data), 'aes-256-cbc', $encryptionKey, OPENSSL_RAW_DATA, $iv);
			if ($result) {
			return $result;
		}else{
			return false;
		}
	}

	private function dataencrypt($data){
		$encryptionKey = env('SECRET_KEY');
		$iv = env('SECRET_VI');
		$result = openssl_encrypt($data, 'aes-256-cbc', $encryptionKey, OPENSSL_RAW_DATA, $iv);
		if ($result) {
			return base64_encode($result);
		}else{
			return false;
		}

		
	}


}
