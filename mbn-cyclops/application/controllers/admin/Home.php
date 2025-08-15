<?php

class Home extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model');
		if(!$this->auth_model->current_user()){
			redirect('auth/login');
		}
	}

	public function index()
	{
        // load view admin/overview.php
        $this->load->view("admin/home");
	}
}
