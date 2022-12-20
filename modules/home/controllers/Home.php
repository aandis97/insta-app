<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('PostModel', 'postModel');
		$this->load->model('CommentModel', 'commentModel');
		$this->load->model('LikeModel', 'likeModel');
	}

	public function index()
	{
		$data['posts'] = $this->postModel->all();
		$this->render('home', $data);
	}

	public function getPostsJson() 
	{
		$posts = $this->postModel->all();
		$userId = $this->session->userdata('user')['id'];

		foreach($posts as $post) {
			$post->comments = $this->commentModel->getCommentsByPostId($post->id);
			$isLikeExist = $this->likeModel->find(['post_id' => $post->id, 'user_id' => $userId]);
			$post->is_liked_by_me = $isLikeExist ? true : false;
		}

		return $this->jsonResponse([
			'status' => 'success',
			'data' => $posts
		], 200);
	}

	public function doLikePost($postId)
	{
		try {
			$type = $this->input->get('type');
			$userId = $this->session->userdata('user')['id'];

			$isLikeExist = $this->likeModel->find(['post_id' => $postId, 'user_id' => $userId]);
			$post = $this->postModel->find(['id' => $postId]);
			
			if ($type == 'like' && !$isLikeExist) {
				$post->total_likes++;
				$this->likeModel->insert(['post_id' => $postId, 'user_id' => $userId]);
			} else if($type == 'unlike' && $isLikeExist) {				
				$post->total_likes--;
				$this->likeModel->delete(['id' => $isLikeExist->id]);
			}

			$this->postModel->update(['total_likes' => $post->total_likes], ['id' => $postId]);

			$this->jsonResponse([
				'status' => 'success',
				'message' => 'Data successfuly updated',
				'data' => [
					'type' => $type
				]
			], 200);
		} catch (\Throwable $th) {
			$this->jsonResponse([
				'status' => 'error',
				'message' => $th->getMessage()
			], 400);
		}
	}

	public function doComment($postId)
	{
		try {
			$data = [
				'comment' => $this->input->get('comment'),
				'user_id' => $this->session->userdata('user')['id'],
				'post_id' => $postId
			];

			$this->commentModel->insert($data);
			
			$data['username'] =$this->session->userdata('user')['username'];
			$this->jsonResponse([
				'status' => 'success',
				'message' => 'Data successfuly updated',
				'data' => $data
			], 200);
		} catch (\Throwable $th) {
			$this->jsonResponse([
				'status' => 'error',
				'message' => $th->getMessage()
			], 400);
		}
	}
}
