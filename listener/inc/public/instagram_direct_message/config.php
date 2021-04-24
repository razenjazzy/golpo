<?php
return [
    'id' => 'instagram_direct_message',
    'name' => 'Instagram Direct Message',
    'author' => 'Stackcode',
    'author_uri' => 'https://stackposts.com',
    'version' => '1.0',
    'desc' => '',
    'icon' => 'fab fa-instagram',
    'color' => '#d62976',
    'menu' => [
        'tab' => 2,
        'position' => 980,
        'name' => 'Instagram',
        'sub_menu' => [
        	'position' => 3000,
            'id' => 'instagram_direct_message',
            'name' => 'Direct Message'
        ]
    ],
    'css' => [
		'assets/css/instagram_direct_message.css'
	],
    'js' => [
        'assets/js/instagram_direct_message.js'
    ]
];