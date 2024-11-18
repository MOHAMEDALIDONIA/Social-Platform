<?php
namespace App\traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


Trait apiTraits {
    public function ReturnErrorMessage($message,$NumError){
        return response()->json([
           'status'=>'flase',
           'message'=>$message,
           'number'=>$NumError
        ]);
  }
  public function ReturnSuccessMessage($message = "",$NumSuccess = "200"){
          return response()->json([
          'status'=>'true',
          'message'=>$message,
          'number'=>$NumSuccess
          ]);
  }
  public function ReturnData($key,$value,$message = "",$NumSuccess ='200'){
          return response()->json([
              'status'=>'true',
              'message'=>$message,
              'number'=>$NumSuccess,
               $key=>$value
          ]);
  }   
  public function ReturnValidationError($request,$rules){

        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()) {
          return $this->ReturnErrorMessage($validation->messages()->first(),'422');
        }
  }

}
?>