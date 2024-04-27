<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show Login Page
    public function showLogin()
    {
        return view('pages.login');
    }

    // Show Register Page
    public function showRegister()
    {
        return view('pages.register');
    }

    // Register User

    public function postRegister(Request $request)
    {
        
        $request->validate([
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

       $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // login

        Auth::login($user);

        return back()->with('success', 'successfully Registered');


    }
        // login
        public function postLogin(Request $request)
        {
            // Validate
          $details =  $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            // Attempt to login
            if (Auth::attempt($details))
            {
                return redirect()->intended('/');

            }
            
            // Redirect back with error
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            
            ]);
        }

    
    // Logout User
    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
    }
