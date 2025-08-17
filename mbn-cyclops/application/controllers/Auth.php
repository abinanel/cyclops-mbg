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
		$this->load->model('departments_model');
		$this->load->model('kantin_model');
		$this->load->model('suppliers_model');
		$this->load->library('form_validation');

		$rules = $this->auth_model->rules();
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run() == FALSE){
			return $this->load->view('login_form');
		}

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$user = $this->auth_model->login($username, $password);
		$department = $this->departments_model->get_by_user_id($user->user_id);
		$kantin = $this->kantin_model->get_by_user_id($user->user_id);
		$supplier = $this->suppliers_model->get_by_user_id($user->user_id);
		log_message('debug', 'supplier: ' . print_r($supplier, true));

		if ($user) {
			// Ambil data user id, username dan department_id dari user
			$loggedInUserData = array(
				'user_id' => $user->user_id,
				'username' => $user->username,
				'role' => $user->role
			);

			// Tambahkan detail department jika ada
			if ($department) {
				$loggedInUserData['department_id'] = $department->department_id;
				$loggedInUserData['department_name'] = $department->department_name;
				$loggedInUserData['npsn'] = $department->npsn;
				$loggedInUserData['nama'] = $department->nama;
				$loggedInUserData['tingkatan'] = $department->tingkatan;
				$loggedInUserData['kepala_sekolah'] = $department->kepala_sekolah;
				$loggedInUserData['akreditasi'] = $department->akreditasi;
				$loggedInUserData['alamat'] = $department->alamat;
				$loggedInUserData['telepon'] = $department->telepon;
				$loggedInUserData['email'] = $department->email;
				// tambahkan field lain sesuai kebutuhan
			}

			// Tambahkan detail kantin jika ada
			if ($kantin) {
				$loggedInUserData['nama_kantin']   = $kantin->nama_kantin;
				$loggedInUserData['email_kantin']  = $kantin->email_kantin;
				$loggedInUserData['nama_pemilik']  = $kantin->nama_pemilik;
				$loggedInUserData['tahun_berdiri'] = $kantin->tahun_berdiri;
				$loggedInUserData['provinsi']      = $kantin->provinsi;
				$loggedInUserData['kota']          = $kantin->kota;
				$loggedInUserData['kecamatan']     = $kantin->kecamatan;
				$loggedInUserData['kelurahan']     = $kantin->kelurahan;
				$loggedInUserData['alamat_kantin'] = $kantin->alamat_kantin;
				// tambahkan field lain sesuai kebutuhan
			}

			if ($supplier) {
				$loggedInUserData['nama_supplier']      = $supplier->nama_supplier;
				$loggedInUserData['jenis_usaha']        = $supplier->jenis_usaha;
				$loggedInUserData['izin_usaha']         = $supplier->izin_usaha;
				$loggedInUserData['npwp']               = $supplier->npwp;
				$loggedInUserData['email_supplier']     = $supplier->email;
				$loggedInUserData['telepon']            = $supplier->telepon;
				$loggedInUserData['penanggung_jawab']   = $supplier->penanggung_jawab;
				$loggedInUserData['alamat_supplier']    = $supplier->alamat;
				$loggedInUserData['provinsi']           = $supplier->provinsi;
				$loggedInUserData['kota']               = $supplier->kota;
				$loggedInUserData['kecamatan']          = $supplier->kecamatan;
				$loggedInUserData['kelurahan']          = $supplier->kelurahan;
				// tambahkan field lain jika diperlukan
			}
			
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