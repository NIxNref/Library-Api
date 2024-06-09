<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Transaksis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransaksisController extends Controller
{
    

    public function pinjam_buku($id)
    {
        \Log::info('ID Buku yang diterima: ' . $id);
        $buku = Buku::findOrFail($id);
        
        // Check if the book is available to borrow
        if ($buku->stok_buku == 0) {
            return redirect()->back()->with('error', 'Buku tidak tersedia untuk dipinjam');
        }
        \Log::info('Buku yang ditemukan: ' . $buku->judul);
        
        $bukuId = $buku->id;

        $authId = Auth::user()->id;
        

        $user = Transaksis::create([
            'user_id' => $authId,
            'buku_id' => $bukuId,
            'qty' => 1,
            'status' => 'Pending',
        ]);

        return redirect()->route('dashboard_siswa')->with('success', 'Permintaan peminjaman berhasil dibuat, menunggu persetujuan');
    }

    public function data_buku()
    {
        // Mengambil data transaksi yang tidak dihapus dan tidak ditolak
        $trxs = Transaksis::where('is_deleted', 0)->with(['user', 'buku'])->get();
        // return $trxs;
                        
        return view('data_pinjam', compact('trxs'));
    }

    public function data_buku_siswa()
    {
        // Mengambil data transaksi yang tidak dihapus dan tidak ditolak
        $trans = Transaksis::where('is_deleted', 0)->with(['user', 'buku'])->get();
        // return $trxs;
                        
        return view('borrow', compact('trans'));
    }

    public function return_data_pinjam($id)
    {
        $trxs = Transaksis::findOrFail($id);
        $buku = Buku::findOrFail($trxs->buku_id);
        
        // Increase the quantity of the book when returning
        // $buku->stok_buku += 1;
        // $buku->save();
        
        // Update the transaction status to "Returned"
        $trxs->status = 'Dikembalikan';
        $trxs->save();
        
        return redirect()->route('data_pinjam')->with('success', 'Buku berhasil dikembalikan');
    }

    public function updateStatus(Request $request, $id)
    {

        $request->validate([
            'status' => 'required|string',
            'reject_reason' => 'nullable|string|max:255',
        ]);

        \Log::info('Request data:', $request->all());
        $trxs = Transaksis::findOrFail($id);
        $trxs->status = $request->status;
        $trxs->reject_reason = $request->reject_reason;
        $trxs->save();

        // Debugging: Log transaksi data
        \Log::info('Updated transaction:', $trxs->toArray());

        // Decrease or increase the quantity of the book based on the new status
        // $buku = Buku::findOrFail($trxs->buku_id);
        // if ($trxs->status = 'Approved') {
        //     $buku->stok_buku -= 1;
        // } 
        // $buku->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}

