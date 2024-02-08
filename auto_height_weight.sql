-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2023 at 07:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auto_height_weight`
--

-- --------------------------------------------------------

--
-- Table structure for table `esp8266`
--

CREATE TABLE `esp8266` (
  `id` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `RT_ID` int(11) NOT NULL,
  `status_finger` int(10) NOT NULL,
  `del_or_add` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `esp8266`
--

INSERT INTO `esp8266` (`id`, `weight`, `height`, `status`, `RT_ID`, `status_finger`, `del_or_add`) VALUES
(1, 65, 170, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `prename` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `bdo` date NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `age` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `body` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `prename`, `name`, `bdo`, `time_stamp`, `age`, `weight`, `height`, `body`) VALUES
(1, 'นาย', 'ธีรภัทร แสวงดี', '2023-12-06', '2023-12-12 17:04:00', 25, 65, 170, 'น้ำหนักปกติ'),
(2, 'นาย', 'ธีรภัทร แสวงดี', '2023-12-06', '2023-12-12 17:20:02', 25, 65, 170, 'น้ำหนักปกติ'),
(3, 'นาย', 'ธีรภัทร แสวงดี', '2023-11-30', '2023-12-12 17:22:53', 25, 65, 170, 'น้ำหนักปกติ'),
(4, 'นาย', 'ธีรภัทร แสวงดี', '2023-11-26', '2023-12-12 17:37:16', 25, 65, 170, 'น้ำหนักปกติ'),
(5, 'นาย', 'ธีรภัทร แสวงดี', '2023-12-07', '2023-12-12 17:38:00', 25, 65, 170, 'น้ำหนักปกติ'),
(6, 'นางสาว', 'ธีรภัทร แสวงดี', '2023-12-15', '2023-12-12 17:41:12', 25, 65, 170, 'น้ำหนักปกติ'),
(7, 'นางสาว', 'ธีรภัทร แสวงดี', '2023-11-26', '2023-12-12 17:41:45', 25, 65, 170, 'น้ำหนักปกติ'),
(8, 'นาย', 'ธีรภัทร แสวงดี', '2023-12-22', '2023-12-12 17:59:11', 25, 65, 170, 'น้ำหนักปกติ'),
(9, 'นาย', 'ธีรภัทร แสวงดี', '2023-11-26', '2023-12-12 18:00:17', 25, 65, 170, 'น้ำหนักปกติ'),
(10, 'นาย', 'ธีรภัทร แสวงดี', '2023-12-23', '2023-12-12 18:01:01', 25, 65, 170, 'น้ำหนักปกติ'),
(11, 'นาย', 'ธีรภัทร แสวงดี', '2023-11-30', '2023-12-12 18:01:39', 25, 65, 170, 'น้ำหนักปกติ'),
(12, 'นาย', 'ธีรภัทร แสวงดี', '2023-12-07', '2023-12-12 18:04:56', 25, 65, 170, 'น้ำหนักปกติ'),
(13, 'นาย', 'ธีรภัทร แสวงดี', '2023-12-08', '2023-12-12 18:05:58', 25, 65, 170, 'น้ำหนักปกติ'),
(14, 'นาย', 'ผสุดี ทวีเลิศ', '2023-12-09', '2023-12-12 18:06:37', 25, 65, 170, 'น้ำหนักปกติ');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `tech_id` int(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`tech_id`, `username`, `password`, `fname`, `lname`) VALUES
(1, 'teerapat', '12345678', 'ธีรภัทร ', 'แสวงดี');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esp8266`
--
ALTER TABLE `esp8266`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`tech_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esp8266`
--
ALTER TABLE `esp8266`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `tech_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
