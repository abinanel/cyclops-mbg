<?php

class Kantin_model extends CI_Model
{
	private $_table = 'kantin';

    public function get_kantins_by_ids($ids) {
        if (empty($ids)) return [];
    
        $this->db->where_in('kantin_id', $ids);
        $query = $this->db->get('kantin'); // Ganti nama tabel jika berbeda
        return $query->result(); // return array of supplier objects
    }

    public function get_by_id($id) 
    {
        $query = $this->db->get_where($this->_table, ['kantin_id' => $id]);
        return $query->row(); // return berupa satu object
    }

    public function get_by_user_id($user_id) 
    {
        $query = $this->db->get_where($this->_table, ['user_id' => $user_id]);
        return $query->row(); // return berupa satu object
    }

    public function get_all()
    {
        return $this->db->get($this->_table)->result(); // return array of kantin objects
    }
}