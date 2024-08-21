<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';


    public function transaksiHeaders()
    {
        return $this->hasMany(TransaksiH::class, 'id_customer');
    }
}
