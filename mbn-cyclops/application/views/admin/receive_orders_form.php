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
                                <h3 class="card-title">Detail Penerimaan Pesanan</h3>
                            </div>
                            <div class="card-body">
                                <form id="PurchaseRequestForm" method="post">
                                    <div class="row" id="pr-id-row">
                                        <input type="hidden" id="split" name="split" value="<?php echo isset($split_po->split_po_id) ? $split_po->split_po_id : ''; ?>">
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="pr-id" class="form-label">Pesanan ID</label>
                                                <input type="text" class="form-control bg-gray" id="split-po-id" name="split-po-id" value="<?php echo isset($split_po->po_id) ? $split_po->po_id : ''; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Kantin</label>
                                                <input type="text" class="form-control bg-gray" id="supplier-name" name="supplier-name" value="<?php echo isset($suppliers->kantin_name) ? $suppliers->kantin_name : ''; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="receive-date" class="form-label">Tanggal Terima</label>
                                                <input 
                                                    type="date" 
                                                    class="form-control" 
                                                    id="receive-date" 
                                                    name="receive-date"
                                                    value="<?= ($split_po->status == 'received') ? $received_date : date('Y-m-d') ?>" 
                                                    min="<?= date('Y-m-d') ?>" 
                                                    <?= ($split_po->status == 'received') ? 'disabled' : '' ?>
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div id="items-container">
                                        <?php if (!empty($items)) : ?>
                                            <?php foreach ($items as $index => $item) : ?>
                                                <div class="row mb-2">
                                                    <input type="hidden" id="item-id-<?= $index ?>" name="items[<?= $index ?>][id]" value="<?= $item->split_po_item_id ?>">

                                                    <div class="col-md-2">
                                                        <div class="mb-3">
                                                            <?php if ($index == 0): ?>
                                                                <label for="item-name-<?= $index ?>" class="form-label">Nama Makanan</label>
                                                            <?php endif; ?>
                                                            <input type="text" class="form-control bg-gray" id="item-name-<?= $index ?>" name="items[<?= $index ?>][name]" value="<?= $item->item_name ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="mb-3">
                                                            <?php if ($index == 0): ?>
                                                                <label for="item-qty-<?= $index ?>" class="form-label">Kuantitas Pesan</label>
                                                            <?php endif; ?>
                                                            <input type="text" class="form-control bg-gray" id="item-qty-<?= $index ?>" name="items[<?= $index ?>][qty]" value="<?= $item->quantity ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="mb-3">
                                                            <?php if ($index == 0): ?>
                                                                <label for="item-desc-<?= $index ?>" class="form-label">Kuantitas Terima</label>
                                                            <?php endif; ?>
                                                            <input type="text" class="form-control" id="item-rcv-<?= $index ?>" name="items[<?= $index ?>][rcv]" value="<?= $item->quantity_received ?>" <?= ($split_po->status == 'received') ? 'disabled' : '' ?>>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <div class="mb-3">
                                                            <?php if ($index == 0): ?>
                                                                <label for="item-unit-<?= $index ?>" class="form-label">Satuan</label>
                                                            <?php endif; ?>
                                                            <input type="text" class="form-control bg-gray" id="item-unit-<?= $index ?>" name="items[<?= $index ?>][unit]" value="<?= $item->unit ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="mb-3">
                                                            <?php if ($index == 0): ?>
                                                                <label for="item-unit-<?= $index ?>" class="form-label">Target Tanggal Kirim</label>
                                                            <?php endif; ?>
                                                            <input type="text" class="form-control bg-gray" id="item-target-<?= $index ?>" name="items[<?= $index ?>][target]" value="<?= $item->delivery_target_date ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="notes" class="form-label">Catatan</label>
                                            <textarea 
                                                class="form-control" 
                                                id="notes" 
                                                name="notes" 
                                                <?= ($split_po->status == 'received') ? 'disabled' : '' ?>
                                            ><?= $notes ?></textarea>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="text-center d-flex justify-content-center gap-3">
                                    <?php if ($split_po->status == 'received'): ?>
                                        <button type="button" class="btn btn-primary flex-fill cancelBtn" style="max-width: 100px;">Back</button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-primary flex-fill receiveBtn" style="max-width: 100px;">Receive</button>
                                        <button type="button" class="btn btn-secondary flex-fill cancelBtn" style="max-width: 100px;">Cancel</button>
                                    <?php endif; ?>
                                    </div>
                                    <br>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
                <!--end of main page here -->

                <?php $this->load->view("admin/_partials/footer.php") ?>
            </div>

            <!-- Modal untuk Pesan -->
            <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Notification System</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Pesan akan dimuat di sini -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
            </div>

            <!-- Modal untuk Konfirmasi Penghapusan -->
            <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Delete Confirmation</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure want to delete this data ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="deleteConfirmBtn">Delete</button>
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
                $(document).on('click', '.cancelBtn', function() {
                    window.location.href = "<?php echo site_url('admin/receive-orders/list'); ?>";
                });

                $(document).on('click', '.receiveBtn', function(e) {
                    e.preventDefault();
                    $('#loadingModal').modal('show');

                    var formData = $(this).closest('form').serialize(); // FIXED
                    console.log(formData);
                    console.log('tes');

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('admin/ReceiveOrders/receive'); ?>',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            $('#infoModal .modal-body').html(response.message);
                            $('#infoModal').modal('show');

                            $('#infoModal').on('hidden.bs.modal', function () {
                                window.location.href = "<?php echo site_url('admin/receive-orders/list'); ?>";
                            });

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            var error = jqXHR.responseJSON && jqXHR.responseJSON.error ? jqXHR.responseJSON.error : 'An error occurred';
                            $('#infoModal .modal-body').html('Error: ' + error);
                            $('#infoModal').modal('show');
                        }
                    }).always(function() {
                        setTimeout(function() {
                            $('#loadingModal').modal('hide');
                        }, 500);
                    });
                });
            });
        </script>
    </body>
</html>