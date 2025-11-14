<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /**
     * Display a listing of users for password reset.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $users = User::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                           ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(15)
            ->appends(['search' => $search]);

        return view('admin.resetpassword.reset-password', compact('users'));
    }

    /**
     * Reset user password to custom password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Prevent resetting admin password
        if ($user->role === 'admin') {
            return redirect()->route('admin.reset-password.index')
                ->with('error', 'Cannot reset password for admin users.');
        }

        // Validate password
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'Password must be at least 8 characters.',
            'new_password.confirmed' => 'Password confirmation does not match.',
        ]);

        // Update user password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('admin.reset-password.index')
            ->with('success', "Password has been successfully reset for {$user->name}. Please inform the user about their new password.");
    }
}
