<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserMananagementController extends Controller
{
    public function index()
    {
        try {
            $users = User::paginate(10);

            return view('user-management.pages.userDetails', compact('users'));

        } catch (Exception $e) {
            Log::error('Failed to fetch users: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load users.');
        }
    }

    public function destroy($id)
    {
        try {
            // Prevent the logged-in user from deleting their own account
            if (Auth::id() == $id) {
                return redirect()->back()->with('error', 'You cannot delete your own account.');
            }

            // Find the user or fail
            $user = User::findOrFail($id);

            // Delete the user
            $user->delete();

            return redirect()->back()->with('success', 'User deleted successfully.');

        } catch (Exception $e) {
            // Log the error for debugging
            Log::error('Failed to delete User: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An unexpected error occurred while deleting the user.');
        }
    }
}
