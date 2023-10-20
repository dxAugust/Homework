INSERT INTO `category` (`name`, `code`) 
VALUES
    ('Доски и лыжи', 'boards'),
    ('Крепления', 'attachment'),
    ('Одежда', 'clothing'),
    ('Ботинки', 'boots'),
    ('Инструменты', 'tools'),
    ('Разное', 'other');

INSERT INTO `account` (`email`, `name`, `password`, `contacts`) VALUES 
    ('ybrbnf1306@gmail.com', 'Никита', 'test123', '+7(901)4144412'),
    ('catslover2832@gmail.com', 'Зинаида', 'test123', 'prodaugust21@gmail.com'),
    ('IJAHwuhd@mail.ru', 'Афанасий', 'pevo2832', 'Telegram: @herbatalove'),
    ('kevkin2004@yahoo.com', 'Абдул', 'pevo2832', 'magistrpivnyxnayk@gmail.com');

INSERT INTO `lot` (`name`, `description`, `image_link`, `start_price`, `expire_date`, `bet_step`, `author_id`, `winner_id`, `category_id`) 
VALUES
    ('Куртка для сноуборда DC Mutiny Charocal', 'Лёгкая куртка для катания на сноуборде', '/img/lot-5.jpg', 20000, '2023-09-24', 9000, 3, 2, 3 ),
    ('Маска Oakley Canopy', 'Крутая маска что ещё сказать :)', '/img/lot-6.jpg', 5400, '2023-09-24', 2000, 4, 1, 6),
    ('Крепления Union Contact Pro 2015 года размер L/XL', 'Удобные крепления для ваших ножек', '/img/lot-3.jpg', 12000, '2023-09-22', 6000, 2, 1, 2),
    ('DC Ply Mens 2016/2017 Snowboard', 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами.', '/img/lot-1.jpg', 18000, '2023-09-25', 4000, 1, NULL, 1);


INSERT INTO `bet` (`summary`, `user_id`, `lot_id`) 
VALUES
    (8000, 1, 1),
    (9000, 2, 1),
    (9237, 3, 1),
    (10000, 4, 1),
    (15000, 2, 2),
    (70000, 1, 2),
    (10000, 3, 2),
    (86000, 4, 2),
    (3000, 2, 3),
    (5000, 1, 3),
    (8000, 4, 3),
    (8232, 2, 4),
    (10293, 1, 4),
    (13612, 3, 4),
    (23143, 4, 4);

-- 1. Получить список всех категорий
SELECT * FROM `category`;

-- 2. получить cписок лотов, которые еще не истекли отсортированных по 
-- дате публикации, от новых к старым. 
-- Каждый лот должен включать название, стартовую цену, 
-- ссылку на изображение, название категории и дату окончания торгов;
SELECT `lot`.`name`, `lot`.`start_price`, `lot`.`image_link`, `category`.`name` AS `category_name`  
FROM `lot` INNER JOIN `category` ON `lot`.`category_id` = `category`.`id` WHERE `lot`.`expire_date` >= CURRENT_TIMESTAMP ORDER BY `lot`.`date_create`;

-- 3. показать информацию о лоте по его ID. 
-- Вместо id категории должно выводиться  название категории, 
-- к которой принадлежит лот из таблицы категорий;
SELECT `lot`.*, `category`.`name` AS `category_name` FROM `lot` INNER JOIN `category` ON `lot`.`category_id` = `category`.`id` WHERE `lot`.`id`=2;

-- 4. Обновить название лота по его идентификатору
UPDATE `lot` SET `name`='Смена названия тест' WHERE `id`=1;

-- 5. Получить список ставок для лота по его идентификатору с сортировкой по дате. 
-- Список должен содержать дату и время размещения ставки, цену, 
-- по которой пользователь готов приобрести лот, название лота и имя пользователя, сделавшего ставку
SELECT `bet`.`create_date`, `bet`.`summary`, `lot`.`name` AS `lot_name`, `account`.`name` AS `account_name` 
FROM `bet` INNER JOIN `lot` ON `bet`.`lot_id` = `lot`.`id` INNER JOIN `account` ON `bet`.`user_id` = `account`.`id` WHERE `bet`.`lot_id` = 2 ORDER BY `bet`.`create_date` ASC;