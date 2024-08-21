<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Menampilkan halaman create transaksi
    public function create()
    {
        $customers = Customer::all(); // Ambil semua data pelanggan
        return view('transaksi.create', compact('customers'));
    }
}
