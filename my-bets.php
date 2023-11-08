<?php
    require_once('init.php');

    $category_list = get_categories_list($mysql);

    $user_bets = get_user_bets($mysql, $_SESSION['user_id']);

    print(include_template('header.php', [
      'page_title' => "Мои ставки",
      'categories' => $category_list
    ]));

    print(include_template('my-bets.php', [
      'bets' => $user_bets,
    ]));
?>

</div>

<?php

print(include_template('footer.php', [
  'categories' => $category_list,
]));

?>