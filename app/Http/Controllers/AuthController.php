<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::user()) {
            return redirect()->route('dashboard');
        }
        return view('pages.auth.login');
    }

    public function loginProcess(Request $request)
    {
        $rules = [
            'email'      => 'required',
            'password'      => 'required'
        ];

        $messages = [
            'email.required'     => 'Email tidak boleh kosong',
            'password.required'     => 'Password tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);

        $remember = $request->has('remember') ? true : false;

        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];

        Auth::attempt($data, $remember);

        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login')->withInput()->withErrors(['error' => 'Email atau password salah!']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    //Forgot/Reset Password 
    public function forgetPassword()
    {
        return view('pages.auth.forgetPassword');
    }

    public function forgetPasswordProcess(Request $request)
    {
        $rules = [
            'email'      => 'required|email|exists:users',
        ];

        $messages = [
            'email.required'     => 'Email wajib diisi',
            'email.email'        => 'Format email salah',
            'email.exists' => 'Email tidak ditemukan'
        ];

        $this->validate($request, $rules, $messages);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        
        Mail::send('pages.auth.resetPasswordMail', ['token' => $token, 'email' => $request->email ], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Kata Sandi');
        });

        return back()->with('success', 'Link reset password telah dikirim ke email anda');
    }

    public function resetPassword($email, $token)
    {
        return view('pages.auth.resetPassword', ['email' => $email, 'token' => $token]);
    }

    public function resetPasswordProcess(Request $request)
    {
        $rules = [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ];

        $messages = [
            'password.required'     => 'Password tidak boleh kosong',
            'password.min'        => 'Password minimal 6 karakter',
            'password.confirmed' => 'Password tidak sama dengan konfirmasi password',
            'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong'
        ];

        $this->validate($request, $rules, $messages);

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        // dd($request);
        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Token tidak valid!');
        }

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect()->route('login')->with('success', 'Password berhasil diubah, silakan login');
    }
}
