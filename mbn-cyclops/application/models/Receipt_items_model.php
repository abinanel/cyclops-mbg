<?php

class Receipt_items_model extends CI_Model
{
	private $_table = 'receipt_items';

	public function insert($data) {
        $this->db->insert_batch($this->_table, $data);  // Efficiently insert multiple records
    }

    public function get_by_receipt_id($receipt_id) 
    {
        $query = $this->db->get_where($this->_table, ['receipt_id' => $receipt_id]);
        return $query->result(); // return array
    }
}