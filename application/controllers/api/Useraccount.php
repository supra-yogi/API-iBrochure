<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
 
class Useraccount extends REST_Controller {
 
    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('UseraccountModel');
    }
 
    // GET ALL DATA
    // api/customer or api/customer/1 [GET]
    public function index_get()
    {
        $id = $this->get('id');
        if ($id != null) {
            $data = $this->UseraccountModel->GetById($id);
            if ($data == null){
                $data = ARRAY(
                'Error'   => REST_Controller::HTTP_NOT_FOUND,
                'Message' => 'Useraccount Id = '.$id.' not found');
                $this->response($data, REST_Controller::HTTP_NOT_FOUND);
            }
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $data = $this->UseraccountModel->GetAll();
            $this->response($data, REST_Controller::HTTP_OK);
        }
    }
 
    // INSERT NEW DATA
    // api/customer [POST]
    public function index_post() {
        $password = hash("sha1", $this->POST('Password'));
        $data = ARRAY(
            'Username'   => $this->POST('Username'),
            'Email'      => $this->POST('Email'),
            'Password'   => $password);

        if ($this->UseraccountModel->GetByUsername($data['Username']) != null ) {
            $data = ARRAY(
                'Error' => REST_Controller::HTTP_NOT_FOUND,
                'Message' => "Username ".$data['Username']." is already exist");
            $this->response($data, REST_Controller::HTTP_NOT_FOUND);
        }

        if ($this->UseraccountModel->GetByEmail($data['Email']) != null ) {
            $data = ARRAY(
                'Error' => REST_Controller::HTTP_NOT_FOUND,
                'Message' => "Email ".$data['Email']." is already exist");
            $this->response($data, REST_Controller::HTTP_NOT_FOUND);
        }


        $this->UseraccountModel->Save(0, $data);
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
                'Error'   => REST_Controller::HTTP_BAD_REQUEST,
                'Message' => 'Id must > 0 | Id =' . $id);
            $this->response($data, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = $this->UseraccountModel->GetById($id);
        if ($data == null){
            $data = ARRAY(
                'Error'   => REST_Controller::HTTP_NOT_FOUND,
                'Message' => 'Useraccount Id = '.$id.' not found');
            $this->response($data, REST_Controller::HTTP_NOT_FOUND);
        }

        $update = ARRAY(
            'Name'      => $this->PUT('Name'),
            'Contact'   => $this->PUT('Contact'),
            'Telephone' => $this->PUT('Telephone'),
            'Address'   => $this->PUT('Address'),
            'Picture'   => $this->PUT('Picture'));

        if ($this->UseraccountModel->GetByEmail($update['Email']) != null ) {
            $data = ARRAY(
                'Error' => REST_Controller::HTTP_NOT_FOUND,
                'Message' => "Email ".$update['Email']." is already used");
            $this->response($data, REST_Controller::HTTP_NOT_FOUND);
        }

        $this->UseraccountModel->Save($id, $update);
        $this->response($update, REST_Controller::HTTP_OK);  
    }

    public function index_delete() {
        $id = $this->GET('id');

        // Validate the id.
        if ($id <= 0)
        {
            $data = ARRAY(
                'Error'   => REST_Controller::HTTP_BAD_REQUEST,
                'Message' => 'Id must > 0');
            $this->response($data, REST_Controller::HTTP_BAD_REQUEST);
        }

        $data = $this->UseraccountModel->GetById($id);
        if ($data == null){
            $data = ARRAY(
                'Error'   => REST_Controller::HTTP_NOT_FOUND,
                'Message' => 'Useraccount Id = '.$id.' not found');
            $this->response($data, REST_Controller::HTTP_NOT_FOUND);
        }

        $this->UseraccountModel->Delete($id);

        $data = ARRAY(
            'Message' => 'Deleted');
        $this->response($data, REST_Controller::HTTP_NO_CONTENT);
    }

    public function login_post() {
        $userOrEmail = $this->POST('UserOrEmail');
        $password    = $this->post('Password');
        $password    = hash("sha1", $password);

       
        $data = $this->UseraccountModel->Login($userOrEmail, $password);
        if ($data != null) {
             $this->response($data, REST_Controller::HTTP_OK);
        }

        $data = ARRAY(
            'Error'   => REST_Controller::HTTP_NOT_FOUND,
            'Message' => 'Username or password incorect');
        $this->response($data, REST_Controller::HTTP_NOT_FOUND);
    }

    public function getByUsername_post() {
        $username = $this->post('Username');

        $data = $this->UseraccountModel->GetByUsername($username);
        if ($data == null) {
            $data = ARRAY(
            'Error'   => REST_Controller::HTTP_NOT_FOUND,
            'Message' => 'Useraccount '.$username.' doesnt exist');
            $this->response($data, REST_Controller::HTTP_NOT_FOUND);
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function getByEmail_post() {
        $email = $this->post('Email');

        $data = $this->UseraccountModel->GetByEmail($email);
        if ($data == null) {
            $data = ARRAY(
            'Error'   => REST_Controller::HTTP_NOT_FOUND,
            'Message' => 'Useraccount '.$email.' doesnt exist');
            $this->response(REST_Controller::HTTP_NOT_FOUND, REST_Controller::HTTP_NOT_FOUND);
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}