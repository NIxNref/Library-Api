<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;

class SupabaseStorageService
{
    protected $client;
    protected $url;
    protected $key;
    protected $bucket;

    public function __construct()
    {
        $this->url = env('SUPABASE_URL');
        $this->key = env('SUPABASE_KEY');
        $this->bucket = env('SUPABASE_BUCKET');

        $this->client = new Client([
            'base_uri' => $this->url,
            'headers' => [
                'apikey' => $this->key,
                'Authorization' => 'Bearer ' . $this->key,
            ],
        ]);
    }

    public function uploadImage(UploadedFile $image)
    {
        $imageName = $image->getClientOriginalName(); // Mendapatkan nama asli gambar
        $hashName = $image->hashName(); // Mendapatkan hash dari gambar
        $finalImageName = pathinfo($imageName, PATHINFO_FILENAME) . '_' . $hashName; // Menggabungkan nama asli dan hash

        $filePath = "public/{$this->bucket}/{$finalImageName}";

        $response = $this->client->post("/storage/v1/object/{$this->bucket}/{$finalImageName}", [
            'headers' => [
                'Content-Type' => $image->getClientMimeType(),
            ],
            'body' => fopen($image->getPathname(), 'r'),
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Failed to upload image to Supabase');
        }

        return "{$this->url}/storage/v1/object/public/{$this->bucket}/{$finalImageName}";
    }
}
