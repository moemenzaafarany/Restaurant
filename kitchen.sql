CREATE TABLE `kitchen_users` (
    `user_id` int(11) AUTO_INCREMENT,
    `DeviceName` varchar(50) NOT NULL,
    PRIMARY KEY(`user_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `kitchen_items` (
    `item_id` int(11) AUTO_INCREMENT,
    `item_name` varchar(50) NOT NULL,
    `img` varchar(128) NOT NULL,
    `price` double NOT NULL,
    `category` enum('breakfast', 'lunch') not null default 'breakfast',
    PRIMARY KEY(`item_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `kitchen_orders` (
    `order_id` int(11) AUTO_INCREMENT,
    `user_id` int(11) not null,
    `date` date not null,
    `category` enum('breakfast', 'lunch') not null,
    `status` enum('new', 'completed', 'canceled') not null default 'new',
    PRIMARY KEY(`order_id`),
    FOREIGN KEY (`user_id`) REFERENCES `kitchen_users`(`user_id`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `kitchen_orders_items` (
    `order_id` int(11) not null,
    `item_id` int(11) not null,
    `qty` int(11) NOT NULL,
    `price` double NOT NULL,
    `notes` varchar(1024) NULL,
    PRIMARY KEY(`order_id`, `item_id`),
    FOREIGN KEY (`order_id`) REFERENCES `kitchen_orders`(`order_id`) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (`item_id`) REFERENCES `kitchen_items`(`item_id`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;