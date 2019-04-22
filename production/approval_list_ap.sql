-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2019 at 04:44 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cba`
--

-- --------------------------------------------------------

--
-- Table structure for table `approval_list_ap`
--

CREATE TABLE `approval_list_ap` (
  `creation_date` date DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_update_by` varchar(255) DEFAULT NULL,
  `last_update_date` date DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `pr_number` int(20) NOT NULL,
  `po_number` int(20) NOT NULL,
  `ap_approval_id` int(20) NOT NULL,
  `status` varchar(255) NOT NULL,
  `delete_approval_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `approval_list_ap`
--

INSERT INTO `approval_list_ap` (`creation_date`, `created_by`, `last_update_by`, `last_update_date`, `file_name`, `pr_number`, `po_number`, `ap_approval_id`, `status`, `delete_approval_date`) VALUES
('2019-04-15', '6', '6', '2019-04-15', 'Invoice SS.jpg', 1800604, 1802006, 1, 'DELETED', '2019-04-15'),
('2019-04-15', '6', '6', '2019-04-15', 'Payment SS2.jpg', 1800930, 1801361, 2, 'DELETED', '2019-04-15'),
('2019-04-15', '8', '6', '2019-04-15', '49046.jpg', 1800680, 1900026, 3, 'DELETED', '2019-04-15'),
('2019-04-15', '6', '6', '2019-04-15', '49046.jpg', 1800604, 1802006, 4, 'DELETED', '2019-04-15'),
('2019-04-15', '6', '6', '2019-04-15', 'Foto Lucu Banci Dan Bencong In Action3.jpg', 1800817, 1801181, 5, 'DELETED', '2019-04-15'),
('2019-04-15', '6', '6', '2019-04-15', '49046.jpg', 1800817, 1801181, 6, 'P', '0000-00-00'),
('2019-04-15', '6', '6', '2019-04-15', 'Foto Lucu Banci Dan Bencong In Action3.jpg', 1800604, 1802006, 7, 'P', '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approval_list_ap`
--
ALTER TABLE `approval_list_ap`
  ADD PRIMARY KEY (`ap_approval_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approval_list_ap`
--
ALTER TABLE `approval_list_ap`
  MODIFY `ap_approval_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
