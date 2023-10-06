<?php
    require_once('init.php');

    $category_list = get_categories_list($mysql);
    $lot_info = get_lot_info_by_id($mysql, $_GET['id']);

    print(include_template('header.php', [
      'page_title' => $page_title,
      'categories' => $category_list
    ]));
?>

</div>

<?php

print(include_template('footer.php', [
  'categories' => $category_list,
]));

?>