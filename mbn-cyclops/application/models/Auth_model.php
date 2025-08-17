<?php

class Auth_model extends CI_Model
{
	private $_table = "users";
	const SESSION_KEY = 'user_id';

	public function rules()
	{
		return [
			[
				'field' => 'username',
				'label' => 'Username or Email',
				'rules' => 'required'
			],
			[
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|max_length[255]'
			]
		];
	}

	public function login($username, $password)
	{
		$this->db->where('email', $username)->or_where('username', $username);
		$query = $this->db->get($this->_table);
		$user = $query->row();

		// cek apakah user sudah terdaftar?
		if (!$user) {
			return FALSE;
		}

		// cek apakah passwordnya benar?
		if (!password_verify($password, $user->password)) {
			return FALSE;
		}

		// bikin session
		// $this->session->set_userdata([
		// 	self::SESSION_KEY => $user->id,
		// 	'department_id' => $user->department_id
		// ]);
		$this->session->set_userdata([
			self::SESSION_KEY => $user->user_id,
			'role' => $user->role,
			'department_id' => $user->department_id
		]);

		// Kembalikan data user, bukan boolean
		return $user;
	}

	public function current_user()
	{
		if (!$this->session->has_userdata(self::SESSION_KEY)) {
			return null;
		}

		$user_id = $this->session->userdata(self::SESSION_KEY);
		$query = $this->db->get_where($this->_table, ['user_id' => $user_id]);
		return $query->row();
	}

	public function logout()
	{
		$this->session->unset_userdata(self::SESSION_KEY);
		return !$this->session->has_userdata(self::SESSION_KEY);
	}

	public function getByUserId($user_id)
    {
        return $this->db->get_where($this->_table, ["user_id" => $user_id])->row();
    }

	// private function _update_last_login($id)
	// {
	// 	$data = [
	// 		'last_login' => date("Y-m-d H:i:s"),
	// 	];

	// 	return $this->db->update($this->_table, $data, ['id' => $id]);
	// }
}