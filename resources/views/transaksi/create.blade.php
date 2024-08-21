<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Transaksi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" </head>

<body>
    <div class="container my-5">
        <h3 class="mb-4">FORM TRANSAKSI</h3>
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf
            <!-- Menampilkan Pesan Kesalahan Umum -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Nomor Transaksi -->
            <div class="mb-3 col-md-2">
                <label for="nomorTransaksi" class="form-label">Nomor Transaksi</label>
                <input type="text" class="form-control @error('nomor_transaksi') is-invalid @enderror"
                    id="nomorTransaksi" name="nomor_transaksi" value="{{ old('nomor_transaksi', $nomorTransaksi) }}"
                    readonly>
                @error('nomor_transaksi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tanggal Transaksi -->
            <div class="mb-3 col-md-2">
                <label for="tanggalTransaksi" class="form-label">Tanggal Transaksi</label>
                <input type="date" class="form-control @error('tanggal_transaksi') is-invalid @enderror"
                    id="tanggalTransaksi" name="tanggal_transaksi" value="{{ old('tanggal_transaksi') }}">
                @error('tanggal_transaksi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Pilih Customer -->
            <div class="mb-3 col-md-2">
                <label for="pilihCustomer" class="form-label">Pilih Customer</label>
                <select class="form-select @error('id_customer') is-invalid @enderror" id="pilihCustomer"
                    name="id_customer" onchange="toggleCustomerForm()">
                    <option value="" selected>Pilih Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('id_customer') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->nama }}
                        </option>
                    @endforeach
                    <option value="new" {{ old('id_customer') == 'new' ? 'selected' : '' }}>Tambah Customer Baru
                    </option>
                </select>
                @error('id_customer')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Data Customer Baru -->
            <div id="customerForm" class="row mb-3"
                style="{{ old('id_customer') == 'new' ? 'display: flex;' : 'display: none;' }}">
                <div class="col-md-4">
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                        placeholder="Nama" value="{{ old('nama') }}">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                        placeholder="Alamat" value="{{ old('alamat') }}">
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                        placeholder="Phone" value="{{ old('phone') }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Pilih Barang -->
            <div class="mb-3">
                <label for="pilihBarang" class="form-label">Pilih Barang</label>
                <div class="row">
                    <div class="col-md-5">
                        <select class="form-select" id="pilihBarang" name="barang[]">
                            <option value="" selected disabled>Pilih Barang</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" name="qty[]" placeholder="Qty">
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" name="subtotal[]" placeholder="Harga Satuan">
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="tambahBarangBtn" class="btn btn-primary w-100">Tambah Barang</button>
                    </div>
                </div>
            </div>

            <!-- Data Barang -->
            <table id="barangTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Barang akan ditambahkan di sini -->
                </tbody>
            </table>

            <!-- Total Transaksi -->
            <div class="mb-4">
                <h5>Total Transaksi : <span id="totalTransaksi">Rp 0</span></h5>
            </div>

            <!-- Simpan Transaksi -->
            <div class="d-grid gap-2 col-md-2">
                <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/create.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
