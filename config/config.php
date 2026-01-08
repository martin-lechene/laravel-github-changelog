<?php

return [
    'github' => [
        'user' => '',
        'repo' => '',
        'token' => '',
        'since' => '2020-10-13'
    ],
    'types' => [
        'fix' => 'Fix 🐛',
        'improvement' => 'Improvement ⚡',
        'feat' => 'New 🌟',
        'chore' => 'Chore 🛠',
        'security' => 'Security 🔒',
        'performance' => 'Performance 📈'
    ],
    'route_path' => 'changelog',
    'middleware' => ['web'],
];
