<?php

require_once __DIR__.'/../../config/config.inc.php';

$output=null;
exec('git pull', $output);

dump($output);exit;

$data = [
    'prestashop' => [
        'version' => _PS_VERSION_,
        'majorVersion' => substr(_PS_VERSION_, 0, 3),
    ],
    'server' => [
        'software' => $_SERVER['SERVER_SOFTWARE'],
        'version' => phpversion(),
    ],
];

$data = json_encode($data);

die($data);
