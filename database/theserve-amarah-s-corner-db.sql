-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2022 at 03:25 PM
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

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`user_id`, `cart_id`, `category_id`, `subcategory_id`, `product_id`, `variation_value`, `product_qty`, `product_total_price`, `product_total`, `special_instructions`) VALUES
(13, 15, 1, NULL, 4, NULL, 1, '119.00', '119.00', NULL);

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

--
-- Dumping data for table `chatbot`
--

INSERT INTO `chatbot` (`id`, `messages`, `response`) VALUES
(1, 'bading', ' ');

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
(12, 'Jennifer Sabado', 'jenn.sabado', 'jennsabado22@gmail.com', '$2y$10$5AWK/LCslT0pRZwEpjrgAOcfLYpDKp7HkghDGZcoGkGvhhL6uTBom', '09915362419', '2000-12-22', 'FEMALE', NULL, 1, 'df7a98cb5b97d5bf2c6bf82e3694b6c0'),
(13, 'Mark Ryan Jancorda', 'ryjin', 'markryanjancorda@yahoo.com', '$2y$10$YOFUWEtnAZ0KCIFXqLzPluUcYmGDaLSvmh4ju95FXBGFzHF2ctZoe', '09154704204', '1992-03-11', 'MALE', NULL, 0, 'a8b56ff26155d02b3271a395350d2ef9'),
(14, 'Jennifer Sabado', 'Jenifer Sabado', 'jennifer.sabado@cvsu.edu.ph', '$2y$10$XH27SR.YENVjFIViSoWcou1A8EsmieRUByWB4uZmKpqdA81vXoF7q', '09915362419', '2000-12-22', 'FEMALE', NULL, 0, 'c01fabf1469f0372c44f4a5a5105b504'),
(16, 'Jennifer Sabado', 'jennifer.sabado', 'untamedandromeda@gmail.com', '$2y$10$jTHq/OFM8//H.DwIC7QAbOXgO.tgl2JfBr7.fmjtnXT0HSr2rKN.q', '09915362419', '2000-12-22', 'FEMALE', NULL, 1, '8213886e872133b27a8f9bb0aad3d964'),
(17, 'Rainie Akemi', 'Lopez', 'jennifer.sabado1hi2.in@gmail.com', '$2y$10$cLwdhxYk/8CQmsDW.1wsjOyqye13Q0IqftdY7kmI/q0eWxPTad1Ta', '09915362419', '2000-12-22', 'FEMALE', NULL, 1, 'bcbf84f574cf600d3e8e13849e483fda');

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
(4, 'untamedandromeda@gmail.com', 1, 'Di na kayo yung kilala kong Amarah. Nagbago na kayo. Ampanget! TSEEEEEEEEEEEEEEEEEEEEEE!'),
(5, 'jennsabado22@gmail.com', 5, 'Masarap siya! Rooooooor!'),
(6, 'untamedandromeda@gmail.com', 4, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `open_hours`
--

CREATE TABLE `open_hours` (
  `day_id` int(11) NOT NULL,
  `day` varchar(255) DEFAULT NULL,
  `open_hour` varchar(255) DEFAULT NULL,
  `close_hour` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `open_hours`
--

INSERT INTO `open_hours` (`day_id`, `day`, `open_hour`, `close_hour`) VALUES
(1, 'Monday', '11:00 AM', '03:00 AM'),
(2, 'Tuesday', '11:00 AM', '03:00 AM'),
(3, 'Wednesday', '11:00 AM', '03:00 AM'),
(4, 'Thursday', '11:00 AM', '03:00 AM'),
(5, 'Friday', '11:00 AM', '03:00 AM'),
(6, 'Saturday', '11:00 AM', '03:00 AM'),
(7, 'Sunday', '11:00 AM', '03:00 AM');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_method` int(11) DEFAULT NULL,
  `delivery_method` int(11) DEFAULT NULL,
  `shipping_fee` decimal(10,2) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `screenshot_payment` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `order_total` varchar(255) DEFAULT NULL,
  `order_date` varchar(255) DEFAULT NULL,
  `order_status` int(11) DEFAULT NULL,
  `completed_date` varchar(255) DEFAULT NULL,
  `notified` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `payment_method`, `delivery_method`, `shipping_fee`, `longitude`, `latitude`, `screenshot_payment`, `reference`, `order_total`, `order_date`, `order_status`, `completed_date`, `notified`) VALUES
(3, 17, 2, 2, '82.00', '120.9850172375418', '14.438448751331308', '6356a340cd746.png', '4342435235353', '691.00', 'October 24, 2022 10:37 PM', 3, NULL, NULL),
(4, 17, 1, 1, NULL, NULL, NULL, NULL, NULL, '240.00', 'October 26, 2022 01:57 PM', 1, NULL, NULL);

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
(86, 3, 'Rainie Akemi', '09915362419', 'B2 L8, Peacock St.', 'Metro Manila', 'Las Pinas', 'Talon Uno'),
(87, 4, 'Rainie Akemi', '09915362419', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_items_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `variation_value` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `product_total` varchar(255) DEFAULT NULL,
  `special_instructions` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_items_id`, `order_id`, `product_id`, `category_id`, `subcategory_id`, `variation_value`, `qty`, `product_total`, `special_instructions`) VALUES
(134, 3, 14, 2, 1, 'SIZE: 22oz | ADDONS: Cofee Jelly', '3', '360.00', NULL),
(135, 3, 2, 3, 3, 'SIZE: 12 inch', '1', '249.00', NULL),
(136, 4, 3, 2, 1, 'SIZE: 22oz | ADDONS: Nata', '1', '120.00', NULL),
(137, 4, 3, 2, 1, 'SIZE: 22oz | ADDONS: Nata', '1', '120.00', NULL);

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
(1, 'Cash on Delivery/Pick Up'),
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
(4, NULL, 6, 'Buffalo Wings', 'Bufallo flavor wings', 'buffalo-wings', '6343c19ad8229.jpg', NULL, NULL, 'Buffalo Wings', '129.00', NULL, NULL, NULL, 2),
(4, NULL, 7, 'Honey Garlic Wings', 'Honey Garlic Flavor wings', 'honey-garlic-wings', '6343c2480edfe.jpg', NULL, NULL, 'Honey Garlic Wings', '129.00', NULL, NULL, NULL, 2),
(7, NULL, 8, 'Cheesy Fries', 'Cheesy Fries flavor snack', 'cheesy-fries', '6343c2a82c668.jpg', NULL, NULL, 'Cheesy Fries', '145.00', NULL, 1, NULL, 1),
(7, NULL, 9, 'Cheesy Nachos', 'Cheesy Nachos flavor snack', 'cheesy-nachos', '6343c2c93349e.jpg', NULL, NULL, 'Cheesy Nachos', '145.00', NULL, 1, NULL, 1),
(5, 8, 10, 'Espresso', '12oz Espresso Flavor Coffee', 'espresso', NULL, NULL, NULL, 'Espresso', '145.00', NULL, 1, NULL, 1),
(6, 10, 11, 'Strawberry Jasmine', 'Strawberry Jasmine flavor fruit tea', 'strawberry-jasmine', '6343c449c8342.png', NULL, NULL, 'Strawberry Jasmine', '88.00', NULL, NULL, NULL, 2),
(2, 1, 12, 'Taro', 'Taro Flavor Milktea', 'taro', '634e6a9d557fc.jpg', NULL, NULL, 'Taro', '90.00', NULL, NULL, NULL, 2),
(2, 1, 13, 'Matcha', 'Matcha Flavor Milktea', 'matcha', NULL, NULL, NULL, 'Matcha', '90.00', NULL, NULL, NULL, 2),
(2, 1, 14, 'Vanilla', 'Vanilla Flavor Milktea', 'vanilla', '634e6b0b9abf0.jpg', NULL, NULL, 'Vanilla', '90.00', NULL, NULL, NULL, 2),
(2, 1, 15, 'Okinawa', 'Okinawa Flavor Milktea', 'okinawa', '634e6c132d0a0.jpg', NULL, NULL, 'Okinawa', '90.00', NULL, NULL, NULL, 2),
(2, 1, 16, 'Cookies and Cream', 'Cookies and Cream Flavor Milktea', 'cookies-and-cream', '634e6c62e4832.jpg', NULL, NULL, 'Cookies and Cream', '90.00', NULL, NULL, NULL, 2),
(2, 1, 17, 'Dark Chocolate', 'Dark Chocolate Flavor Milktea', 'dark-chocolate', '634e6cb7a4df0.jpg', NULL, NULL, 'Dark Chocolate', '90.00', NULL, NULL, NULL, 2),
(2, 1, 18, 'Wintermelon', 'Wintermelon Flavor Milktea', 'wintermelon', '634e6cfcd3a7c.jpg', NULL, NULL, 'Wintermelon', '90.00', NULL, NULL, NULL, 2),
(2, 1, 19, 'Double Dutch', 'Double Dutch Flavor Milktea', 'double-dutch', '634e6d3b9647d.jpg', NULL, NULL, 'Double Dutch', '90.00', NULL, NULL, NULL, 2),
(2, 2, 20, 'House Blend Winter', 'House Blend Winter Flavor Milktea', 'house-blend-winter', NULL, NULL, NULL, 'House Blend Winter', '125.00', NULL, NULL, NULL, 2),
(2, 2, 21, 'White Rabbit', 'White Rabbit Flavor Milktea', 'white-rabbit', NULL, NULL, NULL, 'White Rabbit', '125.00', NULL, NULL, NULL, 2),
(2, 2, 22, 'Red Velvet', 'Red Velvet Flavor Milktea', 'red-velvet', '634e85e5f2e06.jpg', NULL, NULL, 'Red Velvet', '125.00', NULL, NULL, NULL, 2),
(2, 2, 23, 'Milky Taro', 'Milk Taro Flavor Milktea', 'milky-taro', '634e916983027.jpg', NULL, NULL, 'Milky Taro', '125.00', NULL, NULL, NULL, 2),
(2, 2, 24, 'Choco Lava', 'Choco Lava Flavor Milktea', 'choco-lava', '634e91aa9d943.jpg', NULL, NULL, 'Choco Lava', '125.00', NULL, NULL, NULL, 2),
(2, 2, 25, 'Overload Oreo', 'Overload Oreo Flavor Milktea', 'overload-oreo', '634e91e3de4fd.jpg', NULL, NULL, 'Overload Oreo', '125.00', NULL, NULL, NULL, 2),
(2, 2, 26, 'Brown Sugar', 'Brown Sugar Flavor Milktea', 'brown-sugar', NULL, NULL, NULL, 'Brown Sugar', '125.00', NULL, NULL, NULL, 2),
(4, NULL, 27, 'Salted Egg', 'Salted Egg Flavor Wings', 'salted-egg', '634e93045e955.jpg', NULL, NULL, 'Salted Egg', '129.00', NULL, NULL, NULL, 2),
(4, NULL, 28, 'Garlic Parmesan', 'Garlic Parmesan Flavor Wings', 'garlic-parmesan', '634e935c2d107.jpg', NULL, NULL, 'Garlic Parmesan', '129.00', NULL, NULL, NULL, 2),
(4, NULL, 29, 'Buttered Garlic', 'Buttered Garlic Flavor Wings', 'buttered-garlic', '634e93958723c.jpg', NULL, NULL, 'Buttered Garlic', '129.00', NULL, NULL, NULL, 2),
(5, 8, 30, 'Americano', '12oz Americano Flavor Coffee', 'americano', NULL, NULL, NULL, 'Americano', '145.00', NULL, 1, NULL, 1),
(5, 8, 31, 'Mocha', '12oz Mocha Flavor Coffee', 'mocha', NULL, NULL, NULL, 'Mocha', '145.00', NULL, 1, NULL, 1),
(5, 8, 32, 'Vanilla Latte', '12oz Vanilla Latte Flavor Coffee', 'vanilla-latte', NULL, NULL, NULL, 'Vanilla Latte', '145.00', NULL, 1, NULL, 1),
(5, 8, 33, 'Hazelnut Latte', '12oz Hazelnut Latte Flavor Coffee', 'hazelnut-latte', NULL, NULL, NULL, 'Hazelnut Latte', '145.00', NULL, 1, NULL, 1),
(5, 8, 34, 'Capuccino', '12oz Capuccino Flavor Coffee', 'capuccino', NULL, NULL, NULL, 'Capuccino', '145.00', NULL, 1, NULL, 1),
(5, 7, 35, 'Spanish Cold Brew', '16oz Spanish Cold Brew Flavor Coffee', 'spanish-cold-brew', NULL, NULL, NULL, 'Spanish Cold Brew', '130.00', NULL, 1, NULL, 1),
(5, 7, 36, 'Iced Latte', '16oz Iced Latte Flavor Coffee', 'iced-latte', NULL, NULL, NULL, 'Iced Latte', '130.00', NULL, 1, NULL, 1),
(5, 7, 37, 'Iced Mocha', '16oz Iced Mocha Flavor Coffee', 'iced-mocha', NULL, NULL, NULL, 'Iced Mocha', '130.00', NULL, 1, NULL, 1),
(5, 7, 38, 'Iced Vanilla', '16oz Iced Vanilla Flavor Coffee', 'iced-vanilla', NULL, NULL, NULL, 'Iced Vanilla', '130.00', NULL, 1, NULL, 1),
(5, 7, 39, 'Iced Hazelnut', '16oz Iced Hazelnut Flavor Coffee', 'iced-hazelnut', NULL, NULL, NULL, 'Iced Hazelnut', '130.00', NULL, 1, NULL, 1),
(5, 7, 40, 'Iced Caramel', '16oz Iced Caramel Flavor Coffee', 'iced-caramel', NULL, NULL, NULL, 'Iced Caramel', '130.00', NULL, 1, NULL, 1),
(5, 9, 41, 'Vanilla', 'Vanilla Flavor Frappe', 'vanilla', NULL, NULL, NULL, 'Vanilla', '150.00', NULL, NULL, NULL, 2),
(5, 9, 42, 'Red Velvet', 'Red Velvel Flavor Frappe', 'red-velvet', NULL, NULL, NULL, 'Red Velvet', '150.00', NULL, NULL, NULL, 2),
(5, 9, 43, 'Java Chips', 'Java Chips Flavor Frappe', 'java-chips', NULL, NULL, NULL, 'Java Chips', '150.00', NULL, NULL, NULL, 2),
(5, 9, 44, 'Choco Fudge', 'Choco Fudge Flavor Frappe', 'choco-fudge', NULL, NULL, NULL, 'Choco Fudge', '150.00', NULL, NULL, NULL, 2),
(5, 9, 45, 'Oreo Delight', 'Oreo Delight Flavor Frappe', 'oreo-delight', NULL, NULL, NULL, 'Oreo Delight', '150.00', NULL, NULL, NULL, 2),
(5, 9, 46, 'Coffee Jelly', 'Coffee Jelly Flavor Frappe', 'coffee-jelly', NULL, NULL, NULL, 'Coffee Jelly', '150.00', NULL, NULL, NULL, 2),
(3, 3, 47, 'Pepperoni', 'Pepperoni Flavor Pizza', 'pepperoni', '634e976f3bd0b.jpg', NULL, NULL, 'Pepperoni', '199.00', NULL, NULL, NULL, 2),
(3, 3, 48, 'Beef and Mushroom', 'Beef and Mushroom Flavor Pizza', 'beef-and-mushroom', '634e979edaacd.jpg', NULL, NULL, 'Beef and Mushroom', '199.00', NULL, NULL, NULL, 2),
(3, 4, 49, 'Beef and Mushroom Overload', 'Beef and Mushroom Overload Flavor Pizza', 'beef-and-mushroom-overload', '634e97e35a212.jpg', NULL, NULL, 'Beef and Mushroom Overload', '249.00', NULL, NULL, NULL, 2),
(3, 4, 50, 'Pepperoni Overload', 'Pepperoni Overload Flavor Pizza', 'pepperoni-overload', '634e980a229bb.jpg', NULL, NULL, 'Pepperoni Overload', '249.00', NULL, NULL, NULL, 2),
(3, 4, 51, 'Creamcheese Supreme', 'Creamcheese Supreme Flavor Pizza', 'creamcheese-supreme', '634e984846c10.jpg', NULL, NULL, 'Creamcheese Supreme', '249.00', NULL, NULL, NULL, 2),
(3, 4, 52, 'Spinach Overload', 'Spinach Overload Flavor Pizza', 'spinach-overload', '634e98776df3e.jpg', NULL, NULL, 'Spinach Overload', '249.00', NULL, NULL, NULL, 2),
(3, 4, 53, 'All Meat Pizza', 'All Meat Flavor Pizza', 'all-meat-pizza', '634e989fd9020.jpg', NULL, NULL, 'All Meat Pizza', '249.00', NULL, NULL, NULL, 2),
(3, 4, 54, 'Beef and Bacon Overload', 'Beef and Bacon Overload Flavor Pizza', 'beef-and-bacon-overload', NULL, NULL, NULL, 'Beef and Bacon Overload', '249.00', NULL, NULL, NULL, 2),
(3, 4, 55, 'Bacon and Ham', 'Bacon and Ham Flavor Pizza', 'bacon-and-ham', '634e991363632.jpg', NULL, NULL, 'Bacon and Ham', '249.00', NULL, NULL, NULL, 2),
(3, 4, 56, 'Triple Cheese', 'Triple Cheese Flavor Pizza', 'triple-cheese', '634e9946caa48.jpg', NULL, NULL, 'Triple Cheese', '249.00', NULL, NULL, NULL, 2),
(6, 10, 57, 'Green Apple Jasmine', 'Green Apple Jasmine Flavor Fruit Tea', 'green-apple-jasmine', '634e99a91936f.png', NULL, NULL, 'Green Apple Jasmine', '80.00', NULL, NULL, NULL, 2),
(6, 10, 58, 'Blueberry Jasmine', 'Blueberry Jasmine Flavor Fruit Tea', 'blueberry-jasmine', '634e99dfb5f3e.png', NULL, NULL, 'Blueberry Jasmine', '80.00', NULL, NULL, NULL, 2),
(6, 10, 59, 'Mango Jasmine', 'Mango Jasmine Flavor Fruit Tea', 'mango-jasmine', '634e9a2a040ec.png', NULL, NULL, 'Mango Jasmine', '80.00', NULL, NULL, NULL, 2),
(6, 10, 60, 'Passionfruit Jasmine', 'Passionfruit Jasmine Flavor Fruit Tea', 'passionfruit-jasmine', '634e9a6886077.png', NULL, NULL, 'Passionfruit Jasmine', '80.00', NULL, NULL, NULL, 2),
(6, 11, 61, 'Strawberry Lemonade', 'Strawberry Flavor Lemonade', 'strawberry-lemonade', '634f48b120a0a.png', NULL, NULL, 'Strawberry Lemonade', '140.00', NULL, 1, NULL, 1),
(6, 11, 62, 'Passionfruit Lemonade', 'Passionfruit Flavor Lemonade', 'passionfruit-lemonade', '634f4930d469e.png', NULL, NULL, 'Passionfruit Lemonade', '140.00', NULL, 1, NULL, 1),
(6, 11, 63, 'Cucumber Lemonade', 'Cucumber Flavor Lemonade', 'cucumber-lemonade', '634f4951b37fd.png', NULL, NULL, 'Cucumber Lemonade', '140.00', NULL, 1, NULL, 1),
(6, 11, 64, 'Blueberry Lemonade', 'Blueberry Flavor Lemonade', 'blueberry-lemonade', '634f496c813d6.png', NULL, NULL, 'Blueberry Lemonade', '140.00', NULL, 1, NULL, 1),
(6, 11, 65, 'Green Apple Lemonade', 'Green Apple Flavor Lemonade', 'green-apple-lemonade', '634f498bb0482.png', NULL, NULL, 'Green Apple Lemonade', '140.00', NULL, 1, NULL, 1),
(6, 15, 66, 'Avocado Cheesecake', '22oz Avocado Flavor Cheesecake', 'avocado-cheesecake', '634f4a2f9c35a.png', NULL, NULL, 'Avocado Cheesecake', '159.00', NULL, 1, NULL, 1),
(6, 15, 67, 'Strawberry Cheesecake', '22oz Strawberry Flavor Cheesecake', 'strawberry-cheesecake', '634f4a8046efd.png', NULL, NULL, 'Strawberry Cheesecake', '159.00', NULL, 1, NULL, 1),
(6, 15, 68, 'Blueberry Cheesecake', '22oz Blueberry Flavor Cheesecake', 'blueberry-cheesecake', '634f4ab71a0f9.png', NULL, NULL, 'Blueberry Cheesecake', '159.00', NULL, 1, NULL, 1),
(6, 15, 69, 'Mango Cheesecake', '22oz Mango Flavor Cheesecake', 'mango-cheesecake', '634f4ad701e7d.png', NULL, NULL, 'Mango Cheesecake', '159.00', NULL, 1, NULL, 1),
(6, 15, 70, 'Vanilla Cheesecake', '22oz Vanilla Flavor Cheesecake', 'vanilla-cheesecake', '634f4b06b955b.png', NULL, NULL, 'Vanilla Cheesecake', '159.00', NULL, 1, NULL, 1),
(6, 16, 71, 'Strawberry Queen', 'Strawberry Queen Flavor Milkshake', 'strawberry-queen', '634f4b44ee16c.png', NULL, NULL, 'Strawberry Queen', '130.00', NULL, NULL, NULL, 2),
(6, 16, 72, 'Avocado Delight', 'Avocado Delight Flavor Milkshake', 'avocado-delight', '634f4ba22b685.png', NULL, NULL, 'Avocado Delight', '130.00', NULL, NULL, NULL, 2),
(6, 16, 73, 'Taro', 'Taro Flavor Milkshake', 'taro', '634f4bbf1f665.png', NULL, NULL, 'Taro', '130.00', NULL, NULL, NULL, 2),
(6, 16, 74, 'Matcha', 'Matcha Flavor Milkshake', 'matcha', '634f4c0749188.png', NULL, NULL, 'Matcha', '130.00', NULL, NULL, NULL, 2),
(6, 16, 75, 'Milo Dino', 'Milo Dino Flavor Milkshake', 'milo-dino', '634f4c358b466.png', NULL, NULL, 'Milo Dino', '130.00', NULL, NULL, NULL, 2),
(1, NULL, 76, 'Test', 'Test', 'test', NULL, NULL, NULL, 'Test', '90.00', NULL, NULL, NULL, 2);

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
(11, 333, 'Size'),
(12, 346, 'SIZE'),
(12, 347, 'ADDONS'),
(13, 348, 'SIZE'),
(13, 349, 'ADDONS'),
(14, 352, 'SIZE'),
(14, 353, 'ADDONS'),
(15, 356, 'SIZE'),
(15, 357, 'ADDONS'),
(16, 360, 'SIZE'),
(16, 361, 'ADDONS'),
(17, 364, 'SIZE'),
(17, 365, 'ADDONS'),
(18, 368, 'SIZE'),
(18, 369, 'ADDONS'),
(19, 372, 'SIZE'),
(19, 373, 'ADDONS'),
(20, 376, 'SIZE'),
(20, 377, 'ADDONS'),
(21, 380, 'SIZE'),
(21, 381, 'ADDONS'),
(22, 384, 'SIZE'),
(22, 385, 'ADDONS'),
(23, 388, 'SIZE'),
(23, 389, 'ADDONS'),
(24, 392, 'SIZE'),
(24, 393, 'ADDONS'),
(25, 396, 'SIZE'),
(25, 397, 'ADDONS'),
(26, 400, 'SIZE'),
(26, 401, 'ADDONS'),
(27, 404, 'Pieces'),
(28, 406, 'Pieces'),
(29, 408, 'Pieces'),
(6, 409, 'Pieces'),
(7, 410, 'Pieces'),
(41, 412, 'SIZE'),
(42, 414, 'SIZE'),
(43, 416, 'SIZE'),
(44, 418, 'SIZE'),
(45, 420, 'SIZE'),
(46, 422, 'SIZE'),
(47, 424, 'SIZE'),
(48, 426, 'SIZE'),
(49, 429, 'SIZE'),
(50, 431, 'SIZE'),
(51, 433, 'SIZE'),
(52, 435, 'SIZE'),
(53, 437, 'SIZE'),
(54, 439, 'SIZE'),
(55, 441, 'SIZE'),
(56, 444, 'SIZE'),
(59, 450, 'SIZE'),
(58, 451, 'SIZE'),
(57, 453, 'SIZE'),
(60, 455, 'SIZE'),
(71, 457, 'SIZE'),
(72, 460, 'SIZE'),
(73, 462, 'SIZE'),
(74, 464, 'SIZE'),
(75, 466, 'SIZE'),
(76, 468, 'SIZE');

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
(11, 333, 806, '16oz', '88.00', NULL, NULL, 1),
(11, 333, 807, '22oz', '99.00', NULL, NULL, 1),
(12, 346, 841, '16oz', '90.00', NULL, NULL, 1),
(12, 346, 842, '22oz', '105.00', NULL, NULL, 1),
(12, 347, 843, 'None', '0.00', NULL, NULL, 1),
(12, 347, 844, 'Pearl', '10.00', NULL, NULL, 1),
(12, 347, 845, 'Cofee Jelly', '15.00', NULL, NULL, 1),
(12, 347, 846, 'Nata', '15.00', NULL, NULL, 1),
(12, 347, 847, 'Cream Cheese', '25.00', NULL, NULL, 1),
(13, 348, 848, '16oz', '90.00', NULL, NULL, 1),
(13, 348, 849, '22oz', '105.00', NULL, NULL, 1),
(13, 349, 850, 'None', '0.00', NULL, NULL, 1),
(13, 349, 851, 'Pearl', '10.00', NULL, NULL, 1),
(13, 349, 852, 'Cofee Jelly', '15.00', NULL, NULL, 1),
(13, 349, 853, 'Nata', '15.00', NULL, NULL, 1),
(13, 349, 854, 'Cream Cheese', '25.00', NULL, NULL, 1),
(14, 352, 862, '16oz', '90.00', NULL, NULL, 1),
(14, 352, 863, '22oz', '105.00', NULL, NULL, 1),
(14, 353, 864, 'None', '0.00', NULL, NULL, 1),
(14, 353, 865, 'Pearl', '10.00', NULL, NULL, 1),
(14, 353, 866, 'Cofee Jelly', '15.00', NULL, NULL, 1),
(14, 353, 867, 'Nata', '15.00', NULL, NULL, 1),
(14, 353, 868, 'Cream Cheese', '25.00', NULL, NULL, 1),
(15, 356, 876, '16oz', '90.00', NULL, NULL, 1),
(15, 356, 877, '22oz', '105.00', NULL, NULL, 1),
(15, 357, 878, 'None', '0.00', NULL, NULL, 1),
(15, 357, 879, 'Pearl', '10.00', NULL, NULL, 1),
(15, 357, 880, 'Cofee Jelly', '15.00', NULL, NULL, 1),
(15, 357, 881, 'Nata', '15.00', NULL, NULL, 1),
(15, 357, 882, 'Cream Cheese', '25.00', NULL, NULL, 1),
(16, 360, 890, '16oz', '90.00', NULL, NULL, 1),
(16, 360, 891, '22oz', '105.00', NULL, NULL, 1),
(16, 361, 892, 'None', '0.00', NULL, NULL, 1),
(16, 361, 893, 'Pearl', '10.00', NULL, NULL, 1),
(16, 361, 894, 'Cofee Jelly', '15.00', NULL, NULL, 1),
(16, 361, 895, 'Nata', '15.00', NULL, NULL, 1),
(16, 361, 896, 'Cream Cheese', '25.00', NULL, NULL, 1),
(17, 364, 904, '16oz', '90.00', NULL, NULL, 1),
(17, 364, 905, '22oz', '105.00', NULL, NULL, 1),
(17, 365, 906, 'None', '0.00', NULL, NULL, 1),
(17, 365, 907, 'Pearl', '10.00', NULL, NULL, 1),
(17, 365, 908, 'Cofee Jelly', '15.00', NULL, NULL, 1),
(17, 365, 909, 'Nata', '15.00', NULL, NULL, 1),
(17, 365, 910, 'Cream Cheese', '25.00', NULL, NULL, 1),
(18, 368, 918, '16oz', '90.00', NULL, NULL, 1),
(18, 368, 919, '22oz', '105.00', NULL, NULL, 1),
(18, 369, 920, 'None', '0.00', NULL, NULL, 1),
(18, 369, 921, 'Pearl', '10.00', NULL, NULL, 1),
(18, 369, 922, 'Cofee Jelly', '15.00', NULL, NULL, 1),
(18, 369, 923, 'Nata', '15.00', NULL, NULL, 1),
(18, 369, 924, 'Cream Cheese', '25.00', NULL, NULL, 1),
(19, 372, 932, '16oz', '90.00', NULL, NULL, 1),
(19, 372, 933, '22oz', '105.00', NULL, NULL, 1),
(19, 373, 934, 'None', '0.00', NULL, NULL, 1),
(19, 373, 935, 'Pearl', '10.00', NULL, NULL, 1),
(19, 373, 936, 'Cofee Jelly', '15.00', NULL, NULL, 1),
(19, 373, 937, 'Nata', '15.00', NULL, NULL, 1),
(19, 373, 938, 'Cream Cheese', '25.00', NULL, NULL, 1),
(20, 376, 946, '16oz', '125.00', NULL, NULL, 1),
(20, 376, 947, '22oz', '135.00', NULL, NULL, 1),
(20, 377, 948, 'None', '0.00', NULL, NULL, 1),
(20, 377, 949, 'Pearl', '10.00', NULL, NULL, 1),
(20, 377, 950, 'Cofee Jelly', '15.00', NULL, NULL, 1),
(20, 377, 951, 'Nata', '15.00', NULL, NULL, 1),
(20, 377, 952, 'Cream Cheese', '25.00', NULL, NULL, 1),
(21, 380, 960, '16oz', '125.00', NULL, NULL, 1),
(21, 380, 961, '22oz', '135.00', NULL, NULL, 1),
(21, 381, 962, 'None', '0.00', NULL, NULL, 1),
(21, 381, 963, 'Pearl', '10.00', NULL, NULL, 1),
(21, 381, 964, 'Cofee Jelly', '15.00', NULL, NULL, 1),
(21, 381, 965, 'Nata', '15.00', NULL, NULL, 1),
(21, 381, 966, 'Cream Cheese', '25.00', NULL, NULL, 1),
(22, 384, 974, '16oz', '125.00', NULL, NULL, 1),
(22, 384, 975, '22oz', '135.00', NULL, NULL, 1),
(22, 385, 976, 'None', '0.00', NULL, NULL, 1),
(22, 385, 977, 'Pearl', '10.00', NULL, NULL, 1),
(22, 385, 978, 'Cofee Jelly', '15.00', NULL, NULL, 1),
(22, 385, 979, 'Nata', '15.00', NULL, NULL, 1),
(22, 385, 980, 'Cream Cheese', '25.00', NULL, NULL, 1),
(23, 388, 988, '16oz', '125.00', NULL, NULL, 1),
(23, 388, 989, '22oz', '135.00', NULL, NULL, 1),
(23, 389, 990, 'None', '0.00', NULL, NULL, 1),
(23, 389, 991, 'Pearl', '10.00', NULL, NULL, 1),
(23, 389, 992, 'Cofee Jelly', '15.00', NULL, NULL, 1),
(23, 389, 993, 'Nata', '15.00', NULL, NULL, 1),
(23, 389, 994, 'Cream Cheese', '25.00', NULL, NULL, 1),
(24, 392, 1002, '16oz', '125.00', NULL, NULL, 1),
(24, 392, 1003, '22oz', '135.00', NULL, NULL, 1),
(24, 393, 1004, 'None', '0.00', NULL, NULL, 1),
(24, 393, 1005, 'Pearl', '10.00', NULL, NULL, 1),
(24, 393, 1006, 'Cofee Jelly', '15.00', NULL, NULL, 1),
(24, 393, 1007, 'Nata', '15.00', NULL, NULL, 1),
(24, 393, 1008, 'Cream Cheese', '25.00', NULL, NULL, 1),
(25, 396, 1016, '16oz', '125.00', NULL, NULL, 1),
(25, 396, 1017, '22oz', '135.00', NULL, NULL, 1),
(25, 397, 1018, 'None', '0.00', NULL, NULL, 1),
(25, 397, 1019, 'Pearl', '10.00', NULL, NULL, 1),
(25, 397, 1020, 'Cofee Jelly', '15.00', NULL, NULL, 1),
(25, 397, 1021, 'Nata', '15.00', NULL, NULL, 1),
(25, 397, 1022, 'Cream Cheese', '25.00', NULL, NULL, 1),
(26, 400, 1030, '16oz', '125.00', NULL, NULL, 1),
(26, 400, 1031, '22oz', '135.00', NULL, NULL, 1),
(26, 401, 1032, 'None', '0.00', NULL, NULL, 1),
(26, 401, 1033, 'Pearl', '10.00', NULL, NULL, 1),
(26, 401, 1034, 'Cofee Jelly', '15.00', NULL, NULL, 1),
(26, 401, 1035, 'Nata', '15.00', NULL, NULL, 1),
(26, 401, 1036, 'Cream Cheese', '25.00', NULL, NULL, 1),
(27, 404, 1045, 'Solo 1 - 4pcs', '129.00', NULL, NULL, 1),
(27, 404, 1046, 'Solo 2 - 6pcs', '199.00', NULL, NULL, 1),
(27, 404, 1047, 'Sharing - 8pcs', '229.00', NULL, NULL, 1),
(27, 404, 1048, 'Barkada Bundle - 24pcs', '619.00', NULL, NULL, 1),
(28, 406, 1053, 'Solo 1 - 4pcs', '129.00', NULL, NULL, 1),
(28, 406, 1054, 'Solo 2 - 6pcs', '199.00', NULL, NULL, 1),
(28, 406, 1055, 'Sharing - 8pcs', '229.00', NULL, NULL, 1),
(28, 406, 1056, 'Barkada Bundle - 24pcs', '619.00', NULL, NULL, 1),
(29, 408, 1061, 'Solo 1 - 4pcs', '129.00', NULL, NULL, 1),
(29, 408, 1062, 'Solo 2 - 6pcs', '199.00', NULL, NULL, 1),
(29, 408, 1063, 'Sharing - 8pcs', '229.00', NULL, NULL, 1),
(29, 408, 1064, 'Barkada Bundle - 24pcs', '619.00', NULL, NULL, 1),
(6, 409, 1065, 'Solo 1 - 4pcs', '139.00', NULL, NULL, 1),
(6, 409, 1066, 'Solo 2 - 6pcs', '219.00', NULL, NULL, 1),
(6, 409, 1067, 'Sharing - 8pcs', '249.00', NULL, NULL, 1),
(6, 409, 1068, 'Barkada Bundle - 24pcs', '679.00', NULL, NULL, 1),
(7, 410, 1069, 'Solo 1 - 4pcs', '139.00', NULL, NULL, 1),
(7, 410, 1070, 'Solo 2 - 6pcs', '219.00', NULL, NULL, 1),
(7, 410, 1071, 'Sharing - 8pcs', '249.00', NULL, NULL, 1),
(7, 410, 1072, 'Barkada Bundle - 24pcs', '679.00', NULL, NULL, 1),
(41, 412, 1075, '16oz', '150.00', NULL, NULL, 1),
(41, 412, 1076, '22oz', '165.00', NULL, NULL, 1),
(42, 414, 1079, '16oz', '150.00', NULL, NULL, 1),
(42, 414, 1080, '22oz', '165.00', NULL, NULL, 1),
(43, 416, 1083, '16oz', '150.00', NULL, NULL, 1),
(43, 416, 1084, '22oz', '165.00', NULL, NULL, 1),
(44, 418, 1087, '16oz', '150.00', NULL, NULL, 1),
(44, 418, 1088, '22oz', '165.00', NULL, NULL, 1),
(45, 420, 1091, '16oz', '150.00', NULL, NULL, 1),
(45, 420, 1092, '22oz', '165.00', NULL, NULL, 1),
(46, 422, 1095, '16oz', '150.00', NULL, NULL, 1),
(46, 422, 1096, '22oz', '165.00', NULL, NULL, 1),
(47, 424, 1099, '10 inch', '199.00', NULL, NULL, 1),
(47, 424, 1100, '12 inch', '249.00', NULL, NULL, 1),
(48, 426, 1103, '10 inch', '199.00', NULL, NULL, 1),
(48, 426, 1104, '12 inch', '249.00', NULL, NULL, 1),
(49, 429, 1109, '10 inch', '249.00', NULL, NULL, 1),
(49, 429, 1110, '12 inch', '289.00', NULL, NULL, 1),
(50, 431, 1113, '10 inch', '249.00', NULL, NULL, 1),
(50, 431, 1114, '12 inch', '289.00', NULL, NULL, 1),
(51, 433, 1117, '10 inch', '249.00', NULL, NULL, 1),
(51, 433, 1118, '12 inch', '289.00', NULL, NULL, 1),
(52, 435, 1121, '10 inch', '249.00', NULL, NULL, 1),
(52, 435, 1122, '12 inch', '289.00', NULL, NULL, 1),
(53, 437, 1125, '10 inch', '249.00', NULL, NULL, 1),
(53, 437, 1126, '12 inch', '289.00', NULL, NULL, 1),
(54, 439, 1129, '10 inch', '249.00', NULL, NULL, 1),
(54, 439, 1130, '12 inch', '289.00', NULL, NULL, 1),
(55, 441, 1133, '10 inch', '249.00', NULL, NULL, 1),
(55, 441, 1134, '12 inch', '289.00', NULL, NULL, 1),
(56, 444, 1139, '10 inch', '249.00', NULL, NULL, 1),
(56, 444, 1140, '12 inch', '289.00', NULL, NULL, 1),
(59, 450, 1151, '16oz', '80.00', NULL, NULL, 1),
(59, 450, 1152, '22oz', '90.00', NULL, NULL, 1),
(58, 451, 1153, '16oz', '80.00', NULL, NULL, 1),
(58, 451, 1154, '22oz', '90.00', NULL, NULL, 1),
(57, 453, 1157, '16oz', '80.00', NULL, NULL, 1),
(57, 453, 1158, '22oz', '90.00', NULL, NULL, 1),
(60, 455, 1161, '16oz', '80.00', NULL, NULL, 1),
(60, 455, 1162, '22oz', '90.00', NULL, NULL, 1),
(71, 457, 1165, '16oz', '130.00', NULL, NULL, 1),
(71, 457, 1166, '22oz', '145.00', NULL, NULL, 1),
(72, 460, 1171, '16oz', '130.00', NULL, NULL, 1),
(72, 460, 1172, '22oz', '145.00', NULL, NULL, 1),
(73, 462, 1175, '16oz', '130.00', NULL, NULL, 1),
(73, 462, 1176, '22oz', '145.00', NULL, NULL, 1),
(74, 464, 1179, '16oz', '130.00', NULL, NULL, 1),
(74, 464, 1180, '22oz', '145.00', NULL, NULL, 1),
(75, 466, 1183, '16oz', '130.00', NULL, NULL, 1),
(75, 466, 1184, '22oz', '145.00', NULL, NULL, 1),
(76, 468, 1187, '16oz', '90.00', NULL, NULL, 1),
(76, 468, 1188, '22oz', '150.00', NULL, NULL, 1);

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
(6, 11, 'Lemonade'),
(6, 15, 'Cheesecake Series'),
(6, 16, 'Milkshake');

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
-- Indexes for table `open_hours`
--
ALTER TABLE `open_hours`
  ADD PRIMARY KEY (`day_id`);

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
  ADD KEY `order_id` (`order_id`),
  ADD KEY `category_id` (`category_id`);

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
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `chatbot`
--
ALTER TABLE `chatbot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `open_hours`
--
ALTER TABLE `open_hours`
  MODIFY `day_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_address`
--
ALTER TABLE `order_address`
  MODIFY `order_address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

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
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `product_attribute`
--
ALTER TABLE `product_attribute`
  MODIFY `attribute_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=469;

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
  MODIFY `variation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1189;

--
-- AUTO_INCREMENT for table `stock_status`
--
ALTER TABLE `stock_status`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `subcategory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
