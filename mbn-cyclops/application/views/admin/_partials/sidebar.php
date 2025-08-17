<style>
    .bg-custom-color {
        background: linear-gradient(135deg,#ff6c6cff, #ff1f1fff); /* warna biru gradasi */
    }

    /* Teks menu default */
    .color-font {
        color: black;
    }

    /* Teks saat hover atau focus */
    .color-font:hover,
    .color-font:focus,
    .sb-sidenav .nav-link.active {
        color: white; /* atau warna lain yang kontras */
        text-decoration: none; /* hilangkan underline */
    }

    /* Jika mau background biru saat hover / focus */
    .sb-sidenav .nav-link:hover,
    .sb-sidenav .nav-link:focus {
        background-color: rgba(0, 123, 255, 0.2); /* biru transparan */
    }

    /* Untuk submenu */
    .sb-sidenav-menu-nested .nav-link:hover {
        background-color: rgba(0, 123, 255, 0.1);
        color: white;
    }
</style>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion bg-custom-color" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <!-- <div class="sb-sidenav-menu-heading">Menu</div>
                <a class="nav-link" href="index.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Home
                </a> -->
                
                <?php
                    // Ambil informasi pengguna yang sedang login dari sesi
                    $loggedInUser = $this->session->userdata('logged_in_user');
                    $role = $loggedInUser['role'];
                ?>

                <div class="sb-sidenav-menu-heading">MENU</div>
                <a class="nav-link color-font d-flex justify-content-between align-items-center" href="<?php echo site_url('admin') ?>">
                    <span>Beranda</span>
                    <span style="width: 1.25rem;"></span> <!-- spacer -->
                </a>

                <?php if ($role == 'sekolah'): ?>
                    <!-- Menu khusus Sekolah -->
                    <a class="nav-link color-font d-flex justify-content-between align-items-center" href="<?php echo site_url('admin/purchase-requests') ?>">
                        <span>Pesan Katering</span>
                        <span style="width: 1.25rem;"></span>
                    </a>
                    <a class="nav-link color-font d-flex justify-content-between align-items-center" href="<?php echo site_url('admin/receive-orders/list') ?>">
                        <span>Penerimaan Pesanan Katering</span>
                        <span style="width: 1.25rem;"></span>
                    </a>
                    <a class="nav-link color-font d-flex justify-content-between align-items-center" href="">
                        <span>Ajukan Komplen</span>
                        <span style="width: 1.25rem;"></span>
                    </a>
                    <a class="nav-link color-font d-flex justify-content-between align-items-center" href="<?php echo site_url('admin/dashboard') ?>">
                        <span>Dashboard Analitik</span>
                        <span style="width: 1.25rem;"></span>
                    </a>
                <?php elseif ($role == 'kantin'): ?>
                    <!-- Menu khusus Kantin -->
                    <a class="nav-link color-font d-flex justify-content-between align-items-center" href="<?php echo site_url('admin/incoming-orders/list') ?>">
                        <span>Pesanan Masuk</span>
                        <span style="width: 1.25rem;"></span>
                    </a>

                    <a class="nav-link collapsed color-font d-flex justify-content-between align-items-center" 
                    href="#" data-bs-toggle="collapse" data-bs-target="#PesanBahan" 
                    aria-expanded="false" aria-controls="PesanBahan">
                        <span>Pesan ke Supplier</span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="collapse" id="PesanBahan" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link color-font" href="#">Pesan Bahan</a>
                            <a class="nav-link color-font" href="#">Penerimaan Pesanan Bahan</a>
                        </nav>
                    </div>

                    <a class="nav-link collapsed color-font d-flex justify-content-between align-items-center" 
                    href="#" data-bs-toggle="collapse" data-bs-target="#Komplen" 
                    aria-expanded="false" aria-controls="Komplen">
                        <span>Komplen</span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="collapse" id="Komplen" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link color-font" href="#">Daftar Komplen (dari Sekolah)</a>
                            <a class="nav-link color-font" href="#">Ajukan Komplen (ke Supplier)</a>
                        </nav>
                    </div>
                    <a class="nav-link color-font d-flex justify-content-between align-items-center" href="<?php echo site_url('admin/dashboard-kantin') ?>">
                        <span>Dashboard Analitik</span>
                        <span style="width: 1.25rem;"></span>
                    </a>
                <?php elseif ($role == 'supplier'): ?>
                    <!-- Menu khusus Kantin -->
                    <a class="nav-link color-font d-flex justify-content-between align-items-center" href="">
                        <span>Pesanan Masuk</span>
                        <span style="width: 1.25rem;"></span>
                    </a>
                    <a class="nav-link color-font d-flex justify-content-between align-items-center" href="">
                        <span>Komplen</span>
                        <span style="width: 1.25rem;"></span>
                    </a>
                    <a class="nav-link color-font d-flex justify-content-between align-items-center" href="">
                        <span>Dashboard Analitik</span>
                        <span style="width: 1.25rem;"></span>
                    </a>
                <?php elseif ($role == 'bgn'): ?>
                    <!-- Dashboard dengan submenu -->
                    <a class="nav-link collapsed color-font d-flex justify-content-between align-items-center" 
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseDashboard" 
                    aria-expanded="false" aria-controls="collapseDashboard">
                        <span>Dashboard</span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="collapse" id="collapseDashboard" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link color-font" href="#">Sekolah</a>
                            <a class="nav-link color-font" href="#">Kantin</a>
                            <a class="nav-link color-font" href="#">Supplier</a>
                        </nav>
                    </div>

                    <!-- List Pembayaran (menu tanpa submenu) -->
                    <a class="nav-link color-font d-flex justify-content-between align-items-center" href="#">
                        <span>List Pembayaran</span>
                        <span style="width: 1.25rem;"></span> <!-- spacer agar sejajar -->
                    </a>

                    <!-- Daftar Data dengan submenu -->
                    <a class="nav-link collapsed color-font d-flex justify-content-between align-items-center" 
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseData" 
                    aria-expanded="false" aria-controls="collapseData">
                        <span>Daftar Data</span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="collapse" id="collapseData" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link color-font" href="#">Sekolah</a>
                            <a class="nav-link color-font" href="#">Kantin</a>
                            <a class="nav-link color-font" href="#">Supplier</a>
                        </nav>
                    </div>

                    <!-- Komplen (menu tanpa submenu) -->
                    <a class="nav-link color-font d-flex justify-content-between align-items-center" href="#">
                        <span>Komplen</span>
                        <span style="width: 1.25rem;"></span> <!-- spacer agar sejajar -->
                    </a>

                    <!-- Approval Pendaftaran dengan submenu -->
                    <a class="nav-link collapsed color-font d-flex justify-content-between align-items-center" 
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseApproval" 
                    aria-expanded="false" aria-controls="collapseApproval">
                        <span>Approval Pendaftaran</span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="collapse" id="collapseApproval" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link color-font" href="#">Sekolah</a>
                            <a class="nav-link color-font" href="#">Kantin</a>
                            <a class="nav-link color-font" href="#">Supplier</a>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">masuk sebagai :</div>
            <?php
                // Ambil informasi pengguna yang sedang login dari sesi
                //$loggedInUser = $this->session->userdata('logged_in_user');

                // Tampilkan nama pengguna yang sedang login
                echo $loggedInUser['username']; // Anda perlu menyesuaikan ini dengan atribut yang sesuai dari pengguna
            ?>
        </div>
    </nav>
</div>