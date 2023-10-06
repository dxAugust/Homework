<?php
    require_once('init.php');

    $category_list = get_categories_list($mysql);

    $error_codes = array(
        "email" => false,
        "password" => false,
        "name" => false,
        "message" => false,
    );

    if (isset($_SESSION['is_auth']) && $_SESSION['is_auth'])
    {
        header("Location: /");  
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if (isset($_POST["email"]) && !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
        {
            $error_codes["email"] = true;
        }

        if (isset($_POST["password"]) && empty($_POST["password"]))
        {
            $error_codes["password"] = true;
        }

        if (isset($_POST["name"]) && empty($_POST["name"]))
        {
            $error_codes["name"] = true;
        }

        if (isset($_POST["message"]) && empty($_POST["message"]))
        {
            $error_codes["message"] = true;
        }

        if (empty(array_filter($error_codes, 'strlen'))) 
        {
            $data = $_POST;
            register_user($mysql, $data);

            header("Location: /login.php");
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