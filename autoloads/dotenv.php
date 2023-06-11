<?php
/**
 * Copyright (c) 2019.
 * Developed by Waizabú. V1.0 MIT licensed
 */

$reqVars = [
];
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '../.env');
$dotenv->load();
$dotenv->required($reqVars);

