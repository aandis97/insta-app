<?php

class Auth
{
    const SESSION_KEY = 'user';

    public function __construct()
    {
        $this->load->model('auth/AuthModel', 'authModel');
    }

    /**
     * __get
     *
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * @param string $var
     *
     * @return mixed
     */
    public function __get($var)
    {
        return get_instance()->$var;
    }

    /**
     * login
     *
     * @param  string $email
     * @param  string $password
     * @return bool
     */
    public function login(string $email, string $password): bool
    {
        try {
            $user = $this->authModel->login($email, $password);

            $this->session->set_userdata([
                self::SESSION_KEY => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ]
            ]);

            return $this->session->has_userdata(self::SESSION_KEY);
        } catch (\Throwable $th) {
            //throw $th;
            return FALSE;
        }
    }

     /**
     * register
     *
     * @param  string $email
     * @param  string $password
     * @return bool
     */
    public function register(array $data): bool
    {
        try {
            $this->authModel->insert($data);

            return TRUE;
        } catch (\Throwable $th) {
            //throw $th;
            return FALSE;
        }
    }

    /**
     * logout
     *
     * @return bool
     */
    public function logout(): bool
    {
        $this->session->unset_userdata(self::SESSION_KEY);

        return !$this->session->has_userdata(self::SESSION_KEY);
    }

    /**
     * isLoggedIn
     *
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return !!$this->session->has_userdata(self::SESSION_KEY);
    }
}
