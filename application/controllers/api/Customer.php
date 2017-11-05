<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
 
class Customer extends REST_Controller {
 
    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('CustomerModel');
    }
 
    // GET ALL DATA
    // api/customer or api/customer/1 [GET]
    public function index_get()
    {
        $id = $this->get('id');
        if ($id != null) {
            $data = $this->CustomerModel->GetById($id);
            if ($data == null){
                $this->response('Customer Id = '.$id.' not found', REST_Controller::HTTP_NOT_FOUND);
            }
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $data = $this->CustomerModel->GetAll();
            $this->response($data, REST_Controller::HTTP_OK);
        }
    }
 
    // INSERT NEW DATA
    // api/customer [POST]
    public function index_post() {
        $data = ARRAY(
                'Name'          => $this->POST('Name'),
                'Contact'       => $this->POST('Contact'),
                'Telp'          => $this->POST('Telp'),
                'Address'       => $this->POST('Address'),
                'UseraccountId' => $this->POST('UseraccountId'),
                'RoleId'        => 2); //sebagai customer
        $this->CustomerModel->Save(0, $data);
        $this->response($data, REST_Controller::HTTP_CREATED);        
    }

    // UPDATE DATA
    // api/customer/id [PUT]
    public function index_put() {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            $this->response('{"status": "error"}', REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = $this->CustomerModel->GetById($id);
        if ($data == null){
            $this->response('Customer Id = '.$id.' not found', REST_Controller::HTTP_NOT_FOUND);
        }

        $update = ARRAY(
                'Name'    => $this->PUT('Name'),
                'Contact' => $this->PUT('Contact'),
                'Telp'    => $this->PUT('Telp'),
                'Address' => $this->PUT('Address'));
        $this->CustomerModel->Save($id, $data);
              
        if ($update) {
            $this->response($update, REST_Controller::HTTP_OK);  
        } else {
            $this->response('{"status": "error"}', REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete() {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            $this->response('{"status": "error"}', REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = $this->CustomerModel->GetById($id);
        if ($data == null){
            $this->response('Customer Id = '.$id.' not found', REST_Controller::HTTP_NOT_FOUND);
        }

        $this->CustomerModel->Delete($id);
        $this->response(REST_Controller::HTTP_NO_CONTENT, REST_Controller::HTTP_NO_CONTENT);
    }
}