<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Hash;

class LibraryController extends Controller
{
    public function index_admin()
    {
        $bukus = Buku::where('is_deleted', 0)->get();
        return view('index_admin', compact("bukus"));
    }

    public function detail_buku($id) {
        $book = Buku::where('is_deleted', 0)->find($id);

        if (!$book) {
            // Handle case where book not found (e.g., return error message or redirect)
            return abort(404);  // Example: return a 404 Not Found response
        }

        return $book;

        // return view('buku_modals', compact("book"));
    }

    public function favourite()
    {
        return view('favourite');
    }

    public function download()
    {
        return view('download');
    }
    
    public function admin_pinjam()
    {
        $bukus = Buku::where('is_deleted', 0)->get();
        return view('admin_pinjam', compact("bukus"));
    }

    // === Siswa ===
    public function data_siswa()
    {
        $siswas = Siswa::where('is_deleted', 0)->get();
        return view('data_siswa', compact("siswas"));
    }
    public function create_siswa(Request $request)
    {
        // $datas = $request->validate([
        //     'nama' => 'required|string',
        //     'kelas' => 'required|string',
        //     'email' => 'required|email|unique:siswa',
        //     'password' => 'required|min:6',
        // ]);
        Siswa::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_status' => 'user',
        ]);
        

        return redirect()->route('data_siswa')->with('success', 'Akun User created successfully.');
    }
    public function edit_siswa(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role_status' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $siswa = Siswa::findOrFail($id);
        $siswa->update($validatedData);
        return redirect()->route('data_siswa')->with('success', 'Data User berhasil diedit');
    }
    public function delete_siswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->is_deleted = 1;
        $siswa->save();
        return redirect()->route('data_siswa')->with('success', 'Akun Siswa berhasil dihapus');
    }
    // === End Siswa ===


    // === Admin ===
    public function data_admin()
    {
        $admins = User::where('is_deleted', 0)->get();
        return view('data_admin', compact("admins"));
    }

    public function create_admin(Request $request)
    {
        // $datas = $request->validate([
        //     'nama' => 'required|string',
        //     'kelas' => 'required|string',
        //     'email' => 'required|email|unique:siswa',
        //     'password' => 'required|min:6',
        // ]);
        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_status' => 'admin',
        ]);
        

        return redirect()->route('data_admin')->with('success', 'Akun Admin Berhasil Dibuat.');
    }

    public function edit_admin(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role_status' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $admin = User::findOrFail($id);
        $admin->update($validatedData);
        return redirect()->route('data_admin')->with('success', 'Data Admin berhasil diedit');
    }

    public function delete_admin($id)
    {
        $admins = User::findOrFail($id);
        $admins->is_deleted = 1;
        $admins->save();
        return redirect()->route('data_admin')->with('success', 'Akun Admin berhasil dihapus');
    }

    // === End Admin ===
    
    
    // === Auth ===
    public function login()
    {
        return view('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function register()
    {
        return view('register');
    }

    // === End Auth ===


    // === Profile ===
    public function profile_siswa()
    {
        return view('profile_siswa');
    }

    public function profile_admin()
    {
        return view('profile_admin');
    }
    // === End Profile ===


    // === Buku ===
    public function create_buku(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required|string|unique:bukus',
            'penerbit' => 'required|string',
            'pengarang' => 'required|string',
            'deskripsi' => 'required|string',
            'stok_buku' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
        ]);

        // Check if the request contains an image
        if ($request->hasFile('image')) {
            // Get the image file
            $image = $request->file('image');
            // Define the storage path
            $storagePath = 'public/posts';
            // Store the image with a hashed name
            $imageName = $image->hashName();
            $image->storeAs($storagePath, $imageName);
        } else {
            // If no image is uploaded, set a default image or handle the scenario as per your requirement
            $imageName = 'default.jpg'; // For example, you may want to use a default image
        }

        // Create a new book record
        $buku = new Buku;
        $buku->image = $imageName;
        $buku->judul = strtolower($request->judul);
        $buku->penerbit = $request->penerbit;
        $buku->pengarang = $request->pengarang;
        $buku->deskripsi = $request->deskripsi;
        $buku->stok_buku = $request->stok_buku;
        $buku->save();

        if(!$buku){
             return redirect()->route('dashboard_admin')->with('error', 'Duplicate Data Buku');
        }

        // Redirect with success message
        return redirect()->route('dashboard_admin')->with('success', 'Buku berhasil ditambahkan');
    }



    public function edit_buku(Request $request, $id)
    {
        $datas = $request->validate([
            'judul' => 'required|string',
            'penerbit' => 'required|string',
            'pengarang' => 'required|string',
            'stok_buku' => 'required|integer'
        ]);

        $bukus = Buku::findOrFail($id);
        $bukus->update($datas);
        return redirect()->route('dashboard_admin')->with('success', 'Buku berhasil diedit');
    }

    public function delete_buku($id)
    {
        $bukus = Buku::findOrFail($id);
        $bukus->is_deleted = 1;
        $bukus->save();
        return redirect()->route('dashboard_admin')->with('success', 'Buku berhasil dihapus');
    }

    // === End Buku ===
}
