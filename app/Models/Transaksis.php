<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Buku;
use App\Models\Siswa;

class Transaksis extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'transaksis';
    
    /**
     * Get the user that owns the Transaksis
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'user_id', 'id');
    }

    /**
     * Get the user that owns the Transaksis
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'id');
    }
}
