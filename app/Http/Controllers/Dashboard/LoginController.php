<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{

    public function index(){
        if (Auth::guard('admin')->check())
        {
            return redirect('ar/dashboard');
        }
        return view('dashboard.login');
    }

    public function login(Request $request)
    {
        if (Auth::guard('admin')->attempt(['email'=>$request->email, 'password'=>$request->password])){
            return redirect('ar/dashboard');
        }
        flashy()->error(__('dashboard.login_fail'));
        return back();
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        return redirect(route('admin.login'));
    }
}
