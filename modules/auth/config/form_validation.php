<?php

$config = [
    'login' => [
        [
            'field' => 'email',
            'label' => 'email',
            'rules' => 'required'
        ],
        [
            'field' => 'password',
            'label' => 'password',
            'rules' => 'required'
        ],
    ],
    'register' => [
        [
            'field' => 'name',
            'label' => 'name',
            'rules' => 'trim|required'
        ],
        [
            'field' => 'username',
            'label' => 'username',
            'rules' => 'trim|required'
        ],
        [
            'field' => 'email',
            'label' => 'email',
            'rules' => 'trim|required|valid_email'
        ],
        [
            'field' => 'password',
            'label' => 'password',
            'rules' => 'required|min_length[6]|matches[password_confirm]'
        ],
        [
            'field' => 'password_confirm',
            'label' => 'password_confirm',
            'rules' => 'required'
        ],
    ]
];