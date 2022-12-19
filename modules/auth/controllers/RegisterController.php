<?php defined('BASEPATH') or exit('No direct script access allowed');

class RegisterController extends MY_Controller
{
    private $data = [];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Login Page
     *
     * @return void
     */
    public function index()
    {
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        $this->data['name'] = [
            'name' => 'name',
            'id' => 'name',
            'class' => 'form-control',
            'placeholder' => 'Enter Name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name'),
        ];

        $this->data['username'] = [
            'name' => 'username',
            'id' => 'username',
            'class' => 'form-control',
            'placeholder' => 'Enter Username',
            'type' => 'text',
            'value' => $this->form_validation->set_value('username'),
        ];

        $this->data['email'] = [
            'name' => 'email',
            'id' => 'email',
            'class' => 'form-control',
            'placeholder' => 'Enter Email',
            'type' => 'text',
            'value' => $this->form_validation->set_value('email'),
        ];

        $this->data['password'] = [
            'name' => 'password',
            'id' => 'password',
            'class' => 'form-control',
            'placeholder' => 'Password',
            'type' => 'password',
        ];

        $this->data['password_confirm'] = [
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'class' => 'form-control',
            'placeholder' => 'Password Confirm',
            'type' => 'password',
        ];

        $this->render('register', $this->data);
    }

    /**
     * Store Authentication
     *
     * @return void
     */
    public function store()
    {
        try {
            $data = [
                'name' => $this->input->post('name'),
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'password_confirm' => $this->input->post('password_confirm'),
            ];

			if (!$this->form_validation->run('register')) {
				$errors = $this->form_validation->error_array();
				throw new Exception(current($errors));
			}

            unset($data['password_confirm']);
			$this->auth->register($data);
            
            $this->session->set_flashdata('message', 'Register Successfully');
            redirect('auth/login');
            die();
        } catch (\Throwable $th) {
            $this->session->set_flashdata('message', $th->getMessage());

            redirect('auth/register');
            die();
        }
    }
}
