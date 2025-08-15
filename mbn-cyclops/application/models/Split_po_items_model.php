<?php

class Split_po_items_model extends CI_Model
{
	private $_table = 'split_po_items';

    public function get_list() 
    {
        $query = $this->db->query("SELECT * FROM split_po_items");
        return $query->result(); // return berupa array objek
    }

    public function get_list_by_split_po_id($split_po_id) 
    {
        $this->db->order_by('split_po_item_id', 'ASC');
        $query = $this->db->get_where($this->_table, ['split_po_id' => $split_po_id]);
        return $query->result(); // return array
    }

    public function get_list_by_split_po_ids($split_po_ids) 
    {
        $this->db->where_in('split_po_id', $split_po_ids); // $split_po_ids harus berupa array
        $this->db->order_by('split_po_item_id', 'ASC');
        $query = $this->db->get($this->_table);
        return $query->result(); // return array
    }

    public function insert($data) {
        $this->db->insert_batch($this->_table, $data);  // Efficiently insert multiple records
    }

    public function delete_by_split_po_ids($split_po_ids)
    {
        $this->db->where_in('split_po_id', $split_po_ids);
        return $this->db->delete($this->_table);
    }

    public function insert_one_by_one($data)
    {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id(); // kembalikan ID yang baru di-insert
    }

    public function update($id, $data)
    {
        $this->db->where('split_po_item_id', $id);
        return $this->db->update($this->_table, $data);
    }

    public function delete_by_split_po_id($split_po_id)
    {
        $this->db->where('split_po_id', $split_po_id);
        return $this->db->delete($this->_table);
    }
}