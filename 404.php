<?php
    require_once('init.php');

    $category_list = get_categories_list($mysql);

    print(include_template('header.php', [
      'page_title' => "404 Ошибка",
      'categories' => $category_list
    ]));

    http_response_code(404);
    print(include_template('error.php', [
        'title' => "404 Страница не найдена",
        'description' => "Возможно вы не туда нажали :(",
    ]));
?>

</div>

<?php

print(include_template('footer.php', [
  'categories' => $category_list,
]));

?>