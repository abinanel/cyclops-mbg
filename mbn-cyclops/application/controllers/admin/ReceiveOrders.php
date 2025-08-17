<?php

class ReceiveOrders extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
		$this->load->model('auth_model');
		$this->load->model('Purchase_orders_model');
		$this->load->model('Split_purchase_orders_model');
		$this->load->model('Split_po_items_model');
		$this->load->model('Kantin_model');
		$this->load->model('Goods_receipts_model');
		$this->load->model('Receipt_items_model');
		if(!$this->auth_model->current_user()){
			redirect('auth/login');
		}
	}

	public function index()
	{
        $this->load->view("admin/receive_orders_list");
	}

	public function receiveForm($split_po_id) {
		// Ambil daftar item
		$data['split_po'] = $this->Split_purchase_orders_model->get_by_id($split_po_id);
		$data['items'] = $this->Split_po_items_model->get_list_by_split_po_id($split_po_id);
		$data['suppliers'] = $this->Kantin_model->get_by_id($data['split_po']->kantin_id);

		if($data['split_po']->status == 'received') {
			$goodsReceipts = $this->Goods_receipts_model->get_by_split_po_id($split_po_id);
			log_message('debug', 'Isi goodsReceipts: ' . print_r($goodsReceipts, true));
			$receiptItems = $this->Receipt_items_model->get_by_receipt_id($goodsReceipts->receipt_id);

			// Tambahkan qty_received ke $data['items']
			foreach ($data['items'] as &$item) {
				$item->qty_received = 0; // default jika tidak ditemukan
		
				foreach ($receiptItems as $receiptItem) {
					if ( $item->item_name == $receiptItem->item_name && 
						$item->quantity == $receiptItem->quantity_expected ) {
							$item->quantity_received = $receiptItem->quantity_received;
							break; // jika sudah match, keluar dari loop
					}
				}
			}
			$data['received_date'] = $goodsReceipts->received_date;
			$data['notes'] = $goodsReceipts->notes;
			unset($item); // best practice untuk reference variable
		} else {
			$data['notes'] = '';
			// Tambahkan qty_received ke $data['items']
			foreach ($data['items'] as $item) {
				$item->quantity_received = 0; // default jika tidak ditemukan
			}
		}

        $this->load->view("admin/receive_orders_form", $data);
	}

	public function get_split_po_lists() {
		log_message('debug', 'get_split_po_lists');
		$split_po_lists = $this->Split_purchase_orders_model->get_list_in_delivered_and_received();
		
		// Ambil supplier_id unik
		$kantin_ids = array_unique(array_map(function($po) {
			return $po->kantin_id;
		}, $split_po_lists));

		// Load model supplier
		$Kantins = $this->Kantin_model->get_kantins_by_ids($kantin_ids);

		// Buat mapping supplier_id => name
		$kantin_map = [];
		foreach ($Kantins as $kantin) {
			$kantin_map[$kantin->kantin_id] = $kantin->nama_kantin;
		}

		// Tambahkan supplier_name ke setiap PO
		foreach ($split_po_lists as $po) {
			$po->nama_kantin = isset($kantin_map[$po->kantin_id]) ? $kantin_map[$po->kantin_id] : null;
		}

		log_message('debug', 'Isi split_po_lists: ' . print_r($split_po_lists, true));

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($split_po_lists));
	}

	public function receive() {
		$user_id = $this->session->userdata('user_id');
		$split_po_id = $this->input->post('split');
        $receive_date = $this->input->post('receive-date');
		$notes = $this->input->post('notes');
		$items = $this->input->post('items');
		log_message('debug', 'Isi items: ' . print_r($items, true));

        $receiveData = [
            'split_po_id'       => $split_po_id,
            'received_date' 	=> $receive_date,
			'received_by'		=> $user_id,
			'notes'				=> $notes
        ];
		$receipt_id = $this->Goods_receipts_model->insert($receiveData);

		// Simpan item-itemnya
        $itemData = [];
        foreach ($items as $item) {
			$isMatch = 0;
			if($item['rcv'] == $item['qty']) {
				$isMatch = 1;
			}
            $itemData[] = [
                'receipt_id'        => $receipt_id,
                'item_name'         => $item['name'],
                'quantity_received' => $item['rcv'],
                'quantity_expected' => $item['qty'],
                'is_match'          => $isMatch
            ];
        }
        $this->Receipt_items_model->insert($itemData);

		//update status split po 
        $splitPOData = [
            'status' => 'received'
        ];
        $this->Split_purchase_orders_model->update($split_po_id, $splitPOData);

		//cek apakah sudah semua split po dari 1 po di received
		$splitPO = $this->Split_purchase_orders_model->get_by_id($split_po_id);
		$poID = $splitPO->po_id;
		$splitPOv2 = $this->Split_purchase_orders_model->get_by_po_id($poID);
		log_message('debug', 'Isi split PO by po ID: ' . print_r($splitPOv2, true));
		$isAllReceived = 1;
		foreach ($splitPOv2 as $split) {
			if($split->status != 'received') {
				$isAllReceived = 0;
				break;
			}
		}

		if($isAllReceived == 1) {
			//update status po 
			$poData = [
				'status' => 'diterima'
			];
			$this->Purchase_orders_model->update($poID, $poData);
		}

		echo json_encode(['status' => true, 'message' => 'Data saved successfully']);
	}
}