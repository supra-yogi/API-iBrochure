<?php

class CustomerModel extends CI_Model {    

    public function GetAll() {
        $query =  $this->db->query("SELECT * FROM customer");
        return $query->result();
    }

    public function GetById($id) {
        $id    = $this->db->escape_str($id);
        $query =  $this->db->query("SELECT * FROM customer WHERE Id = $id");
        return $query->result();
    }

    public function Save($id, $param) {
        $id      = $this->db->escape_str($id);
        $name    = $this->db->escape_str($param['Name']);
        $contact = $this->db->escape_str($param['Contact']);
        $telp    = $this->db->escape_str($param['Telp']);
        $address = $this->db->escape_str($param['Address']);

        if ($id == 0) {
            $query = $this->db->insert("customer", $param);
        } else {
            $query = $this->db->query("UPDATE customer 
                SET Name = '$name',
                    Contact = '$contact',
                    Telp = '$telp',
                    Address = '$address'
                WHERE Id = $id");
        }
    }
    
    public function Delete($id) {
        $id = $this->db->escape_str($id);
        
        $query = $this->db->query("DELETE FROM customer WHERE Id = $id");
    }
}