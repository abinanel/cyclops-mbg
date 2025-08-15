<?php

class Goods_receipts_model extends CI_Model
{
	private $_table = 'goods_receipts';
    
	public function insert($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();  // <-- dapatkan nilai pr_id yang baru
    }

    public function get_by_split_po_id($split_po_id) 
    {
        $query = $this->db->get_where($this->_table, ['split_po_id' => $split_po_id]);
        return $query->row(); // return array
    }
}