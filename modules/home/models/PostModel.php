<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PostModel extends MY_Model
{	
	public $table = 'posts';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get All Post
	 *
	 * @return array
	 */
	public function all(array $conditions = []): ?array
	{
		$this->db->select([
			'posts.id', 
            'posts.image', 
            'posts.description', 
            'posts.total_likes', 
            'posts.created_at', 
            'users.id as user_id',
            'users.username as user_username'
		])->join('users', 'users.id = posts.author_id')
		->where($conditions);

		return $this->db->get($this->table)->result();
	}
}
