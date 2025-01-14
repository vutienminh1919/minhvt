<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenController extends Controller
{


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Lấy thông tin đăng nhập
        $credentials = $request->only('email', 'password');

        // Kiểm tra thông tin đăng nhập với bảng users
        if (Auth::attempt($credentials)) {
            // Lấy thông tin user đăng nhập
            $user = Auth::user();
            // Chuyển hướng tới trang dashboard
            return redirect()->route('users.index')->with('success', 'Đăng nhập thành công');
        }

        // Nếu không thành công, trả về trang đăng nhập kèm lỗi
        return redirect()->back()->withInput()->withErrors([
            'login_failed' => 'Email hoặc mật khẩu không đúng',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('authen.login')->with('success', 'Đăng xuất thành công');

    }

    public function register(Request $request)
    {


    }

}
