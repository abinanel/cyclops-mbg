<?php

class PurchaseRequests extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
		$this->load->model('auth_model');
		$this->load->model('Purchase_requests_model');
		$this->load->model('Purchase_requests_items_model');
        $this->load->model('Purchase_orders_model');
        $this->load->model('Split_purchase_orders_model');
        $this->load->model('Split_po_items_model');
        $this->load->model('Kantin_model');
		if(!$this->auth_model->current_user()){
			redirect('auth/login');
		}
	}

	public function index()
	{
        $this->load->model("Kantin_model"); // pastikan model sudah di-load
        $data['kantin_list'] = $this->Kantin_model->get_all(); // ambil semua kantin

        // load view admin/overview.php
        $this->load->view("admin/purchase_requests_form", $data);
	}

    public function get_list_by_user_id() {
		// Mengambil user id dari sesi pengguna
        $user_id = $this->session->userdata('user_id');

		
		//Panggil metode get_list_by_user_id dari model Purchase_requests_model
		//$purchase_requests = $this->Purchase_requests_model->get_list_by_user_id($user_id);

        //Panggil metode get_list_by_user_id dari model Purchase_orders_model
		$purchase_orders = $this->Purchase_orders_model->get_list_by_user_id($user_id);

		// Kirimkan data sebagai JSON
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($purchase_orders));
	}

    public function submit() {
        $po_id = $this->input->post('pr-id');

        log_message('debug', 'PO ID yang diterima: ' . $po_id);
    
        #Cek apakah pr_id sudah ada di database
        $existingPO = $this->Purchase_orders_model->get_by_id($po_id);
    
        if ($existingPO) {
            $this->update($po_id);
        } else {
            $this->save($po_id); // kirim pr_id agar tidak di-generate ulang
        }
    }

    public function save($pr_id) {
        // Mengambil user_id dari sesi pengguna
        $user_id = $this->session->userdata('user_id');

		// Ambil nilai dari input
        $status = $this->input->post('status');
        $statusNote = $this->input->post('status-note');
        $items = $this->input->post('items');

        date_default_timezone_set('Asia/Jakarta'); // Set timezone ke Jakarta
    
        // Simpan PR utama ke database (jika belum ada)
        // $prData = [
        //     'created_by'   => $user_id,
        //     'request_date' => date('Y-m-d'), // tanggal saat ini dalam format YYYY-MM-DD
        //     'status'       => $status,
        //     'status_note'  => $statusNote
        // ];
        //$pr_id = $this->Purchase_requests_model->insert($prData);

        //insert PO
		$poData = [
            'po_id'         => $pr_id,
            'created_by'   => $user_id,
            'request_date'  => date('Y-m-d'),
			'status'		=> $status,
            'status_note'  => $statusNote
        ];
		$po_id = $this->Purchase_orders_model->insert($poData);
    
        // Simpan item-itemnya
        $itemData = [];
        foreach ($items as $item) {

            //insert split po
            $splitData = [
                'po_id'         => $po_id,
                'kantin_id'   => $item['kantin'],
                'request_date'  => date('Y-m-d')
            ];
            $split_po_id = $this->Split_purchase_orders_model->insert_one_by_one($splitData);

            $formatted_target_date = DateTime::createFromFormat('d/m/Y', $item['target'])->format('Y-m-d');
            $itemData[] = [
                'split_po_id'      => $split_po_id,
                'item_name'        => $item['name'],
                'quantity'         => $item['qty'],
                'unit'             => $item['unit'],
                'delivery_target_date' => $formatted_target_date
            ];
        }
        $this->Split_po_items_model->insert($itemData);

        echo json_encode(['status' => true, 'message' => 'Data Berhasil di Simpan']);
	}

    public function delete() {
		// Cek jika ID tersedia di permintaan POST
		$id = $this->input->post('id');
		if (!$id) {
			// ID tidak ada, kirim response error
			$this->output
				 ->set_content_type('application/json')
				 ->set_status_header(400) // Bad Request
				 ->set_output(json_encode(['error' => 'No ID provided']));
			return;
		}

        //get split id
        $splits = $this->Split_purchase_orders_model->get_by_po_id($id);

        $split_po_ids = array_map(function($split) {
            return $split->split_po_id;
        }, $splits);

        // delete items
        $this->Split_po_items_model->delete_by_split_po_ids($split_po_ids);
	
        // delete split
		$this->Split_purchase_orders_model->delete_by_po_id($id);

        //delete PO
        $this->Purchase_orders_model->delete_by_id($id);
	
		// Kirim response sukses
		$this->output
			 ->set_content_type('application/json')
			 ->set_output(json_encode(['message' => 'Data Berhasil di Hapus']));
	}

    public function get_by_id() {
		$id = $this->input->post('id');

        
        // Ambil daftar split
        //$items = $this->Purchase_requests_items_model->get_list_by_pr_id($id);
        $splits = $this->Split_purchase_orders_model->get_by_po_id($id);
        log_message('debug', 'PO ID dikirim: ' . $id);
        log_message('debug', 'split po: ' . print_r($splits, true));

        $split_po_kantin_map = [];
        $split_po_status_map = []; // Tambahkan mapping status
        foreach ($splits as $split) {
            $split_po_kantin_map[$split->split_po_id] = $split->kantin_id;
            $split_po_status_map[$split->split_po_id] = $split->status;
        }

        // Ambil semua split_po_id
        $split_po_ids = array_keys($split_po_kantin_map);

        // Ambil item
        $items = $this->Split_po_items_model->get_list_by_split_po_ids($split_po_ids);

        // Tambahkan kantin_id dan status ke setiap item
        foreach ($items as &$item) {
            $split_po_id = $item->split_po_id;

            // Set nilai kantin
            $item->kantin = isset($split_po_kantin_map[$split_po_id]) ? $split_po_kantin_map[$split_po_id] : null;

            // Set nilai status
            $item->status = isset($split_po_status_map[$split_po_id]) ? $split_po_status_map[$split_po_id] : null;

            // Format tanggal
            if (isset($item->delivery_target_date)) {
                $date = DateTime::createFromFormat('Y-m-d', $item->delivery_target_date);
                $item->target = $date ? $date->format('d/m/Y') : null;
                unset($item->delivery_target_date);
            }

            // Hapus kantin_id jika ada
            if (isset($item->kantin_id)) {
                unset($item->kantin_id);
            }
        }
        unset($item); // best practice


        // Ambil PR utama (status & status_note)
        //$pr = $this->Purchase_requests_model->get_by_id($id); // pastikan ada function ini
        $po = $this->Purchase_orders_model->get_by_id($id);

        // Gabungkan jadi satu array
        $response = [
            'po_id' => $po->po_id,
            'status' => $po->status ?? null,
            'status_note' => $po->status_note ?? null,
            'items' => $items
        ];

        // Kirimkan sebagai JSON
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
	}

    public function update($po_id) {
        $user_id = $this->session->userdata('user_id');
        $status = $this->input->post('status');
        $statusNote = $this->input->post('status-note');
        $items = $this->input->post('items');

        date_default_timezone_set('Asia/Jakarta');

        // Update PO utama
        $poData = [
            'created_by'  => $user_id,
            'request_date'  => date('Y-m-d'),
            'status'      => $status,
            'status_note' => $statusNote
        ];
        $this->Purchase_orders_model->update($po_id, $poData);

        // Ambil split PO lama berdasarkan po_id
        $existingSplits = $this->Split_purchase_orders_model->get_by_po_id($po_id);
        $existingSplitIds = array_column($existingSplits, 'split_po_id');

        // Track split_po_id yang masih ada setelah update
        $sentSplitIds = [];

        // Track item IDs yang tetap ada (untuk split_po_items)
        $sentItemIds = [];

        foreach ($items as $item) {
            if (!empty($item['split'])) {
                // Update split PO lama
                $split_po_id = $item['split'];
                $sentSplitIds[] = $split_po_id;

                $splitData = [
                    'po_id'     => $po_id,
                    'kantin_id' => $item['kantin'],
                    'request_date'  => date('Y-m-d')
                ];
                $this->Split_purchase_orders_model->update($split_po_id, $splitData);

                // Update atau insert split_po_items
                if (!empty($item['id'])) {
                    // Update item lama
                    $sentItemIds[] = $item['id'];
                    $updateData = [
                        'split_po_id'          => $split_po_id,
                        'item_name'            => $item['name'],
                        'quantity'             => $item['qty'],
                        'unit'                 => $item['unit'],
                        'delivery_target_date' => DateTime::createFromFormat('d/m/Y', $item['target'])->format('Y-m-d')
                    ];
                    $this->Split_po_items_model->update($item['id'], $updateData);
                } else {
                    // Insert item baru
                    $newItem = [
                        'split_po_id'          => $split_po_id,
                        'item_name'            => $item['name'],
                        'quantity'             => $item['qty'],
                        'unit'                 => $item['unit'],
                        'delivery_target_date' => DateTime::createFromFormat('d/m/Y', $item['target'])->format('Y-m-d')
                    ];
                    $newItemId = $this->Split_po_items_model->insert_one_by_one($newItem);
                    $sentItemIds[] = $newItemId;
                }
            } else {
                // Insert split PO baru dan item baru
                $splitData = [
                    'po_id'     => $po_id,
                    'kantin_id' => $item['kantin'],
                    'request_date'  => date('Y-m-d')
                ];
                $newSplitPoId = $this->Split_purchase_orders_model->insert_one_by_one($splitData);
                $sentSplitIds[] = $newSplitPoId;

                $newItem = [
                    'split_po_id'          => $newSplitPoId,
                    'item_name'            => $item['name'],
                    'quantity'             => $item['qty'],
                    'unit'                 => $item['unit'],
                    'delivery_target_date' => DateTime::createFromFormat('d/m/Y', $item['target'])->format('Y-m-d')
                ];
                $newItemId = $this->Split_po_items_model->insert_one_by_one($newItem);
                $sentItemIds[] = $newItemId;
            }
        }

        // Hapus split PO yang tidak ada di update
        $splitsToDelete = array_diff($existingSplitIds, $sentSplitIds);
        if (!empty($splitsToDelete)) {
            // Hapus items terkait split PO yg dihapus
            foreach ($splitsToDelete as $splitId) {
                $this->Split_po_items_model->delete_by_split_po_id($splitId);
            }
            // Hapus split PO
            $this->Split_purchase_orders_model->delete_by_ids($splitsToDelete);
        }

        // Hapus split PO items yang tidak ada di update
        $existingItems = $this->Split_po_items_model->get_list_by_split_po_ids($sentSplitIds);
        $existingItemIds = array_column($existingItems, 'split_po_item_id');
        $itemsToDelete = array_diff($existingItemIds, $sentItemIds);
        if (!empty($itemsToDelete)) {
            $this->Split_po_items_model->delete_by_ids($itemsToDelete);
        }
         
        echo json_encode(['status' => true, 'message' => 'Data Berhasil di Ubah']);
    }

    public function get_list_not_in_draft() {
		//Panggil metode get_list_by_user_id dari model Purchase_requests_model
		$purchase_requests = $this->Purchase_requests_model->get_list_not_in_draft();

		// Kirimkan data sebagai JSON
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($purchase_requests));
	}

    function approve($pr_id) {
		//$pr_id = $this->input->post('pr-id');
        //$statusNote = $this->input->post('status-note');

		// Update status and status note PR
        // $prData = [
        //     'status'       => 'approved',
        //     'status_note'  => $statusNote
        // ];
        // $this->Purchase_requests_model->update($pr_id, $prData);

		//insert PO
		$poData = [
            'pr_id'       	=> $pr_id,
            'created_date'  => date('Y-m-d'),
			'status'		=> 'pending'
        ];
		$this->Purchase_orders_model->insert($poData);

		//echo json_encode(['status' => true, 'message' => 'Data saved successfully']);
	}
}
