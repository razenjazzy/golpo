<?php
return [
    'id' => 'pinterest_activity',
    'name' => 'Pinterest Activity',
    'author' => 'Stackcode',
    'author_uri' => 'https://stackposts.com',
    'version' => '1.0',
    'desc' => '',
    'icon' => 'fab fa-pinterest',
    'color' => '#cd2029',
    'menu' => [
        'tab' => 2,
        'position' => 960,
        'name' => 'Pinterest',
        'sub_menu' => [
        	'position' => 2000,
            'id' => 'pinterest_activity',
            'name' => 'Activity'
        ]
    ],
    'css' => [
		'assets/css/pinterest_activity.css'
	],
    'js' => [
        'assets/js/pinterest_activity.js'
    ]
];