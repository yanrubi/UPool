-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2017 at 01:15 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `upooldb`
--

-- --------------------------------------------------------

--
-- Table structure for table `carpooltable`
--

CREATE TABLE `carpooltable` (
  `carpoolid` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `start` varchar(95) DEFAULT NULL,
  `destination` varchar(95) DEFAULT NULL,
  `date` varchar(10) DEFAULT NULL,
  `starttime` varchar(10) DEFAULT NULL,
  `arrivaltime` varchar(10) DEFAULT NULL,
  `repeatweekly` int(11) DEFAULT NULL,
  `seats` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `passengertable`
--

CREATE TABLE `passengertable` (
  `carpoolid` int(11) DEFAULT NULL,
  `passengeruserid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

CREATE TABLE `usertable` (
  `userid` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `firstname` varchar(25) DEFAULT NULL,
  `lastname` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`userid`, `email`, `password`, `firstname`, `lastname`) VALUES
(1, 'bob@cs', 'wasd', 'bob', 'adams'),
(2, 'john@cs', 'wasd', 'john', 'smith'),
(3, 'tom@cs', 'wasd', 'tom', 'miller');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carpooltable`
--
ALTER TABLE `carpooltable`
  ADD PRIMARY KEY (`carpoolid`);

--
-- Indexes for table `usertable`
--
ALTER TABLE `usertable`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carpooltable`
--
ALTER TABLE `carpooltable`
  MODIFY `carpoolid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usertable`
--
ALTER TABLE `usertable`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
