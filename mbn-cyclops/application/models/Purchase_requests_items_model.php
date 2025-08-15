<?php

class Purchase_requests_items_model extends CI_Model
{
	private $_table = 'purchase_request_items';

    public function get_list() 
    {
        $query = $this->db->query("SELECT * FROM purchase_requests_items");
        return $query->result(); // return berupa array objek
    }

    public function get_list_by_pr_id($pr_id) 
    {
        $this->db->order_by('pr_id', 'DESC');
        $query = $this->db->get_where($this->_table, ['pr_id' => $pr_id]);
        return $query->result(); // return array
    }

    public function get_by_id($id) 
    {
        $query = $this->db->get_where($this->_table, ['pr_item_id' => $id]);
        return $query->row(); // return berupa satu object
    }

    public function insert($data) {
        $this->db->insert_batch($this->_table, $data);  // Efficiently insert multiple records
    }

    public function update($id, $data) {
        $this->db->where('pr_item_id', $id)->update($this->_table, $data);
    }
    
    public function delete_by_ids($ids) {
        $this->db->where_in('pr_item_id', $ids)->delete($this->_table);
    }  

    public function delete_by_pr_id($pr_id) {
        $this->db->where('pr_id', $pr_id);
        $this->db->delete($this->_table);  // Hapus data dari tabel
    }
}