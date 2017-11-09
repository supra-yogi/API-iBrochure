<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
 
class Category extends REST_Controller {
 
    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('CategoryModel');
    }
 
    // GET ALL DATA
    // api/customer or api/customer/1 [GET]
    public function index_get()
    {
        $id = $this->get('id');
        if ($id != null) {
            $data = $this->CategoryModel->GetById($id);
            if ($data == null){
                $data = ARRAY(
                'Error'   => REST_Controller::HTTP_NOT_FOUND,
                'Message' => 'Category Id = '.$id.' not found');
                $this->response($data, REST_Controller::HTTP_NOT_FOUND);
            }
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $data = $this->CategoryModel->GetAll();
            $this->response($data, REST_Controller::HTTP_OK);
        }
    }
 
    // INSERT NEW DATA
    // api/customer [POST]
    public function index_post() {
        $data = ARRAY(
                'Code' => $this->POST('Code'),
                'Name' => $this->POST('Name'));
        $this->CategoryModel->Save(0, $data);
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

        $data = $this->CategoryModel->GetById($id);
        if ($data == null){
            $data = ARRAY(
                'Error'   => REST_Controller::HTTP_NOT_FOUND,
                'Message' => 'Category Id = '.$id.' not found');
            $this->response($data, REST_Controller::HTTP_NOT_FOUND);
        }

        $update = ARRAY(
                'Code' => $this->PUT('Code'),
                'Name' => $this->PUT('Name'));
        $this->CategoryModel->Save($id, $update);
              
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
            $this->response($data, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = $this->CategoryModel->GetById($id);
        if ($data == null){
            $data = ARRAY(
                'Error'   => REST_Controller::HTTP_NOT_FOUND,
                'Message' => 'Category Id = '.$id.' not found');
            $this->response($data, REST_Controller::HTTP_NOT_FOUND);
        }

        $this->CategoryModel->Delete($id);

        $data = ARRAY(
                'Message' => 'Deleted');
        $this->response($data, REST_Controller::HTTP_NO_CONTENT);
    }
}