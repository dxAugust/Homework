<?php 
    require_once('init.php');

    $error_codes = array(
        "email" => "",
        "password" => "",
        "auth" => "",
    );
    $auth_error = "Ошибка";

    
    if (isset($_SESSION['is_auth']) && $_SESSION['is_auth'])
    {
        header("Location: /");  
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if (isset($_POST["email"]) && (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)))
        {
            $error_codes["email"] = "Некоректный e-mail";
        }

        if (isset($_POST["password"]) && empty($_POST["password"]))
        {
            $error_codes["password"] = "Введите пароль";
        }

        if (empty(array_filter($error_codes, 'strlen'))) 
        {
            $user_data = $_POST;
            $user_info = get_user_info_by_email($mysql, $user_data['email']);

            if ($user_info)
            {
                if (password_verify($user_data['password'], $user_info['password']))
                {
                    $_SESSION['username'] = $user_info['name'];
                    $_SESSION['is_auth'] = true;
                    header("Location: /");
                } else {
                    $error_codes['auth'] = true;
                    $auth_error = "Пароль не совпадает";
                }
            } else {
                $error_codes['auth'] = true;
                $auth_error = "Неверная почта или пароль";
            }
        }
    }

    $category_list = get_categories_list($mysql);
    print(include_template('header.php', [
      'page_title' => $page_title,
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