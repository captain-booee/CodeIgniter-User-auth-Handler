-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2020 at 10:02 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `small_business`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(55) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(300) NOT NULL,
  `wallet_address` text NOT NULL,
  `parent_user_id` int(55) NOT NULL,
  `win_amount` int(5) NOT NULL,
  `small_token` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT 0,
  `hash` varchar(100) NOT NULL,
  `blocked` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_ips`
--

CREATE TABLE `user_ips` (
  `id` int(11) NOT NULL,
  `user_id` int(55) NOT NULL,
  `user_ip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`,`ip_address`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_ips`
--
ALTER TABLE `user_ips`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(55) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_ips`
--
ALTER TABLE `user_ips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;