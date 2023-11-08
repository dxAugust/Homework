<?php
    require_once('init.php');

    $category_list = get_categories_list($mysql);
    $lot_info = get_lot_info_by_id($mysql, intval($_GET['id']));

    $error = "";

    print(include_template('header.php', [
      'page_title' => $page_title,
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

      if($_SERVER['REQUEST_METHOD'] === 'POST')
      {
        if (empty($_POST['cost'])) {
          $error = 'Поле не заполнено';
        } else {
          if(!filter_var($_POST['cost'], FILTER_VALIDATE_INT)){
            $error = 'Ставка должна быть целым числом';
          } else {
            if(!isset($errors['cost']) && $_POST['cost'] < $lot_info['bet_step']) {
              $error = 'Ставка должна быть больше, либо равна минимальной ставке';
            }
          }
        }

        if (empty($error)) 
        {
          if ($_SESSION['is_auth'])
          {
            $data["summary"] = intval($_POST['cost']);
            $data['user_id'] = $_SESSION['user_id'];
            $data['lot_id'] = intval($_GET['id']);

            add_bet_to_lot($mysql, $data);
          }
        }
      }

      $page_title = $lot_info['name'];
      print(include_template('lot.php', [
        'lot_info' => $lot_info,
        'bet_history' =>  get_bet_list_by_lot_id($mysql, $_GET['id']),
        'error' => $error,
      ]));
    }
?>

</div>

<?php

print(include_template('footer.php', [
  'categories' => $category_list,
]));

?>