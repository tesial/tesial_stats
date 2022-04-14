<?php

require_once __DIR__.'/../../config/config.inc.php';

$data = [
    'prestashop' => [
        'version' => _PS_VERSION_,
    ],
    'server' => [
        'software' => $_SERVER['SERVER_SOFTWARE'],
        'version' => phpversion(),
    ],
];

$data = json_encode($data);

die($data);
