-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 14, 2018 at 01:53 AM
-- Server version: 8.0.13
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auction_db1`
--

-- --------------------------------------------------------

--
-- Table structure for table `auctions`
--

CREATE TABLE `auctions` (
  `auction_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `current_offer` double DEFAULT NULL,
  `bidder_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auctions`
--

INSERT INTO `auctions` (`auction_id`, `item_id`, `current_offer`, `bidder_id`) VALUES
(1, 3, 50, 1),
(2, 6, 20, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(45) NOT NULL,
  `item_keywords` varchar(60) NOT NULL,
  `item_short_description` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `item_description` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `auction_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'if the item is an of type auction then item will contain the forignkey to the auction',
  `starting_price` double NOT NULL COMMENT 'this will either be the starting price of the item or the fixed price for a standard sale\\n',
  `delivery_cost` double NOT NULL,
  `date_listed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seller_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item_name`, `item_keywords`, `item_short_description`, `item_description`, `auction_id`, `starting_price`, `delivery_cost`, `seller_id`) VALUES
(1, 'sony tablet', 'tablet, android, testAll', 'crappy short text', 'Iam just typing some random shit as im not even arsed pasting in lorm ipsum.', 0, 10000000, 0, 1),
(2, 'sony tablet', 'tablet, android, testAll', 'crappy short description', 'Iam just typing some random shit as im not even arsed pasting in lorm ipsum.', 0, 10000000, 0, 2),
(3, 'iphone', 'mobile phone, Iphone, smart Phone, touchscreen, testAll', 'crappy short description', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sagittis dignissim consectetur. Mauris erat orci, scelerisque in pretium quis, elementum quis nisl. Curabitur at nibh sed felis volutpat luctus. Maecenas cursus venenatis nunc id dignissim. Ut vel ligula et turpis rhoncus gravida. Donec vel felis pellentesque, pellentesque neque vitae, pulvinar sapien. Praesent et purus at ex tincidunt blandit sed eu mauris. Vestibulum vulputate urna lectus, quis ornare tortor vulputate at. In ullamcorper malesuada hendrerit. Quisque lobortis erat non justo tempor volutpat. In hac habitasse platea dictumst. Fusce id viverra dui. Aliquam eu eros viverra, sollicitudin nisl sed, dictum felis. Aenean auctor eu purus a posuere. Nam ullamcorper diam ultricies cursus feugiat. Fusce posuere maximus nulla, sed vulputate velit consectetur ac.', 1, 32, 0, 1),
(4, 'smart tv', 'tv, android, testAll, smart tv', 'this is a smart tv, like new', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dignissim sem non metus malesuada interdum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean et velit a neque placerat pretium ut nec mauris. Mauris vitae purus cursus, laoreet lacus at, vehicula arcu. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Phasellus molestie iaculis magna sit amet lobortis. Etiam lacinia sit amet eros a gravida. Nunc tristique scelerisque elementum. Aenean vitae quam nec augue dapibus semper. Sed gravida mauris varius, pharetra metus vitae, imperdiet orci. In posuere semper condimentum. Etiam feugiat risus tempus mauris pulvinar, cursus sodales felis convallis. Cras sed lorem interdum, ultricies justo vel, malesuada sem. Pellentesque enim lectus, rutrum quis gravida quis, gravida et massa. Duis felis est, cursus ut nibh et, ullamcorper cursus massa', 0, 1234, 0, 1),
(5, '20\" monitor', 'monitor, pc, testAll', 'pc monitor what more do you want', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dignissim sem non metus malesuada interdum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean et velit a neque placerat pretium ut nec mauris. Mauris vitae purus cursus, laoreet lacus at, vehicula arcu. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Phasellus molestie iaculis magna sit amet lobortis. Etiam lacinia sit amet eros a gravida. Nunc tristique scelerisque elementum. Aenean vitae quam nec augue dapibus semper. Sed gravida mauris varius, pharetra metus vitae, imperdiet orci. In posuere semper condimentum. Etiam feugiat risus tempus mauris pulvinar, cursus sodales felis convallis. Cras sed lorem interdum, ultricies justo vel, malesuada sem. Pellentesque enim lectus, rutrum quis gravida quis, gravida et massa. Duis felis est, cursus ut nibh et, ullamcorper cursus massa', 0, 423, 0, 1),
(6, 'test', 'insert test', 'test', 'queryTest', 0, 20, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_images`
--

CREATE TABLE `item_images` (
  `item_images_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `image_name` varchar(40) NOT NULL,
  `image_url` varchar(60) NOT NULL,
  `item_image_num` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_images`
--

INSERT INTO `item_images` (`item_images_id`, `item_id`, `image_name`, `image_url`, `item_image_num`) VALUES
(3, 3, 'no image', '1.jpg', 1),
(4, 1, 'no image', '1.jpg', 1),
(5, 1, 'test', '1.jpg', 1),
(6, 2, 'test', '1.jpg', 1),
(7, 3, 'test', '1.jpg', 1),
(8, 4, 'test', '1.jpg', 1),
(9, 5, 'test', '1.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_sounds`
--

CREATE TABLE `item_sounds` (
  `item_sounds_id` int(11) NOT NULL,
  `item_name_sounds` varchar(45) NOT NULL,
  `keyword_sounds` varchar(45) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_sounds`
--

INSERT INTO `item_sounds` (`item_sounds_id`, `item_name_sounds`, `keyword_sounds`, `item_id`) VALUES
(1, 'sony', 'sony', 1),
(2, 'sony', 'sony', 1),
(3, 'iphonesound', 'iphonesound', 3),
(4, 'test', 'test', 4);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(6) NOT NULL,
  `txnid` varchar(20) NOT NULL,
  `payment_amount` decimal(7,2) NOT NULL,
  `payment_status` varchar(25) NOT NULL,
  `itemid` varchar(25) NOT NULL,
  `createdtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sold_items`
--

CREATE TABLE `sold_items` (
  `sold_item_id` int(11) NOT NULL,
  `item_name` varchar(45) NOT NULL,
  `item_keywords` varchar(60) NOT NULL,
  `item_short_description` varchar(100) NOT NULL,
  `item_description` varchar(400) NOT NULL,
  `delivery_cost` double NOT NULL,
  `price` double DEFAULT NULL,
  `Seller_id` int(11) DEFAULT NULL,
  `Buyer_id` int(11) NOT NULL,
  `date_purchased` date DEFAULT NULL,
  `date_listed` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `second_name` varchar(45) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `user_password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email_address` varchar(45) DEFAULT NULL,
  `home_address` varchar(45) DEFAULT NULL,
  `phone_number` int(11) NOT NULL,
  `post_code` varchar(10) NOT NULL,
  `user_rating` int(11) NOT NULL DEFAULT '0' COMMENT 'this is a rating of the over character of the user, if the user buys an item and makes a false claim they get a negative rating and if that user sells a dodgy item buyer can give a bad rating'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `second_name`, `username`, `user_password`, `email_address`, `home_address`, `phone_number`, `post_code`, `user_rating`) VALUES
(1, 'Hassan', 'Al', 'anyname', '', 'anyEmail@willdo.com', '123 easy street', 0, '', 0),
(2, 'random', 'seller', 'xXxRandom_SellerxXx', 'itsRandom', 'random@randy.com', '62 randy street,', 908765, 'rn 32d', 0),
(4, 'Dixie', 'Normous', 'DN', 'anypasswilldo', 'dixie.Normous@wtf.com', 'wheres yours', 866969696, 'cr33py', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_rating`
--

CREATE TABLE `user_rating` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rater_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comments` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_rating`
--

INSERT INTO `user_rating` (`rating_id`, `user_id`, `rater_id`, `rating`, `comments`) VALUES
(1, 2, 1, 1, '1 star, wrecks the head'),
(2, 2, 1, 1, '1 star, wrecks the head'),
(3, 2, 1, 3, 'sold me dodgy coke');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auctions`
--
ALTER TABLE `auctions`
  ADD PRIMARY KEY (`auction_id`),
  ADD KEY `bidder_id_idx` (`bidder_id`),
  ADD KEY `item_id_idx` (`item_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `item_id_UNIQUE` (`item_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `item_images`
--
ALTER TABLE `item_images`
  ADD PRIMARY KEY (`item_images_id`);

--
-- Indexes for table `item_sounds`
--
ALTER TABLE `item_sounds`
  ADD PRIMARY KEY (`item_sounds_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sold_items`
--
ALTER TABLE `sold_items`
  ADD PRIMARY KEY (`sold_item_id`),
  ADD KEY `user_id_idx` (`Seller_id`),
  ADD KEY `Buyer_id` (`Buyer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `email_address_UNIQUE` (`email_address`);

--
-- Indexes for table `user_rating`
--
ALTER TABLE `user_rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `thePersonRating` (`rater_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auctions`
--
ALTER TABLE `auctions`
  MODIFY `auction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `item_images`
--
ALTER TABLE `item_images`
  MODIFY `item_images_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `item_sounds`
--
ALTER TABLE `item_sounds`
  MODIFY `item_sounds_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sold_items`
--
ALTER TABLE `sold_items`
  MODIFY `sold_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_rating`
--
ALTER TABLE `user_rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auctions`
--
ALTER TABLE `auctions`
  ADD CONSTRAINT `bidder_id` FOREIGN KEY (`bidder_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `item_id` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`);

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `item_sounds`
--
ALTER TABLE `item_sounds`
  ADD CONSTRAINT `item_sounds_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`);

--
-- Constraints for table `sold_items`
--
ALTER TABLE `sold_items`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`Seller_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_rating`
--
ALTER TABLE `user_rating`
  ADD CONSTRAINT `thePersonBeingRated` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `thePersonRating` FOREIGN KEY (`rater_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
