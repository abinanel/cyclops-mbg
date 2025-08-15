<?php

class Split_purchase_orders_model extends CI_Model
{
	private $_table = 'split_purchase_orders';

    public function get_by_id($id) 
    {
        $query = $this->db->get_where($this->_table, ['split_po_id' => $id]);
        return $query->row(); // return berupa satu object
    }

    public function get_by_po_id($id) 
    {
        $query = $this->db->get_where($this->_table, ['po_id' => $id]);
        return $query->result();
    }

    public function get_list_in_delivered_and_received() 
    {
        $this->db->where_in('status', ['delivered', 'received']);
        $query = $this->db->get('split_purchase_orders');
        return $query->result(); // return berupa array objek
    }

    public function update($split_po_id, $data) {
        $this->db->where('split_po_id', $split_po_id)->update('split_purchase_orders', $data);
    }

    public function get_list_by_supplier_id($supplier_id) 
    {
        $this->db->where('supplier_id', $supplier_id);
        $query = $this->db->get('split_purchase_orders');
        return $query->result(); // return berupa array objek
    }

    public function get_list_by_kantin_id($supplier_id) 
    {
        $this->db->where('kantin_id', $supplier_id);
        $query = $this->db->get('split_purchase_orders');
        return $query->result(); // return berupa array objek
    }

    public function insert_one_by_one($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id(); // Mengembalikan ID dari baris yang baru diinsert
    }

    public function delete_by_po_id($id)
    {
        $this->db->where('po_id', $id);
        return $this->db->delete($this->_table);
    }

    public function delete_by_ids($ids)
    {
        if (empty($ids)) return false;

        $this->db->where_in('split_po_id', $ids);
        return $this->db->delete($this->_table);
    }
}