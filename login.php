<?php 
    require_once('init.php');

    $error_codes = array(
        "email" => false,
        "password" => false,
    );
    $auth_error = "Ошибка";

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if (isset($_POST["email"]) && (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)))
        {
            $error_codes["email"] = true;
        }

        if (isset($_POST["password"]) && empty($_POST["password"]))
        {
            $error_codes["password"] = true;
        }
    }

    $category_list = get_categories_list($mysql);
    print(include_template('header.php', [
      'page_title' => $page_title,
      'is_auth' => $is_auth,
      'user_name' => $user_name,
      'categories' => $category_list
    ])); 

    print(include_template('login.php', [
        'error_codes' => $error_codes,
        'auth_error' => $auth_error
    ])); 
?>

</div>

<?php

print(include_template('footer.php', [
  'categories' => $category_list,
]));

?>