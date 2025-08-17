<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <?php $this->load->view("admin/_partials/head.php") ?>
        <style>
            .branding {
            position: absolute;
            display: flex;
            top: 30%;
            left: 40%;
            align-items: center;
            flex-direction: column; /* susun vertikal */
            gap: 0px;
            font-weight: bold;
            font-size: 24px;
            color: #000;
            padding: 10px 20px;
            border-radius: 12px;
            color:rgba(0, 0, 0, 1);
        }

        .logo-daikin {
            height: 75px;
            width: auto;
        }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <?php $this->load->view("admin/_partials/navbar.php") ?>
        <div id="layoutSidenav">
            <?php $this->load->view("admin/_partials/sidebar.php") ?>
            
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="branding-card" style="
                            display: flex;
                            align-items: center;
                            background-color: #fff0f0ff;
                            border-radius: 12px;
                            padding: 20px;
                            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                            max-width: 80%;
                            margin: 50px auto;
                        ">
                            <?php
                            $loggedInUser = $this->session->userdata('logged_in_user');
                            $role = $loggedInUser['role'] ?? '';

                            if ($role == 'sekolah') {
                                $logo = 'https://static.thenounproject.com/png/school-icon-7947478-512.png';
                                $text = $loggedInUser['department_name'] ?? '';

                                $alamat = $loggedInUser['alamat'] ?? '';
                                $kepala = $loggedInUser['kepala_sekolah'] ?? '';
                                $tingkatan = $loggedInUser['tingkatan'] ?? '';
                                $npsn = $loggedInUser['npsn'] ?? '';
                                $akreditasi = $loggedInUser['akreditasi'] ?? '';
                                $email = $loggedInUser['email'] ?? '';
                                $telepon = $loggedInUser['telepon'] ?? '';
                                $student_total = $loggedInUser['student_total'] ?? '';
                            } elseif ($role == 'kantin') {
                                $logo = 'https://static.thenounproject.com/png/canteen-icon-324071-512.png';
                                $text = $loggedInUser['nama_kantin'] ?? '';

                                $email        = $loggedInUser['email_kantin'] ?? '';
                                $pemilik      = $loggedInUser['nama_pemilik'] ?? '';
                                $tahunBerdiri = $loggedInUser['tahun_berdiri'] ?? '';
                                $provinsi     = $loggedInUser['provinsi'] ?? '';
                                $kota         = $loggedInUser['kota'] ?? '';
                                $kecamatan    = $loggedInUser['kecamatan'] ?? '';
                                $kelurahan    = $loggedInUser['kelurahan'] ?? '';
                                $alamat       = $loggedInUser['alamat_kantin'] ?? '';
                            } elseif ($role == 'bgn') {
                                $logo = base_url('assets/img/BGN_LOGO.png');
                                $text = 'Program Makan Gratis Nasional';
                            } elseif ($role == 'supplier') {
                                $logo = 'https://static.thenounproject.com/png/supplier-icon-2673557-512.png';
                                $text = $loggedInUser['nama_supplier'] ?? '';

                                $email        = $loggedInUser['email_supplier'] ?? '';
                                $pemilik      = $loggedInUser['penanggung_jawab'] ?? '';
                                $tahunBerdiri = $loggedInUser['tahun_berdiri'] ?? ''; // jika tidak ada di supplier, bisa dikosongkan atau hapus
                                $provinsi     = $loggedInUser['provinsi'] ?? '';
                                $kota         = $loggedInUser['kota'] ?? '';
                                $kecamatan    = $loggedInUser['kecamatan'] ?? '';
                                $kelurahan    = $loggedInUser['kelurahan'] ?? '';
                                $alamat       = $loggedInUser['alamat_supplier'] ?? '';
                            }
                            ?>
                            
                            <!-- Logo -->
                            <?php if ($role == 'bgn') : ?>
                                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100%;">
                                    <img src="<?= $logo ?>" alt="Logo" style="width: 450px; height: 200px; border-radius: 8px;">
                                    <h3 style="margin: 10px 0 0 0; color: #2ba7d0; text-align: center;"><?= $text ?></h3>
                                </div>
                            <?php else : ?>
                                <div style="flex-shrink: 0;">
                                    <img src="<?= $logo ?>" alt="Logo Lain" style="width: 250px; height: 200px; border-radius: 8px;">
                                </div>
                            <?php endif; ?>
                            <!-- Info sekolah -->
                            <div style="margin-left: 20px; flex-grow: 1;">
                                <?php if ($role != 'bgn') : ?>
                                    <h3 style="margin: 0; color: #2ba7d0;"><?= $text ?></h3>
                                <?php endif; ?>
                                
                                <?php if ($role == 'sekolah') : ?>
                                    <div style="
                                        display: grid;
                                        grid-template-columns: max-content 1fr;
                                        gap: 5px 10px;
                                        font-size: 14px;
                                        color: #333;
                                        margin-top: 5px;
                                    ">
                                        <?php if ($tingkatan) : ?><div><strong>Tingkatan:</strong></div><div><?= $tingkatan ?></div><?php endif; ?>
                                        <?php if ($kepala) : ?><div><strong>Kepala Sekolah:</strong></div><div><?= $kepala ?></div><?php endif; ?>
                                        <?php if ($alamat) : ?><div><strong>Alamat:</strong></div><div><?= $alamat ?></div><?php endif; ?>
                                        <?php if ($npsn) : ?><div><strong>NPSN:</strong></div><div><?= $npsn ?></div><?php endif; ?>
                                        <?php if ($akreditasi) : ?><div><strong>Akreditasi:</strong></div><div><?= $akreditasi ?></div><?php endif; ?>
                                        <?php if ($email) : ?><div><strong>Email:</strong></div><div><?= $email ?></div><?php endif; ?>
                                        <?php if ($telepon) : ?><div><strong>Telepon:</strong></div><div><?= $telepon ?></div><?php endif; ?>
                                        <?php if ($student_total) : ?><div><strong>Jumlah Siswa:</strong></div><div><?= $student_total ?></div><?php endif; ?>
                                    </div>
                                <?php elseif ($role == 'kantin') : ?>
                                    <div style="
                                        display: grid;
                                        grid-template-columns: max-content 1fr;
                                        gap: 5px 10px;
                                        font-size: 14px;
                                        color: #333;
                                        margin-top: 5px;
                                    ">
                                        <?php if ($pemilik) : ?><div><strong>Nama Pemilik:</strong></div><div><?= $pemilik ?></div><?php endif; ?>
                                        <?php if ($tahunBerdiri) : ?><div><strong>Tahun Berdiri:</strong></div><div><?= $tahunBerdiri ?></div><?php endif; ?>
                                        <?php if ($provinsi) : ?><div><strong>Provinsi:</strong></div><div><?= $provinsi ?></div><?php endif; ?>
                                        <?php if ($kota) : ?><div><strong>Kota:</strong></div><div><?= $kota ?></div><?php endif; ?>
                                        <?php if ($kecamatan) : ?><div><strong>Kecamatan:</strong></div><div><?= $kecamatan ?></div><?php endif; ?>
                                        <?php if ($kelurahan) : ?><div><strong>Kelurahan:</strong></div><div><?= $kelurahan ?></div><?php endif; ?>
                                        <?php if ($alamat) : ?><div><strong>Alamat:</strong></div><div><?= $alamat ?></div><?php endif; ?>
                                        <?php if ($email) : ?><div><strong>Email:</strong></div><div><?= $email ?></div><?php endif; ?>
                                    </div>
                                <?php elseif ($role == 'supplier') : ?>
                                    <div style="
                                        display: grid;
                                        grid-template-columns: max-content 1fr;
                                        gap: 5px 10px;
                                        font-size: 14px;
                                        color: #333;
                                        margin-top: 5px;
                                    ">
                                        <?php if ($pemilik) : ?>
                                            <div><strong>Penanggung Jawab:</strong></div><div><?= $pemilik ?></div>
                                        <?php endif; ?>
                                        <?php /* Tahun Berdiri tidak ada di tabel supplier, bisa dihapus atau dikosongkan */ ?>
                                        <?php if ($provinsi) : ?>
                                            <div><strong>Provinsi:</strong></div><div><?= $provinsi ?></div>
                                        <?php endif; ?>
                                        <?php if ($kota) : ?>
                                            <div><strong>Kota:</strong></div><div><?= $kota ?></div>
                                        <?php endif; ?>
                                        <?php if ($kecamatan) : ?>
                                            <div><strong>Kecamatan:</strong></div><div><?= $kecamatan ?></div>
                                        <?php endif; ?>
                                        <?php if ($kelurahan) : ?>
                                            <div><strong>Kelurahan:</strong></div><div><?= $kelurahan ?></div>
                                        <?php endif; ?>
                                        <?php if ($alamat) : ?>
                                            <div><strong>Alamat:</strong></div><div><?= $alamat ?></div>
                                        <?php endif; ?>
                                        <?php if ($email) : ?>
                                            <div><strong>Email:</strong></div><div><?= $email ?></div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </main>
                <?php $this->load->view("admin/_partials/footer.php") ?>
            </div>
            
        </div>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> -->
        <script src="https://unpkg.com/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('js/scripts.js') ?>"></script>
    </body>
</html>
