<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        // Check if the user is a student (Siswa)
        $siswa = Siswa::where('email', $request->email)->first();
        $user = User::where('email', $request->email)->first();

        if ($siswa) {
            // Check if student account is deleted
            if ($siswa->is_deleted == 1) {
                throw ValidationException::withMessages([
                    'email' => ['Your account has been deleted. Please contact the administrator.'],
                ]);
            }

            // Attempt login for student
            if (!Hash::check($request->password, $siswa->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            Auth::guard('user')->login($siswa);
            return redirect()->route('dashboard_siswa');
        } elseif ($user && $user->is_deleted == 0) {
            // Attempt login for admin or petugas
            if (!Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            Auth::login($user);
            if ($user->role_status == 'admin') {
                return redirect()->route('dashboard_admin');
            } elseif ($user->role_status == 'petugas') {
                return redirect()->route('dashboard_petugas');
            }
        } else {
            // No account found with the provided email
            throw ValidationException::withMessages([
                'email' => ['No account found with this email.'],
            ]);
        }
    }



    public function register(Request $request)
    {
        $user = Siswa::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_status' => 'user',
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login');
    }
}