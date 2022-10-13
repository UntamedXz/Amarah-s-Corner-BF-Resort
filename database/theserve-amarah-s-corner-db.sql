-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2022 at 02:13 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `theserve-amarah-s-corner-db`
--
CREATE DATABASE IF NOT EXISTS `theserve-amarah-s-corner-db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `theserve-amarah-s-corner-db`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(255) DEFAULT NULL,
  `admin_username` varchar(255) DEFAULT NULL,
  `admin_phone_number` varchar(255) DEFAULT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  `admin_password` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `admin_type` int(11) DEFAULT NULL,
  `vkey` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_username`, `admin_phone_number`, `admin_email`, `admin_password`, `profile_image`, `admin_type`, `vkey`) VALUES
(3, 'Jovy Ocampo', 'jovy.ocampo', '09364871634', 'jovelyn.ocampo@cvsu.edu.ph', '$2y$10$17Yg/icchirlCNiC9Jsgju9T73O.k0xNnf6YaK18ZL2O.icjHKKcC', '62d54c5c6594f.jpg', 1, NULL),
(5, 'Eramie Metre', 'era.metre', '09423532536', 'eramie.metre@cvsu.edu.ph', '$2y$10$/wxP61DoA6zozs4GiuYt1eflkawPqVCaXjSLjVT.FA/xRSA8q/kJu', '62a2c79cbfbd1.jpg', 2, NULL),
(7, 'Jennifer Sabado', 'jennifer.sabado', '', 'jensaturday02@gmail.com', '$2y$10$Km79rHLbe/7j1qAirnvJ3ede/FLf6mdzVzCsHM/y810v9d28qmY9m', '6304b5144b34c.jpg', 2, '59ebff0add6ae384ec01ab8e2b00b65b');

-- --------------------------------------------------------

--
-- Table structure for table `admin_type`
--

CREATE TABLE `admin_type` (
  `admin_type_id` int(11) NOT NULL,
  `admin_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_type`
--

INSERT INTO `admin_type` (`admin_type_id`, `admin_type`) VALUES
(1, 'admin'),
(2, 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `variation_value` varchar(255) DEFAULT NULL,
  `product_qty` int(11) DEFAULT NULL,
  `product_total_price` decimal(10,2) DEFAULT NULL,
  `product_total` decimal(10,2) DEFAULT NULL,
  `special_instructions` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(255) DEFAULT NULL,
  `categoty_thumbnail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_title`, `categoty_thumbnail`) VALUES
(1, 'Pasta', '629e3fab89c02.png'),
(2, 'Milktea', '629e3fc513386.png'),
(3, 'Pizza', '629e40015781f.png'),
(4, 'Chicken Wings', '629e4018c89ea.png'),
(5, 'Coffee', '629e4025508bd.png'),
(6, 'Refreshing Drinks', '629e403931a3e.png'),
(7, 'Cheesy Snacks', '629e404e7693f.png');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot`
--

CREATE TABLE `chatbot` (
  `id` int(11) NOT NULL,
  `messages` mediumtext NOT NULL,
  `response` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(11) DEFAULT NULL,
  `user_birthday` date DEFAULT NULL,
  `user_gender` varchar(255) DEFAULT NULL,
  `user_profile_image` varchar(255) DEFAULT NULL,
  `verified` tinyint(11) DEFAULT 0,
  `vkey` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`user_id`, `name`, `username`, `email`, `password`, `phone_number`, `user_birthday`, `user_gender`, `user_profile_image`, `verified`, `vkey`) VALUES
(1, 'Jennifer Sabado', 'jenn_sabado', 'untamedandromeda@gmail.com', '$2y$10$KkGSXrfUEl6Jd/ECa9d7A.P.QCL3erAlS0SqAq5dg7anMmVhROuTq', '09915362419', '2000-12-22', 'FEMALE', '633ea7c71c0ef.jpg', 1, NULL),
(10, 'Jennifer Sabado', 'jennifer.sabado', 'jennifer.sabado@cvsu.edu.ph', '$2y$10$RBrtZqqd0HEAusMlRkDZj.XeYlsc/T9E5dG9PRdClVhTPYRY1UmDa', '09162622138', '2000-12-22', 'FEMALE', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `delivery_id` int(11) NOT NULL,
  `delivery_title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`delivery_id`, `delivery_title`) VALUES
(1, 'Pick Up'),
(2, 'Delivery via Lalamove'),
(3, 'Delivery within BF');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `quality_score` tinyint(5) NOT NULL,
  `feedback` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `email`, `quality_score`, `feedback`) VALUES
(2, 'untamedandromeda@gmail.com', 4, 'ediwow asdfghjkl;qwertyuiop'),
(3, 'untamedandromeda@gmail.com', 5, 'Sheeeet sarap lang masasabi ko!'),
(4, 'untamedandromeda@gmail.com', 1, 'Di na kayo yung kilala kong Amarah. Nagbago na kayo. Ampanget! TSEEEEEEEEEEEEEEEEEEEEEE!');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_method` int(11) DEFAULT NULL,
  `delivery_method` int(11) DEFAULT NULL,
  `shipping_fee` varchar(255) DEFAULT NULL,
  `screenshot_payment` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `order_total` varchar(255) DEFAULT NULL,
  `order_date` varchar(255) DEFAULT NULL,
  `order_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `payment_method`, `delivery_method`, `shipping_fee`, `screenshot_payment`, `reference`, `order_total`, `order_date`, `order_status`) VALUES
(1, 1, 1, 1, '0.00', NULL, NULL, '1823.00', 'October 8, 2022 09:49 PM', 5),
(3, 1, 1, 1, '0.00', NULL, NULL, '115.00', 'October 8, 2022 10:25 PM', 5),
(4, 1, 1, 2, '135.00', NULL, NULL, '1086.00', 'October 8, 2022 11:17 PM', 5);

-- --------------------------------------------------------

--
-- Table structure for table `order_address`
--

CREATE TABLE `order_address` (
  `order_address_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `billing_name` varchar(255) DEFAULT NULL,
  `billing_number` varchar(11) DEFAULT NULL,
  `block_street_building` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city_municipality` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_address`
--

INSERT INTO `order_address` (`order_address_id`, `order_id`, `billing_name`, `billing_number`, `block_street_building`, `province`, `city_municipality`, `barangay`) VALUES
(64, 1, 'Jennifer Sabado', '09915362419', 'Block 130, Bagong Kampi St., Green Valley', 'Cavite', 'Bacoor', 'San Nicolas III'),
(66, 3, 'Jennifer Sabado', '09915362419', 'Block 130, Bagong Kampi St., Green Valley', 'Cavite', 'Bacoor', 'San Nicolas III'),
(67, 4, 'Jennifer Sabado', '09915362419', 'Block 130, Bagong Kampi St., Green Valley', 'Cavite', 'Bacoor', 'San Nicolas III');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_items_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `product_total` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_items_id`, `order_id`, `product_id`, `subcategory_id`, `qty`, `product_total`) VALUES
(100, 1, 4, 0, '5', '595.00'),
(101, 1, 3, 1, '5', '600.00'),
(102, 1, 2, 3, '1', '249.00'),
(103, 1, 1, 3, '1', '249.00'),
(104, 1, 3, 1, '1', '130.00'),
(105, 3, 3, 1, '1', '115.00'),
(106, 4, 4, 0, '3', '357.00'),
(107, 4, 3, 1, '3', '345.00'),
(108, 4, 2, 3, '1', '249.00');

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `order_status_id` int(11) NOT NULL,
  `order_status_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`order_status_id`, `order_status_name`) VALUES
(1, 'Pending'),
(2, 'Order Confirmed'),
(3, 'Preparing'),
(4, 'To be Received'),
(5, 'Order Delivered'),
(6, 'Cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `payment_title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `payment_title`) VALUES
(1, 'Cash on Delivery'),
(2, 'Gcash');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `product_title` varchar(255) DEFAULT NULL,
  `product_desc` varchar(255) DEFAULT NULL,
  `product_slug` varchar(255) DEFAULT NULL,
  `product_img1` varchar(255) DEFAULT NULL,
  `product_img2` varchar(255) DEFAULT NULL,
  `product_img3` varchar(255) DEFAULT NULL,
  `product_keyword` varchar(255) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `product_sale` varchar(255) DEFAULT NULL,
  `product_status` int(11) DEFAULT NULL,
  `product_stock` int(11) DEFAULT NULL,
  `product_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`category_id`, `subcategory_id`, `product_id`, `product_title`, `product_desc`, `product_slug`, `product_img1`, `product_img2`, `product_img3`, `product_keyword`, `product_price`, `product_sale`, `product_status`, `product_stock`, `product_type`) VALUES
(3, 3, 1, 'Ham & Cheese ', 'Ham & Cheese Flavor Pizza', 'ham-cheese', '63396bc4177f3.jpg', NULL, NULL, 'Ham & Cheese ', '129.00', NULL, NULL, NULL, 2),
(3, 3, 2, 'Hawaiian Pizza', 'Hawaiian Flavor Pizza', 'hawaiian-pizza', '63396c1ea88f4.jpg', NULL, NULL, 'Hawaiian Pizza', '129.00', NULL, NULL, NULL, 2),
(2, 1, 3, 'Classic', 'Classic Flavor Milktea', 'classic', '633b9a87b5007.jpg', NULL, NULL, 'Classic', '90.00', NULL, NULL, NULL, 2),
(1, NULL, 4, 'Saucy Spaghetti', 'Saucy Spaghetti Pasta', 'saucy-spaghetti', '633ba3ff1901a.jpg', NULL, NULL, 'Saucy Spaghetti', '119.00', NULL, 1, NULL, 1),
(1, NULL, 5, 'Creamy Carbonara', 'Creamy Carbonara Pasta', 'creamy-carbonara', '633ba43b84324.jpg', NULL, NULL, 'Creamy Carbonara', '119.00', NULL, 1, NULL, 1),
(4, NULL, 6, 'Buffalo Wings', 'Bufallo flavor wings', 'buffalo-wings', '6343c19ad8229.jpg', NULL, NULL, 'Buffalo Wings', '139.00', NULL, NULL, NULL, 2),
(4, NULL, 7, 'Honey Garlic Wings', 'Honey Garlic Flavor wings', 'honey-garlic-wings', '6343c2480edfe.jpg', NULL, NULL, 'Honey Garlic Wings', '139.00', NULL, NULL, NULL, 2),
(7, NULL, 8, 'Cheesy Fries', 'Cheesy Fries flavor snack', 'cheesy-fries', '6343c2a82c668.jpg', NULL, NULL, 'Cheesy Fries', '145.00', NULL, 1, NULL, 1),
(7, NULL, 9, 'Cheesy Nachos', 'Cheesy Nachos flavor snack', 'cheesy-nachos', '6343c2c93349e.jpg', NULL, NULL, 'Cheesy Nachos', '145.00', NULL, 1, NULL, 1),
(5, 8, 10, 'Espresso', 'Espresso flavor coffee', 'espresso', NULL, NULL, NULL, 'Espresso', '160.00', NULL, 1, NULL, 1),
(6, 10, 11, 'Strawberry Jasmine', 'Strawberry Jasmine flavor fruit tea', 'strawberry-jasmine', '6343c449c8342.png', NULL, NULL, 'Strawberry Jasmine', '88.00', NULL, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute`
--

CREATE TABLE `product_attribute` (
  `product_id` int(11) DEFAULT NULL,
  `attribute_id` int(11) NOT NULL,
  `attribute_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_attribute`
--

INSERT INTO `product_attribute` (`product_id`, `attribute_id`, `attribute_name`) VALUES
(2, 272, 'SIZE'),
(3, 325, 'SIZE'),
(3, 326, 'ADDONS'),
(1, 327, 'SIZE'),
(6, 329, 'Pieces'),
(7, 331, 'Pieces'),
(11, 333, 'Size');

-- --------------------------------------------------------

--
-- Table structure for table `product_status`
--

CREATE TABLE `product_status` (
  `product_status_id` int(11) NOT NULL,
  `product_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_status`
--

INSERT INTO `product_status` (`product_status_id`, `product_status`) VALUES
(1, 'AVAILABLE'),
(2, 'NOT AVAILABLE');

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `product_type_id` int(11) NOT NULL,
  `product_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`product_type_id`, `product_type`) VALUES
(1, 'Simple Product'),
(2, 'Variable Product');

-- --------------------------------------------------------

--
-- Table structure for table `product_variation`
--

CREATE TABLE `product_variation` (
  `product_id` int(11) DEFAULT NULL,
  `attribute_id` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL,
  `variation_value` varchar(255) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `product_sale` decimal(10,2) DEFAULT NULL,
  `stock` varchar(255) DEFAULT NULL,
  `stock_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_variation`
--

INSERT INTO `product_variation` (`product_id`, `attribute_id`, `variation_id`, `variation_value`, `product_price`, `product_sale`, `stock`, `stock_status`) VALUES
(2, 272, 609, '10 inch', '129.00', NULL, NULL, 1),
(2, 272, 610, '12 inch', '249.00', NULL, NULL, 1),
(3, 325, 779, '16oz', '90.00', NULL, NULL, 1),
(3, 325, 780, '22oz', '105.00', NULL, NULL, 1),
(3, 326, 781, 'None', '0.00', NULL, NULL, 1),
(3, 326, 782, 'Pearl', '10.00', NULL, NULL, 1),
(3, 326, 783, 'Cofee Jelly', '15.00', NULL, NULL, 1),
(3, 326, 784, 'Nata', '15.00', NULL, NULL, 1),
(3, 326, 785, 'Cream Cheese', '25.00', NULL, NULL, 1),
(1, 327, 786, '10 inch', '199.00', NULL, NULL, 1),
(1, 327, 787, '12 inch', '249.00', NULL, NULL, 1),
(6, 329, 792, 'Solo 1 - 4pcs', '139.00', NULL, NULL, 1),
(6, 329, 793, 'Solo 2 - 6pcs', '219.00', NULL, NULL, 1),
(6, 329, 794, 'Sharing - 8pcs', '249.00', NULL, NULL, 1),
(6, 329, 795, 'Barkada Bundle - 24pcs', '679.00', NULL, NULL, 1),
(7, 331, 800, 'Solo 1 - 4pcs', '139.00', NULL, NULL, 1),
(7, 331, 801, 'Solo 2 - 6pcs', '219.00', NULL, NULL, 1),
(7, 331, 802, 'Sharing - 8pcs', '249.00', NULL, NULL, 1),
(7, 331, 803, 'Barkada Bundle - 24pcs', '679.00', NULL, NULL, 1),
(11, 333, 806, '16oz', '88.00', NULL, NULL, 1),
(11, 333, 807, '22oz', '99.00', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `stock_status`
--

CREATE TABLE `stock_status` (
  `stock_id` int(11) NOT NULL,
  `stock` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stock_status`
--

INSERT INTO `stock_status` (`stock_id`, `stock`) VALUES
(1, 'In stock'),
(2, 'Out of stock');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `subcategory_title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`category_id`, `subcategory_id`, `subcategory_title`) VALUES
(2, 1, 'Classic Series'),
(2, 2, 'Special Series'),
(3, 3, 'Classic Flavor'),
(3, 4, 'Special Flavor'),
(5, 7, 'Cold Coffee'),
(5, 8, 'Hot Coffee'),
(5, 9, 'Frappe'),
(6, 10, 'Fruit Tea'),
(6, 11, 'Lemonade');

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE `updates` (
  `updates_id` int(11) NOT NULL,
  `updates_text` varchar(900) DEFAULT NULL,
  `updates_image` varchar(255) DEFAULT NULL,
  `updates_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `updates`
--

INSERT INTO `updates` (`updates_id`, `updates_text`, `updates_image`, `updates_date`) VALUES
(5, 'Some days, you just need a sweet sip of cool coffee to make you feel better. ☕ ORDER NOW!\r\n\r\nWE DELIVER ❗❗\r\n?0908-812-6310\r\n⏰ 11:00am-3:00amI Daily\r\n? Amarah\'s Corner BF Resort\r\nB5 L71 JB TAN ST BF RESORT VILLAGE TALON DOS LAS PINAS\r\n✔️Dine-In\r\n✔️Takeout\r\n✔️Delivery\r\n✔️Pick-Up\r\n✔️Advance Order\r\nMessage us to Order!\r\n( FREE DELIVERY WITHIN BF RESORT VILLAGE)\r\n#amarahscornerbf\r\n#chickenwings\r\n#pizza\r\n#milktea\r\n#coffee', '62a67281c7cff.jpg', 'June 13, 2022'),
(6, 'Netflix & chill? We\'re chilling with this combo you need to try! Message us to order.\r\nWE DELIVER ❗❗\r\n?0908-812-6310\r\n⏰ 11:00am-3:00amI Daily\r\n? Amarah\'s Corner BF Resort\r\nB5 L71 JB TAN ST BF RESORT VILLAGE TALON DOS LAS PINAS\r\n✔️Dine-In\r\n✔️Takeout\r\n✔️Delivery\r\n✔️Pick-Up\r\n✔️Advance Order\r\nMessage us to Order!\r\n( FREE DELIVERY WITHIN BF RESORT VILLAGE)\r\n#amarahscornerbf\r\n#chickenwings\r\n#pizza\r\n#milktea\r\n#coffee', '62a677b76208b.jpg', 'June 13, 2022'),
(7, 'Another acoustic jam session here at Amarah\'s Corner - Bf Resort x Lando\'s this coming Wednesday to Sunday at 8pm. See you! ?', '62a6782ac0b3f.jpg', 'June 13, 2022');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `admin_type` (`admin_type`);

--
-- Indexes for table `admin_type`
--
ALTER TABLE `admin_type`
  ADD PRIMARY KEY (`admin_type_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `chatbot`
--
ALTER TABLE `chatbot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`delivery_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `payment_method` (`payment_method`),
  ADD KEY `delivery_method` (`delivery_method`),
  ADD KEY `order_status` (`order_status`);

--
-- Indexes for table `order_address`
--
ALTER TABLE `order_address`
  ADD PRIMARY KEY (`order_address_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_items_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`order_status_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `subcategory_id` (`subcategory_id`),
  ADD KEY `product_type` (`product_type`),
  ADD KEY `product_status` (`product_status`);

--
-- Indexes for table `product_attribute`
--
ALTER TABLE `product_attribute`
  ADD PRIMARY KEY (`attribute_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_status`
--
ALTER TABLE `product_status`
  ADD PRIMARY KEY (`product_status_id`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`product_type_id`);

--
-- Indexes for table `product_variation`
--
ALTER TABLE `product_variation`
  ADD PRIMARY KEY (`variation_id`),
  ADD KEY `stock_status` (`stock_status`),
  ADD KEY `attribute_id` (`attribute_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `stock_status`
--
ALTER TABLE `stock_status`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`subcategory_id`),
  ADD KEY `subcategory_ibfk_1` (`category_id`);

--
-- Indexes for table `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`updates_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `admin_type`
--
ALTER TABLE `admin_type`
  MODIFY `admin_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `chatbot`
--
ALTER TABLE `chatbot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_address`
--
ALTER TABLE `order_address`
  MODIFY `order_address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `order_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_attribute`
--
ALTER TABLE `product_attribute`
  MODIFY `attribute_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=334;

--
-- AUTO_INCREMENT for table `product_status`
--
ALTER TABLE `product_status`
  MODIFY `product_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `product_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_variation`
--
ALTER TABLE `product_variation`
  MODIFY `variation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=808;

--
-- AUTO_INCREMENT for table `stock_status`
--
ALTER TABLE `stock_status`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `subcategory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `updates`
--
ALTER TABLE `updates`
  MODIFY `updates_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`admin_type`) REFERENCES `admin_type` (`admin_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customers` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`payment_method`) REFERENCES `payment` (`payment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`delivery_method`) REFERENCES `delivery` (`delivery_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`order_status`) REFERENCES `order_status` (`order_status_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_address`
--
ALTER TABLE `order_address`
  ADD CONSTRAINT `order_address_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategory` (`subcategory_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_4` FOREIGN KEY (`product_type`) REFERENCES `product_type` (`product_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_5` FOREIGN KEY (`product_status`) REFERENCES `stock_status` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_attribute`
--
ALTER TABLE `product_attribute`
  ADD CONSTRAINT `product_attribute_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_variation`
--
ALTER TABLE `product_variation`
  ADD CONSTRAINT `product_variation_ibfk_2` FOREIGN KEY (`stock_status`) REFERENCES `stock_status` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_variation_ibfk_3` FOREIGN KEY (`attribute_id`) REFERENCES `product_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_variation_ibfk_4` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `subcategory_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
