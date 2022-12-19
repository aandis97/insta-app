<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('PostModel', 'postModel');
	}

	public function index()
	{
		$data['posts'] = $this->postModel->all();
		$this->render('home', $data);
	}
}
