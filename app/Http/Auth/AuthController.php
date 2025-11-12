<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function loginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $role = $request->input('role');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role !== $role) {
                Auth::logout();
                return back()->with('error', 'Vai trò không khớp với tài khoản!');
            }

            // Điều hướng theo vai trò
            return match ($user->role) {
                'admin'  => redirect()->route('admin.dashboard'),
                'doctor' => redirect()->route('doctor.dashboard'),
                default  => redirect()->route('patient.dashboard'),
            };
        }

        return back()->with('error', 'Email hoặc mật khẩu không đúng!');
    }

    // Đăng xuất
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:doctor,patient',
            'dob' => 'nullable|date',
            'cccd' => 'nullable|string|max:20',
            'specialty' => 'nullable|string|max:255',
            'certificate_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Xử lý upload bằng cấp
        $certificatePath = null;
        if ($request->hasFile('certificate_image')) {
            $certificatePath = $request->file('certificate_image')->store('certificates', 'public');
        }

        // Tạo user mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'dob' => $request->dob,
            'cccd' => $request->cccd,
            'specialty' => $request->specialty,
            'certificate_image' => $certificatePath,
        ]);

        Auth::login($user);

        // Điều hướng
        return $user->role === 'doctor'
            ? redirect()->route('doctors.dashboard')->with('success', 'Đăng ký thành công!')
            : redirect()->route('patient.dashboard')->with('success', 'Đăng ký thành công!');
    }
}
