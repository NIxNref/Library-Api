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
        $imageName = $image->hashName();
        $filePath = "public/{$this->bucket}/{$imageName}";

        $response = $this->client->post("/storage/v1/object/{$this->bucket}/{$imageName}", [
            'headers' => [
                'Content-Type' => $image->getClientMimeType(),
            ],
            'body' => fopen($image->getPathname(), 'r'),
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Failed to upload image to Supabase');
        }

        return "{$this->url}/storage/v1/object/public/{$this->bucket}/{$imageName}";
    }
}
