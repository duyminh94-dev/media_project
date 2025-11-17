<?php

namespace App\Http\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Http\Controllers\Controller;

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

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Kiểm tra tài khoản có bị vô hiệu hóa không
            if (!$user->is_active) {
                Auth::logout();
                return back()->with('error', 'Tài khoản của bạn đã bị vô hiệu hóa. Vui lòng liên hệ quản trị viên!');
            }

            // Điều hướng theo vai trò từ database
            return match ($user->role) {
                'admin'  => redirect()->route('admin.users.index'),
                'doctor' => redirect()->route('doctors.dashboard'),
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
        // Validation cơ bản
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:doctor,patient',
        ];

        // Validation theo role
        if ($request->role === 'patient') {
            $rules['dob'] = 'nullable|date|before:today';
            $rules['phone'] = 'nullable|string|max:15';
            $rules['address'] = 'nullable|string|max:255';
            $rules['gender'] = 'nullable|in:male,female,other';
        } elseif ($request->role === 'doctor') {
            $rules['specialty_id'] = 'nullable|exists:specialties,id';
            $rules['city_id'] = 'nullable|exists:cities,id';
            $rules['degree'] = 'nullable|string|max:255';
            $rules['bio'] = 'nullable|string';
            $rules['experience_years'] = 'nullable|integer|min:0|max:70';
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            // Tạo user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            // Tạo patient hoặc doctor tương ứng
            if ($user->role === 'patient') {
                Patient::create([
                    'user_id' => $user->id,
                    'dob' => $request->dob,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'gender' => $request->gender,
                ]);
            } elseif ($user->role === 'doctor') {
                Doctor::create([
                    'user_id' => $user->id,
                    'specialty_id' => $request->specialty_id,
                    'city_id' => $request->city_id,
                    'degree' => $request->degree,
                    'bio' => $request->bio,
                    'experience_years' => $request->experience_years,
                ]);
            }

            DB::commit();

            Auth::login($user);

            // Điều hướng theo vai trò
            return $user->role === 'doctor'
                ? redirect()->route('doctors.dashboard')->with('success', 'Đăng ký thành công!')
                : redirect()->route('patient.dashboard')->with('success', 'Đăng ký thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Đăng ký thất bại! Vui lòng thử lại.');
        }
    }
}
