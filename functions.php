<?php
function make_number($num)
{
    return number_format($num, 0, '', ' ').' ₽';
} 

function pretty_number($num)
{
    return number_format($num, 0, '', ' ');
}

function is_future_date($date)
{
    if (is_date_valid($date))
    {
        $date = DateTime::createFromFormat('Y-m-d', $date);
        $today = new DateTime();

        return $date->getTimestamp() >= $today->getTimestamp();
    } else {
        return false;
    }
}

const HOUR_SECONDS = 3600;
const MINUTE_SECONDS = 60;

function get_dt_range($date)
{
    $date_diff = strtotime($date) - time();

    $hours = str_pad(floor($date_diff / HOUR_SECONDS), 2, "0", STR_PAD_LEFT);
    $minutes = str_pad((round($date_diff / MINUTE_SECONDS) % MINUTE_SECONDS), 2, "0", STR_PAD_LEFT);
    return [$hours, $minutes];
}

function get_categories_list(mysqli $mysql) : array
{ 
    $sql_query = "SELECT * FROM category";
    $result = mysqli_query($mysql, $sql_query);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $rows;
}

function get_lot_list(mysqli $mysql)
{
    $sql_query = "SELECT `lot`.*, `category`.`name` AS `category_name` FROM `lot` INNER JOIN `category` ON `lot`.`category_id` = `category`.`id` WHERE `lot`.`expire_date` >= CURRENT_TIMESTAMP ORDER BY `lot`.`date_create`";
    $result = mysqli_query($mysql, $sql_query);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $rows;
}

function get_lot_info_by_id(mysqli $mysql, int $id)
{
    $sql_query = "SELECT `lot`.*, `category`.`name` AS `category_name` FROM `lot` INNER JOIN `category` ON `lot`.`category_id` = `category`.`id` WHERE `lot`.`id`=?";

    $stmt = mysqli_prepare($mysql, $sql_query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $lot = mysqli_fetch_assoc($result);

    return $lot;
}

function get_bet_list_by_lot_id(mysqli $mysql, int $id) : array
{
    $sql_query = "SELECT `bet`.`create_date`, `bet`.`summary`, `lot`.`name` AS `lot_name`, `account`.`name` AS `account_name` 
    FROM `bet` INNER JOIN `lot` ON `bet`.`lot_id` = `lot`.`id` INNER JOIN `account` ON `bet`.`user_id` = `account`.`id` WHERE `bet`.`lot_id` = ? ORDER BY `bet`.`create_date`";

    $stmt = mysqli_prepare($mysql, $sql_query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($result);

    return $rows;
}

function add_lot_to_database(mysqli $mysql, array $data)
{
    $sql_query = "INSERT INTO `lot` (`name`, `description`, `expire_date`, `start_price`, `bet_step`, `author_id`, `category_id`, `image_link`) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($mysql, $sql_query);
    mysqli_stmt_bind_param($stmt, 'sssiiiis', 
    $data["lot-name"],
    $data["message"],
    $data["lot-date"],
    $data["lot-rate"],
    $data["lot-step"],
    $data["author_id"],
    $data["category"],
    $data['image_link']
    );

    mysqli_stmt_execute($stmt);

    return mysqli_insert_id($mysql);
}

function format_time($date)
{
    $date_time = strtotime($date);

    $time = strtotime('now') - $date_time;
    $time = ($time < 1 ) ? 1 : $time;
    $tokens = array (
        86400 => 'день назад',
        3600 => 'часов назад',
        60 => 'минут назад',
        1 => 'секунд назад'
    );

    if ($time < 86400)
    {
        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text;
        }
    } else {
        return date('d.m.y в H:i', $date_time);
    }
}

function getPostVal($name)
{
    return $_POST[$name] ?? "";
}

function register_user($mysql, $data)
{
    $sql_query = "INSERT INTO `account` (`email`, `name`, `password`, `contacts`) VALUES(?, ?, ?, ?)";

    $userData = Array(
        "email" => htmlspecialchars($data["email"]),
        "password" => password_hash($data['password'], PASSWORD_DEFAULT),
        "name" => htmlspecialchars($data["name"]),
        "message" => htmlspecialchars($data["message"]),
    );
    $stmt = mysqli_prepare($mysql, $sql_query);
    mysqli_stmt_bind_param($stmt, 'ssss', 
    $userData["email"],
    $userData["password"],
    $userData["name"],
    $userData["message"]
    );

    mysqli_stmt_execute($stmt);
}

?>