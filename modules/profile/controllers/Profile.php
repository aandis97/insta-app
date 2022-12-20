<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('home/PostModel', 'postModel');
	}

	public function index()
	{
		$this->render('profile');
	}

	public function uploadPost()
	{	
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		 }
		
		try {
			if (!$this->form_validation->run('upload-post')) {
				$errors = $this->form_validation->error_array();
				throw new Exception(current($errors));
			}

			$config['upload_path']          = './img/posts/';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 1000;
			
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('image'))
			{
				$error = array('error' => $this->upload->display_errors());
				throw new Exception(current($error));
			}

			$payload = [
				'image'       => $this->upload->data()['file_name'],
				'description' => $this->input->post("description"),
				'author_id'   => $this->session->userdata('user')['id'],
				'created_at'  => date('Y-m-d H:i:s')
			];

			$this->postModel->insert($payload);
			
			$this->jsonResponse([
				'status' => 'success',
				'message' => 'Data successfuly updated',
				'data' => $payload
			], 200);
		} catch (\Throwable $th) {
			$this->jsonResponse([
				'status' => 'error',
				'message' => $th->getMessage()
			], 400);
		}
	}
}
