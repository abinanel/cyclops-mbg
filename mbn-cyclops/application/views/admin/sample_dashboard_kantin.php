<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view("admin/_partials/head.php") ?>
        <link href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css" rel="stylesheet">
        <style>
            html, body {
                height: 95%; /* atau bisa juga height: 100vh; */
            }
            .bg-gray {
                background-color: #e9ecef;
                pointer-events: none; /* Menghilangkan interaksi seperti klik */
                opacity: 1; /* Opsional: Menambahkan efek transparansi untuk visual */
            }
            body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 20px;
            }

            h2 {
            margin-top: 40px;
            font-size: 20px;
            color: #333;
            }

            .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            }

            .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            }

            canvas {
            max-width: 100%;
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
                    <div class="container my-1">
                    <h1 class="mb-4 text-center">Dashboard Analitik Pesanan Sekolah</h1>

                    <div class="row mb-4">
                        <!-- Top 5 Sekolah -->
                        <div class="col-md-6">
                            <div class="card">
                                <h5>🏫 TOP 5 Sekolah - Jumlah Pesanan Terbanyak</h5>
                                <canvas id="topSekolahChart" width="450" height="100"></canvas>
                            </div>
                        </div>

                        <!-- Top Menu -->
                        <div class="col-md-6">
                            <div class="card">
                                <h5>🍱 TOP 5 Menu yang Dipesan</h5>
                                <canvas id="topMenuChart" width="450" height="120"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <h5>📈 History Penjualan Makanan - 5 Bulan Terakhir</h5>
                        <canvas id="historyPenjualanChart" width="1100" height="150"></canvas>
                    </div>
                </div>
                </main>
                <!--end of main page here -->

                <?php $this->load->view("admin/_partials/footer.php") ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://unpkg.com/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('js/scripts.js') ?>"></script>
        <script>
            //Dummy data - kamu bisa ganti dengan data asli dari backend
            const sekolahLabels = ['SMA 1', 'SMK 2', 'SMP 3', 'SMA 4', 'SMP 5'];
            const jumlahPesananSekolah = [420, 390, 370, 340, 310];

            const menuLabels = ['Nasi Ayam', 'Mie Goreng', 'Soto Ayam', 'Bakso', 'Gado-Gado'];
            const menuCount = [150, 130, 120, 110, 100];

            const bulanLabels = ['Mar', 'Apr', 'Mei', 'Jun', 'Jul'];
            const penjualanBulan = [900, 1100, 1050, 1200, 1250];

            // Chart 1: Bar Chart - TOP 5 Sekolah Jumlah Pesanan
            new Chart(document.getElementById('topSekolahChart'), {
                type: 'bar',
                data: {
                    labels: sekolahLabels,
                    datasets: [{
                        label: 'Jumlah Pesanan',
                        data: jumlahPesananSekolah,
                        backgroundColor: '#007bff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: context => context.parsed.y + ' pesanan'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Chart 2: Doughnut Chart - TOP 5 Menu
            new Chart(document.getElementById('topMenuChart'), {
                type: 'doughnut',
                data: {
                    labels: menuLabels,
                    datasets: [{
                        label: 'Jumlah Pesanan',
                        data: menuCount,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#6A5ACD', '#4BC0C0']
                    }]
                },
                options: {
                    responsive: false,
                    plugins: {
                        legend: { position: 'right' }
                    }
                }
            });

            // Chart 3: Line Chart - History Penjualan
            new Chart(document.getElementById('historyPenjualanChart'), {
                type: 'line',
                data: {
                    labels: bulanLabels,
                    datasets: [{
                        label: 'Penjualan',
                        data: penjualanBulan,
                        fill: true,
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </body>
</html>