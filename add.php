<?php
    require_once('init.php');

    $error_codes = array(
      "lot-name" => '',
      "category" => '',
      "message" => '',
      "lot-img" => '',
      "lot-rate" => '',
      "lot-step" => '',
      "lot-date" => ''
    );


    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
      if (isset($_POST['lot-name']) && empty($_POST['lot-name'])) {
        $error_codes["lot-name"] = 'Поле является обязательным для заполнения';
      }
  
      if (isset($_POST['category']) && !$_POST['category']) {
        $error_codes["category"] = 'Поле является обязательным для заполнения';
      }
  
      if (isset($_POST['message']) && empty($_POST['message'])) {
        $error_codes["message"] = 'Поле является обязательным для заполнения';
      }
  
      if (isset($_FILES["lot-img"]) && !filesize($_FILES['lot-img']['tmp_name']))
      {
        $error_codes["lot-img"] = 'Загрузите изображение';
      }
  
      if (isset($_FILES["lot-img"]) && !empty($_FILES['lot-img']['tmp_name'])) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['lot-img']['tmp_name']);
        $allowed_file_types = ['image/png', 'image/jpeg', 'image/jpg'];
        if (!in_array($mime_type, $allowed_file_types)) {
          $error_codes["lot-img"] = 'Изображение должно быть в формате .png или .jpg';
        }
      }
  
      if (
        isset($_POST['lot-rate'])
        && empty($_POST['lot-rate']
        && !preg_match("/[a-zA-Z]/", $_POST['lot-rate']))
      ) {
        $error_codes["lot-rate"] = 'Поле является обязательным для заполнения';
      }
  
      if (
        isset($_POST['lot-step'])
        && empty($_POST['lot-step']
        && !preg_match("/[a-zA-Z]/", $_POST['lot-step']))
      ) {
        $error_codes["lot-step"] = 'Поле является обязательным для заполнения';
      }
  
      if (
        isset($_POST['lot-date']) 
        && empty($_POST['lot-date']))
      {
        $error_codes["lot-date"] = 'Поле является обязательным для заполнения';
      } else if (isset($_POST['lot-date']) 
      && !empty($_POST['lot-date']) &&
      !is_future_date($_POST['lot-date']))
      {
        $error_codes["lot-date"] = 'Дата должна быть в будующем времени';
      }

      if (empty(array_filter($error_codes, 'strlen'))) {
        $data = $_POST;
        $data["author_id"] = $user_id;

        $file_name = $_FILES["lot-img"]['name'] . time();

        $data["image_link"] = '/uploads/'. $file_name;
        move_uploaded_file($_FILES["lot-img"]['tmp_name'], UPLOADS_PATH . $file_name);

        $lot_id = add_lot_to_database($mysql, $data);

        header("Location: /lot.php?id=" . $lot_id);
      }
    }

    $category_list = get_categories_list($mysql);
    print(include_template('header.php', [
      'page_title' => $page_title,
      'categories' => $category_list
    ])); 

    if (isset($_SESSION['is_auth']))
    {
      print(include_template('add.php', [
        'error_codes' => $error_codes,
        'categories' => $category_list
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
  'categories' => get_categories_list($mysql),
]));

?>