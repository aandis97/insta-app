<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class LikeModel extends MY_Model
{	
	public $table = 'likes';

	public function __construct()
	{
		parent::__construct();
	}
}
