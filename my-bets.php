<?php
    require_once('init.php');

    $category_list = get_categories_list($mysql);

    print(include_template('header.php', [
      'page_title' => "Мои ставки",
      'categories' => $category_list
    ]));

    print(include_template('my-bets.php', [
      'bets' => get_user_bets($mysql, $_SESSION['user_id']),
    ]));
?>

</div>

<?php

print(include_template('footer.php', [
  'categories' => $category_list,
]));

?>