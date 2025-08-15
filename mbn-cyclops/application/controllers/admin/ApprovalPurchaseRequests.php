<?php

class ApprovalPurchaseRequests extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
		$this->load->model('auth_model');
		$this->load->model('Purchase_requests_model');
		$this->load->model('Purchase_requests_items_model');
		$this->load->model('Purchase_orders_model');
		if(!$this->auth_model->current_user()){
			redirect('auth/login');
		}
	}

	public function index()
	{
        $this->load->view("admin/approval_purchase_requests_list");
	}

	public function approveForm($pr_id) {
		// Ambil daftar item
        $data['items'] = $this->Purchase_requests_items_model->get_list_by_pr_id($pr_id);
        $data['pr'] = $this->Purchase_requests_model->get_by_id($pr_id);
        $this->load->view("admin/approval_purchase_requests_form", $data);
	}

	public function approve() {
		$pr_id = $this->input->post('pr-id');
        $statusNote = $this->input->post('status-note');

		// Update status and status note PR
        $prData = [
            'status'       => 'approved',
            'status_note'  => $statusNote
        ];
        $this->Purchase_requests_model->update($pr_id, $prData);

		//insert PO
		$poData = [
            'pr_id'       	=> $pr_id,
            'created_date'  => date('Y-m-d'),
			'status'		=> 'pending'
        ];
		$this->Purchase_orders_model->insert($poData);

		echo json_encode(['status' => true, 'message' => 'Data saved successfully']);
	}

	public function reject() {
		$pr_id = $this->input->post('pr-id');
        $statusNote = $this->input->post('status-note');

		// Update status and status note PR
        $prData = [
            'status'       => 'rejected',
            'status_note'  => $statusNote
        ];
        $this->Purchase_requests_model->update($pr_id, $prData);

		echo json_encode(['status' => true, 'message' => 'Data saved successfully']);
	}
}