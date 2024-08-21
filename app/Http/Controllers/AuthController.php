<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credential = $request->only('email', 'password');
        $user = User::where('email', $credential['email'])->first();

        if($user && Hash::check($credential['password'], $user->password)) {
            Auth::login($user);
            return redirect()->intended('/dashboard')->with('success', 'Login Berhasil');
        } else {
            return redirect()->back()->with('error', 'Akun tidak terdaftar');
        }
        
        return redirect()->back()->with('error', 'Email atau password salah!');   
    }

    public function logout(Request $request) 
    {
        Auth::logout();

        return redirect('/')->with('success', 'Berhasil Logout');
    }
}