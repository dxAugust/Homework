<?php
    require_once('init.php');

    $page_title = "Регистрация";
    $category_list = get_categories_list($mysql);

    $error_codes = array(
        "email" => '',
        "password" => '',
        "name" => '',
        "message" => '',
    );

    if (isset($_SESSION['is_auth']) && $_SESSION['is_auth'])
    {
        header("Location: /");  
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if (isset($_POST["email"]) && empty($_POST["email"]))
        {
            $error_codes["email"] = 'Поле является обязательным';
        }

        if (isset($_POST["email"]) && !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
        {
            $error_codes["email"] = 'Неправильно введённый E-mail';
        }
        
        if (isset($_POST["password"]) && empty($_POST["password"]))
        {
            $error_codes["password"] = 'Поле является обязательным';
        }

        if (isset($_POST["name"]) && empty($_POST["name"]))
        {
            $error_codes["name"] = 'Поле является обязательным';
        }

        if (isset($_POST["message"]) && empty($_POST["message"]))
        {
            $error_codes["message"] = 'Поле является обязательным';
        }

        if (empty(array_filter($error_codes, 'strlen'))) 
        {
            $data = $_POST;
            $user_id = register_user($mysql, $data);

            if (is_null($user_id))
            {
                $error_codes["email"] = 'E-mail уже занят';
            } else {
                header("Location: /login.php");
            }
        }
    }

    print(include_template('header.php', [
      'page_title' => $page_title,
      'categories' => $category_list
    ]));

    print(include_template('sign-up.php', [
        'error_codes' => $error_codes
    ]));
?>

</div>

<?php

print(include_template('footer.php', [
  'categories' => get_categories_list($mysql),
]));

?>