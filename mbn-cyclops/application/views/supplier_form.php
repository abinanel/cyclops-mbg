<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view("admin/_partials/head.php") ?>
        <?php $this->load->view("admin/_partials/navbar_registration.php") ?>
        <!-- Flatpickr CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <!-- Load jQuery & Select2 CSS/JS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <!-- Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <style>
            html, body {
                height: 100%; /* atau bisa juga height: 100vh; */
            }
            .bg-gray {
                background-color: #f81919ff;
                pointer-events: none; /* Menghilangkan interaksi seperti klik */
                opacity: 1; /* Opsional: Menambahkan efek transparansi untuk visual */
            }
        </style>
    </head>
    <body>
        <div>
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">Formulir Pendaftaran Supplier</h3>
                </div>
                <div class="card-body">
                    <form id="SupplierRegistrationForm" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_supplier" class="form-label">Nama Perusahaan / Supplier</label>
                                    <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jenis_usaha" class="form-label">Jenis Usaha</label>
                                    <input type="text" class="form-control" id="jenis_usaha" name="jenis_usaha" placeholder="Contoh: Makanan, Minuman, ATK" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="izin_usaha" class="form-label">Nomor Izin Usaha (SIUP / NIB)</label>
                                    <input type="text" class="form-control" id="izin_usaha" name="izin_usaha" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="npwp" class="form-label">NPWP</label>
                                    <input type="text" class="form-control" id="npwp" name="npwp" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Supplier</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telepon" class="form-label">Telepon</label>
                                    <input type="text" class="form-control" id="telepon" name="telepon" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="penanggung_jawab" class="form-label">Nama Penanggung Jawab</label>
                            <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" required>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <input type="text" class="form-control" id="provinsi" name="provinsi" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="kota" class="form-label">Kota/Kabupaten</label>
                                    <input type="text" class="form-control" id="kota" name="kota" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="kelurahan" class="form-label">Kelurahan</label>
                                    <input type="text" class="form-control" id="kelurahan" name="kelurahan" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kantin" class="form-label">Pilih Kantin</label>
                                    <select class="form-control" id="kantin" name="kantin[]" multiple="multiple">
                                        <option value="abc">Kantin ABC</option>
                                        <option value="xyz">Kantin XYZ</option>
                                        <option value="kkk">Kantin KKK</option>
                                        <option value="ccc">Kantin CCC</option>
                                        <!-- dst ratusan data -->
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="produk" class="form-label">Upload Daftar Produk</label>
                                    <input type="file" class="form-control" id="produk" name="produk" accept=".xls,.xlsx,.pdf" required>
                                    <div class="form-text">Format: Excel atau PDF</div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100">Kirim</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
                <!--end of main page here -->
        </div>

            <!-- Modal untuk Pesan -->
            <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Notif Sistem</h5>
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
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Konfirmasi Hapus Data</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus data ini ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="deleteConfirmBtn">Hapus</button>
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
                    <span class="sr-only">Memuat...</span>
                    </div>
                    <h5 class="mt-2">Memuat...</h5>
                </div>
                </div>
            </div>
            </div>
        <script src="https://unpkg.com/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('js/scripts.js') ?>"></script>
        <?php $this->load->view("admin/_partials/footer.php") ?>
        <script>
            $(document).ready(function() {
                $('#kantin').select2({
                    placeholder: "Pilih Kantin...",
                    allowClear: true
                });
            });
        </script>
    </body>
</html>