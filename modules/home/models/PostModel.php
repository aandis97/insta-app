<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PostModel extends CI_Model
{
	const TABLE_NAME = "posts";

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get All Post
	 *
	 * @return array
	 */
	public function all(): array
	{
		$this->db->select([
			'posts.id', 
            'posts.image', 
            'posts.description', 
            'posts.created_at', 
            'users.id as user_id',
            'users.username as user_username'
		])->join('users', 'users.id = posts.author_id');

		return $this->db->get(self::TABLE_NAME)->result();
	}
}
