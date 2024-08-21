<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransaksiH;

class TransaksiHSeeder extends Seeder
{
    public function run()
    {
        TransaksiH::factory()->count(4)->create();
    }
}
