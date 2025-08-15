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
                                <h3 class="card-title">Approval Purchase Requests Form</h3>
                            </div>
                            <div class="card-body">
                                <form id="PurchaseRequestForm" method="post">
                                    <div class="row" id="pr-id-row">
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="pr-id" class="form-label">Purchase Request ID</label>
                                                <input type="text" class="form-control bg-gray" id="pr-id" name="pr-id" value="<?php echo isset($pr->pr_id) ? $pr->pr_id : ''; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <input type="text" class="form-control bg-gray" id="status" name="status" value="<?php echo isset($pr->status) ? $pr->status : ''; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Request Date</label>
                                                <input type="text" class="form-control bg-gray" id="request-date" name="request-date" value="<?php echo isset($pr->request_date) ? $pr->request_date : ''; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div id="items-container">
                                        <?php if (!empty($items)) : ?>
                                            <?php foreach ($items as $index => $item) : ?>
                                                <div class="row mb-2">
                                                    <input type="hidden" id="item-id-<?= $index ?>" name="items[<?= $index ?>][id]" value="<?= $item->pr_item_id ?>">

                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <?php if ($index == 0): ?>
                                                                <label for="item-name-<?= $index ?>" class="form-label">Item Name</label>
                                                            <?php endif; ?>
                                                            <input type="text" class="form-control bg-gray" id="item-name-<?= $index ?>" name="items[<?= $index ?>][name]" value="<?= $item->item_name ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <?php if ($index == 0): ?>
                                                                <label for="item-desc-<?= $index ?>" class="form-label">Item Description</label>
                                                            <?php endif; ?>
                                                            <input type="text" class="form-control bg-gray" id="item-desc-<?= $index ?>" name="items[<?= $index ?>][desc]" value="<?= $item->item_description ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <div class="mb-3">
                                                            <?php if ($index == 0): ?>
                                                                <label for="item-qty-<?= $index ?>" class="form-label">Qty</label>
                                                            <?php endif; ?>
                                                            <input type="text" class="form-control bg-gray" id="item-qty-<?= $index ?>" name="items[<?= $index ?>][qty]" value="<?= $item->quantity ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="mb-3">
                                                            <?php if ($index == 0): ?>
                                                                <label for="item-unit-<?= $index ?>" class="form-label">Unit</label>
                                                            <?php endif; ?>
                                                            <input type="text" class="form-control bg-gray" id="item-unit-<?= $index ?>" name="items[<?= $index ?>][unit]" value="<?= $item->unit ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="status-note" class="form-label">Status Note</label>
                                            <textarea 
                                                class="form-control <?php echo ($pr->status == 'approved' || $pr->status == 'rejected') ? 'bg-gray' : ''; ?>" 
                                                id="status-note" 
                                                name="status-note"
                                                <?php echo ($pr->status == 'approved' || $pr->status == 'rejected') ? 'readonly' : ''; ?>
                                                required
                                            ><?php echo isset($pr->status_note) ? $pr->status_note : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="text-center d-flex justify-content-center gap-3">
                                        <?php if ($pr->status == 'submitted'): ?>
                                            <button type="button" class="btn btn-primary flex-fill approveBtn" style="max-width: 100px;">Approve</button>
                                            <button type="button" class="btn btn-danger flex-fill rejectBtn" style="max-width: 100px;">Reject</button>
                                            <button type="button" class="btn btn-secondary flex-fill cancelBtn" style="max-width: 100px;">Cancel</button>
                                        <?php elseif ($pr->status == 'approved' || $pr->status == 'rejected'): ?>
                                            <button type="button" class="btn btn-primary flex-fill cancelBtn" style="max-width: 100px;">Back</button>
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
                    window.location.href = "<?php echo site_url('admin/approval-purchase-request/list'); ?>";
                });

                $(document).on('click', '.approveBtn', function(e) {
                    e.preventDefault();

                    const form = document.getElementById('PurchaseRequestForm'); // ganti dengan ID form kamu
                    if (!form.reportValidity()) {
                        // Form tidak valid, browser akan otomatis kasih feedback
                        return;
                    }
                    
                    $('#loadingModal').modal('show');

                    var formData = $(this).closest('form').serialize(); // FIXED
                    console.log(formData);
                    console.log('tes');

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('admin/ApprovalPurchaseRequests/approve'); ?>',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            $('#infoModal .modal-body').html(response.message);
                            $('#infoModal').modal('show');

                            $('#infoModal').on('hidden.bs.modal', function () {
                                window.location.href = "<?php echo site_url('admin/approval-purchase-request/list'); ?>";
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

                $(document).on('click', '.rejectBtn', function(e) {
                    e.preventDefault();

                    const form = document.getElementById('PurchaseRequestForm'); // ganti dengan ID form kamu
                    if (!form.reportValidity()) {
                        // Form tidak valid, browser akan otomatis kasih feedback
                        return;
                    }
                    
                    $('#loadingModal').modal('show');

                    var formData = $(this).closest('form').serialize(); // FIXED
                    console.log(formData);
                    console.log('tes');

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('admin/ApprovalPurchaseRequests/reject'); ?>',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            $('#infoModal .modal-body').html(response.message);
                            $('#infoModal').modal('show');

                            $('#infoModal').on('hidden.bs.modal', function () {
                                window.location.href = "<?php echo site_url('admin/approval-purchase-request/list'); ?>";
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