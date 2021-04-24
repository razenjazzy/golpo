<?php
return [
    'id' => 'instagram_activity',
    'name' => 'Instagram Activity',
    'author' => 'Stackcode',
    'author_uri' => 'https://stackposts.com',
    'version' => '1.0',
    'desc' => '',
    'icon' => 'fab fa-instagram',
    'color' => '#d62976',
    'menu' => [
        'tab' => 2,
        'position' => 995,
        'name' => 'Instagram',
        'sub_menu' => [
        	'position' => 3000,
            'id' => 'instagram_activity',
            'name' => 'Activity'
        ]
    ],
    'css' => [
		'assets/css/instagram_activity.css'
	],
    'js' => [
        'assets/js/instagram_activity.js'
    ]
];