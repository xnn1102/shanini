<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    //
    public function register()
    {
    	return view('home.register.register',['title'=>'前台的注册页面']);
    }
}
