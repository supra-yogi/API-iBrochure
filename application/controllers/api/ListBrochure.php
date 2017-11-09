<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
 
class ListBrochure extends REST_Controller {
 
    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('ListBrochureModel');
    }
 
    // GET ALL DATA
    // api/customer or api/customer/1 [GET]
    public function index_get()
    {
        $id = $this->get('id');
        if ($id != null) {
            $data = $this->ListBrochureModel->GetById($id);
            if ($data == null){
                 $data = ARRAY(
                'Error'   => REST_Controller::HTTP_NOT_FOUND,
                'Message' => 'ListBrochure Id = '.$id.' not found');
                $this->response($data, REST_Controller::HTTP_NOT_FOUND);
            }
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $data = $this->ListBrochureModel->GetAll();
            $this->response($data, REST_Controller::HTTP_OK);
        }
    }
 
    // INSERT NEW DATA
    // api/customer [POST]
    public function index_post() {
        header('Content-type : bitmap; charset=utf-8');
            
        // //UNTUK MENDECODE IMAGE YANG SUDAH MENJADI CODE
        // $encoded_string = $this->POST('encoded_image');
        // $image_name     = $this->POST('image_name');
        // $decoded_string = base64_decode($encoded_string);
        // $path = './assets/images/'.$image_name;
        // $file = fopen($path, 'wb');
        // $is_written = fwrite($file, $decoded_string);
        // fclose($file);
        
        $data = ARRAY(
            'Title'         => $this->POST('Title'),
            'Telephone'     => $this->POST('Telephone'),
            'Address'       => $this->POST('Address'),
            'PostingDate'   => $this->POST('PostingDate'),
            'Description'   => $this->POST('Description'),
            'UseraccountId' => $this->POST('UseraccountId'),
            'PictureFront'  => $this->POST('PictureFront'),
            'PictureBack'   => $this->POST('PictureBack'),
            'CategoryId'    => $this->POST('CategoryId'));

        $this->ListBrochureModel->Save(0, $data);
        $this->response($data, REST_Controller::HTTP_CREATED);        
    }

    // UPDATE DATA
    // api/customer/id [PUT]
    public function index_put() {
        $id = $this->PUT('Id');

        // Validate the id.
        if ($id <= 0)
        {
            $data = ARRAY(
                'Error'   => REST_Controller::HTTP_NOT_FOUND,
                'Message' => 'Id must > 0');
            $this->response($data, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = $this->ListBrochureModel->GetById($id);
        if ($data == null){
            $data = ARRAY(
                'Error'   => REST_Controller::HTTP_NOT_FOUND,
                'Message' => 'ListBrochure Id = '.$id.' not found');
            $this->response($data, REST_Controller::HTTP_NOT_FOUND);
        }

        $update = ARRAY(
            'Title'        => $this->PUT('Title'),
            'Telephone'    => $this->PUT('Telephone'),
            'Address'      => $this->PUT('Address'),
            'PictureFront' => $this->PUT('PictureFront'),
            'PictureBack'  => $this->PUT('PictureBack'),
            'Description'  => $this->PUT('Description'),
            'CategoryId'   => $this->PUT('CategoryId'));
        
        $this->ListBrochureModel->Save($id, $update);
              
        $this->response($update, REST_Controller::HTTP_OK);  
    }

    public function index_delete() {
        $id = $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            $data = ARRAY(
                'Error'   => REST_Controller::HTTP_NOT_FOUND,
                'Message' => 'Id must > 0');
            $this->response('{"status": "error"}', REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = $this->ListBrochureModel->GetById($id);
        if ($data == null){
            $data = ARRAY(
                'Error'   => REST_Controller::HTTP_NOT_FOUND,
                'Message' => 'ListBrochure Id = '.$id.' not found');
            $this->response($data, REST_Controller::HTTP_NOT_FOUND);
        }

        $this->ListBrochureModel->Delete($id);

        $data = ARRAY(
                'Message' => 'Deleted');
        $this->response($data, REST_Controller::HTTP_NO_CONTENT);
    }

    public function getListBrochureByPage_post() {
        $data = ARRAY(
            'Page' => $this->POST('Page'),
            'Size' => $this->POST('Size'));

        $result = $this->ListBrochureModel->getListBrochureByPage($data);
        if ($result == null) {
            $data = ARRAY(
                'Error'   => REST_Controller::HTTP_NOT_FOUND,
                'Message' => 'No More Data');
            $this->response($data, REST_Controller::HTTP_NOT_FOUND);
        }

        $this->response($result, REST_Controller::HTTP_OK);
    }

    public function getAllByUseraccountByPage_post() {
        $data = ARRAY(
            'Id'   => $this->POST('UseraccountId'),
            'Page' => $this->POST('Page'),
            'Size' => $this->POST('Size'));

        $result = $this->ListBrochureModel->getAllByUseraccountByPage($data);
        if ($result == null) {
            $data = ARRAY(
                'Error'   => REST_Controller::HTTP_NOT_FOUND,
                'Message' => 'No More Data');
            $this->response($data, REST_Controller::HTTP_NOT_FOUND);
        }

        $this->response($result, REST_Controller::HTTP_OK);
    }
}