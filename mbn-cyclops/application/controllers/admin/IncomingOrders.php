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
        // Mengambil user id dari sesi pengguna
        $user_id = $this->session->userdata('user_id');
        $kantin = $this->Kantin_model->get_by_user_id($user_id);
		$incoming_po_lists = $this->Split_purchase_orders_model->get_list_by_kantin_id($kantin->kantin_id);

		// Tambahkan supplier_name ke setiap PO
		foreach ($incoming_po_lists as $po) {
			$po->kantin_name = $kantin->kantin_name;
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

        $this->load->view("admin/incoming_orders_form", $data);
	}

	public function confirm() {
		$split_po_id = $this->input->post('split');

		// Update status
        $splitPOData = [
            'status' => 'confirmed'
        ];
        $this->Split_purchase_orders_model->update($split_po_id, $splitPOData);

		echo json_encode(['status' => true, 'message' => 'Data Berhasil di Ubah']);
	}

	public function deliver() {
		$split_po_id = $this->input->post('split');

		// Update status
        $splitPOData = [
            'status' => 'delivered'
        ];
        $this->Split_purchase_orders_model->update($split_po_id, $splitPOData);

		echo json_encode(['status' => true, 'message' => 'Data Berhasil di Ubah']);
	}

	public function reject() {
		$split_po_id = $this->input->post('split');

		// Update status
        $splitPOData = [
            'status' => 'rejected'
        ];
        $this->Split_purchase_orders_model->update($split_po_id, $splitPOData);

		echo json_encode(['status' => true, 'message' => 'Data Berhasil di Ubah']);
	}
}