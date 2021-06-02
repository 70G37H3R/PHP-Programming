-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2021 at 06:43 PM
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
-- Database: `php_hospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` int(11) NOT NULL,
  `admin_email_address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `admin_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `admin_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `admin_email_address`, `admin_password`, `admin_name`) VALUES
(1, 'johnsmith@gmail.com', 'password', 'John smith');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_table`
--

CREATE TABLE `appointment_table` (
  `appointment_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_schedule_id` int(11) NOT NULL,
  `appointment_number` int(11) NOT NULL,
  `reason_for_appointment` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `appointment_time` time NOT NULL,
  `status` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `patient_come_into_hospital` enum('No','Yes') COLLATE utf8_unicode_ci NOT NULL,
  `doctor_comment` mediumtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `appointment_table`
--

INSERT INTO `appointment_table` (`appointment_id`, `doctor_id`, `patient_id`, `doctor_schedule_id`, `appointment_number`, `reason_for_appointment`, `appointment_time`, `status`, `patient_come_into_hospital`, `doctor_comment`) VALUES
(3, 1, 3, 2, 1000, 'Pain in Stomach', '09:00:00', 'Completed', 'Yes', 'okala'),
(4, 1, 3, 2, 1001, 'Paint in stomach', '09:00:00', 'Completed', 'Yes', 'ok'),
(5, 1, 4, 2, 1002, 'For Delivery', '09:30:00', 'Cancel', 'No', 'ok'),
(6, 5, 3, 7, 1003, 'Fever and cold.', '18:00:00', 'Cancel', 'No', 'asdasds'),
(7, 6, 5, 13, 1004, 'Pain in Stomach.', '15:30:00', 'Booked', 'Yes', 'Acidity Problem. '),
(8, 5, 4, 9, 1005, 'dsadsd', '11:00:00', 'In Process', 'Yes', ''),
(9, 6, 4, 17, 1006, 'Dau bung', '00:55:00', 'Completed', 'Yes', 'Ok');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_schedule_table`
--

CREATE TABLE `doctor_schedule_table` (
  `doctor_schedule_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `doctor_schedule_date` date NOT NULL,
  `doctor_schedule_day` enum('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') COLLATE utf8_unicode_ci NOT NULL,
  `doctor_schedule_start_time` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_schedule_end_time` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `average_consulting_time` int(5) NOT NULL,
  `doctor_schedule_status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctor_schedule_table`
--

INSERT INTO `doctor_schedule_table` (`doctor_schedule_id`, `doctor_id`, `doctor_schedule_date`, `doctor_schedule_day`, `doctor_schedule_start_time`, `doctor_schedule_end_time`, `average_consulting_time`, `doctor_schedule_status`) VALUES
(2, 1, '2021-02-19', 'Friday', '09:00', '14:00', 15, 'Active'),
(3, 2, '2021-02-19', 'Friday', '09:00', '12:00', 15, 'Active'),
(4, 5, '2021-02-19', 'Friday', '10:00', '14:00', 10, 'Active'),
(5, 3, '2021-02-19', 'Friday', '13:00', '17:00', 20, 'Active'),
(6, 4, '2021-02-19', 'Friday', '15:00', '18:00', 5, 'Active'),
(7, 5, '2021-02-22', 'Monday', '18:00', '20:00', 10, 'Active'),
(8, 2, '2021-02-24', 'Wednesday', '09:30', '12:30', 10, 'Active'),
(9, 5, '2021-05-13', 'Wednesday', '11:00', '15:00', 55, 'Active'),
(10, 1, '2021-02-24', 'Wednesday', '12:00', '15:00', 10, 'Active'),
(16, 1, '2021-05-26', 'Wednesday', '03:16', '03:17', 55, 'Active'),
(17, 6, '2021-06-03', 'Thursday', '00:55', '13:55', 45, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_table`
--

CREATE TABLE `doctor_table` (
  `doctor_id` int(11) NOT NULL,
  `doctor_email_address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_profile_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_phone_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_address` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `doctor_date_of_birth` date NOT NULL,
  `doctor_degree` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_expert_in` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL,
  `doctor_added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctor_table`
--

INSERT INTO `doctor_table` (`doctor_id`, `doctor_email_address`, `doctor_password`, `doctor_name`, `doctor_profile_image`, `doctor_phone_no`, `doctor_address`, `doctor_date_of_birth`, `doctor_degree`, `doctor_expert_in`, `doctor_status`, `doctor_added_on`) VALUES
(1, 'peterparker@gmail.com', 'password', 'Dr. Peter Parker', '../images/10872.jpg', '7539518520', '102, Sky View, NYC', '1985-10-29', 'CK I', 'Tim mạch', 'Active', '2021-02-15 17:04:59'),
(2, 'adambrodly@gmail.com', 'password', 'Dr. Adam Broudly', '../images/2012868744.jpg', '753852963', '105, Fort, NYC', '1982-08-10', 'CK I', 'Nhi', 'Active', '2021-02-18 15:00:32'),
(3, 'sophia.parker@gmail.com', 'password', 'Dr. Sophia Parker', '../images/1588265484.jpg', '7417417410', '50, Best street CA', '1989-04-03', 'CK II', 'Phục hồi chức năng', 'Active', '2021-02-18 15:05:02'),
(4, 'williampeterson@gmail.com', 'password', 'Dr. William Peterson', '../images/455471457.jpg', '8523698520', '32, Green City, NYC', '1984-06-11', 'CK II', 'Tai - Mũi - Họng', 'Active', '2021-02-18 15:08:24'),
(6, 'manuel.armstrong@gmail.com', 'password', 'Dr. Manuel Armstrong', '../images/277898927.jpg', '8523697410', '2378 Fire Access Road Asheboro, NC 27203', '1989-03-01', 'CK I', 'Da liễu', 'Active', '2021-02-23 17:26:16'),
(23, 'admin@gmail.com', 'asd', 'test', '../images/1173730417.jpg', '1231231312', '2378 Fire Access Road Asheboro, NC 27203', '2021-06-16', 'CK II', 'Răng - Hàm - Mặt', 'Active', '2021-06-02 16:05:50');

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `medicine_id` int(11) NOT NULL,
  `prescription_no` int(11) NOT NULL,
  `medicine_name` varchar(100) NOT NULL,
  `unit` int(11) NOT NULL,
  `dosage` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`medicine_id`, `prescription_no`, `medicine_name`, `unit`, `dosage`) VALUES
(1, 1000, 'alaba', 3, '2 viên - 3 lần - 1 ngày'),
(2, 1000, 'messi', 2, '3 viên - 2 lần - 1 ngày'),
(3, 1001, 'panada', 333, '2 viên - 2 lần - 1 ngày'),
(4, 1002, 'alaba', 67, '2 viên - 2 lần - 1 ngày'),
(5, 1002, 'banana', 11, '3 viên - 3 lần - 1 ngày');

-- --------------------------------------------------------

--
-- Table structure for table `patient_table`
--

CREATE TABLE `patient_table` (
  `patient_id` int(11) NOT NULL,
  `patient_email_address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `patient_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `patient_first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `patient_last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `patient_date_of_birth` date NOT NULL,
  `patient_gender` enum('Nam','Nữ','Khác') COLLATE utf8_unicode_ci NOT NULL,
  `patient_address` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `patient_phone_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `patient_height` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `patient_added_on` datetime NOT NULL,
  `patient_weight` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `patient_blood` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `patient_status` enum('Inactive','Active') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `patient_table`
--

INSERT INTO `patient_table` (`patient_id`, `patient_email_address`, `patient_password`, `patient_first_name`, `patient_last_name`, `patient_date_of_birth`, `patient_gender`, `patient_address`, `patient_phone_no`, `patient_height`, `patient_added_on`, `patient_weight`, `patient_blood`, `patient_status`) VALUES
(3, 'jacobmartin@gmail.com', 'password', 'Jacob', 'Martin', '2021-02-26', '', 'Green view, 1025, NYC city', '85745635210', '1m5', '2021-02-18 16:34:55', '51', 'B', 'Active'),
(4, 'oliviabaker@gmail.com', 'password', 'Olivia', 'Baker', '2021-05-12', 'Nam', 'Diamond street, 115, NYC', '7539518520', '1m6', '2021-02-19 18:28:23', '55', 'B', 'Active'),
(5, 'web-tutorial@programmer.net', 'password', 'Amber', 'Anderson', '1995-07-25', 'Nam', '2083 Cameron Road Buffalo, NY 14202', '75394511442', '1m7', '2021-02-23 17:50:06', '55', 'AB+', 'Active'),
(9, 'trong@gmail.com', 'password', 'Quoc', 'Trong', '2021-04-07', 'Nam', 'Ô Môn', '2125798366', '1m75', '2021-04-22 23:17:32', '53', 'C', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `prescription_id` int(11) NOT NULL,
  `prescription_no` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `prescription_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`prescription_id`, `prescription_no`, `doctor_id`, `patient_id`, `prescription_date`) VALUES
(1, 1000, 1, 4, '2021-06-25'),
(2, 1001, 1, 5, '2021-06-02'),
(3, 1002, 1, 4, '2021-06-02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `appointment_table`
--
ALTER TABLE `appointment_table`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `doctor_schedule_table`
--
ALTER TABLE `doctor_schedule_table`
  ADD PRIMARY KEY (`doctor_schedule_id`);

--
-- Indexes for table `doctor_table`
--
ALTER TABLE `doctor_table`
  ADD PRIMARY KEY (`doctor_id`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `patient_table`
--
ALTER TABLE `patient_table`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`prescription_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointment_table`
--
ALTER TABLE `appointment_table`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `doctor_schedule_table`
--
ALTER TABLE `doctor_schedule_table`
  MODIFY `doctor_schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `doctor_table`
--
ALTER TABLE `doctor_table`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patient_table`
--
ALTER TABLE `patient_table`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `prescription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
