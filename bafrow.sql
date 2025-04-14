-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 10:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
  `appointment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_table`
--

INSERT INTO `appointment_table` (`appointment_id`, `staff_id`, `appointment_date`) VALUES
(1, '623744348888', '2025-04-16'),
(2, '623744348888', '2025-04-15'),
(3, '623744348888', '2025-04-17');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_timeslots`
--

CREATE TABLE `appointment_timeslots` (
  `timeslot_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `time_slot` time NOT NULL,
  `status` enum('Available','Booked') DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_timeslots`
--

INSERT INTO `appointment_timeslots` (`timeslot_id`, `appointment_id`, `time_slot`, `status`) VALUES
(1, 1, '07:00:00', 'Available'),
(2, 1, '09:00:00', 'Booked'),
(3, 1, '12:00:00', 'Available'),
(4, 1, '15:00:00', 'Available'),
(5, 2, '07:00:00', 'Available'),
(6, 2, '08:00:00', 'Available'),
(7, 2, '09:00:00', 'Booked'),
(8, 2, '10:00:00', 'Available'),
(9, 3, '07:00:00', 'Available'),
(10, 3, '12:00:00', 'Available'),
(11, 3, '13:00:00', 'Available'),
(12, 3, '14:00:00', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `booking_table`
--

CREATE TABLE `booking_table` (
  `booking_id` int(11) NOT NULL,
  `patient_id` varchar(50) NOT NULL,
  `timeslot_id` int(11) NOT NULL,
  `appointment_type` varchar(100) NOT NULL,
  `clinic_id` int(11) NOT NULL,
  `status` enum('Scheduled','Completed','Cancelled') DEFAULT 'Scheduled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_table`
--

INSERT INTO `booking_table` (`booking_id`, `patient_id`, `timeslot_id`, `appointment_type`, `clinic_id`, `status`) VALUES
(6, '88888888', 7, 'Virtual', 9345678, 'Completed'),
(7, '88888888', 2, 'In-Person', 935953, 'Scheduled');

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
(935953, 'hahajhsjkjldsdad', 756545),
(9345678, 'Postnatal', 756545),
(12345654, 'sgjsrntrs rt', 756545),
(2147483647, 'gfdggdfh', 88567);

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
(88567, 'ivfjkggdfgsdf'),
(756545, 'Computer scienc');

-- --------------------------------------------------------

--
-- Table structure for table `lab_table`
--

CREATE TABLE `lab_table` (
  `lab_id` int(11) NOT NULL,
  `patient_id` varchar(50) DEFAULT NULL,
  `staff_id` varchar(50) DEFAULT NULL,
  `suspected_diagnosis` varchar(255) DEFAULT NULL,
  `signature` varchar(100) DEFAULT NULL,
  `extension` varchar(20) DEFAULT NULL,
  `request_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_table`
--

INSERT INTO `lab_table` (`lab_id`, `patient_id`, `staff_id`, `suspected_diagnosis`, `signature`, `extension`, `request_date`) VALUES
(8, '88888888', '238983009', 'malaria', 'Kwame', 'hmm', '2025-04-04'),
(9, '88888888', '238983009', 'malaria', 'Kwame', 'hmm', '2025-04-03');

-- --------------------------------------------------------

--
-- Table structure for table `lab_test_table`
--

CREATE TABLE `lab_test_table` (
  `lab_test_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `test_type_id` int(11) NOT NULL,
  `result` text DEFAULT NULL,
  `result_status` enum('Pending','Completed','Abnormal') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_test_table`
--

INSERT INTO `lab_test_table` (`lab_test_id`, `lab_id`, `test_type_id`, `result`, `result_status`) VALUES
(26, 8, 6, NULL, 'Pending'),
(27, 8, 8, NULL, 'Pending'),
(28, 8, 9, NULL, 'Pending'),
(29, 9, 1, NULL, 'Pending'),
(30, 9, 2, NULL, 'Pending'),
(31, 9, 3, NULL, 'Pending');

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
('12345678', 'Fat', 'dairy', '2003-05-05', 'Male', 34.00, 'hgkjd', '0551718945', 'kwaku', '0551718945', 'Male', 'brother'),
('88888888', 'Fatou', 'Waggeh', '2025-04-03', 'Male', 89.00, 'hgkjd', '0551718945', 'kwaku', '0551718945', 'Male', 'brother'),
('967589', 'Kwame', 'emerole', '2025-04-03', 'Male', 50.00, 'Bort 36', '0551718945', 'kwaku', '0551718945', 'Female', 'brother');

-- --------------------------------------------------------

--
-- Table structure for table `prescription_medication_table`
--

CREATE TABLE `prescription_medication_table` (
  `medication_id` int(11) NOT NULL,
  `prescription_id` int(11) NOT NULL,
  `medication` text NOT NULL,
  `dosage` varchar(100) NOT NULL,
  `instructions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescription_medication_table`
--

INSERT INTO `prescription_medication_table` (`medication_id`, `prescription_id`, `medication`, `dosage`, `instructions`) VALUES
(8, 5, 'hmm ', '500mg', 'jhbjkb'),
(9, 5, 'kjsidu', '5000', 'hbjlk ');

-- --------------------------------------------------------

--
-- Table structure for table `prescription_table`
--

CREATE TABLE `prescription_table` (
  `prescription_id` int(11) NOT NULL,
  `patient_id` varchar(50) DEFAULT NULL,
  `staff_id` varchar(50) DEFAULT NULL,
  `medication_date` date NOT NULL,
  `status` enum('Pending','Dispensed','Cancelled') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescription_table`
--

INSERT INTO `prescription_table` (`prescription_id`, `patient_id`, `staff_id`, `medication_date`, `status`) VALUES
(5, '967589', '238983009', '2025-04-04', 'Pending');

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
('62374434', 'Kwame', 'emerole', 'Female', 756545, '0551718945', 'mntawiah@gmail.com', 'Staff'),
('623744348888', 'Kay', 'emerole', 'Male', 88567, '0551718945', 'ktproductions124@ashesi.edu.gh', 'Doctor');

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
-- Table structure for table `test_type_table`
--

CREATE TABLE `test_type_table` (
  `test_type_id` int(11) NOT NULL,
  `test_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_type_table`
--

INSERT INTO `test_type_table` (`test_type_id`, `test_name`, `description`) VALUES
(1, 'Haemoglobin', NULL),
(2, 'Full Blood Count & DIFF', NULL),
(3, 'Blood Film', NULL),
(4, 'Blood group', NULL),
(5, 'Retics', NULL),
(6, 'Sickle test', NULL),
(7, 'Hb genotype', NULL),
(8, 'PT', NULL),
(9, 'aPTT', NULL),
(10, 'INR', NULL);

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
('12345678', '$2y$10$lddjxVm7VReYtJgsVS6GSeDYtzES.qOAiSOACuH3AH.nn9lcmS2/.', 'Patient'),
('238983009', '$2y$10$o6EDE7J18uvRUKTrh3kzReFGi1eW0UFZCC7c7XTm5xQZFDpaGdBQ6', 'staff'),
('62374', '$2y$10$dmwwQvujqkrSyb46BLgXAOi9FHRxPbozXFkcUV8F9glnysfhwPyL2', 'staff'),
('62374434', '$2y$10$tH3AMK4whtrQ.Y7h7/RuYO1yYeSXIwSNjoWfcbcrUcqNhei1aKcRy', 'staff'),
('623744348888', '$2y$10$OHXlwKATE/RdaGXcZ7O2qORpQq34b99Cf1vI8K4Iaqt8acvSbjlpC', 'Doctor'),
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
-- Indexes for table `appointment_timeslots`
--
ALTER TABLE `appointment_timeslots`
  ADD PRIMARY KEY (`timeslot_id`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `booking_table`
--
ALTER TABLE `booking_table`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `timeslot_id` (`timeslot_id`),
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
-- Indexes for table `lab_test_table`
--
ALTER TABLE `lab_test_table`
  ADD PRIMARY KEY (`lab_test_id`),
  ADD KEY `lab_id` (`lab_id`),
  ADD KEY `test_type_id` (`test_type_id`);

--
-- Indexes for table `patient_table`
--
ALTER TABLE `patient_table`
  ADD PRIMARY KEY (`patient_id`),
  ADD KEY `idx_patient_name` (`first_name`,`last_name`);

--
-- Indexes for table `prescription_medication_table`
--
ALTER TABLE `prescription_medication_table`
  ADD PRIMARY KEY (`medication_id`),
  ADD KEY `prescription_id` (`prescription_id`);

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
  ADD KEY `department_id` (`department_id`),
  ADD KEY `idx_staff_name` (`first_name`,`last_name`);

--
-- Indexes for table `telemedicine_table`
--
ALTER TABLE `telemedicine_table`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `test_type_table`
--
ALTER TABLE `test_type_table`
  ADD PRIMARY KEY (`test_type_id`),
  ADD UNIQUE KEY `test_name` (`test_name`);

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
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `appointment_timeslots`
--
ALTER TABLE `appointment_timeslots`
  MODIFY `timeslot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `booking_table`
--
ALTER TABLE `booking_table`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `clinic_table`
--
ALTER TABLE `clinic_table`
  MODIFY `clinic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

--
-- AUTO_INCREMENT for table `department_table`
--
ALTER TABLE `department_table`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=756546;

--
-- AUTO_INCREMENT for table `lab_table`
--
ALTER TABLE `lab_table`
  MODIFY `lab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lab_test_table`
--
ALTER TABLE `lab_test_table`
  MODIFY `lab_test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `prescription_medication_table`
--
ALTER TABLE `prescription_medication_table`
  MODIFY `medication_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `prescription_table`
--
ALTER TABLE `prescription_table`
  MODIFY `prescription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `receipt_table`
--
ALTER TABLE `receipt_table`
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_type_table`
--
ALTER TABLE `test_type_table`
  MODIFY `test_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment_table`
--
ALTER TABLE `appointment_table`
  ADD CONSTRAINT `appointment_table_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff_table` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `appointment_timeslots`
--
ALTER TABLE `appointment_timeslots`
  ADD CONSTRAINT `appointment_timeslots_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointment_table` (`appointment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `booking_table`
--
ALTER TABLE `booking_table`
  ADD CONSTRAINT `booking_table_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient_table` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_table_ibfk_2` FOREIGN KEY (`timeslot_id`) REFERENCES `appointment_timeslots` (`timeslot_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_table_ibfk_3` FOREIGN KEY (`clinic_id`) REFERENCES `clinic_table` (`clinic_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `lab_table_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff_table` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lab_test_table`
--
ALTER TABLE `lab_test_table`
  ADD CONSTRAINT `lab_test_table_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `lab_table` (`lab_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lab_test_table_ibfk_2` FOREIGN KEY (`test_type_id`) REFERENCES `test_type_table` (`test_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patient_table`
--
ALTER TABLE `patient_table`
  ADD CONSTRAINT `patient_table_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `user_table` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prescription_medication_table`
--
ALTER TABLE `prescription_medication_table`
  ADD CONSTRAINT `prescription_medication_table_ibfk_1` FOREIGN KEY (`prescription_id`) REFERENCES `prescription_table` (`prescription_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prescription_table`
--
ALTER TABLE `prescription_table`
  ADD CONSTRAINT `prescription_table_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient_table` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prescription_table_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff_table` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `receipt_table`
--
ALTER TABLE `receipt_table`
  ADD CONSTRAINT `receipt_table_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient_table` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `receipt_table_ibfk_2` FOREIGN KEY (`lab_id`) REFERENCES `lab_table` (`lab_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `receipt_table_ibfk_3` FOREIGN KEY (`prescription_id`) REFERENCES `prescription_table` (`prescription_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff_table`
--
ALTER TABLE `staff_table`
  ADD CONSTRAINT `staff_table_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department_table` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
