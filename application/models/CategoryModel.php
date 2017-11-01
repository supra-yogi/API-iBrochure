<?php

class CategoryModel extends CI_Model {    

    public function GetAll() {
        $query =  $this->db->query("SELECT * FROM category");
        return $query->result();
    }

    public function GetById($id) {
        $id    = $this->db->escape_str($id);
        $query =  $this->db->query("SELECT * FROM category WHERE Id = $id");
        return $query->result();
    }

    public function Save($id, $param) {
        $id   = $this->db->escape_str($id);
        $code = $this->db->escape_str($param['Code']);
        $name = $this->db->escape_str($param['Name']);

        if ($id == 0) {
            $query = $this->db->insert("category", $param);
        } else {
            $query = $this->db->query("UPDATE category 
                SET Code = '$code',
                    Name = '$name'
                WHERE Id = $id");
        }
    }
    
    public function Delete($id) {
        $id = $this->db->escape_str($id);
        
        $query = $this->db->query("DELETE FROM category WHERE Id = $id");
    }
}