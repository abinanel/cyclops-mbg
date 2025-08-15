<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view("admin/_partials/head.php") ?>
        <link href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css" rel="stylesheet">
        <style>
            /* Atur lebar kolom paket */
            #datatablesSimple th:nth-child(6),
            #datatablesSimple td:nth-child(6) {
                width: 110px; /* Ganti nilai width sesuai kebutuhan */
            }
            td {
                text-align: center; /* Meratakan teks di tengah untuk semua kolom */
            }
            .status {
                font-weight: bold;
            }
            .waiting {
                color: orange; /* Warna kuning untuk status menunggu */
            }
            .approved {
                color: green; /* Warna hijau untuk status disetujui */
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <?php $this->load->view("admin/_partials/navbar.php") ?>
        <div id="layoutSidenav">
            <?php $this->load->view("admin/_partials/sidebar.php") ?>
            <div id="layoutSidenav_content">

                <!-- main page here -->
                <main>
                    <div class="container mt-5">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Input Cuti</h3>
                            </div>
                            <div class="card-body">
                                <form id="programForm" method="post">
                                    <div class="row">
                                        <div class="mb-3">
                                            <label for="dropdown" class="form-label">Tahun Cuti</label>
                                            <select class="form-select" id="tahun_dropdown" name="tahun_dropdown" required>
                                                <option value="" selected>Pilih Tahun Cuti</option>
                                                <?php
                                                    // Mendapatkan tahun saat ini
                                                    $tahun_sekarang = date("Y");

                                                    // Rentang tahun (misalnya 10 tahun ke belakang dan 10 tahun ke depan dari tahun saat ini)
                                                    $tahun_mulai = $tahun_sekarang - 1;
                                                    $tahun_akhir = $tahun_sekarang;

                                                    // Membuat opsi pilihan untuk setiap tahun dalam rentang
                                                    for ($tahun = $tahun_mulai; $tahun <= $tahun_akhir; $tahun++) {
                                                        echo "<option value='$tahun'>$tahun</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-12" id="daftar_program">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <div class="mb-3">
                                                                <label for="korek" class="form-label">Sisa Cuti</label>
                                                                <input type="text" class="form-control" id="korek" value="7" title="cth kode rekening : '0001-01-A' (0001 = kode pask, 01 = kode paket, A = Kode Rekening)" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="mb-3">
                                                                <label for="tanggal_awal_paket" class="form-label">Tanggal Mulai</label>
                                                                <input type="date" class="form-control" id="tanggal_awal_paket" name="tgl_mulai" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="mb-3">
                                                                <label for="tanggal_akhir_paket" class="form-label">Tanggal Akhir</label>
                                                                <input type="date" class="form-control" id="tanggal_akhir_paket" name="tgl_selesai" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="mb-3">
                                                                <label for="korek" class="form-label">Durasi Cuti (Hari)</label>
                                                                <input type="text" class="form-control" id="korek" value="3" title="cth kode rekening : '0001-01-A' (0001 = kode pask, 01 = kode paket, A = Kode Rekening)" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="mb-3">
                                                                <label for="alasan_cuti" class="form-label">Alasan Cuti</label>
                                                                <textarea class="form-control" id="alasan_cuti" name="alasan_cuti" rows="3" placeholder="Masukkan alasan cuti..."></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <br>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                    <br>
                                    <br>
                                </form>
                                <table id="datatablesSimple" class="cell-border">
                                    <thead>
                                        <tr>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Durasi Cuti</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Akhir</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>2025-03-03</td>
                                            <td>5 Hari</td>
                                            <td>2025-03-10</td>
                                            <td>2025-03-15</td>
                                            <td class="status waiting">Menunggu Persetujuan</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm">Edit</button>
                                                <button class="btn btn-danger btn-sm">Hapus</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2025-01-01</td>
                                            <td>2 Hari</td>
                                            <td>2025-01-12</td>
                                            <td>2025-01-14</td>
                                            <td class="status approved">Disetujui</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm">Edit</button>
                                                <button class="btn btn-danger btn-sm">Hapus</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <!--end of main page here -->

                <?php $this->load->view("admin/_partials/footer.php") ?>
            </div>

            <!-- Modal untuk pesan array kosong -->
            <div class="modal fade" id="emptyArrayModal" tabindex="-1" role="dialog" aria-labelledby="emptyArrayModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="emptyArrayModalLabel">Perhatian</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Tidak ada data Program yang ditemukan untuk tahun yang dipilih,
                    Silahkan Tambah Program Baru.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
                </div>
            </div>
            </div>

            <!-- Modal untuk Pesan -->
            <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Pesan Sistem</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Pesan akan dimuat di sini -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
                </div>
            </div>
            </div>

            <!-- Modal untuk Konfirmasi Penghapusan -->
            <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus item ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="deleteConfirmBtn">Delete</button>
                </div>
                </div>
            </div>
            </div>

            <!-- Modal Loading -->
            <div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                    </div>
                    <h5 class="mt-2">Loading...</h5>
                </div>
                </div>
            </div>
            </div>
        </div>
        <script src="https://unpkg.com/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('js/scripts.js') ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
        <!-- Memuat library DataTables -->
        <script>
            $('#datatablesSimple').DataTable();
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let dateInputs = document.querySelectorAll('input[type="date"]');

                dateInputs.forEach(input => {
                    input.addEventListener('focus', function () {
                        this.type = 'date'; 
                    });

                    input.addEventListener('blur', function () {
                        if (!this.value) {
                            this.type = 'text';
                            this.placeholder = 'dd/mm/yyyy';
                        }
                    });

                    if (!input.value) {
                        input.type = 'text';
                        input.placeholder = 'dd/mm/yyyy';
                    }
                });
            });
        </script>
        <!-- <script>
            var counter = 0; //initial
            var dataTable;

            // Fungsi untuk menghapus elemen card di dalam div "daftar_rekening"
            function initDivTambah() {
                var container = document.getElementById("daftar_program");
                container.innerHTML = `
                    <div class="card">
                    <div>
                `; // Menghapus semua elemen di dalam container
            }

            // Fungsi untuk menghapus elemen card di dalam div "daftar_rekening"
            function hapusDivTambah() {
                var container = document.getElementById("daftar_program");
                container.innerHTML = ""; // Menghapus semua elemen di dalam container

                counter = 0;
            }

            // Fungsi untuk membuat elemen div "item_pekerjaan" sesuai jumlah array respons
            function tambahDiv(jumlah) {
                var container = document.getElementById("daftar_program");

                for (var i = 0; i < jumlah; i++) {
                    var divTambah = document.createElement("div");
                    divTambah.classList.add("card");
                    divTambah.classList.add("mb-3");

                    divTambah.innerHTML = `
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="ids[]" id="id${i}">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="koPro${i}" class="form-label">Kode Program</label>
                                        <input type="text" class="form-control" name="koPro[]" id="koPro${i}" required>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="mb-3">
                                        <label for="nama${i}" class="form-label">Nama Program</label>
                                        <input type="text" class="form-control" name="nama[]" id="nama${i}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="dpa${i}" class="form-label">Nilai DPA</label>
                                        <input type="text" class="form-control" name="dpa[]" id="dpa${i}" title="Nilai DPA Dalam Rupiah" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="dppa${i}" class="form-label">Nilai DPPA</label>
                                        <input type="text" class="form-control" name="dppa[]" id="dppa${i}" title="Nilai DPPA Dalam Rupiah" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    container.appendChild(divTambah);
                }
            }

            // Definisikan fungsi untuk mengisi nilai elemen jika dropdown dipilih
            function isiDataJikaDipilih(programs) {
                // Dapatkan nilai dropdown rekening
                var dropdown = document.getElementById("tahun_dropdown").value;

                // Jika dropdown kosong, hapus elemen card di dalam div "daftar_rekening"
                if (dropdown === "") {
                    initDivTambah();
                    return; // Keluar dari fungsi
                }

                // Jika dropdown tidak kosong
                if (dropdown !== "") {
                    
                    if (programs.length === 0) {
                        // Jika array kosong, tampilkan modal Bootstrap
                        $('#emptyArrayModal').modal('show');
                        counter = 0;
                        initDivTambah();
                        return; // Keluar dari fungsi
                    }

                    hapusDivTambah();

                    // Dapatkan jumlah array atau sesuai kebutuhan
                    var jumlahArray = programs.length;

                    // set jumlah counter untuk input tambah button
                    counter = jumlahArray;

                    // Panggil fungsi untuk membuat elemen div "item_pekerjaan"
                    tambahDiv(jumlahArray);

                    // Loop untuk mengisi nilai pada elemen-elemen lainnya
                    for (var i = 0; i < jumlahArray; i++) {
                        var program = programs[i]; // Dapatkan program individual

                        document.getElementById("id" + i).value = program.id;
                        document.getElementById("koPro" + i).value = program.kode_program;
                        document.getElementById("nama" + i).value = program.nama_program;
                        document.getElementById("dpa" + i).value = formatNumber(Math.round(program.nilai_dpa));
                        document.getElementById("dppa" + i).value = program.nilai_dppa ? formatNumber(Math.round(program.nilai_dppa)) : "0";
                    }
                }
            }

            // Edit Klik
            function isiDetailEdit(program) {
                hapusDivTambah();

                // Dapatkan jumlah array atau sesuai kebutuhan
                var jumlahArray = 1;

                // set jumlah counter untuk input tambah button
                counter = 1;

                // Panggil fungsi untuk membuat elemen div "item_pekerjaan"
                tambahDiv(jumlahArray);

                // Loop untuk mengisi nilai pada elemen-elemen lainnya
                for (var i = 0; i < jumlahArray; i++) {
                    document.getElementById("tahun_dropdown").value = program.tahun_program;
                    document.getElementById("id" + i).value = program.id;
                    document.getElementById("koPro" + i).value = program.kode_program;
                    document.getElementById("nama" + i).value = program.nama_program;
                    document.getElementById("dpa" + i).value = formatNumber(Math.round(program.nilai_dpa));
                    document.getElementById("dppa" + i).value = program.nilai_dppa ? formatNumber(Math.round(program.nilai_dppa)) : "0";
                }
            }

            // Panggil fungsi hapusDiv saat tombol reset diklik
            document.querySelector("button[type='reset']").addEventListener("click", hapusDivTambah);

            // Fungsi untuk memformat angka dengan titik sebagai pemisah ribuan
            function formatNumber(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function updateTable(programs) {
                if (programs.length === 0) {
                    tbody.append('<tr><td colspan="6">Tidak ada data yang ditemukan</td></tr>');
                    return;
                }

                $('#datatablesSimple').DataTable().destroy();

                var tbody = $('#datatablesSimple tbody');
                tbody.empty(); // Bersihkan isi tabel saat ini

                $.each(programs, function(index, program) {
                    var nilai_dppa = program.nilai_dppa ? formatNumber(Math.round(program.nilai_dppa)) : "0";
                    var row = '<tr>' +
                            '<td>' + program.tahun_program + '</td>' +
                            '<td>' + program.kode_program + '</td>' +
                            '<td>' + program.nama_program + '</td>' +
                            '<td>' + formatNumber(Math.round(program.nilai_dpa)) + '</td>' +
                            '<td>' + formatNumber(nilai_dppa) + '</td>' +
                            '<td> <button type="button" class="btn btn-primary btn-sm me-2 editBtn" data-id="' + program.id + '">Edit</button> <button type="button" class="btn btn-danger btn-sm me-2 deleteBtn" data-id="' + program.id + '">X</button> </td>' +
                            '</tr>';
                    tbody.append(row);
                });

                // Inisialisasi ulang DataTables
                $('#datatablesSimple').DataTable();
            }
        </script>
        <script>
            document.getElementById("addInputBtn").addEventListener("click", function () {
                event.preventDefault(); // Prevent page reload

                // Mendapatkan nilai dari dropdown kegiatan
                var selected = document.getElementById('tahun_dropdown').value;

                // Cek apakah kegiatan telah dipilih
                if (selected === "") {
                    $('#infoModal .modal-body').html("Silakan pilih Tahun terlebih dahulu."); // Set isi modal dengan pesan sukses
                    $('#infoModal').modal('show'); // Tampilkan modal info
                    return; // Hentikan fungsi jika tidak ada kegiatan yang dipilih
                }

                var card = document.createElement("div");
                card.classList.add("card", "mb-3");
                card.setAttribute("id", "card_"+counter);

                var cardBody = document.createElement("div");
                cardBody.classList.add("card-body");

                var row = document.createElement("div");
                row.classList.add("row");

                //hidden, null only value
                var inputId = document.createElement("input");
                inputId.setAttribute("type", "hidden");
                inputId.setAttribute("id", "id"+counter);
                inputId.setAttribute("name", "ids[]");
                inputId.setAttribute("value", "");

                var col1 = document.createElement("div");
                col1.classList.add("col-md-3");

                var number1 = document.createElement("div");
                number1.classList.add("mb-3");

                var label1 = document.createElement("label");
                label1.classList.add("form-label");
                label1.setAttribute("for", "koPro"+counter);
                label1.textContent = "Kode Program";
                number1.appendChild(label1);

                var input1 = document.createElement("input");
                input1.setAttribute("type", "text");
                input1.classList.add("form-control");
                input1.setAttribute("id", "koPro"+counter);
                input1.setAttribute("name", "koPro[]");
                input1.setAttribute("required", "required");
                number1.appendChild(input1);

                var col2 = document.createElement("div");
                col2.classList.add("col-md-8");

                var number2 = document.createElement("div");
                number2.classList.add("mb-3");

                var label2 = document.createElement("label");
                label2.classList.add("form-label");
                label2.setAttribute("for", "nama"+counter);
                label2.textContent = "Nama Program";
                number2.appendChild(label2);

                var input2 = document.createElement("input");
                input2.setAttribute("type", "text");
                input2.classList.add("form-control");
                input2.setAttribute("id", "nama"+counter);
                input2.setAttribute("name", "nama[]");
                input2.setAttribute("required", "required");
                number2.appendChild(input2);

                //Row Pertama
                col1.appendChild(number1);
                col2.appendChild(number2);
                row.appendChild(inputId);
                row.appendChild(col1);
                row.appendChild(col2);
                // ========================

                var row1 = document.createElement("div");
                row1.classList.add("row");

                var col3 = document.createElement("div");
                col3.classList.add("col-md-6");

                var number3 = document.createElement("div");
                number3.classList.add("mb-3");

                var label3 = document.createElement("label");
                label3.classList.add("form-label");
                label3.setAttribute("for", "dpa"+counter);
                label3.textContent = "Nilai DPA";
                number3.appendChild(label3);

                var input3 = document.createElement("input");
                input3.setAttribute("type", "text");
                input3.classList.add("form-control");
                input3.setAttribute("id", "dpa"+counter);
                input3.setAttribute("name", "dpa[]");
                input3.setAttribute("required", "required");
                number3.appendChild(input3);

                var col4 = document.createElement("div");
                col4.classList.add("col-md-6");

                var number4 = document.createElement("div");
                number4.classList.add("mb-3");

                var label4 = document.createElement("label");
                label4.classList.add("form-label");
                label4.setAttribute("for", "dppa"+counter);
                label4.textContent = "Nilai DPPA";
                number4.appendChild(label4);

                var input4 = document.createElement("input");
                input4.setAttribute("type", "text");
                input4.classList.add("form-control");
                input4.setAttribute("id", "dppa"+counter);
                input4.setAttribute("name", "dppa[]");
                input4.setAttribute("required", "required");
                number4.appendChild(input4);

                //Row Pertama
                col3.appendChild(number3);
                col4.appendChild(number4);
                row1.appendChild(col3);
                row1.appendChild(col4);
                // ========================

                // Add the "X" button next to the input field
                var colButton = document.createElement("div");
                colButton.classList.add("col-sm-1", "mb-3", "d-flex", "align-items-end"); // Menambahkan kelas "d-flex" dan "align-items-end" untuk mengatur posisi tombol "X"

                var deleteBtn = document.createElement("button");
                deleteBtn.classList.add("btn", "btn-danger"); // Menambahkan kelas "align-self-start" untuk membuat tombol "X" berada di atas
                deleteBtn.textContent = "X";
                deleteBtn.addEventListener("click", function () {
                    card.remove();
                    counter--;
                });
                colButton.appendChild(deleteBtn); // Menempatkan tombol "X" di dalam kolom pertama

                row.appendChild(colButton)
                cardBody.appendChild(row);
                cardBody.appendChild(row1);
                card.appendChild(cardBody);

                document.querySelector("#daftar_program").appendChild(card);

                //console.log(counter);
                counter++;
            });
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                // Ketika terjadi perubahan pada elemen select dengan id tahun_dropdown
                $('#tahun_dropdown').change(function() {
                    // Tampilkan modal loading
                    $('#loadingModal').modal('show');

                    // Ambil nilai tahun yang dipilih
                    var tahun = $(this).val();

                    // Kirim nilai tahun ke server menggunakan AJAX
                    $.ajax({
                        url: '<?php echo base_url('index.php/admin/program/get_program_by_tahun'); ?>', // Ganti dengan URL yang sesuai
                        type: 'POST',
                        data: {tahun: tahun}, // Kirim tahun ke server
                        dataType: 'json', // Pastikan respons diharapkan dalam format JSON
                        success: function(response) {
                            isiDataJikaDipilih(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(error); // Cetak pesan kesalahan jika terjadi error
                        }
                    }).always(function() {
                        setTimeout(function() {
                            $('#loadingModal').modal('hide');
                        }, 500); // Tunggu setengah detik
                    });
                });
            });

            $(document).ready(function() {
                let table = new DataTable('#datatablesSimple');
                // Kirim nilai tahun ke server menggunakan AJAX
                $.ajax({
                    url: '<?php echo base_url('index.php/admin/program/get_program_by_bidang'); ?>', // Ganti dengan URL yang sesuai
                    type: 'GET',
                    dataType: 'json', // Pastikan respons diharapkan dalam format JSON
                    success: function(response) {
                        updateTable(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error); // Cetak pesan kesalahan jika terjadi error
                    }
                });
            });

            $(document).on('click', '.editBtn', function() {
                var programId = $(this).data('id'); // mengambil ID dari data-id attribute
                fetchProgramData(programId);       // fungsi untuk mengambil data
            });

            function fetchProgramData(id) {
                // Tampilkan modal loading
                $('#loadingModal').modal('show');

                $.ajax({
                    url: '<?php echo base_url('index.php/admin/program/get_program_by_id'); ?>', // Sesuaikan dengan URL yang tepat
                    type: 'POST',
                    data: {id: id},
                    dataType: 'json',
                    success: function(program) {
                        if (program) {
                            isiDetailEdit(program)
                        }
                    },
                    error: function() {
                        alert('Error fetching data.');
                    }
                }).always(function() {
                    setTimeout(function() {
                        $('#loadingModal').modal('hide');
                    }, 500); // Tunggu setengah detik
                });
            }

            $(document).on('click', '.deleteBtn', function() {
                var programId = $(this).data('id'); // mengambil ID dari data-id attribute
                deleteProgram(programId);       // fungsi untuk mengambil data
            });

            function deleteProgram(id) {
                // Simpan id di tempat yang bisa diakses oleh tombol konfirmasi hapus
                $('#deleteConfirmBtn').data('id', id);
                $('#deleteConfirmModal').modal('show');
            }

            // Tangani ketika tombol konfirmasi hapus diklik
            $('#deleteConfirmBtn').on('click', function() {
                $('#deleteConfirmModal').modal('hide');
                // Tampilkan modal loading
                $('#loadingModal').modal('show');
                
                var id = $(this).data('id');  // Ambil id yang telah disimpan
                $.ajax({
                    url: '<?php echo base_url('index.php/admin/program/delete_program'); ?>',
                    type: 'POST',
                    data: {id: id},
                    dataType: 'json',
                    success: function(response) {
                        $('#infoModal .modal-body').html(response.message); // Set isi modal dengan pesan sukses
                        $('#infoModal').modal('show'); // Tampilkan modal info
                        
                        $('#deleteConfirmModal').modal('hide'); // Sembunyikan modal konfirmasi

                        // Opsional: reload halaman atau hapus baris setelah modal info ditutup
                        $('#infoModal').on('hidden.bs.modal', function (e) {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        var error = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'An error occurred';
                        $('#infoModal .modal-body').html('Error: ' + error); // Set isi modal dengan pesan error
                        $('#infoModal').modal('show'); // Tampilkan modal info
                        $('#deleteConfirmModal').modal('hide'); // Sembunyikan modal konfirmasi
                    }
                }).always(function() {
                    setTimeout(function() {
                        $('#loadingModal').modal('hide');
                    }, 500); // Tunggu setengah detik
                });
            });

            $(document).ready(function() {
                $('#programForm').submit(function(e) {
                    e.preventDefault(); // Menghentikan pengiriman formulir standar
                    if(counter === 0) {
                        $('#infoModal .modal-body').html("Silakan tambah program terlebih dahulu."); // Set isi modal dengan pesan sukses
                        $('#infoModal').modal('show'); // Tampilkan modal info
                        return; // Hentikan fungsi jika tidak ada kegiatan yang dipilih
                    }
                    // Tampilkan modal loading
                    $('#loadingModal').modal('show');

                    e.preventDefault(); // Menghentikan pengiriman formulir standar

                    var formData = $(this).serialize(); // Mengambil data dari formulir

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('admin/program/save_program'); ?>', // URL untuk pengiriman AJAX
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            $('#infoModal .modal-body').html(response.message); // Set isi modal dengan pesan sukses
                            $('#infoModal').modal('show'); // Tampilkan modal info

                            // Opsional: reload halaman atau hapus baris setelah modal info ditutup
                            $('#infoModal').on('hidden.bs.modal', function (e) {
                                location.reload();
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            var error = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'An error occurred';
                            $('#infoModal .modal-body').html('Error: ' + error); // Set isi modal dengan pesan error
                            $('#infoModal').modal('show'); // Tampilkan modal info
                        }
                    }).always(function() {
                        setTimeout(function() {
                            $('#loadingModal').modal('hide');
                        }, 500); // Tunggu setengah detik
                    });
                });
            });

        </script> -->
    </body>
</html>
