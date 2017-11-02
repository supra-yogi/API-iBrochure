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
                $this->response('ListBrochure Id = '.$id.' not found', REST_Controller::HTTP_NOT_FOUND);
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
            'Title'       => $this->POST('Title'),
            'ListPicture' => $this->POST('ListPicture'),
            'Telp'        => $this->POST('Telp'),
            'Address'     => $this->POST('Address'),
            'Description' => $this->POST('Description'),
            'CustomerId'  => $this->POST('CustomerId'),
            'CategoryId'  => $this->POST('CategoryId'));

        $this->ListBrochureModel->Save(0, $data);
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

        $data = $this->ListBrochureModel->GetById($id);
        if ($data == null){
            $this->response('ListBrochure Id = '.$id.' not found', REST_Controller::HTTP_NOT_FOUND);
        }

        $update = ARRAY(
            'Title'       => $this->POST('Title'),
            'ListPicture' => $this->POST('ListPicture'),
            'Telp'        => $this->POST('Telp'),
            'Address'     => $this->POST('Address'),
            'Description' => $this->POST('Description'),
            'CustomerId'  => $this->POST('CustomerId'),
            'CategoryId'  => $this->POST('CategoryId'));
        
        $this->ListBrochureModel->Save($id, $data);
              
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

        $data = $this->ListBrochureModel->GetById($id);
        if ($data == null){
            $this->response('ListBrochure Id = '.$id.' not found', REST_Controller::HTTP_NOT_FOUND);
        }

        $this->ListBrochureModel->Delete($id);
        $this->response(REST_Controller::HTTP_NO_CONTENT, REST_Controller::HTTP_NO_CONTENT);
    }
}