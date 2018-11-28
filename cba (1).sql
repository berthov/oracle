-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2018 at 08:55 AM
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
-- Table structure for table `ap_invoices_header`
--

CREATE TABLE `ap_invoices_header` (
  `INVOICE_ID` int(22) NOT NULL,
  `INVOICE_NUM` varchar(255) NOT NULL,
  `INVOICE_TYPE_LOOKUP_CODE` varchar(255) NOT NULL,
  `INVOICE_DATE` date NOT NULL,
  `VENDOR_NAME` varchar(255) NOT NULL,
  `VENDOR_SITE_CODE` varchar(255) NOT NULL,
  `INVOICE_AMOUNT` bigint(20) NOT NULL,
  `INVOICE_CURRENCY_CODE` varchar(255) NOT NULL,
  `TERMS_NAME` varchar(255) NOT NULL,
  `SOURCE` varchar(255) NOT NULL,
  `GOODS_RECEIVED_DATE` date NOT NULL,
  `INVOICE_RECEIVED_DATE` date NOT NULL,
  `GL_DATE` date NOT NULL,
  `ORG_ID` varchar(255) NOT NULL,
  `TERMS_DATE` date NOT NULL,
  `LAST_UPDATE_DATE` date NOT NULL,
  `LAST_UPDATED_BY` varchar(255) NOT NULL,
  `CREATION_DATE` date NOT NULL,
  `CREATED_BY` varchar(255) NOT NULL,
  `STATUS` varchar(1) NOT NULL,
  `APPROVAL_DATE` date NOT NULL,
  `COUNT_PRINT` int(11) NOT NULL,
  `LAST_PRINT_BY` varchar(255) DEFAULT NULL,
  `LAST_PRINT_DATE` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ap_invoices_header`
--

INSERT INTO `ap_invoices_header` (`INVOICE_ID`, `INVOICE_NUM`, `INVOICE_TYPE_LOOKUP_CODE`, `INVOICE_DATE`, `VENDOR_NAME`, `VENDOR_SITE_CODE`, `INVOICE_AMOUNT`, `INVOICE_CURRENCY_CODE`, `TERMS_NAME`, `SOURCE`, `GOODS_RECEIVED_DATE`, `INVOICE_RECEIVED_DATE`, `GL_DATE`, `ORG_ID`, `TERMS_DATE`, `LAST_UPDATE_DATE`, `LAST_UPDATED_BY`, `CREATION_DATE`, `CREATED_BY`, `STATUS`, `APPROVAL_DATE`, `COUNT_PRINT`, `LAST_PRINT_BY`, `LAST_PRINT_DATE`) VALUES
(114348, '123123', 'EXPENSE REPORT', '2018-11-22', 'CBA EMPLOYEE', 'ANGGA', 123, 'IDR', '5 HARI', 'SALESFORCE', '2018-11-22', '2018-11-22', '2018-11-22', '81', '2018-11-22', '2018-11-28', '2', '2018-11-22', '2', 'P', '2018-11-23', 5, '2', '2018-11-28'),
(114349, '123123123123123123', 'EXPENSE REPORT', '2018-11-23', 'CBA EMPLOYEE', 'ANDI SEDIO', 123, 'IDR', '5 HARI', 'WEB', '2018-11-23', '2018-11-23', '2018-11-23', '81', '2018-11-23', '2018-11-28', '2', '2018-11-23', '2', 'P', '2018-11-23', 1, '2', '2018-11-28'),
(114350, '1344444', 'EXPENSE REPORT', '2018-11-23', 'CBA EMPLOYEE', 'ABDUL ROSYID', 45678, 'IDR', '5 HARI', 'WEB', '2018-11-23', '2018-11-23', '2018-11-23', '81', '2018-11-23', '2018-11-23', '2', '2018-11-23', '2', 'P', '2018-11-23', 0, '', NULL),
(115301, '123123123', 'EXPENSE REPORT', '2018-11-28', 'CBA EMPLOYEE', 'BANGKA', 123, 'IDR', '5 HARI', 'WEB', '2018-11-28', '2018-11-28', '2018-11-28', '81', '2018-11-28', '2018-11-28', '2', '2018-11-28', '2', 'P', '0000-00-00', 0, '', NULL),
(115302, '23123123', 'EXPENSE REPORT', '2018-11-28', 'CBA EMPLOYEE', 'BANJAR BARU', 123, 'IDR', '5 HARI', 'WEB', '2018-11-28', '2018-11-28', '2018-11-28', '81', '2018-11-28', '2018-11-28', '2', '2018-11-28', '2', 'P', '0000-00-00', 0, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ap_invoices_line`
--

CREATE TABLE `ap_invoices_line` (
  `INVOICE_ID` int(22) NOT NULL,
  `LINE_NUMBER` int(22) NOT NULL,
  `LINE_TYPE_LOOKUP_CODE` varchar(255) NOT NULL,
  `AMOUNT` bigint(22) NOT NULL,
  `ACCOUNTING_DATE` date NOT NULL,
  `DESCRIPTION` varchar(255) NOT NULL,
  `DISTRIBUTION_SET_ID` int(22) NOT NULL,
  `CREATION_DATE` date NOT NULL,
  `CREATED_BY` varchar(255) NOT NULL,
  `LAST_UPDATE_DATE` date NOT NULL,
  `LAST_UPDATED_BY` varchar(255) NOT NULL,
  `INVOICE_LINE_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ap_invoices_line`
--

INSERT INTO `ap_invoices_line` (`INVOICE_ID`, `LINE_NUMBER`, `LINE_TYPE_LOOKUP_CODE`, `AMOUNT`, `ACCOUNTING_DATE`, `DESCRIPTION`, `DISTRIBUTION_SET_ID`, `CREATION_DATE`, `CREATED_BY`, `LAST_UPDATE_DATE`, `LAST_UPDATED_BY`, `INVOICE_LINE_ID`) VALUES
(114348, 1, 'ITEM', 123, '2018-11-22', 'Biaya Pendidikan & Pelatihan, Training Center', 11000, '2018-11-22', '1154', '2018-11-22', '1154', 1),
(114349, 1, 'ITEM', 123, '2018-11-23', 'Biaya Pendidikan & Pelatihan, Training Center', 11000, '2018-11-23', '1154', '2018-11-23', '1154', 2),
(114350, 1, 'ITEM', 45678, '2018-11-23', 'Biaya Pendidikan & Pelatihan, Training Center', 11000, '2018-11-23', '1154', '2018-11-23', '1154', 3),
(115301, 1, 'ITEM', 123, '2018-11-28', 'Biaya Lain-Lain , IT', 10805, '2018-11-28', '', '2018-11-28', '', 4),
(115302, 1, 'ITEM', 123, '2018-11-28', 'Biaya Lain-Lain , IT', 10805, '2018-11-28', '2', '2018-11-28', '2', 5);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `divisi` varchar(255) NOT NULL,
  `created_date` date NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `name`, `password`, `email`, `divisi`, `created_date`, `role`) VALUES
(2, 'asdasdasd', '7815696ecbf1c96e6894b779456d330e', 'asd@asd', '207', '2018-11-22', 'Staff'),
(3, 'ben', '7815696ecbf1c96e6894b779456d330e', 'asd@asdasd', '207', '2018-11-23', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ap_invoices_line`
--
ALTER TABLE `ap_invoices_line`
  ADD PRIMARY KEY (`INVOICE_LINE_ID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ap_invoices_line`
--
ALTER TABLE `ap_invoices_line`
  MODIFY `INVOICE_LINE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
