<?php

class UseraccountModel extends CI_Model {    

    public function GetAll() {
        $query =  $this->db->query("SELECT * FROM user_account");
        return $query->result();
    }

    public function GetByUsername($username) {
        $query =  $this->db->query("SELECT * FROM user_account WHERE Username = '$username'");
        return $query->result();
    }

    public function GetByEmail($email) {
        $query =  $this->db->query("SELECT * FROM user_account WHERE Email = '$email'");
        return $query->result();
    }

    public function GetById($id) {
        $id    = $this->db->escape_str($id);
        $query =  $this->db->query("SELECT * FROM user_account WHERE Id = $id");
        return $query->result();
    }

    public function Save($id, $param) {
        $id         = $this->db->escape_str($id);

        if ($id == 0) {
            $query = $this->db->insert("user_account", $param);
        } else {
            $name      = $this->db->escape_str($param['Name']);
            $contact   = $this->db->escape_str($param['Contact']);
            $telephone = $this->db->escape_str($param['Telephone']);
            $address   = $this->db->escape_str($param['Address']);
            $picture   = $this->db->escape_str($param['Picture']);

            $query = $this->db->query("UPDATE user_account 
                SET Name = '$name',
                    Contact = '$contact',
                    Telephone = '$telephone',
                    Address = '$address',
                    Picture = '$picture'
                WHERE Id = $id");
        }
    }
    
    public function Delete($id) {
        $id = $this->db->escape_str($id);
        
        $query = $this->db->query("DELETE FROM user_account WHERE Id = $id");
    }

    public function Login($userOrEmail, $password) {
        $userOrEmail = $this->db->escape_str($userOrEmail);
        $password = $this->db->escape_str($password);

        $query = $this->db->query("SELECT * FROM user_account 
            WHERE (Username = '$userOrEmail' OR Email = '$userOrEmail') AND Password = '$password'");

        return $query->result();
    }
}