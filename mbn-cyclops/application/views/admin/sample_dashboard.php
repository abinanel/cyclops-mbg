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
                    <h1 class="mb-4 text-center">Dashboard Analitik Pesanan</h1>

                    <div class="row mb-4">
                        <!-- Top 5 Kantin -->
                        <div class="col-md-6">
                            <!-- TOP 5 Kantin dengan Ketepatan Waktu -->
                            <div class="card">
                                <h5>🏆 TOP 5 Kantin - Ketepatan Waktu Kirim (%)</h5>
                            <canvas id="topKantinChart" width="450" height="100"></canvas>
                            </div>
                        </div>

                        <!-- Top Makanan -->
                        <div class="col-md-6">
                            <!-- TOP 5 Makanan yang sering dipesan -->
                            <div class="card">
                                <h5>🍽️ TOP 5 Makanan yang Sering Dipesan</h5>
                            <canvas id="topMakananChart" width="450" height="120"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <h5>📅 History Pemesanan Makanan - 6 Bulan Terakhir</h5>
                        <canvas id="historyChart" width="1100" height="150"></canvas>
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
            // Dummy data
            const kantinLabels = ['Kantin A', 'Kantin B', 'Kantin C', 'Kantin D', 'Kantin E'];
            const ketepatanWaktu = [98, 95, 93, 90, 89];

            const makananLabels = ['Nasi Goreng', 'Ayam Geprek', 'Mie Ayam', 'Bakso', 'Sate Ayam'];
            const makananCount = [320, 300, 280, 260, 250];

            const bulanLabels = ['Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'];
            const jumlahPemesanan = [1200, 1400, 1350, 1500, 1700, 1600];

            // Chart 1: Bar Chart - TOP 5 Kantin Ketepatan Waktu
            new Chart(document.getElementById('topKantinChart'), {
            type: 'bar',
            data: {
                labels: kantinLabels,
                datasets: [{
                label: 'Ketepatan Waktu (%)',
                data: ketepatanWaktu,
                backgroundColor: '#4CAF50'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                legend: { display: false },
                tooltip: { callbacks: {
                    label: context => context.parsed.y + '%'
                }}
                },
                scales: {
                y: {
                    min: 80,
                    max: 100,
                    ticks: { callback: value => value + '%' }
                }
                }
            }
            });

            // Chart 2: Doughnut Chart - TOP 5 Makanan
            new Chart(document.getElementById('topMakananChart'), {
            type: 'doughnut',
            data: {
                labels: makananLabels,
                datasets: [{
                label: 'Jumlah Pesanan',
                data: makananCount,
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

            // Chart 3: Line Chart - History Pemesanan
            new Chart(document.getElementById('historyChart'), {
            type: 'line',
            data: {
                labels: bulanLabels,
                datasets: [{
                label: 'Jumlah Pemesanan',
                data: jumlahPemesanan,
                fill: true,
                borderColor: '#FF5733',
                backgroundColor: 'rgba(255,87,51,0.2)',
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