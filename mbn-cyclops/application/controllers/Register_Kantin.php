<?php

class Register_Kantin extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
	}

	public function index()
	{
        // load view admin/overview.php
        $this->load->view("kantin_form");
	}
}
