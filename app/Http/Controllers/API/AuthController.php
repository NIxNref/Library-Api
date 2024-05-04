<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    function Register(Request $request)
    {
        try {
            $user = new Siswa();
            $user->name = $request->name;
            $user->kelas = $request->kelas;
            $user->email = $request->email;
            $user->role_status = 'siswa'; // Mengatur role_status ke 'siswa'
            $user->password = Hash::make($request->password);
            $user->save(); // Menyimpan user baru ke database
            $response  = ['status' => 200, 'message' => 'Register Succesfully', 'data' => $user];
            return response()->json($response);
        } catch (Exception $e) {
            $response = ['status' => 500, 'message' => $e->getMessage()]; // Mengambil pesan kesalahan dari pengecualian
            return response()->json($response, 500); // Mengembalikan pesan kesalahan dalam respons JSON
        }
    }

    function Login(Request $request)
    {
        $user = Siswa::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response  = ['status' => 200, 'token' => $token, 'user' => $user, 'message' => 'Successfully logged in'];
            return response()->json($response);
        } else if (!$user) {
            $response  = ['status' => 500, 'message' => 'No account found with this email'];
            return response()->json($response);
        } else {
            $response  = ['status' => 500, 'message' => 'Wrong email or password! Please try again'];
            return response()->json($response);
        }
    }

    function Logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete(); // Revoking the current access token
            $response = ['status' => 200, 'message' => 'Logout successfully'];
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ['status' => 500, 'message' => $e->getMessage()];
            return response()->json($response, 500);
        }
    }
}
