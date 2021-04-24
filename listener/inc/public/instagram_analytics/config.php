<?php
return [
    'id' => 'instagram_analytics',
    'name' => 'Instagram Analytics',
    'author' => 'Stackcode',
    'author_uri' => 'https://stackposts.com',
    'version' => '1.0',
    'desc' => '',
    'icon' => 'fab fa-instagram',
    'color' => '#d62976',
    'menu' => [
        'tab' => 2,
        'position' => 990,
        'name' => 'Instagram',
        'sub_menu' => [
        	'position' => 3000,
            'id' => 'instagram_analytics',
            'name' => 'Analytics'
        ]
    ],
    'css' => [
		'assets/css/instagram_analytics.css'
	],
    'js' => [
        'assets/js/instagram_analytics.js'
    ]
];