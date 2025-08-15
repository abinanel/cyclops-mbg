<head>
    <style>
        .bg-cyclops {
            background: linear-gradient(135deg,rgb(179, 226, 245),rgb(79, 195, 249)); /* warna biru gradasi */
            color: white;
        }
    </style>
</head>

<nav class="sb-topnav navbar navbar-expand navbar-dark bg-cyclops">
    <!-- Navbar Brand-->
    <!-- <a class="navbar-brand ps-3" href="index.html">Start Bootstrap</a> bg-dark-->
    <a class="navbar-brand ps-3" href="<?php echo site_url('admin') ?>">
        <img src="<?= base_url('assets/img/MBN_logo.png') ?>" alt="Logo" style="width: 50px; height: 50px; margin-bottom: -50px; margin-left: 0px;">
        <span style="display: flex; font-size: 17px; font-weight: bold; color:rgba(0, 0, 0, 1); margin-bottom: 30px; margin-left: 60px;">Sistem Pesan Katering</span>
    </a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!" style="margin-left: 30px;"><i class="fas fa-bars" style="color: black;"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <!-- <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
        </div> -->
    </form>
</nav>