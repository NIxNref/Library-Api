<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Transaksis;
use App\Models\Ulasan;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Hash;
use App\Services\SupabaseStorageService;

class LibraryController extends Controller
{
    protected $storageService;

    public function __construct(SupabaseStorageService $storageService)
    {
        $this->storageService = $storageService;
    }
    public function index_admin()
    {
        $bukus = Buku::where('is_deleted', 0)->get();
        return view('index_admin', compact("bukus"));
    }
    public function index_petugas()
    {
        $bukus = Buku::where('is_deleted', 0)->get();
        return view('index_petugas', compact("bukus"));
    }

    public function index_siswa()
    {
        // Mengambil data buku yang tidak dihapus
        $bukus = Buku::where('is_deleted', 0)->get();
                        
        return view('index_siswa', compact("bukus"));
    }

    public function show_ulasan()
    {
        $ulasan = Ulasan::all();
        return $ulasan; 
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
        $favourites = Favorite::where('is_favorite', 1)->with('buku')->get();
        return view('favourite', compact('favourites'));
    }

    public function fav_siswa(Request $request, $id)
    {
        $authId = Auth::user()->id;

        Favorite::updateOrCreate(
            ['user_id' => $authId, 'buku_id' => $id],
            ['is_favorite' => 1]
        );

        return redirect()->route('favourite')->with('success', 'Buku berhasil ditambahkan ke favorit.');
    }
    

    public function setting()
    {
        return view('setting');
    }
    public function borrow()
    {
        // Mengambil data transaksi yang tidak dihapus dan tidak ditolak
        $trans = Transaksis::where('is_deleted', 0)
            ->where('user_id', auth()->user()->id)
            ->with(['user', 'buku'])
            ->get();
        // return $trxs;
                        
        return view('borrow', compact('trans'));
    }
    
    public function ulasan(Request $request, $id)
    {
        // Validasi input dari request
        $request->validate([
            'ulasan' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Cari transaksi berdasarkan ID
        $transaksi = Transaksis::findOrFail($id);

        // Simpan ulasan ke tabel ulasan
        Ulasan::create([
            'user_id' => Auth::id(),
            'buku_id' => $transaksi->buku_id,
            'ulasan' => $request->ulasan,
            'rating' => $request->rating,
        ]);

        $transaksi->is_reviewed = 1;
        $transaksi->save();

        // Redirect ke route 'history' dengan pesan sukses
        return redirect()->route('borrow')->with('success', 'Success memberikan Review.');
    }

    
    // public function admin_pinjam()
    // {
    //     $bukus = Buku::where('is_deleted', 0)->get();
    //     return view('admin_pinjam', compact("bukus"));
    // }

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
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role_status' => 'required|string|max:255',
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // Temukan user berdasarkan ID
        $siswa = Siswa::findOrFail($id);

        // Verifikasi password lama
        if (!Hash::check($request->old_password, $siswa->password)) {
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai']);
        }

        // Hash password baru
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Update data siswa
        $siswa->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role_status' => $validatedData['role_status'],
            'password' => $validatedData['password'],
        ]);

        // Redirect ke route 'data_siswa' dengan pesan sukses
        return redirect()->route('data_siswa')->with('success', 'Data user berhasil diedit');
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
        $admins = User::where('is_deleted', 0)->where('role_status', 'admin')->get();
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
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role_status' => 'required|string|max:255',
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // Temukan user berdasarkan ID
        $admin = User::findOrFail($id);

        // Verifikasi password lama
        if (!Hash::check($request->old_password, $admin->password)) {
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai']);
        }

        // Hash password baru
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Update data admin
        $admin->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role_status' => $validatedData['role_status'],
            'password' => $validatedData['password'],
        ]);

        // Redirect ke route 'data_admin' dengan pesan sukses
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

    // === Petugas ===

    public function data_petugas()
    {
        $petugases = User::where('is_deleted', 0)->where('role_status', 'petugas')->get();
        return view('data_petugas', compact("petugases"));
    }

    public function create_petugas(Request $request)
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
            'role_status' => 'petugas',
        ]);
        

        return redirect()->route('data_petugas')->with('success', 'Akun Petugas Berhasil Dibuat.');
    }

    public function edit_petugas(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role_status' => 'required|string|max:255',
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // Temukan user berdasarkan ID
        $petugas = User::findOrFail($id);

        // Verifikasi password lama
        if (!Hash::check($request->old_password, $petugas->password)) {
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai']);
        }

        // Hash password baru
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Update data petugas
        $petugas->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role_status' => $validatedData['role_status'],
            'password' => $validatedData['password'],
        ]);

        // Redirect ke route 'data_petugas' dengan pesan sukses
        return redirect()->route('data_petugas')->with('success', 'Data petugas berhasil diedit');
    }

    public function delete_petugas($id)
    {
        $petugas = User::findOrFail($id);
        $petugas->is_deleted = 1;
        $petugas->save();
        return redirect()->route('data_petugas')->with('success', 'Akun Petugas berhasil dihapus');
    }

    // === End Petugas ===
    
    
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

        if ($request->hasFile('image')) {
            // Get the image file
            $image = $request->file('image');
            // Upload image to Supabase
            $imageUrl = $this->storageService->uploadImage($image);
        } else {
            // If no image is uploaded, set a default image or handle the scenario as per your requirement
            $imageUrl = 'default.jpg'; // For example, you may want to use a default image
        }

        // Create a new book record
        $buku = new Buku;
        $buku->image = $imageUrl;
        $buku->judul = strtolower($request->judul);
        $buku->penerbit = $request->penerbit;
        $buku->pengarang = $request->pengarang;
        $buku->deskripsi = $request->deskripsi;
        $buku->stok_buku = $request->stok_buku;
        $buku->save();

        if(!$buku) {
            if(Auth::user()->role_status == 'admin') {
                return redirect()->route('dashboard_admin')->with('error', 'Duplicate Data Buku');
            } else {
                return redirect()->route('dashboard_petugas')->with('error', 'Duplicate Data Buku');
            }
        }

        // Redirect with success message based on user role
        if (Auth::user()->role_status == 'admin') {
            return redirect()->route('dashboard_admin')->with('success', 'Buku berhasil ditambahkan');
        } else {
            return redirect()->route('dashboard_petugas')->with('success', 'Buku berhasil ditambahkan');
        }
    }



    public function edit_buku(Request $request, $id)
    {

        $bukus = Buku::findOrFail($id);
        $datas = $request->validate([
            'judul' => 'required|string|unique:bukus',
            'penerbit' => 'required|string',
            'pengarang' => 'required|string',
            'deskripsi' => 'required|string',
            'stok_buku' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
        ]);

        if ($request->hasFile('image')) {
            // Get the image file
            $image = $request->file('image');
            // Upload image to Supabase
            $imageUrl = $this->storageService->uploadImage($image);
        } else {
            // If no image is uploaded, set a default image or handle the scenario as per your requirement
            $imageUrl = 'default.jpg'; // For example, you may want to use a default image
        }

        $bukus->update($datas);
        if (Auth::user()->role_status == 'admin') {
            return redirect()->route('dashboard_admin')->with('success', 'Buku berhasil di edit');
        } else {
            return redirect()->route('dashboard_petugas')->with('success', 'Buku berhasil di edit');
        }
    }

    public function delete_buku($id)
    {
        $bukus = Buku::findOrFail($id);
        $bukus->is_deleted = 1;
        $bukus->save();
        if (Auth::user()->role_status == 'admin') {
            return redirect()->route('dashboard_admin')->with('success', 'Buku berhasil di hapus');
        } else {
            return redirect()->route('dashboard_petugas')->with('success', 'Buku berhasil di hapus');
        }
    }

    // === End Buku ===
}
