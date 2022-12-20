<?php

$config = [
    'upload-post' => [
        [
            'field' => 'description',
            'label' => 'description',
            'rules' => 'trim|required'
        ],
        [
            'field' => 'image', 
            'label' => 'image',
            'rules' => 'uploaded[image]|max_size[image, 1024]|mime_in[image,image/png,image/jpg,image/jpeg]|is_image[image]'
        ]
    ]
];