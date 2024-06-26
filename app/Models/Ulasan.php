<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'ulasan';

    protected $fillable = ['user_id', 'buku_id', 'ulasan', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
