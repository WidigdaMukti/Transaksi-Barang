<?php

namespace App\Http\Controllers;

use App\Models\TransaksiH;
use App\Models\TransaksiD;
use App\Models\Counter;
use App\Models\Customer;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // Mengambil semua data transaksi bersama dengan data customer
        $transactions = TransaksiH::with('customer')->get();

        // Mengirim data ke view
        return view('transaksi.index', compact('transactions'));
    }

    public function create()
    {
        // Ambil data customer
        $customers = Customer::all();

        // Generate nomor transaksi otomatis
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Ambil data dari tabel counter berdasarkan bulan dan tahun saat ini
        $counter = Counter::where('bulan', $currentMonth)->where('tahun', $currentYear)->first();

        if ($counter) {
            // Jika sudah ada, tingkatkan counter
            $counter->counter++;
            // Simpan counter baru ke session untuk digunakan nanti
            session(['counter' => $counter]);
        } else {
            // Jika belum ada, buat entri baru dengan counter = 1
            $counter = new Counter();
            $counter->bulan = $currentMonth;
            $counter->tahun = $currentYear;
            $counter->counter = 1;
            // Simpan counter baru ke session untuk digunakan nanti
            session(['counter' => $counter]);
            $counter->save();
        }

        // Format nomor transaksi (misalnya: SO/2024-08/0001)
        $nomorTransaksi = 'SO/' . $currentYear . '-' . $currentMonth . '/' . str_pad($counter->counter, 4, '0', STR_PAD_LEFT);

        // Kirim data customer dan nomor transaksi ke view
        return view('transaksi.create', [
            'customers' => $customers,
            'nomorTransaksi' => $nomorTransaksi,
        ]);
    }


    public function edit($id)
    {
        $transaksi = TransaksiH::findOrFail($id);
        $customers = Customer::all(); // Ambil semua customer untuk dropdown
        return view('transaksi.edit', compact('transaksi', 'customer'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = TransaksiH::findOrFail($id);
        $transaksi->update($request->all());

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $transaksi = TransaksiH::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function getData(Request $request)
    {
        // Mengambil semua transaksi dengan relasi customer
        $transactions = TransaksiH::with('customer')->get();

        // Memformat data agar sesuai dengan kebutuhan DataTables
        $data = [];
        foreach ($transactions as $transaction) {
            $data[] = [
                'id' => $transaction->id,
                'transaction_number' => $transaction->nomor_transaksi,
                'customer' => $transaction->customer ? $transaction->customer->nama : 'N/A',
                'total' => number_format($transaction->total_transaksi, 2),
                'action' => '<a href="' . route('transaksi.edit', $transaction->id) . '" class="btn btn-warning">Edit</a>
                         <form action="' . route('transaksi.destroy', $transaction->id) . '" method="POST" style="display:inline-block;">
                             ' . csrf_field() . '
                             ' . method_field('DELETE') . '
                             <button type="submit" class="btn btn-danger">Hapus</button>
                         </form>'
            ];
        }

        // Mengembalikan data dalam format JSON
        return response()->json([
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        dd($request->all());
        // Validasi data
        $validated = $request->validate([
            'nomor_transaksi' => 'required|string',
            'tanggal_transaksi' => 'required|date',
            'id_customer' => 'required',
            'nama' => 'nullable|string',
            'alamat' => 'nullable|string',
            'phone' => 'nullable|string',
            'barang' => 'required|array',
            'barang.*' => 'required|string',
            'qty' => 'required|array',
            'qty.*' => 'required|numeric',
            'subtotal' => 'required|array',
            'subtotal.*' => 'required|numeric',
        ]);

        $totalTransaksi = array_sum($validated['subtotal']);

        if ($validated['id_customer'] === 'new') {
            $customer = Customer::create([
                'nama' => $validated['nama'],
                'alamat' => $validated['alamat'],
                'phone' => $validated['phone'],
            ]);
            $customerId = $customer->id;
        } else {
            $customerId = $validated['id_customer'];
        }

        $transaksiH = TransaksiH::create([
            'nomor_transaksi' => $validated['nomor_transaksi'],
            'tanggal_transaksi' => $validated['tanggal_transaksi'],
            'id_customer' => $customerId,
            'total_transaksi' => $totalTransaksi,
        ]);

        foreach ($validated['barang'] as $key => $barang) {
            TransaksiD::create([
                'id_transaksi_h' => $transaksiH->id,
                'kd_barang' => $barang,
                'qty' => $validated['qty'][$key],
                'subtotal' => $validated['subtotal'][$key],
            ]);
        }

        return redirect('/')->with('success', 'Transaksi berhasil disimpan!');
    }

    // public function store(Request $request)
    // {
    //     // Cek semua data yang diterima oleh request
    //     // dd($request->all());

    //     // Validasi request jika diperlukan
    //     $validatedData = $request->validate([
    //         'kd_barang' => 'required|string',
    //         'nama_barang' => 'required|string',
    //         'qty' => 'required|integer',
    //         'subtotal' => 'required|numeric',
    //         'total_transaksi' => 'required|numeric',
    //         'tanggal_transaksi' => 'required|date',
    //         'id_customer' => 'required|exists:customer,id',
    //     ]);

    //     // Debugging untuk memeriksa data yang divalidasi
    //     // dd($validatedData);

    //     try {
    //         // Simpan data ke tabel transaksi_h
    //         $transaksi_h = new TransaksiH();
    //         $transaksi_h->total = $validatedData['total_transaksi'];
    //         $transaksi_h->nomor_transaksi = 
    //         $transaksi_h->tanggal_transaksi = $validatedData['tanggal_transaksi'];
    //         $transaksi_h->id_customer = $validatedData['id_customer'];
    //         $transaksi_h->save();

    //         // // Debugging setelah menyimpan transaksi_h
    //         // dd($transaksi_h);

    //         // Simpan data ke tabel transaksi_d
    //         $transaksi_d = new TransaksiD();
    //         $transaksi_d->id_transaksi_h = $transaksi_h->id; // Ambil ID dari transaksi_h yang baru saja disimpan
    //         $transaksi_d->kd_barang = $validatedData['kd_barang'];
    //         $transaksi_d->nama_barang = $validatedData['nama_barang'];
    //         $transaksi_d->qty = $validatedData['qty'];
    //         $transaksi_d->subtotal = $validatedData['subtotal'];
    //         $transaksi_d->save();

    //         // // Debugging setelah menyimpan transaksi_d
    //         // dd($transaksi_d);

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Transaksi berhasil disimpan',
    //         ]);
    //     } catch (\Exception $e) {
    //         // Tangkap dan tampilkan error
    //         dd($e->getMessage());
    //     }
    // }
}
