<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("admin/_partials/head.php") ?>
    <link href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css" rel="stylesheet">
    <style>
        html, body { height: 95%; }
        .bg-gray { background-color: #e9ecef; pointer-events: none; opacity: 1; }
        body { font-family: Arial, sans-serif; background: #f5f7fa; margin: 0; padding: 20px; }
        h2 { margin-top: 40px; font-size: 20px; color: #333; }
        .dashboard { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; }
        .card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        canvas { max-width: 100%; }
    </style>
</head>
<body class="sb-nav-fixed">
    <?php $this->load->view("admin/_partials/navbar.php") ?>
    <div id="layoutSidenav">
        <?php $this->load->view("admin/_partials/sidebar.php") ?>
        <div id="layoutSidenav_content">
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

                    <!-- History Penjualan Makanan -->
                    <div class="card mb-4">
                        <h5>📈 History Penjualan Makanan - 5 Bulan Terakhir</h5>
                        <canvas id="historyPenjualanChart" width="1100" height="150"></canvas>
                    </div>

                    <div class="row mb-4">
                        <!-- TOP 5 Supplier -->
                        <div class="col-md-6">
                            <div class="card">
                                <h5>🚚 TOP 5 Supplier - Ketepatan Pengiriman Bahan</h5>
                                <canvas id="topSupplierChart" width="450" height="120"></canvas>
                            </div>
                        </div>

                        <!-- TOP 10 Bahan -->
                        <div class="col-md-6">
                            <div class="card">
                                <h5>🛒 TOP 10 Bahan yang Paling Sering Dipesan</h5>
                                <canvas id="topBahanChart" width="450" height="120"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- History Pemesanan Bahan -->
                    <div class="card mb-4">
                        <h5>📊 History Pemesanan Bahan - 6 Bulan Terakhir</h5>
                        <canvas id="historyBahanChart" width="1100" height="150"></canvas>
                    </div>

                    <div class="row mb-4">
                        <!-- Komplen Response dari Sekolah -->
                        <div class="col-md-6">
                            <div class="card">
                                <h5>📩 Komplen Response dari Sekolah</h5>
                                <canvas id="complenSekolahChart" width="450" height="120"></canvas>
                            </div>
                        </div>

                        <!-- Komplen Response ke Supplier -->
                        <div class="col-md-6">
                            <div class="card">
                                <h5>📤 Komplen Response ke Supplier</h5>
                                <canvas id="complenSupplierChart" width="450" height="120"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <?php $this->load->view("admin/_partials/footer.php") ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url('js/scripts.js') ?>"></script>
    <script>
        // ===================== DUMMY DATA =====================
        const sekolahLabels = ['SMA 1', 'SMK 2', 'SMP 3', 'SMA 4', 'SMP 5'];
        const jumlahPesananSekolah = [420, 390, 370, 340, 310];

        const menuLabels = ['Nasi Ayam', 'Mie Goreng', 'Soto Ayam', 'Bakso', 'Gado-Gado'];
        const menuCount = [150, 130, 120, 110, 100];

        const bulanLabels = ['Mar', 'Apr', 'Mei', 'Jun', 'Jul'];
        const penjualanBulan = [900, 1100, 1050, 1200, 1250];

        const supplierLabels = ['Supplier A', 'Supplier B', 'Supplier C', 'Supplier D', 'Supplier E'];
        const supplierPercent = [100, 98, 96, 94, 90];

        const bahanLabels = ['Beras', 'Gula', 'Telur', 'Ayam', 'Susu', 'Sayur', 'Minyak', 'Roti', 'Tepung', 'Bumbu'];
        const bahanCount = [120, 110, 100, 95, 90, 85, 80, 75, 70, 65];

        const bulanBahanLabels = ['Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'];
        const pemesananBulan = [500, 600, 550, 650, 700, 720];

        const complenStatusLabels = ['Selesai', 'Pending', 'Ditolak'];
        const complenStatusCountSekolah = [8, 3, 2];
        const complenStatusCountSupplier = [5, 2, 1];

        // ===================== CHARTS =====================
        // Top 5 Sekolah
        new Chart(document.getElementById('topSekolahChart'), {
            type: 'bar',
            data: {
                labels: sekolahLabels,
                datasets: [{ label: 'Jumlah Pesanan', data: jumlahPesananSekolah, backgroundColor: '#28a745' }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => ctx.parsed.y + ' pesanan' } }
                },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Top 5 Menu
        new Chart(document.getElementById('topMenuChart'), {
            type: 'doughnut',
            data: {
                labels: menuLabels,
                datasets: [{ label: 'Jumlah Pesanan', data: menuCount, backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#6A5ACD', '#4BC0C0'] }]
            },
            options: { responsive: false, plugins: { legend: { position: 'right' } } }
        });

        // History Penjualan Makanan
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
            options: { responsive: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });

        // Top 5 Supplier - Bar Chart
        new Chart(document.getElementById('topSupplierChart'), {
            type: 'bar',
            data: { labels: supplierLabels, datasets: [{ label: 'Persentase Pengiriman (%)', data: supplierPercent, backgroundColor: '#ffc107' }] },
            options: {
                responsive: true,
                plugins: { legend: { display: false }, tooltip: { callbacks: { label: ctx => ctx.parsed.y + ' %' } } },
                scales: { y: { beginAtZero: true, max: 100 } }
            }
        });

        // Top 10 Bahan - Pie Chart
        new Chart(document.getElementById('topBahanChart'), {
            type: 'pie',
            data: { labels: bahanLabels, datasets: [{ label: 'Jumlah Pesanan', data: bahanCount, backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#6A5ACD', '#4BC0C0', '#FF9F40', '#9966FF', '#C9CBCF', '#FF6666', '#66CC99'] }] },
            options: { responsive: false, plugins: { legend: { position: 'right' } } }
        });

        // History Pemesanan Bahan
        new Chart(document.getElementById('historyBahanChart'), {
            type: 'line',
            data: { labels: bulanBahanLabels, datasets: [{ label: 'Pemesanan Bahan', data: pemesananBulan, fill: true, borderColor: '#ffc107', backgroundColor: 'rgba(255, 193, 7, 0.2)', tension: 0.4 }] },
            options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });

        // Komplen Response dari Sekolah - Pie Chart
        new Chart(document.getElementById('complenSekolahChart'), {
            type: 'pie',
            data: { labels: complenStatusLabels, datasets: [{ label: 'Status Komplen', data: complenStatusCountSekolah, backgroundColor: ['#28a745', '#ffc107', '#dc3545'] }] },
            options: { responsive: false, plugins: { legend: { position: 'right' } } }
        });

        // Komplen Response ke Supplier - Pie Chart
        new Chart(document.getElementById('complenSupplierChart'), {
            type: 'pie',
            data: { labels: complenStatusLabels, datasets: [{ label: 'Status Komplen', data: complenStatusCountSupplier, backgroundColor: ['#28a745', '#ffc107', '#dc3545'] }] },
            options: { responsive: false, plugins: { legend: { position: 'right' } } }
        });
    </script>
</body>
</html>
