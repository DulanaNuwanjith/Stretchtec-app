<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleFilter extends Controller
{
    public function adminCheck()
    {
        // get the user details from the session
        $user = session('user');

        // check if the user is logged in
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        // check if the user has the 'admin' role
        if ($user->role === 'admin') {
            // allow access to the admin dashboard
            return view('admin.dashboard');
        } elseif ($user->role === 'user') {
            // allow access to the user dashboard
            return view('user.dashboard');
        } else {
            // deny access for other roles
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }
    }
}
