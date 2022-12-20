<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CommentModel extends MY_Model
{
	public $table = 'comments';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get All Post
	 *
	 * @return array
	 */
	public function getCommentsByPostId($postId, $start = 0, $limit = 5): array
	{
		$this->db->select([
			'comments.id', 
            'comments.comment', 
            'users.id as user_id',
            'users.username as user_username'
		])->join('users', 'users.id = comments.user_id')
		->where('post_id', $postId)
		->limit($limit, $start);

		return $this->db->get($this->table)->result();
	}
}
