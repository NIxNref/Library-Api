<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    // Gw mau coba bikin ini biar gausah milih "Login As" lagi, tapi gagal di siswa nya coba benerin dh
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
        if (!$siswa) {
            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
            Auth::login($user);
            return redirect()->route('dashboard_admin');
        }
        else
        {
            Auth::guard($siswa->role_status)->attempt($credentials);
            if (!Hash::check($request->password, $siswa->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
            Auth::login($siswa);
            return redirect()->route('dashboard_siswa');
        } 
        

        // if (!$siswa) {
        //     if (!$user || !Hash::check($request->password, $user->password)) {
        //         throw ValidationException::withMessages([
        //             'email' => ['The provided credentials are incorrect.'],
        //         ]);
        //     }
        //     Auth::login($user);
        //     return redirect()->route('dashboard_admin');
        // }

        // // If it's a student
        // else {
        //     if (!Hash::check($request->password, $siswa->password)) {
        //         throw ValidationException::withMessages([
        //             'email' => ['The provided credentials are incorrect.'],
        //         ]);
        //     }
        //     Auth::login($siswa);
        //     return redirect()->route('dashboard_siswa');
        // }
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