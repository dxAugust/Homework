<?php
    require_once('init.php');

    $category_list = get_categories_list($mysql);
    $lot_info = get_lot_info_by_id($mysql, $_GET['id']);

    print(include_template('header.php', [
      'page_title' => $page_title,
      'is_auth' => $is_auth,
      'user_name' => $user_name,
      'categories' => $category_list
    ]));

    if (empty($lot_info))
    {
      header("HTTP/1.1 404 Not Found");
      $page_title = 'Страница не найдена';

      print('
      <section class="lot-item container">
            <h2>404 Страница не найдена</h2>
            <p>Данной страницы не существует на сайте.</p>
      </section>

      </main>
      ');
    } else {
      $page_title = $lot_info['name'];
      print(include_template('lot.php', [
        'lot_info' => $lot_info,
        'bet_history' =>  get_bet_list_by_lot_id($mysql, $_GET['id'])
      ]));
    }
?>

</div>

<?php

print(include_template('footer.php', [
  'categories' => $category_list,
]));

?>