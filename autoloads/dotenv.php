<?php
/**
 * Copyright (c) 2019.
 * Developed by Waizabú. V1.0 MIT licensed
 */

$reqVars = [
];
if (file_exists(__DIR__ . '/../.env')) {
    $reqVars = [
        'MYSQL_DATABASE',
        'MYSQL_USER',
        'MYSQL_PASSWORD',
        'MYSQL_HOST',
        'ADMIN_USERNAME',
        'ADMIN_PASSWORD',
        'ADMIN_AUTH_KEY'
    ];
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '../.env');
    $dotenv->load();
    $dotenv->required($reqVars);
}


