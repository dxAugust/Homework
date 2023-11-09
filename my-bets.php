<?php
    require_once('init.php');

    $category_list = get_categories_list($mysql);

    print(include_template('header.php', [
      'page_title' => "Мои ставки",
      'categories' => $category_list
    ]));

    if (isset($_SESSION['is_auth']))
    {
      $user_bets = get_user_bets($mysql, $_SESSION['user_id']);
      print(include_template('my-bets.php', [
        'bets' => $user_bets,
      ]));
    } else {
      http_response_code(403);
      print(include_template('error.php', [
        'title' => "403 Доступ запрещён",
        'description' => "Вам необходимо быть авторизированным для просмотра этой страницы",
      ]));
    }
?>

</div>

<?php

print(include_template('footer.php', [
  'categories' => $category_list,
]));

?>