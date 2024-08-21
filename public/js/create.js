// Fungsi untuk menampilkan atau menyembunyikan form customer baru
function toggleCustomerForm() {
    const selectCustomer = document.getElementById("pilihCustomer");
    const customerForm = document.getElementById("customerForm");
    customerForm.style.display =
        selectCustomer.value === "new" ? "flex" : "none";
}

let barangCounter = 1;
let totalKeseluruhan = 0;

// Fungsi untuk memperbarui total transaksi
function updateTotal() {
    document.getElementById(
        "totalTransaksi"
    ).innerText = `Rp ${totalKeseluruhan.toFixed(2)}`;
}

// Fungsi untuk menambahkan barang ke tabel dan form
document.getElementById("tambahBarangBtn").addEventListener("click", () => {
    const barangSelect = document.getElementById("pilihBarang");
    const qtyInput = document.querySelector('input[placeholder="Qty"]');
    const hargaSatuanInput = document.querySelector(
        'input[placeholder="Harga Satuan"]'
    );

    const barangId = barangSelect.value;
    const namaBarang =
        barangSelect.options[barangSelect.selectedIndex].textContent;
    const qty = parseInt(qtyInput.value, 10);
    const hargaSatuan = parseFloat(hargaSatuanInput.value);

    // Validasi input
    if (barangId === "" || isNaN(qty) || isNaN(hargaSatuan)) {
        alert("Harap lengkapi semua input sebelum menambahkan barang.");
        return;
    }

    // Tambahkan data ke hidden input hanya jika semua input valid
    addHiddenInput("barang[]", barangId);
    addHiddenInput("qty[]", qty);
    addHiddenInput("subtotal[]", (qty * hargaSatuan).toFixed(2));

    // Tambahkan baris ke tabel
    const tableBody = document.querySelector("#barangTable tbody");
    const newRow = document.createElement("tr");
    newRow.innerHTML = `
        <td>${barangCounter}</td>
        <td>${namaBarang}</td>
        <td>${qty}</td>
        <td>${(qty * hargaSatuan).toFixed(2)}</td>
        <td>
            <a href="#" class="text-decoration-none text-danger delete-btn">Hapus</a>
        </td>
    `;

    tableBody.appendChild(newRow);
    barangCounter++;

    // Reset input setelah menambahkan barang
    barangSelect.value = "";
    qtyInput.value = "";
    hargaSatuanInput.value = "";

    // Perbarui total keseluruhan
    totalKeseluruhan += qty * hargaSatuan;
    updateTotal();
});

// Fungsi untuk menambahkan input hidden ke form
function addHiddenInput(name, value) {
    const input = document.createElement("input");
    input.type = "hidden";
    input.name = name;
    input.value = value;
    document.querySelector("form").appendChild(input);
}

// Event delegation untuk tombol hapus
document.querySelector("#barangTable").addEventListener("click", (event) => {
    if (event.target.classList.contains("delete-btn")) {
        event.preventDefault();
        const row = event.target.closest("tr");
        const subtotal = parseFloat(row.cells[3].innerText);
        totalKeseluruhan -= subtotal;
        row.remove();
        updateTotal();
    }
});

// Fungsi untuk mengambil data barang dari server
async function fetchBarang() {
    try {
        const response = await fetch(
            "http://gmedia.bz/DemoCase/main/list_barang",
            {
                method: "POST",
                headers: {
                    "Client-Service": "gmedia-recruitment",
                    "Auth-Key": "demo-admin",
                    "User-Id": "1",
                    Token: "8godoajVqNNOFz21npycK6iofUgFXl1kluEJt/WYFts9C8IZqUOf7rOXCe0m4f9B",
                },
            }
        );

        const data = await response.json();
        if (data.metadata.status === 200) {
            const barangSelect = document.getElementById("pilihBarang");
            barangSelect.innerHTML = "";

            const defaultOption = document.createElement("option");
            defaultOption.textContent = "Pilih Barang";
            defaultOption.value = "";
            defaultOption.disabled = true;
            defaultOption.selected = true;
            barangSelect.appendChild(defaultOption);

            data.response.forEach((barang) => {
                const option = document.createElement("option");
                option.value = barang.kd_barang;
                option.textContent = barang.nama_barang;
                barangSelect.appendChild(option);
            });
        } else {
            alert("Gagal mengambil data barang!");
        }
    } catch (error) {
        console.error("Error fetching data:", error);
    }
}

document.addEventListener("DOMContentLoaded", fetchBarang);
