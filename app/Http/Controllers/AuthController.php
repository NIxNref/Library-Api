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

        // If not a student, check if it's an admin (User)
        if (!$siswa && $user && $user->is_deleted == 0) {
            if (!Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
            Auth::login($user);
            return redirect()->route('dashboard_admin');
        } else {
            // Check if a student with provided email exists
            if (!$siswa) {
                throw ValidationException::withMessages([
                    'email' => ['No account found with this email.'],
                ]);
            }
            
            // Check if student account is deleted
            if ($siswa->is_deleted == 1) {
                throw ValidationException::withMessages([
                    'email' => ['Your account has been deleted. Please contact the administrator.'],
                ]);
            }

            // Attempt login for student
            if (!Auth::guard($siswa->role_status)->attempt($credentials)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
            return redirect()->route('dashboard_siswa');
        } 
    }


    public function register(Request $request)
    {
        $user = Siswa::create([
            'name' => $request->name,
            'kelas' => $request->kelas,
            'email' => $request->email,
            'role_status' => 'siswa',
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login');
    }
}