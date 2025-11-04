<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Illuminate\Support\Facades\Auth;

use Auth;

class DeliveryManLoginController extends Controller
{
    public function getLoginForm()
    {
        if (Auth::check()) {

            return redirect('delivery-man/dashboard');
        } else {
            $po_hospital_details = Company::where('status', 1)->first();
            return view('deliveryMan.login', ['po_hospital_details' => $po_hospital_details]);
        }
    }
    public function checkLoginCredential(Request $request)
    {
        // dd(Auth::check());

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'

        ]);
        $credentials = $request->only('email', 'password');
        $credentials['user_type'] = 'dmn';
        if (Auth::attempt($credentials)) {
            return redirect('delivery-man/dashboard');
            // Authentication passed...

        }
        return back()->with('message', 'These credentials do not match our records');
    }
    public function logout()
    {
        //logout user
        auth()->logout();
        // redirect to homepage
        return redirect('delivery-man/login');
    }
}
