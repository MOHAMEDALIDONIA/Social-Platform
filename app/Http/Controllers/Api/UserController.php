<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\traits\apiTraits;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use apiTraits;
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index','store');
    }
    public function index(){
     return  $this->ReturnSuccessMessage("success");
    }
    public function store(){
       return $this->ReturnSuccessMessage("success");
    }
    public function delete(){
      return  $this->ReturnSuccessMessage("success");
    }
    public function update(){
       return $this->ReturnSuccessMessage("success");
    }
}
