<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected $guard = 'admin';
    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->input();

            if(Auth::attempt(['email' => $data['email'],'password' => $data['password'], 'admin' => 1 ])){
                Session::put('adminSession', $data['email']);
                return redirect('/admin/dashboard');
            }else{

                return redirect('/admin')->with('flash_message_error','Invalid username or password');
            }
        }
        return view('admin.admin_login');
    }

    public function dashboard(){if(Session::has('adminSession')){
            // Perform all actions
        }else{
            //return redirect()->action('AdminController@login')->with('flash_message_error', 'Please Login');
            return redirect('/admin')->with('flash_message_error','Please Login to access the page you are looking for');
        }
        return view('admin.dashboard');
    }

    public function logout(){
        Session::flush();
        return redirect('/admin')->with('flash_message_success', 'Logged out successfully.');

    }
}
