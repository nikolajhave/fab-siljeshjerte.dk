<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

ini_set("date.timezone", "Europe/Copenhagen");
setlocale(LC_ALL, 'da_DK.UTF-8');

require_once '../vendor/autoload.php';

$if = new \App\DecodeInterface();
$if->display();