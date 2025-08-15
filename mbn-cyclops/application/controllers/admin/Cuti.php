<?php

class Cuti extends CI_Controller {
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
		// Mengambil bidang_id dari sesi pengguna
        $bidang_id = $this->session->userdata('bidang_id');

        // load view admin/overview.php
        $this->load->view("admin/input_cuti");
	}

	public function get_program_by_tahun() {
		// ambil data request post untuk attribute
		$tahun = $this->input->post('tahun');

		// Mengambil bidang_id dari sesi pengguna
        $bidang_id = $this->session->userdata('bidang_id');
		
		//Panggil metode get_program_list() dari model Program_model
		$programs = $this->Program_model->get_by_bidang_and_tahun($bidang_id, $tahun);

		// Log isi dari array $data['programs']
		log_message('debug', 'Isi data programs: ' . print_r($programs, true));

		// Kirimkan data sebagai JSON
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($programs));
	}

	public function get_program_by_bidang() {
		// Mengambil bidang_id dari sesi pengguna
        $bidang_id = $this->session->userdata('bidang_id');
		
		//Panggil metode get_program_list() dari model Program_model
		$programs = $this->Program_model->get_by_bidang($bidang_id);

		// Log isi dari array $data['programs']
		//log_message('debug', 'Isi data programs: ' . print_r($programs, true));

		// Kirimkan data sebagai JSON
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($programs));
	}

	public function save_program() {
		// Check if the form data is posted
		if ($this->input->post()) {

			// Retrieve post data
			$ids = $this->input->post('ids'); 
			$kode_program = $this->input->post('koPro');
			$nama_program = $this->input->post('nama');
			$nilai_dpa = $this->input->post('dpa');
			$nilai_dppa = $this->input->post('dppa');
			$tahun_program = $this->input->post('tahun_dropdown'); // Menerima tahun dari dropdown
	
			// Current date and user
			date_default_timezone_set('Asia/Jakarta'); // Set timezone ke WIB (GMT+7)
			$current_date = date('Y-m-d H:i:s');
			$username = $this->getUsernameFromSession();
	
			// Example of saving multiple entries
			$data_new = [];
			$data_update = [];
			$format_digit = ".00";
			for ($i = 0; $i < count($kode_program); $i++) {
				$nilai_dpa[$i] = preg_replace('/\./', '', $nilai_dpa[$i]); // Menghilangkan titik = preg_replace('/\./', '', $nilai_dpa[$i]; // Menghilangkan titik
				$nilai_dpa[$i] = $nilai_dpa[$i] . $format_digit;

				$nilai_dppa[$i] = preg_replace('/\./', '', $nilai_dppa[$i]); // Menghilangkan titik = preg_replace('/\./', '', $nilai_dpa[$i]; // Menghilangkan titik
				$nilai_dppa[$i] = $nilai_dppa[$i] . $format_digit;

				if (!empty($ids[$i])) {
					$data_update[] = [
						'id' => $ids[$i],
						'kode_program' => $kode_program[$i],
						'nama_program' => $nama_program[$i],
						'nilai_dpa' => $nilai_dpa[$i],
						'nilai_dppa' => $nilai_dppa[$i],
						'bidang_id' => $this->session->userdata('bidang_id'),
						'tahun_program' => $tahun_program,
						'updated_at' => $current_date,
						'updated_by' => $username
					];
				} else {
					$data_new[] = [
						'kode_program' => $kode_program[$i],
						'nama_program' => $nama_program[$i],
						'nilai_dpa' => $nilai_dpa[$i],
						'nilai_dppa' => $nilai_dppa[$i],
						'bidang_id' => $this->session->userdata('bidang_id'),
						'tahun_program' => $tahun_program,
						'created_at' => $current_date,
						'created_by' => $username
					];
				}
			}

			// Call the model function to insert and update data
			$insert_success = false;
			$update_success = false;
	
			// Call the model function to insert data
			if(count($data_new) > 0) {
				log_message('debug', 'insert data baru');
				$this->Program_model->insert_programs($data_new);
				$insert_success = true;
			}
			
			// Call the model function to update data
			if(count($data_update) > 0) {
				log_message('debug', 'update data');
				$this->Program_model->update_programs_batch($data_update);
				$update_success = true;
			}

			if ($insert_success || $update_success) {
				// Return success message
				$this->output
					 ->set_content_type('application/json')
					 ->set_output(json_encode(['status' => 'success', 'message' => 'Programs berhasil disimpan']));
			} else {
				// Return error message
				$this->output
					 ->set_content_type('application/json')
					 ->set_output(json_encode(['status' => 'error', 'message' => 'Gagal menyimpan program']));
			}
		}
	}

	public function get_program_by_id() {
		$id = $this->input->post('id');
		$program = $this->Program_model->get_by_id($id);

		// Kirimkan data sebagai JSON
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($program));
	}

	public function delete_program() {
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
	
		// Coba temukan dan hapus program menggunakan ID
		$program = $this->Program_model->get_by_id($id);
		if (!$program) {
			// Program tidak ditemukan, kirim response error
			$this->output
				 ->set_content_type('application/json')
				 ->set_status_header(404) // Not Found
				 ->set_output(json_encode(['error' => 'Program not found']));
			return;
		}
	
		// Program ditemukan, lakukan penghapusan
		$this->Program_model->delete_program($id);
	
		// Kirim response sukses
		$this->output
			 ->set_content_type('application/json')
			 ->set_output(json_encode(['message' => 'Program deleted successfully']));
	}
	
	public function getUsernameFromSession() {
		if ($this->session->userdata('logged_in_user')) {
			$userSessionData = $this->session->userdata('logged_in_user');
			return $userSessionData['username']; // Mengembalikan username
		} else {
			return null; // Tidak ada pengguna yang terlogin
		}
	}
}
