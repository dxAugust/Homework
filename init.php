<?php
require_once('functions.php');
require_once('helpers.php');

session_start();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$page_title = 'Главная';
$is_auth = 0;
$user_name = '';

$user_id = 1;

const UPLOADS_PATH = __DIR__ . '/uploads/';

const DATABASE_HOST = 'localhost';
const DATABASE_USERNAME = 'arhzfxgj';
const DATABASE_PASSWORD = 'Ju5M96';
const DATABASE_NAME = 'arhzfxgj_m3';

$mysql = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
mysqli_set_charset($mysql, "utf8");
?>