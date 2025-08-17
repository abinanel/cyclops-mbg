<?php

class Departments_model extends CI_Model
{
	private $_table = 'departments';

    public function get_by_user_id($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->limit(1); // pastikan hanya 1 record
        $query = $this->db->get($this->_table);
        return $query->row(); // kembalikan 1 record sebagai object
    }

    public function get_by_user_ids($user_ids)
    {
        if (empty($user_ids)) return [];
        $this->db->where_in('user_id', $user_ids);
        return $this->db->get('departments')->result();
    }
}