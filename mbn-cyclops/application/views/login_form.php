<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view("admin/_partials/head.php") ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            margin: 0;
            background: linear-gradient(135deg, #ff6c6cff, #ff1f1fff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-wrapper {
            position: relative;
            height: 100%;
        }

        .login-container {
            position: absolute;
            top: 50%;
            right: 10%;
            transform: translateY(-50%);
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 30%;
            max-width: 30%;
        }

        .login-title {
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            color: #f81919ff;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            color: #555;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-primary {
            width: 100%;
            border-radius: 10px;
            padding: 10px;
        }

        .invalid-feedback {
            display: block;
            color: red;
            font-size: 0.9rem;
        }

        .branding {
            position: absolute;
            top: 40%;
            left: 5%;
            display: flex;
            align-items: center;
            gap: 0px;
            font-weight: bold;
            font-size: 24px;
            color: #000;
            background-color: rgba(255, 255, 255, 0.6);
            padding: 10px 20px;
            border-radius: 12px;
            color: #000000ff;
        }

        .logo-mbn {
            height: 100px;
            width: auto;
            margin-right: 10px;
        }

        a.no-underline {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="branding">
            <img src="<?= base_url('assets/img/MBN_logo.png') ?>" alt="{MBN Logo} " class="logo-mbn" />
            <span>Program Makan Gratis Nasional</span>
        </div>

        <div class="login-container">
            <div class="login-title">Masuk</div>
            <div class="subtitle">Silakan masuk untuk melanjutkan</div>

            <?php if ($this->session->flashdata('message_login_error')) : ?>
                <div class="alert-danger text-center" style="font-size: 13px; color: red;">
                    <?= $this->session->flashdata('message_login_error') ?>
                </div>
            <?php endif ?>

            <form action="" method="post" novalidate>
                <div class="mb-3">
                    <label for="username" class="form-label">Email/Username*</label>
                    <input type="text" class="form-control" name="username" placeholder="masukkan email atau username anda"
                        value="<?= set_value('username') ?>" required />
                    <div class="invalid-feedback">
                        <?= form_error('username') ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password*</label>
                    <input type="password" class="form-control" name="password" placeholder="masukkan password anda"
                        value="<?= set_value('password') ?>" required />
                    <div class="invalid-feedback">
                        <?= form_error('password') ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>

                <!-- Tambahan link -->
                <div class="mt-4">
                    <span>Belum Punya Akun? </span><br>
                    <a href="<?php echo site_url('register-school') ?>" class="no-underline">Daftarkan Sekolah</a> ,
                    <a href="<?php echo site_url('register-kantin') ?>" class="no-underline">Daftarkan Kantin</a> 
                    atau <a href="<?php echo site_url('register-supplier') ?>" class="no-underline">Daftarkan Supplier</a>
                </div>
            </form>
        </div>
    </div>

    <?php $this->load->view("admin/_partials/footer.php") ?>
</body>

</html>
