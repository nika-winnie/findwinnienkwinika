<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected $guard = 'admin';
    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->input();

            if(Auth::attempt(['email' => $data['email'],'password' => $data['password'], 'admin' => 1 ])){
                //echo 'i am here';exit();
                return redirect('/admin/dashboard');
            }else{

                return redirect('/admin')->with('flash_message_error','Invalid username or password');
            }
        }
        return view('admin.admin_login');
    }

    public function dashboard(){
        return view('admin.dashboard');
    }
    //
}
