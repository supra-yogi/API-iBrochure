<?php

class ListBrochureModel extends CI_Model {    

    public function GetAll() {
        $query =  $this->db->query("SELECT * FROM list_brochure lb
                                    LEFT JOIN list_brochure_picture lbp ON lbp.ListBrochureId = lb.Id");
        return $query->result();
    }

    public function GetById($id) {
        $id    = $this->db->escape_str($id);
        $query =  $this->db->query("SELECT * FROM list_brochure lb
                                    LEFT JOIN list_brochure_picture lbp ON lbp.ListBrochureId = lb.Id 
                                    WHERE lb.Id = $id");
        return $query->result();
    }

    public function Save($id, $param) {
        $id          = $this->db->escape_str($id);
        $title        = $this->db->escape_str($param['Title']);
        $telp        = $this->db->escape_str($param['Telp']);
        $address     = $this->db->escape_str($param['Address']);
        $description = $this->db->escape_str($param['Description']);
        $customerId  = $this->db->escape_str($param['CustomerId']);
        $categoryId  = $this->db->escape_str($param['CategoryId']);
        $listPicture = $param['ListPicture'];

        if ($id == 0) {
            unset($param['ListPicture']);
            $query = $this->db->insert("list_brochure", $param);

            foreach ($listPicture as $pictureItem) {
                $pictureName   = $pictureItem['PictureName'];
                $pictureBase64 = $pictureItem['PictureBase64'];

                $this->db->query("INSERT INTO list_brochure_picture(PictureName, PictureBase64, ListBrochureId)
                                        VALUES('$pictureName', '$pictureBase64', LAST_INSERT_ID())");
            }
            
        } else {
            $this->db->query("UPDATE list_brochure 
                SET Title = '$title',
                    Telp = '$telp',
                    Address = '$address'
                    Description = '$description'
                    CustomerId = $customerId
                    CategoryId = $categoryId
                WHERE Id = $id");

            foreach ($listPicture as $pictureItem) {
                $pictureName   = $pictureItem['PictureName'];
                $pictureBase64 = $pictureItem['PictureBase64'];

                $this->db->query("UPDATE list_brochure_picture 
                    SET PictureName = '$pictureName',
                        pictureBase64 = '$pictureBase64',
                    WHERE Id = $id");
            }
        }
    }
    
    public function Delete($id) {
        $id = $this->db->escape_str($id);
        
        $this->db>query("DELETE FROM list_brochure_picture WHERE ListBrochureId = $id");
        $this->db->query("DELETE FROM list_brochure WHERE Id = $id");
    }
}