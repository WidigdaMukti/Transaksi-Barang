<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model ini
    protected $table = 'counter';

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['bulan', 'tahun', 'counter'];

    // Kolom yang tidak perlu diisi secara massal
    protected $guarded = [];
}
