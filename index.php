<?php
require_once('init.php');

$lots = get_all_lot_list($mysql);

foreach ($lots as $lot) 
{
    check_expire_lot_winner($mysql, $lot);
}

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