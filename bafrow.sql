-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2025 at 05:30 PM
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
-- Database: `bafrow`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment_table`
--

CREATE TABLE `appointment_table` (
  `appointment_id` int(11) NOT NULL,
  `staff_id` varchar(50) DEFAULT NULL,
  `availabletimes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`availabletimes`)),
  `unavailabletimes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`unavailabletimes`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_table`
--

CREATE TABLE `booking_table` (
  `booking_id` int(11) NOT NULL,
  `patient_id` varchar(50) DEFAULT NULL,
  `staff_id` varchar(50) DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `appointment_type` varchar(100) DEFAULT NULL,
  `clinic_id` int(11) DEFAULT NULL,
  `status` enum('Scheduled','Completed','Cancelled') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_table`
--

CREATE TABLE `clinic_table` (
  `clinic_id` int(11) NOT NULL,
  `clinic_name` varchar(50) NOT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic_table`
--

INSERT INTO `clinic_table` (`clinic_id`, `clinic_name`, `department_id`) VALUES
(935953, 'hahajhs', 756545);

-- --------------------------------------------------------

--
-- Table structure for table `department_table`
--

CREATE TABLE `department_table` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_table`
--

INSERT INTO `department_table` (`department_id`, `department_name`) VALUES
(756545, 'Computer science');

-- --------------------------------------------------------

--
-- Table structure for table `lab_table`
--

CREATE TABLE `lab_table` (
  `lab_id` int(11) NOT NULL,
  `patient_id` varchar(50) DEFAULT NULL,
  `staff_id` varchar(50) DEFAULT NULL,
  `testtype` text DEFAULT NULL,
  `status` enum('Pending','Completed','Cancelled') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_table`
--

CREATE TABLE `patient_table` (
  `patient_id` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `DOB` date NOT NULL,
  `Gender` varchar(8) NOT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `nextofkinname` varchar(100) DEFAULT NULL,
  `nextofkincontact` varchar(20) DEFAULT NULL,
  `nextofkingender` enum('Male','Female','Other') DEFAULT NULL,
  `nextofkinrelationship` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_table`
--

INSERT INTO `patient_table` (`patient_id`, `first_name`, `last_name`, `DOB`, `Gender`, `weight`, `address`, `contact`, `nextofkinname`, `nextofkincontact`, `nextofkingender`, `nextofkinrelationship`) VALUES
('88888888', 'Fatou', 'Waggeh', '2025-04-03', 'Male', 89.00, 'hgkjd', '0551718945', 'kwaku', '0551718945', 'Male', 'brother'),
('967589', 'Kwame', 'emerole', '2025-04-03', 'Male', 50.00, 'Bort 36', '0551718945', 'kwaku', '0551718945', 'Female', 'brother');

-- --------------------------------------------------------

--
-- Table structure for table `prescription_table`
--

CREATE TABLE `prescription_table` (
  `prescription_id` int(11) NOT NULL,
  `patient_id` varchar(50) DEFAULT NULL,
  `staff_id` varchar(50) DEFAULT NULL,
  `medication` text DEFAULT NULL,
  `dosage` text DEFAULT NULL,
  `status` enum('Pending','Dispensed','Cancelled') DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receipt_table`
--

CREATE TABLE `receipt_table` (
  `receipt_id` int(11) NOT NULL,
  `patient_id` varchar(50) DEFAULT NULL,
  `lab_id` int(11) DEFAULT NULL,
  `prescription_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` enum('Paid','Unpaid') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_table`
--

CREATE TABLE `staff_table` (
  `staff_id` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `Gender` varchar(8) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_table`
--

INSERT INTO `staff_table` (`staff_id`, `first_name`, `last_name`, `Gender`, `department_id`, `phone`, `email`, `position`) VALUES
('238983009', 'Fatou', 'Waggeh', 'Female', 756545, '0551718945', 'ktprodu@ashesi.edu.gh', 'Staff'),
('62374', 'Kwame', 'Waggeh', 'Female', NULL, '0551718945', 'mntawiah@gmail.com', 'Staff'),
('62374434', 'Kwame', 'emerole', 'Female', 756545, '0551718945', 'mntawiah@gmail.com', 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `telemedicine_table`
--

CREATE TABLE `telemedicine_table` (
  `user_id` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `zoom_role` text DEFAULT NULL,
  `meeting_id` text DEFAULT NULL,
  `host_id` text DEFAULT NULL,
  `topic` text DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `join_url` text DEFAULT NULL,
  `password` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `password`, `role`) VALUES
('238983009', '$2y$10$o6EDE7J18uvRUKTrh3kzReFGi1eW0UFZCC7c7XTm5xQZFDpaGdBQ6', 'staff'),
('62374', '$2y$10$dmwwQvujqkrSyb46BLgXAOi9FHRxPbozXFkcUV8F9glnysfhwPyL2', 'staff'),
('62374434', '$2y$10$tH3AMK4whtrQ.Y7h7/RuYO1yYeSXIwSNjoWfcbcrUcqNhei1aKcRy', 'staff'),
('88888888', '$2y$10$3oqfAKngFH/6i3eyGoEtv.kMNGb4BDpSrei2pdaVatBzI.ajj3LFi', 'Patient'),
('967589', '$2y$10$GUxoAMk6H38nY53ycKjP4.91uqueHBUP4WUBxe4BJOqLk2jJCBxRm', 'Patient');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment_table`
--
ALTER TABLE `appointment_table`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `booking_table`
--
ALTER TABLE `booking_table`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `clinic_id` (`clinic_id`);

--
-- Indexes for table `clinic_table`
--
ALTER TABLE `clinic_table`
  ADD PRIMARY KEY (`clinic_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `department_table`
--
ALTER TABLE `department_table`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `lab_table`
--
ALTER TABLE `lab_table`
  ADD PRIMARY KEY (`lab_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `patient_table`
--
ALTER TABLE `patient_table`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `prescription_table`
--
ALTER TABLE `prescription_table`
  ADD PRIMARY KEY (`prescription_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `receipt_table`
--
ALTER TABLE `receipt_table`
  ADD PRIMARY KEY (`receipt_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `lab_id` (`lab_id`),
  ADD KEY `prescription_id` (`prescription_id`);

--
-- Indexes for table `staff_table`
--
ALTER TABLE `staff_table`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `telemedicine_table`
--
ALTER TABLE `telemedicine_table`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment_table`
--
ALTER TABLE `appointment_table`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_table`
--
ALTER TABLE `booking_table`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clinic_table`
--
ALTER TABLE `clinic_table`
  MODIFY `clinic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7584938;

--
-- AUTO_INCREMENT for table `department_table`
--
ALTER TABLE `department_table`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=756546;

--
-- AUTO_INCREMENT for table `lab_table`
--
ALTER TABLE `lab_table`
  MODIFY `lab_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescription_table`
--
ALTER TABLE `prescription_table`
  MODIFY `prescription_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `receipt_table`
--
ALTER TABLE `receipt_table`
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment_table`
--
ALTER TABLE `appointment_table`
  ADD CONSTRAINT `appointment_table_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff_table` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `booking_table`
--
ALTER TABLE `booking_table`
  ADD CONSTRAINT `booking_table_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient_table` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_table_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff_table` (`staff_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_table_ibfk_3` FOREIGN KEY (`clinic_id`) REFERENCES `clinic_table` (`clinic_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `clinic_table`
--
ALTER TABLE `clinic_table`
  ADD CONSTRAINT `clinic_table_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department_table` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lab_table`
--
ALTER TABLE `lab_table`
  ADD CONSTRAINT `lab_table_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient_table` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lab_table_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff_table` (`staff_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `patient_table`
--
ALTER TABLE `patient_table`
  ADD CONSTRAINT `patient_table_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `user_table` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prescription_table`
--
ALTER TABLE `prescription_table`
  ADD CONSTRAINT `prescription_table_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient_table` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prescription_table_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff_table` (`staff_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `receipt_table`
--
ALTER TABLE `receipt_table`
  ADD CONSTRAINT `receipt_table_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient_table` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `receipt_table_ibfk_2` FOREIGN KEY (`lab_id`) REFERENCES `lab_table` (`lab_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `receipt_table_ibfk_3` FOREIGN KEY (`prescription_id`) REFERENCES `prescription_table` (`prescription_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `staff_table`
--
ALTER TABLE `staff_table`
  ADD CONSTRAINT `staff_table_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department_table` (`department_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_table_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `user_table` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `telemedicine_table`
--
ALTER TABLE `telemedicine_table`
  ADD CONSTRAINT `telemedicine_table_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
