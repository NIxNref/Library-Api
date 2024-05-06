<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;


class Siswa extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $guarded = [];

    protected $table = 'siswas';


}
