<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Buku;
use App\Models\Ulasan;

class LibraryController extends Controller
{
    //

    // === Buku === 

    public function getAllBuku(Request $request)
    {
        // Retrieve all books
        $bukus = Buku::all();

        // Return the books as JSON response
        return response()->json(['data' => $bukus], 200);
    }

    public function show_ulasan(Request $request, $bukuId)
    {
        // Fetch ulasan records by bukuId along with the associated user
        $ulasan = Ulasan::with('user')->where('buku_id', $bukuId)->get();
        
        // Check if any ulasan are found
        if ($ulasan->isEmpty()) {
            return response()->json(['message' => 'No ulasan found for this book'], 200);
        } else {
            return response()->json(['data' => $ulasan], 200);
        }
    }





    public function CreateBukuA(Request $request)
    {
        // Validating the request data
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string',
            'penerbit' => 'required|string',
            'pengarang' => 'required|string',
            'stok_buku' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
        ]);

        // Checking if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

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
        $buku->judul = $request->judul;
        $buku->penerbit = $request->penerbit;
        $buku->pengarang = $request->pengarang;
        $buku->stok_buku = $request->stok_buku;
        $buku->save();

        // Return a JSON response indicating success
        return response()->json(['message' => 'Buku berhasil ditambahkan', 'data' => $buku], 201);
    }

    // === END Buku ===
}
