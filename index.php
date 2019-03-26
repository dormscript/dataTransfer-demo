<?php

namespace Demo;

include 'vendor/autoload.php';
$db = array(
    'read'  => array(
        'host' => '192.168.8.31',
        'user' => 'root',
        'pswd' => '123456',
    ),
    'write' => array(
        'host' => '192.168.8.31',
        'user' => 'root',
        'pswd' => '123456',
    ),
);
$setting = array(
    'Demo\Models\Startrack\MonitorSqlProd' => 100,
);

new \dormscript\Data\Main();
