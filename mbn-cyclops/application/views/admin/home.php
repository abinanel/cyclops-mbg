<!DOCTYPE html>
<html lang="en">
    <head>
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
            color:rgb(43, 167, 208);
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
                        <div class="branding">
                            <img src="<?= base_url('assets/img/MBN_logo.png') ?>" alt="MBN Logo" style="width: 100px; height: 100px; margin-bottom: 0px; margin-left: 0px;" />
                            <span class="branding-text">Sistem Pesan Katering</span>
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
