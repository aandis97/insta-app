<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('PostModel', 'postModel');
		$this->load->model('CommentModel', 'commentModel');
	}

	public function index()
	{
		$data['posts'] = $this->postModel->all();
		$this->render('home', $data);
	}

	public function getPostsJson() 
	{
		$posts = $this->postModel->all();

		foreach($posts as $post) {
			$post->comments = $this->commentModel->getCommentsByPostId($post->id);
		}

		return $this->jsonResponse([
			'status' => 'success',
			'data' => $posts
		], 200);
	}
}
