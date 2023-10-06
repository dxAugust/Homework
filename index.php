<?php
require_once('init.php');

date_default_timezone_set('Asia/Yekaterinburg');

$main = include_template('main.php', [
    'categories' => get_categories_list($mysql),
    'lots' => get_lot_list($mysql),
]);

print(include_template('layout.php', [
    'page_title' => $page_title,
    'categories' => get_categories_list($mysql),
    'main' => $main,
]));
?>