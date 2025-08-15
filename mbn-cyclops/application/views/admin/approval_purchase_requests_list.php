<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view("admin/_partials/head.php") ?>
        <link href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css" rel="stylesheet">
        <style>
            #datatablesSimple td, #datatablesSimple th {
                text-align: left !important;
            }
            html, body {
                height: 95%; /* atau bisa juga height: 100vh; */
            }
            .bg-gray {
                background-color: #e9ecef;
                pointer-events: none; /* Menghilangkan interaksi seperti klik */
                opacity: 1; /* Opsional: Menambahkan efek transparansi untuk visual */
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
                    <div class="container mt-5">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Purchase Requests List</h3>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Purchase Request ID</th>
                                            <th>Status</th>
                                            <th>Request Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <!--end of main page here -->

                <?php $this->load->view("admin/_partials/footer.php") ?>
            </div>

            <!-- Modal Loading -->
            <div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                    </div>
                    <h5 class="mt-2">Loading...</h5>
                </div>
                </div>
            </div>
            </div>
        </div>
        <script src="https://unpkg.com/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('js/scripts.js') ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                //Function yang dipanggil akan terload saat awal page
                loadDataTable();

                function loadDataTable() {
                    let table = new DataTable('#datatablesSimple');
                    $.ajax({
                        url: '<?php echo site_url('admin/PurchaseRequests/get_list_not_in_draft'); ?>',
                        type: 'GET',
                        dataType: 'json',
                        success: function(dataList) {
                            updateTable(dataList)
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log('Error loading kegiatans: ' + textStatus);
                        }
                    });
                }

                //list function yang bisa digunakan
                function updateTable(dataList) {
                    if (dataList.length === 0) {
                        tbody.append('<tr><td colspan="4">Tidak ada data yang ditemukan</td></tr>');
                        return;
                    }

                    $('#datatablesSimple').DataTable().destroy();

                    var tbody = $('#datatablesSimple tbody');
                    tbody.empty(); // Bersihkan isi tabel saat ini

                    $.each(dataList, function(index, data) {
                        var row = '<tr>' +
                                '<td>' + data.pr_id + '</td>' +
                                '<td>' + data.status + '</td>' +
                                '<td>' + data.request_date + '</td>' +
                                '<td> <button type="button" class="btn btn-primary btn-sm me-2 editBtn" data-id="' + data.pr_id + '">View</button> </td>' +
                                '</tr>';
                        tbody.append(row);
                    });

                    $('#datatablesSimple').DataTable({
                        order: [[0, 'desc']] // ⬅️ kolom ke-0 (pr_id), descending
                    });
                }

                $(document).on('click', '.editBtn', function() {
                    var id = $(this).data('id'); // mengambil ID dari data-id attribute
                    window.location.href = '<?php echo site_url("admin/approval-purchase-request/form"); ?>/' + id;
                });
            });
        </script>
    </body>
</html>