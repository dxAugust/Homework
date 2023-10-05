CREATE TABLE IF NOT EXISTS `category`
( 
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL UNIQUE,
    `code` VARCHAR(60) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS `account`
( 
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `date_create` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `name` VARCHAR(60) NOT NULL,
    `password` VARCHAR(90) NOT NULL,
    `contacts` VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS `lot`
(
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `date_create` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(1024) NOT NULL,
    `image_link` VARCHAR(400) NOT NULL,

    `start_price` INT(255) NOT NULL,
    `expire_date` DATE NOT NULL,
    `bet_step` INT NOT NULL,

    `author_id` INT,
    `winner_id` INT,
    `category_id` INT,

    FOREIGN KEY (`author_id`) REFERENCES `account`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`winner_id`) REFERENCES `account`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`category_id`) REFERENCES `category`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `bet`
( 
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `create_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `summary` INT(80) NOT NULL,

    `user_id` INT,
    `lot_id` INT,

    FOREIGN KEY (`user_id`) REFERENCES `account`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`lot_id`) REFERENCES `lot`(`id`) ON DELETE CASCADE
);
