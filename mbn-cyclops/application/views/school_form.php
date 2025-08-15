<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view("admin/_partials/head.php") ?>
        <?php $this->load->view("admin/_partials/navbar_registration.php") ?>
        <!-- Flatpickr CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <!-- Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <style>
            html, body {
                height: 100%; /* atau bisa juga height: 100vh; */
            }
            .bg-gray {
                background-color: #e9ecef;
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
                    <h3 class="card-title">Formulir Pendaftaran Sekolah</h3>
                </div>
                <div class="card-body">
                    <form id="SchoolRegistrationForm" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Username</label>
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
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="npsn" class="form-label">NPSN</label>
                                    <input type="text" class="form-control" id="npsn" name="npsn" required>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Sekolah</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tingkatan" class="form-label">Tingkatan Sekolah</label>
                                    <select class="form-select" id="tingkatan" name="tingkatan" required>
                                        <option value="" selected>Pilih Tingkatan</option>
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA">SMA</option>
                                        <option value="SMK">SMK</option>
                                        <option value="TK">TK</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kepala_sekolah" class="form-label">Kepala Sekolah</label>
                                    <input type="text" class="form-control" id="kepala_sekolah" name="kepala_sekolah" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="akreditasi" class="form-label">Akreditasi</label>
                                    <select class="form-select" id="akreditasi" name="akreditasi" required>
                                        <option value="" selected>Pilih Akreditasi</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="Belum Terakreditasi">Belum Terakreditasi</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kurikulum" class="form-label">Kurikulum</label>
                                    <input type="text" class="form-control" id="kurikulum" name="kurikulum" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="luas_tanah" class="form-label">Luas Tanah (m²)</label>
                                    <input type="number" class="form-control" id="luas_tanah" name="luas_tanah" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="telepon" class="form-label">Telepon</label>
                                    <input type="text" class="form-control" id="telepon" name="telepon" required>
                                </div>
                            </div>
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
                                    <label for="email" class="form-label">Email Sekolah</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="sk_pendirian" class="form-label">No. SK Pendirian</label>
                                    <input type="text" class="form-control" id="sk_pendirian" name="sk_pendirian" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="tanggal_sk" class="form-label">Tanggal SK Pendirian</label>
                                    <input type="date" class="form-control" id="tanggal_sk" name="tanggal_sk" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="excel_siswa" class="form-label">Unggah Data Siswa (Format Excel)</label>
                                    <input type="file" class="form-control" id="excel_siswa" name="excel_siswa" accept=".xls,.xlsx" required>
                                    <div class="form-text">Hanya file .xls atau .xlsx yang diperbolehkan</div>
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
    </body>
</html>