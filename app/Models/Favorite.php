<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Buku;
use App\Models\Siswa;
class Favorite extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'favorites';

    /**
     * Get the user that owns the Transaksis
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'user_id', 'id');
    }

    protected $fillable = ['user_id', 'buku_id', 'is_favorite'];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
