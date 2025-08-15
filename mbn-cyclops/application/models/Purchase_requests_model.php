<?php

class Purchase_requests_model extends CI_Model
{
	private $_table = 'purchase_requests';

    public function get_list() 
    {
        $query = $this->db->query("SELECT * FROM purchase_requests");
        return $query->result(); // return berupa array objek
    }

    public function get_list_not_in_draft() 
    {
        $this->db->where('status !=', 'draft');
        $query = $this->db->get('purchase_requests');
        return $query->result(); // return berupa array objek
    }

    public function get_list_by_user_id($user_id) 
    {
        $this->db->where('created_by', $user_id);
        $query = $this->db->get('purchase_requests');
        return $query->result();
    }

    public function get_by_id($id) 
    {
        $query = $this->db->get_where($this->_table, ['pr_id' => $id]);
        return $query->row(); // return berupa satu object
    }

    public function insert($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();  // <-- dapatkan nilai pr_id yang baru
    }

    public function update($pr_id, $data) {
        $this->db->where('pr_id', $pr_id)->update('purchase_requests', $data);
    }

    public function delete($id) {
        $this->db->where('pr_id', $id);
        $this->db->delete($this->_table);  // Hapus data dari tabel
    }    
}