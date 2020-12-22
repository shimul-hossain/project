-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2020 at 07:01 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `productlist`
--

-- --------------------------------------------------------

--
-- Table structure for table `catagory`
--

CREATE TABLE `catagory` (
  `catagory_id` int(11) NOT NULL,
  `catagory_name` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `catagory`
--

INSERT INTO `catagory` (`catagory_id`, `catagory_name`) VALUES
(1, 'Samsung'),
(2, 'Sony'),
(3, 'Nokia'),
(4, 'Xiaomi');

-- --------------------------------------------------------

--
-- Table structure for table `failed_login`
--

CREATE TABLE `failed_login` (
  `ip_address` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `failed_login`
--

INSERT INTO `failed_login` (`ip_address`, `date`) VALUES
('::1', '2020-12-21 22:00:10');

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `user_id` int(3) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` (`user_id`, `user_name`, `user_email`, `user_password`) VALUES
(1, 'Shimul Hossain', 'sbshimul000@gmail.com', '$2y$10$MDgvKhCh7LQCPTfkW16BTuzUeG6Fr4E3QjedF09NjOvx.e7LIpUmO'),
(2, 'Shimul Hossain', '01738836990', '$2y$10$H8mw4zUBcPrXJNCTLmCpOunYSBL2Xm5LTy4aJcXeo1GVp.E6.v8gG'),
(3, 'Shimul Hossain', 'mahadi@gmail.com', '$2y$10$HG8EU9Wxj.CuZ6cIt23OGeq7bmG.zfX64BRXy5DDzZm8YSDhJXale'),
(4, 'Shimul Hossain', '0173883699033', '$2y$10$ZIHsocGEKfRq1WQgWc/B2eOepOSDPM.kl1p1hoqJ4OAYxQIGPLpmW'),
(5, 'Shimul Hossain', 'imran@gmail.com', '$2y$10$HLJCwCa.5.wOdQGLxrM/y.SBXh8U4dxsrsIXM8VvPiL01XI/EYtiy'),
(6, 'Shimul Hossain', 'sujan222@gmail.com', '$2y$10$Y6eQl/WugL8xC2KRdbWo/.4Z9La7/LZgfMq0f9z/FTlAK5p2w7dq.'),
(7, 'Shimul Hossain', 'sbshimul000@gmail.com66', '$2y$10$TVpMVrLtB9HP62nR3T22X.2Sr7eNizNRuIlkaNGMnT8Xf4cKmhElu'),
(8, 'Shimul Hossain', 'sbshimuyyl000@gmail.com', '$2y$10$.mFI4RL09zKn/Hv6f5v5nu1QI/ZkFFrr58psuj.26KiystvoMWe42');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(3) NOT NULL,
  `p_description` varchar(200) NOT NULL,
  `product_price` int(100) NOT NULL,
  `product_img` varchar(20) NOT NULL,
  `catagory_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `p_description`, `product_price`, `product_img`, `catagory_id`) VALUES
(65, 'M01s', 43423, '246268.jpg', 1),
(66, 'Nokia-1.3', 999, '537064.jpg', 3),
(67, 'K30i-5G', 1000, '180345.jpg', 4),
(69, 'Sony-10 Plus', 9999, '742400.jpg', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
