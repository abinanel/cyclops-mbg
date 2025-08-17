<?php

class IncomingOrders extends CI_Controller {
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
		$this->load->model('Departments_model');
		if(!$this->auth_model->current_user()){
			redirect('auth/login');
		}
	}

	public function index()
	{
        $this->load->view("admin/incoming_orders_list");
	}

    public function get_incoming_po_lists() {
		log_message('debug', 'get_incoming_po_lists');

		// 1. Ambil user kantin
		$user_id = $this->session->userdata('user_id');
		$kantin  = $this->Kantin_model->get_by_user_id($user_id);

		// 2. Ambil semua split_purchase_orders
		$incoming_po_lists = $this->Split_purchase_orders_model->get_list_by_kantin_id($kantin->kantin_id);

		if (empty($incoming_po_lists)) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode([]));
			return;
		}

		// 3. Ambil semua po_id sekaligus
		$po_ids = array_column($incoming_po_lists, 'po_id');
		$purchase_orders = $this->Purchase_orders_model->get_by_ids($po_ids);

		// 4. Buat map po_id -> purchase_order
		$poMap = [];
		foreach ($purchase_orders as $po) {
			$poMap[$po->po_id] = $po;
		}

		// 5. Ambil semua user_id pembuat PO
		$user_ids = array_column($purchase_orders, 'created_by');
		$departments = $this->Departments_model->get_by_user_ids($user_ids);

		// 6. Buat map user_id -> department
		$deptMap = [];
		foreach ($departments as $dept) {
			$deptMap[$dept->user_id] = $dept;
		}

		// 7. Gabungkan data
		foreach ($incoming_po_lists as $result) {
			$result->nama_kantin = $kantin->nama_kantin;

			if (isset($poMap[$result->po_id])) {
				$po = $poMap[$result->po_id];
				if (isset($deptMap[$po->created_by])) {
					$result->nama_sekolah = $deptMap[$po->created_by]->department_name;
				} else {
					$result->nama_sekolah = null;
				}
			} else {
				$result->nama_sekolah = null;
			}
		}

		log_message('debug', 'Isi incoming_po_lists: ' . print_r($incoming_po_lists, true));

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($incoming_po_lists));
	}

	public function incomingForm($split_po_id) {
		// Ambil daftar item
		//$po = $this->Purchase_orders_model->get_by_id($po_id);
		$data['split_po'] = $this->Split_purchase_orders_model->get_by_id($split_po_id);
		$data['items'] = $this->Split_po_items_model->get_list_by_split_po_id($split_po_id);
		$data['suppliers'] = $this->Kantin_model->get_by_id($data['split_po']->kantin_id);
		$po = $this->Purchase_orders_model->get_by_id($data['split_po']->po_id);
		$data['sekolah'] = $this->Departments_model->get_by_user_id($po->created_by);

        $this->load->view("admin/incoming_orders_form", $data);
	}

	public function confirm() {
		$split_po_id = $this->input->post('split');

		// Update status
        $splitPOData = [
            'status' => 'confirmed'
        ];
        $this->Split_purchase_orders_model->update($split_po_id, $splitPOData);

		$splitPO = $this->Split_purchase_orders_model->get_by_id($split_po_id);
		$poID = $splitPO->po_id;

		//update status po 
		$poData = [
			'status' => 'diproses'
		];
		$this->Purchase_orders_model->update($poID, $poData);

		echo json_encode(['status' => true, 'message' => 'Data Berhasil di Ubah']);
	}

	public function deliver() {
		$split_po_id = $this->input->post('split');

		// Update status
        $splitPOData = [
            'status' => 'delivered'
        ];
        $this->Split_purchase_orders_model->update($split_po_id, $splitPOData);

		$splitPO = $this->Split_purchase_orders_model->get_by_id($split_po_id);
		$poID = $splitPO->po_id;

		//update status po 
		$poData = [
			'status' => 'dikirim'
		];
		$this->Purchase_orders_model->update($poID, $poData);

		echo json_encode(['status' => true, 'message' => 'Data Berhasil di Ubah']);
	}

	public function reject() {
		$split_po_id = $this->input->post('split');

		// Update status
        $splitPOData = [
            'status' => 'rejected'
        ];
        $this->Split_purchase_orders_model->update($split_po_id, $splitPOData);

		$splitPO = $this->Split_purchase_orders_model->get_by_id($split_po_id);
		$poID = $splitPO->po_id;

		//update status po 
		$poData = [
			'status' => 'ditolak'
		];
		$this->Purchase_orders_model->update($poID, $poData);

		echo json_encode(['status' => true, 'message' => 'Data Berhasil di Ubah']);
	}
}