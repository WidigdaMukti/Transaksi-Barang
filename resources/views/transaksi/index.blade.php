<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Penjualan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>TRANSAKSI PENJUALAN</h1>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>

        <div class="mt-4">
            <h5>Filter Tanggal Transaksi</h5>
            <form action="{{ route('transaksi.index') }}" method="GET" class="form-inline">
                <div class="row align-items-center">
                    <div class="col-auto mb-2">
                        <input type="date" class="form-control" id="datepicker1" name="start_date"
                            placeholder="Tanggal Awal">
                    </div>
                    <div class="col-auto mb-2">
                        <span class="mx-2">sd</span>
                    </div>
                    <div class="col-auto mb-2">
                        <input type="date" class="form-control" id="datepicker2" placeholder="Tanggal Akhir"
                            name="end_date">
                    </div>
                    <div class="col-auto mb-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel-fill"></i> <!-- Ikon Filter -->
                        </button>
                    </div>
                    <div class="col-auto mb-2 ms-auto">
                        <a href="{{ route('transaksi.create') }}" class="btn btn-success ">
                            <i class="bi bi-plus-circle "></i> Tambah Transaksi <!-- Ikon Tambah -->
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-4 d-flex justify-content-between align-items-center mb-4">
            <div class="form-group">
                <input type="text" id="searchInput" class="form-control" placeholder="Search...">
            </div>
            <button id="exportBtn" class="btn btn-secondary ml-2">Export</button>
        </div>

        <div class="mt-2">
            <table class="table table-bordered" id="transactionsTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Transaksi</th>
                        <th>Customer</th>
                        <th>Total Transaksi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($transactions as $index => $transaction)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $transaction->nomor_transaksi }}</td>
                            <td>{{ $transaction->customer ? $transaction->customer->nama : 'N/A' }}</td>
                            <td>{{ number_format($transaction->total_transaksi, 2) }}</td>
                            <td>
                                <a href="{{ route('transaksi.edit', $transaction->id) }}"
                                    class="btn btn-warning">Edit</a>
                                <form action="{{ route('transaksi.destroy', $transaction->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach --}}
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total</td>
                        <td>{{ number_format($transactions->sum('total_transaksi'), 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Datepicker and DataTable JS -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js">
    </script> --}}
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // // Initialize datepickers
            // $('#datepicker1').datepicker();
            // $('#datepicker2').datepicker();

            // Initialize DataTable
            var table = $('#transactionsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('transaksi.data') }}', // Menentukan endpoint data
                columns: [{
                        data: 'id',
                        name: 'id'
                    }, // ID Transaksi
                    {
                        data: 'transaction_number',
                        name: 'transaction_number'
                    }, // Nomor Transaksi
                    {
                        data: 'customer',
                        name: 'customer'
                    }, // Nama Customer
                    {
                        data: 'total',
                        name: 'total'
                    }, // Total Transaksi
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    } // Action Buttons
                ],
                searching: false, // Nonaktifkan pencarian default
                lengthChange: false // Nonaktifkan pilihan jumlah entri
            });

            // Search functionality
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Export button functionality
            $('#exportBtn').on('click', function() {
                // Implement your export logic here
                alert('Export button clicked!');
            });
        });
    </script>
</body>

</html>
