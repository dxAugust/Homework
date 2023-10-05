<?php
    require_once('init.php');

    $error_codes = array(
      "lot-name" => false,
      "category" => false,
      "message" => false,
      "lot-img" => false,
      "lot-rate" => false,
      "lot-step" => false,
      "lot-date" => false
    );

    if (isset($_POST['lot-name']) && empty($_POST['lot-name'])) {
      $error_codes["lot-name"] = true;
    }

    if (isset($_POST['category']) && !$_POST['category']) {
      $error_codes["category"] = true;
    }

    if (isset($_POST['message']) && empty($_POST['message'])) {
      $error_codes["message"] = true;
    }

    if (isset($_FILES["lot-img"]) && !empty($_FILES['lot-img']['tmp_name'])) {
      $mime_type = mime_content_type($_FILES['lot-img']['tmp_name']);
      $allowed_file_types = ['image/png', 'image/jpeg', 'image/jpg'];
      if (!in_array($mime_type, $allowed_file_types)) {
        $error_codes["lot-img"] = true;
      }
    }

    if (
      isset($_POST['lot-rate'])
      && empty($_POST['lot-rate']
      && !preg_match("/[a-zA-Z]/", $_POST['lot-rate']))
    ) {
      $error_codes["lot-rate"] = true;
    }

    if (
      isset($_POST['lot-step'])
      && empty($_POST['lot-step']
      && !preg_match("/[a-zA-Z]/", $_POST['lot-step']))
    ) {
      $error_codes["lot-step"] = true;
    }

    if (
      isset($_POST['lot-date']) 
      && !is_future_date($_POST['lot-date'])
    ) {
      $error_codes["lot-date"] = true;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      if (!isset($_FILES['lot-img']))
      {
        $error_codes["lot-img"] = true;
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
      'is_auth' => $is_auth,
      'user_name' => $user_name,
      'categories' => $category_list
    ])); 

    print(include_template('add.php', [
        'error_codes' => $error_codes,
        'categories' => $category_list
    ]));
?>

</div>

<?php

print(include_template('footer.php', [
  'categories' => get_categories_list($mysql),
]));

?>