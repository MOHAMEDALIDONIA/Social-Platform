<?php
namespace App\traits;

use Illuminate\Http\Request;


Trait apiTraits {
    public function ReturnErrorMessage($message,$NumError){
        return response()->json([
           'status'=>'flase',
           'message'=>$message,
           'number'=>$NumError
        ]);
  }
  public function ReturnSuccessMessage($message = "",$NumSuccess = "0000"){
          return response()->json([
          'status'=>'true',
          'message'=>$message,
          'number'=>$NumSuccess
          ]);
  }
  public function ReturnData($key,$value,$message = "",$NumSuccess ='00000'){
          return response()->json([
              'status'=>'true',
              'message'=>$message,
              'number'=>$NumSuccess,
               $key=>$value
          ]);
  }   

}
?>