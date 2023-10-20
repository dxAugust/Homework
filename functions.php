<?php
/**
* Форматирует число добавляя пробелы, пример: 1 000 000
* Также добавляет знак национальной валюты РФ
* @param integer $num Дата для валидации
*
* @return string Возвращает строку с форматрированным числом
*/
function make_number($num)
{
    return number_format($num, 0, '', ' ').' ₽';
} 

/**
* Форматирует число добавляя пробелы, пример: 1 000 000
* @param integer $num Дата для валидации
*
* @return string Возвращает строку с форматрированным числом
*/
function pretty_number($num)
{
    return number_format($num, 0, '', ' ');
}

/**
* Проверяет является ли дата в будующем или настоящем времени
* @param string $date Дата для валидации
*
* @return bool Возвращает true в случае если всё соотвестствует (false если дата не валидна или находится в прощедшем времени)
*/
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

/**
* Получает разницу между датами в часах, минутах, секундах (Пример: 02:28:12)
* @param string $date Дата для валидации
*
* @return array Возвращает массив с кол-вом часов и минут
*/
function get_dt_range($date)
{
    $date_diff = strtotime($date) - time();

    $hours = str_pad(floor($date_diff / HOUR_SECONDS), 2, "0", STR_PAD_LEFT);
    $minutes = str_pad((round($date_diff / MINUTE_SECONDS) % MINUTE_SECONDS), 2, "0", STR_PAD_LEFT);
    $seconds = str_pad((round($date_diff) % 1), 2, "0", STR_PAD_LEFT);

    return [$hours, $minutes, $seconds];
}

/**
* Получает список всех категорий имеющихся в базе данных
* @param mysqli $mysql Дата для валидации
*
* @return array Возвращает список всех лотов из базы данных
*/
function get_categories_list(mysqli $mysql) : array
{ 
    $sql_query = "SELECT * FROM category";
    $result = mysqli_query($mysql, $sql_query);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $rows;
}

/**
* Получает список всех актуальных лотов
* @param mysqli $mysql Текущее подключение к базе данных
*
* @return array Возвращает список всех актуальных лотов
*/
function get_lot_list(mysqli $mysql)
{
    $sql_query = "SELECT `lot`.*, `category`.`name` AS `category_name` FROM `lot` INNER JOIN `category` ON `lot`.`category_id` = `category`.`id` WHERE `lot`.`expire_date` >= CURRENT_TIMESTAMP ORDER BY `lot`.`date_create`";
    $result = mysqli_query($mysql, $sql_query);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $rows;
}

/**
* Получить информацию о лоте по ID
* @param mysqli $mysql Текущее подключение к базе данных
* @param integer $id Идентификатор искомого лота в базе данных
*
* @return array Возвращает информацию о лоте
*/
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

/**
* Получить список ставок на лот по его ID
* @param mysqli $mysql Текущее подключение к базе данных
* @param integer $id Идентификатор искомого лота в базе данных
*
* @return array Возвращает список ставок на лот
*/
function get_bet_list_by_lot_id(mysqli $mysql, int $id) : array
{
    $sql_query = "SELECT `bet`.`create_date`, `bet`.`summary`, `lot`.`name` AS `lot_name`, `account`.`name` AS `account_name` 
    FROM `bet` INNER JOIN `lot` ON `bet`.`lot_id` = `lot`.`id` INNER JOIN `account` ON `bet`.`user_id` = `account`.`id` WHERE `bet`.`lot_id` = ? ORDER BY `bet`.`create_date`";

    $stmt = mysqli_prepare($mysql, $sql_query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $rows;
}

/**
* Добавляет лот в базу данных
* с указанными данными
* @param mysqli $mysql Текущее подключение к базе данных
* @param array $data Данные пользователя
*
* @return integer ID добавленного лота
*/
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

/**
* Возвращает время в формате прошедших дней суток, часов и т. д.
* @param string $date Дата
*
* @return string Отформатированное время
*/
function format_time(string $date) : string
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
            
            return $numberOfUnits .' '. $text;
        }
    } else {
        return date('d.m.y в H:i', $date_time);
    }

    return "";
}

/**
* Получает значение поля при POST запросе
* @param string $name Название поля в POST запросе
*
* @return string Возвращает значение, иначе возвращает пустую строку
*/
function get_post_val(string $name)
{
    return $_POST[$name] ?? "";
}

/**
* Создаёт учётную запись в базе данных
* с указанными данными
* @param mysqli $mysql Текущее подключение к базе данных
* @param array $data Данные пользователя
*
* @return integer ID зарегистрированного пользователя
*/
function register_user(mysqli $mysql, array $data)
{
    $sql_query = "INSERT INTO `account` (`email`, `name`, `password`, `contacts`) VALUES(?, ?, ?, ?)";

    $userData = Array(
        "email" => strip_tags($data["email"]),
        "password" => password_hash($data['password'], PASSWORD_DEFAULT),
        "name" => strip_tags($data["name"]),
        "message" => strip_tags($data["message"]),
    );
    $stmt = mysqli_prepare($mysql, $sql_query);
    mysqli_stmt_bind_param($stmt, 'ssss', 
    $userData["email"],
    $userData["name"],
    $userData["password"],
    $userData["message"]
    );

    mysqli_stmt_execute($stmt);
    return mysqli_insert_id($mysql);
}

/**
* Получает информацию о пользователе
* по указанной электронной почте
* @param mysqli $mysql Текущее подключение к базе данных
* @param string $email Почта пользователя
*
* @return array Информация о пользователе
*/
function get_user_info_by_email(mysqli $mysql, string $email)
{
    $sql_query = "SELECT * FROM `account` WHERE `account`.`email`=?";

    $stmt = mysqli_prepare($mysql, $sql_query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result) ?? null;
}

/**
* Ищет лоты по указанному имени
* @param mysqli $mysql Текущее подключение к базе данных
* @param string $term Название искомого лота
*
* @return array Найденные лоты (В противном случае возвращает null)
*/
function search_lots_by_name(mysqli $mysql, string $term, int $limit, int $offset) : array | null
{
    $sql_query = "SELECT `lot`.*, `category`.`name` AS `category_name` FROM `lot` INNER JOIN `category` ON `lot`.`category_id` = `category`.`id` WHERE MATCH(`lot`.`name`, `lot`.`description`) AGAINST(?) LIMIT ? OFFSET ?";

    $stmt = mysqli_prepare($mysql, $sql_query);
    mysqli_stmt_bind_param($stmt, 'sii', $term, $limit, $offset);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC) ?? null;
}

?>