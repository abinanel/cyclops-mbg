<?php

class Purchase_orders_model extends CI_Model
{
	private $_table = 'purchase_orders';

    public function get_list() 
    {
        $query = $this->db->query("SELECT * FROM purchase_orders");
        return $query->result(); // return berupa array objek
    }

    public function insert($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id(); // Mengembalikan ID dari baris yang baru diinsert
    }

    public function get_by_id($id) 
    {
        $query = $this->db->get_where($this->_table, ['po_id' => $id]);
        return $query->row(); // return berupa satu object
    }

    public function get_by_ids($ids)
    {
        if (empty($ids)) return [];
        $this->db->where_in('po_id', $ids);
        return $this->db->get('purchase_orders')->result();
    }

    public function update($po_id, $data) {
        $this->db->where('po_id', $po_id)->update('purchase_orders', $data);
    }

    public function get_list_by_user_id($user_id) 
    {
        $this->db->where('created_by', $user_id);
        $query = $this->db->get('purchase_orders');
        return $query->result();
    }

    public function delete_by_id($id)
    {
        $this->db->where('po_id', $id);
        return $this->db->delete($this->_table);
    }
}