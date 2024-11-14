<?php

namespace App\Http\Controllers;

use App\traits\savephoto;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use savephoto;
    public function test(){
        return $this->saveimage('kkkk','dfdgh',400,500);
    }
}
