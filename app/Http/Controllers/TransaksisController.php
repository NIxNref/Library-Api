<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Transaksis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransaksisController extends Controller
{
    public function index_siswa()
    {
        // Mengambil data buku yang tidak dihapus
        $bukus = Buku::where('is_deleted', 0)->get();
                        
        return view('index_siswa', compact("bukus"));
    }

    public function pinjam_buku($id)
    {
        $buku = Buku::findOrFail($id);
        $bukuId = $buku->id;
        $bukuName = $buku->judul;

        $authId = Auth::user()->id;
        $authName = Auth::user()->name;

        $user = Transaksis::create([
            'user_id' => $authId,
            'name_user' => $authName,
            'buku_id' => $bukuId,
            'name_buku' => $bukuName,
            'qty' => 1,
        ]);

        // Decrease the quantity of the book
        $buku->stok_buku -= 1;
        $buku->save();

        return redirect()->route('dashboard_siswa');
    }

    public function data_buku()
    {
        // Mengambil data transaksi yang tidak dihapus dan tidak ditolak
        $trxs = Transaksis::where('is_deleted', 0)->get();
                        
        return view('data_pinjam', compact('trxs'));
    }


    public function delete_data_pinjam($id)
    {
        $trxs = Transaksis::findOrFail($id);
        $buku = Buku::findOrFail($trxs->buku_id);
        $buku->stok_buku += 1;
        $trxs->is_deleted = 1;
        $buku->save();
        $trxs->save();
        return redirect()->route('data_pinjam')->with('success', 'Data berhasil dihapus');
    }

    public function updateStatus(Request $request, $id)
    {
        $trxs = Transaksis::findOrFail($id);
        $trxs->status = $request->status;
        $trxs->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
