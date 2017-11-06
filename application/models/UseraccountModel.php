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
        $username   = $this->db->escape_str($param['Username']);
        $email      = $this->db->escape_str($param['Email']);
        $password   = $this->db->escape_str($param['Password']);

        if ($id == 0) {
            $query = $this->db->insert("user_account", $param);
        } else {
            $query = $this->db->query("UPDATE user_account 
                SET Username = '$username',
                    Email = '$email',
                    Password = '$password'
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

        if ($query->num_rows() > 0) {
            return true;
        }

        return false;
    }
}