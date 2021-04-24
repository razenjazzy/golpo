<?php
return [
    'id' => 'vk_post',
    'name' => 'Vk Post',
    'author' => 'Stackcode',
    'author_uri' => 'https://stackposts.com',
    'version' => '1.0',
    'desc' => '',
    'icon' => 'fab fa-vk',
    'color' => '#4b729c',
    'menu' => [
        'tab' => 2,
        'position' => 920,
        'name' => 'Vk',
        'sub_menu' => [
        	'position' => 1000,
            'id' => 'vk_post',
            'name' => 'Post'
        ]
    ],
    'css' => [
		'assets/css/vk_post.css'
	]
];