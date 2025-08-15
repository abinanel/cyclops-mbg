<?php

class Auth extends CI_Controller
{
	public function index()
	{
		show_404();
	}

	public function login()
	{
		$this->load->model('auth_model');
		$this->load->library('form_validation');

		$rules = $this->auth_model->rules();
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run() == FALSE){
			return $this->load->view('login_form');
		}

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$user = $this->auth_model->login($username, $password);

		if ($user) {
			// Ambil data user id, username dan department_id dari user
			$loggedInUserData = array(
				'user_id' => $user->user_id,
				'username' => $user->username,
				'role' => $user->role,
				'department_id' => $user->department_id
			);
			$this->session->set_userdata('logged_in_user', $loggedInUserData);
		
			redirect('admin');
		} else {
			$this->session->set_flashdata('message_login_error', 'Login Gagal, pastikan username dan password benar!');
			redirect('login'); // atau halaman login kamu
		}
	}

	public function logout()
	{
		$this->load->model('auth_model');
		$this->auth_model->logout();
		redirect('auth/login');
	}
}