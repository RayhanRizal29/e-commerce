<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    //

    public function register()
    {
        return view('auth.register');
    }

    /**
     * Store a new user.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:250'],
            'email' => ['required', 'email', 'max:250', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
            'role' => 'required|string|in:admin,user',
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'], 
        ]);
    
        // Redirect setelah registrasi berhasil
        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    public function login()
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            if (Auth::user()->role === 'admin') {
                return redirect()->route('products.index');
            }
    
            return redirect()->route('auth.dashboard');
        }
    
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);

        // if (!Auth::attempt($credentials)) {
        //     return back()->withErrors([
        //         'email' => 'Your provided credentials do not match in our records.',
        //     ])->onlyInput('email');
        // }

        // return to_route('products.index')
        //     ->withSuccess('You have successfully logged in!');
    }

    /**
     * Display a dashboard to authenticated users.
     */
    public function dashboard()
    {
        return view('auth.dashboard');
    }

    /**
     * Log out the user from application.
     *
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login')
            ->withSuccess('You have logged out successfully!');;
    }
}
