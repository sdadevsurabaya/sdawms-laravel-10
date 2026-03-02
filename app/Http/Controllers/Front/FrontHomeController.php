<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FrontHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('front.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required',
        ]);

        if (auth()->attempt(['username' => $request->username, 'password' => $request->password])) {
            if (auth()->user()->role_id == 1) {
                return redirect()->route('admin.dashboard');
            } else if (auth()->user()->role_id == 2) {
                return redirect()->route('gudang.dashboard');
            }
        } else {
            return redirect()->route('front.login')
                ->with('error', 'Username atau Password salah.');
        }
    }

    public function logout(Request $request)
    {
        try {
            if (Auth::check()) {
                // Log the user out
                Auth::logout();

                // Invalidate the session
                $request->session()->invalidate();

                // Regenerate the CSRF token
                $request->session()->regenerateToken();

                return redirect()->route('front.login');
            }

            // If the user is not logged in, redirect to sign-in page
            return redirect()->route('front.login');
        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());

            return redirect()->route('front.login');
        }
    }
}
