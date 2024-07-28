<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{

    // Show form to reset password
    public function showResetPasswordForm()
    {
        return view('form.reset-password');
    }
    // Reset password
    public function resetPassword(Request $request)
    {
        $email = $request->email;
        // Check if email exists
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Tài khoản không tồn tại');
        }

        // Generate a token code
        $token = mt_rand(100000, 999999);

        // Update the token code in the database
        $user->update([
            'token' => $token
        ]);

        Mail::to($email)->send(new ResetPasswordMail($token));

        return redirect()->route('forget.password.confirm')->with('success', 'Mã token đã được gửi đến email của bạn');
    }

    // Show form to confirm token
    public function showConfirmTokenForm()
    {
        return view('form.confirm-reset-password');
    }

    // Confirm token
    public function confirmToken(Request $request)
    {
        $token = $request->token;

        // Check if token exists
        $user = User::where('token', $token)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Mã token không hợp lệ');
        }

        return redirect()->route('forget.password.change.form', ['token' => $token])->with('success', 'Hãy đổi mật khẩu mới');
    }

    // Show form to change password
    public function showChangePasswordForm(Request $request)
    {
        $token = $request->token;
        return view('form.change-password', ['token' => $token]);
    }

    // Change password
    public function changePassword(Request $request)
    {
        $password = $request->password;
        $token = $request->token;

        $user = User::where('token', $token)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Token không hợp lệ');
        }

        $user->update([
            'password' => bcrypt($password),
            'token' => null
        ]);

        // Logout user
        auth()->logout();

        return redirect()->route('login')->with('success', 'Mật khẩu đã được thay đổi');
    }
}
