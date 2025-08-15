<?php

class Suppliers_model extends CI_Model
{
	private $_table = 'suppliers';

    public function get_suppliers_by_ids($ids) {
        if (empty($ids)) return [];
    
        $this->db->where_in('supplier_id', $ids);
        $query = $this->db->get('suppliers'); // Ganti nama tabel jika berbeda
        return $query->result(); // return array of supplier objects
    }

    public function get_by_id($id) 
    {
        $query = $this->db->get_where($this->_table, ['supplier_id' => $id]);
        return $query->row(); // return berupa satu object
    }

    public function get_by_user_id($user_id) 
    {
        $query = $this->db->get_where($this->_table, ['user_id' => $user_id]);
        return $query->row(); // return berupa satu object
    }
}