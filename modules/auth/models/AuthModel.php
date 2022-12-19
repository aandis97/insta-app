<?php

class AuthModel extends CI_Model
{
    const TABLE_NAME = 'users';

    /**
     * login
     *
     * @param  string $username
     * @param  string $password
     * @return stdClass
     */
    public function login($username, $password): stdClass
    {
        try {
            $user = $this->db->select(['users.id', 'users.name', 'users.username', 'users.email', 'users.password', 'roles.name as role'])->join('roles', 'roles.id = users.role_id')->where('email', $username)->get(self::TABLE_NAME)->row();

            if (!$user) {
                throw new Exception("Email is not registered yet");
            }

            if (!password_verify($password, $user->password)) {
                throw new Exception("Password did not match");
            }

            return $user;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
	 * Insert Data
	 *
	 * @param  array $data
	 * @return void
	 */
	public function insert(array $data): void
	{
		$this->db->insert(self::TABLE_NAME, $data);
	}
}
