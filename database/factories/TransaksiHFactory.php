<?php

namespace Database\Factories;

use App\Models\TransaksiH;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiHFactory extends Factory
{
    protected $model = TransaksiH::class;

    public function definition()
    {
        return [
            'id_customer' => Customer::factory(),
            'nomor_transaksi' => 'SO/' . $this->faker->date('Y-m') . '/' . $this->faker->unique()->numberBetween(1, 999),
            'tanggal_transaksi' => $this->faker->date(),
            'total_transaksi' => $this->faker->randomFloat(2, 1000, 100000),
        ];
    }
}
