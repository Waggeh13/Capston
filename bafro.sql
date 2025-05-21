-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 27, 2025 at 10:18 PM
-- Server version: 8.0.41-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.21

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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contact` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `first_name`, `last_name`, `contact`, `role`) VALUES
('06798725', 'Assanatou', 'Kamaso', '3955102', 'Admin'),
('7890', 'emmaa', 'wright-gomez', '3934845', 'Admin'),
('bafoo1ad', 'fatou', 'waggeh', '3925639', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_table`
--

CREATE TABLE `appointment_table` (
  `appointment_id` int NOT NULL,
  `staff_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `appointment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_table`
--

INSERT INTO `appointment_table` (`appointment_id`, `staff_id`, `appointment_date`) VALUES
(8, '11567879', '2025-04-24'),
(9, '89546789', '2025-04-25'),
(11, '11567879', '2025-04-25');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_timeslots`
--

CREATE TABLE `appointment_timeslots` (
  `timeslot_id` int NOT NULL,
  `appointment_id` int NOT NULL,
  `time_slot` time NOT NULL,
  `status` enum('Available','Booked') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_timeslots`
--

INSERT INTO `appointment_timeslots` (`timeslot_id`, `appointment_id`, `time_slot`, `status`) VALUES
(4, 8, '07:00:00', 'Booked'),
(5, 8, '12:00:00', 'Available'),
(6, 8, '13:00:00', 'Booked'),
(7, 9, '11:00:00', 'Available'),
(8, 9, '12:00:00', 'Booked'),
(9, 9, '13:00:00', 'Booked'),
(10, 9, '14:00:00', 'Booked'),
(11, 9, '15:00:00', 'Booked'),
(12, 9, '16:00:00', 'Available'),
(14, 11, '11:00:00', 'Available'),
(15, 11, '13:00:00', 'Available'),
(16, 11, '14:00:00', 'Available'),
(17, 11, '16:00:00', 'Booked');

-- --------------------------------------------------------

--
-- Table structure for table `booking_table`
--

CREATE TABLE `booking_table` (
  `booking_id` int NOT NULL,
  `patient_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `timeslot_id` int NOT NULL,
  `appointment_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `clinic_id` int NOT NULL,
  `status` enum('Scheduled','Completed','Cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Scheduled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_table`
--

INSERT INTO `booking_table` (`booking_id`, `patient_id`, `timeslot_id`, `appointment_type`, `clinic_id`, `status`) VALUES
(3, '10850167', 11, 'In-Person', 1, 'Scheduled'),
(4, '10850167', 9, 'In-Person', 1, 'Scheduled'),
(5, '105801', 10, 'In-Person', 1, 'Completed'),
(6, '108613', 8, 'In-Person', 1, 'Cancelled'),
(7, '107991', 6, 'In-Person', 8, 'Scheduled'),
(8, '104881', 4, 'In-Person', 1, 'Scheduled'),
(9, '00214898', 17, 'In-Person', 8, 'Scheduled'),
(10, '00214898', 16, 'Virtual', 8, 'Cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `clinic_table`
--

CREATE TABLE `clinic_table` (
  `clinic_id` int NOT NULL,
  `clinic_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `department_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic_table`
--

INSERT INTO `clinic_table` (`clinic_id`, `clinic_name`, `department_id`) VALUES
(1, 'family medcine', 2),
(2, 'gynea', 2),
(3, 'obstetrics', 2),
(4, 'cardiology', 2),
(5, 'surgical', 8),
(6, 'Antenatal', 7),
(7, 'infant welfare', 2),
(8, 'paediatrics', 2);

-- --------------------------------------------------------

--
-- Table structure for table `department_table`
--

CREATE TABLE `department_table` (
  `department_id` int NOT NULL,
  `department_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_table`
--

INSERT INTO `department_table` (`department_id`, `department_name`) VALUES
(1, 'Admin'),
(2, 'Outpatient'),
(3, 'radiology'),
(4, 'pharmacy'),
(5, 'laboratory'),
(6, 'inpatient'),
(7, 'maternity'),
(8, 'surgical'),
(9, 'housekeeping');

-- --------------------------------------------------------

--
-- Table structure for table `dispensed_medication_table`
--

CREATE TABLE `dispensed_medication_table` (
  `dispensed_id` int NOT NULL,
  `medication_id` int NOT NULL,
  `prescription_id` int NOT NULL,
  `patient_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `quantity_dispensed` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Pending','Paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `dispensed_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `pharmacist_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dispensed_medication_table`
--

INSERT INTO `dispensed_medication_table` (`dispensed_id`, `medication_id`, `prescription_id`, `patient_id`, `quantity_dispensed`, `status`, `dispensed_date`, `pharmacist_id`) VALUES
(2, 2, 2, '104881', '12', 'Paid', '2025-04-23 23:55:59', '234567890');

-- --------------------------------------------------------

--
-- Table structure for table `lab_table`
--

CREATE TABLE `lab_table` (
  `lab_id` int NOT NULL,
  `patient_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `staff_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `suspected_diagnosis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `signature` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `extension` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `request_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_table`
--

INSERT INTO `lab_table` (`lab_id`, `patient_id`, `staff_id`, `suspected_diagnosis`, `signature`, `extension`, `request_date`) VALUES
(3, '104881', '11567879', 'malaria', 'Kwame', '1234', '2025-04-19'),
(4, '00214898', '11567879', 'malaria', 'Dr Singhateh', '', '2025-04-25');

-- --------------------------------------------------------

--
-- Table structure for table `lab_test_table`
--

CREATE TABLE `lab_test_table` (
  `lab_test_id` int NOT NULL,
  `lab_id` int NOT NULL,
  `test_type_id` int NOT NULL,
  `result` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `result_status` enum('Pending','Completed','Abnormal') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `specimen_received_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `specimen_date` date DEFAULT NULL,
  `specimen_time` time DEFAULT NULL,
  `sample_accepted` enum('YES','NO') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lab_tech_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lab_tech_signature` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lab_tech_date` date DEFAULT NULL,
  `supervisor_signature` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `supervisor_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_test_table`
--

INSERT INTO `lab_test_table` (`lab_test_id`, `lab_id`, `test_type_id`, `result`, `result_status`, `specimen_received_by`, `specimen_date`, `specimen_time`, `sample_accepted`, `lab_tech_id`, `lab_tech_signature`, `lab_tech_date`, `supervisor_signature`, `supervisor_date`) VALUES
(5, 3, 1, '134234', 'Completed', 'Kwame', '2025-04-23', '23:47:00', 'YES', '58603759', 'hmmm', '2025-04-23', 'yess', '2025-04-23'),
(6, 3, 6, '124', 'Completed', 'Kwame', '2025-04-23', '23:47:00', 'YES', '58603759', 'hmmm', '2025-04-23', 'yess', '2025-04-23'),
(7, 3, 8, '4576', 'Completed', 'Kwame', '2025-04-23', '23:47:00', 'YES', '58603759', 'hmmm', '2025-04-23', 'yess', '2025-04-23'),
(8, 4, 2, NULL, 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 4, 3, NULL, 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages_table`
--

CREATE TABLE `messages_table` (
  `id` int NOT NULL,
  `sender_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `receiver_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sent_at` datetime NOT NULL,
  `read_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages_table`
--

INSERT INTO `messages_table` (`id`, `sender_id`, `receiver_id`, `message`, `sent_at`, `read_at`) VALUES
(2, '10850167', '89546789', 'your head', '2025-04-23 21:34:09', NULL),
(3, '10850167', '89546789', 'ts aint tf, sybau', '2025-04-23 21:34:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_table`
--

CREATE TABLE `patient_table` (
  `patient_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `DOB` date NOT NULL,
  `Gender` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `contact` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nextofkinname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nextofkincontact` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nextofkingender` enum('Male','Female','Other') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nextofkinrelationship` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_table`
--

INSERT INTO `patient_table` (`patient_id`, `first_name`, `last_name`, `DOB`, `Gender`, `weight`, `address`, `contact`, `nextofkinname`, `nextofkincontact`, `nextofkingender`, `nextofkinrelationship`) VALUES
('00214898', 'Sally', 'Singhateh', '1978-02-03', 'Female', '85.00', 'Paradise Estate', '7003977', 'FATOU WAGGEH', '3944537', 'Female', 'SISTER'),
('03658', 'kator', 'wright', '1977-12-25', 'Female', '80.00', 'brusubi', '3934846', 'thomas', '9934846', 'Male', 'son'),
('104881', 'SANNA', 'JATTA', '2024-04-23', 'Male', '9.00', 'bakoteh', '7935387', 'Buba  Jatta', '7453665', 'Male', 'father'),
('105801', 'Fatoumata', 'Dampha', '2000-12-12', 'Female', '69.00', 'Fajikunda', '7614242', 'Fatoumatta Dibba', '3767405', 'Female', 'mother'),
('107991', 'Tuti', 'Bah', '1996-09-07', 'Female', '32.00', 'kotu', '3188232', 'fatou cham', '3026303', 'Female', 'mother'),
('108401', 'AISATOU BARRY', 'JALLOW', '1993-12-07', 'Female', '85.00', 'YARAMBAMBA', '2964488', 'SAFFIE JALLOW', '7416125', 'Female', 'mother'),
('10850167', 'Fatoumata', 'Sano', '2007-04-17', 'Female', '49.00', 'Busumbala', '7739550', 'Mariama Jawara', '7945509', 'Female', 'mother'),
('108599', 'Ismaila', 'Manneh', '1988-05-11', 'Male', '95.00', 'bakoteh', '2023007', 'Rohey Bangura', '3481839', 'Female', 'wife'),
('108613', 'Elizabeth', 'Jatta', '1974-08-15', 'Female', '70.00', 'Brusubi', '7298455', 'Rose Jatta', '2362005', 'Female', 'mother'),
('14561', 'mariama', 'kamara', '1986-08-26', 'Female', '91.00', 'bakoteh', '3710230', 'kebba bojang', '3944537', 'Male', 'husband'),
('24396', 'Ebrima', 'Badjie', '1984-10-02', 'Male', '90.00', 'kubuneh', '9800992', 'Rohey Gibba', '6907699', 'Female', 'wife'),
('25987', 'metta', 'jatta', '1968-06-26', 'Female', '75.00', 'brusubi', '9909959', 'faye', '3990399', 'Male', 'husband'),
('47342025', 'hassanatou', 'roberts', '2016-11-13', 'Female', '70.00', 'bijilo', '5860213', 'mamia', '3925639', 'Female', 'auntie'),
('84923789', 'SIRA SOWE', 'JANNEH', '1991-10-02', 'Female', '75.00', 'Bakau New Town', '2035127', 'Jarra Sambou', '7976565', 'Female', 'mother');

-- --------------------------------------------------------

--
-- Table structure for table `prescription_medication_table`
--

CREATE TABLE `prescription_medication_table` (
  `medication_id` int NOT NULL,
  `prescription_id` int NOT NULL,
  `medication` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dosage` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `instructions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescription_medication_table`
--

INSERT INTO `prescription_medication_table` (`medication_id`, `prescription_id`, `medication`, `dosage`, `instructions`) VALUES
(2, 2, 'Paracetamol', '500mg', '2 a day');

-- --------------------------------------------------------

--
-- Table structure for table `prescription_notifications`
--

CREATE TABLE `prescription_notifications` (
  `notification_id` int NOT NULL,
  `medication_id` int NOT NULL,
  `patient_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `enabled` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'No',
  `notification_time` time NOT NULL,
  `interval_hours` int DEFAULT NULL,
  `last_sent` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescription_table`
--

CREATE TABLE `prescription_table` (
  `prescription_id` int NOT NULL,
  `patient_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `staff_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `medication_date` date NOT NULL,
  `status` enum('Pending','Dispensed','Cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescription_table`
--

INSERT INTO `prescription_table` (`prescription_id`, `patient_id`, `staff_id`, `medication_date`, `status`) VALUES
(2, '104881', '11567879', '2025-04-23', 'Dispensed');

-- --------------------------------------------------------

--
-- Table structure for table `receipt_table`
--

CREATE TABLE `receipt_table` (
  `receipt_id` int NOT NULL,
  `patient_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lab_id` int DEFAULT NULL,
  `prescription_id` int DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` enum('Paid','Unpaid') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cashier_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipt_table`
--

INSERT INTO `receipt_table` (`receipt_id`, `patient_id`, `lab_id`, `prescription_id`, `total`, `status`, `cashier_id`) VALUES
(7, '104881', NULL, 2, '6.00', 'Paid', '34869705'),
(8, '104881', NULL, 2, '10.00', 'Paid', '34869705');

-- --------------------------------------------------------

--
-- Table structure for table `staff_table`
--

CREATE TABLE `staff_table` (
  `staff_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Gender` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `department_id` int DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_table`
--

INSERT INTO `staff_table` (`staff_id`, `first_name`, `last_name`, `Gender`, `department_id`, `phone`, `email`, `position`) VALUES
('11567879', 'olaa', 'olagbegu', 'Male', 2, '3511246', 'olagbegi@bafrow.org', 'doctor'),
('12', 'ad', 'adegboy', 'Male', 2, '3371383', 'adegboye@bafrow.org', 'doctor'),
('14', 'babatunde', 'mustapha', 'Male', 8, '6625639', 'mustapha@bafrow.org', 'doctor'),
('17', 'emmanuel', 'ayeyemi', 'Male', 2, '6655102', 'ayeyemi@bafrow.org', 'doctor'),
('178', 'olufem', 'olubiyi', 'Male', 2, '5066558', 'olubilyi@bafrow.gor', 'doctor'),
('234567890', 'yusuf', 'Manneh', 'Male', 4, '3495867', 'd@gmail.com', 'Pharmacist'),
('25689161', 'FEMI', 'SAMUEL', 'Male', 7, '7034332', 'femi@bafrow.org', 'GYNEA'),
('34869705', 'Mariam', 'Jobe', 'Female', 1, '3495867', 'f@gmail.com', 'Cashier'),
('45968705', 'joshua', 'ukandu', 'Female', 7, '3971911', 'ukandu@bafrow.org', 'doctor'),
('58603759', 'Alieu', 'Jeng', 'Male', 5, '3495867', 'd@gmail.com', 'Lab Technician'),
('89546789', 'ousman', 'Manneh', 'Male', 7, '3495867', 'lamin@gmail.com', 'doctor');

-- --------------------------------------------------------

--
-- Table structure for table `super_admin`
--

CREATE TABLE `super_admin` (
  `super_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `super_admin`
--

INSERT INTO `super_admin` (`super_id`, `role`) VALUES
('SAdmin124', 'SuperAdmin');

-- --------------------------------------------------------

--
-- Table structure for table `telemedicine_table`
--

CREATE TABLE `telemedicine_table` (
  `telemedicine_id` int NOT NULL,
  `booking_id` int NOT NULL,
  `patient_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `staff_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `meeting_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `join_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `topic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `duration` int NOT NULL,
  `status` enum('Scheduled','Completed','Cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Scheduled',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `telemedicine_table`
--

INSERT INTO `telemedicine_table` (`telemedicine_id`, `booking_id`, `patient_id`, `staff_id`, `meeting_id`, `join_url`, `password`, `topic`, `start_time`, `duration`, `status`, `notes`) VALUES
(2, 10, '00214898', '11567879', '84279581767', 'https://us05web.zoom.us/j/84279581767?pwd=RY6R62q7BI44QRagUVDg0f0apWXlla.1', 'gx9mdacl', 'Virtual Consultation with Patient 00214898', '2025-04-25 14:00:00', 30, 'Cancelled', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `test_type_table`
--

CREATE TABLE `test_type_table` (
  `test_type_id` int NOT NULL,
  `test_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
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
-- Table structure for table `token_table`
--

CREATE TABLE `token_table` (
  `token_id` int NOT NULL,
  `access_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `refresh_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `token_table`
--

INSERT INTO `token_table` (`token_id`, `access_token`, `refresh_token`, `expires_at`, `created_at`) VALUES
(1, 'eyJzdiI6IjAwMDAwMiIsImFsZyI6IkhTNTEyIiwidiI6IjIuMCIsImtpZCI6ImRkNWE5NmNmLTUxMDktNDkwZC1hNTk2LWIyN2NlYjM0ZDI2NiJ9.eyJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJKcFd1S25WQVRYQzYwMC13Y2pTZjVRIiwidmVyIjoxMCwiYXVpZCI6IjE4NDY1YjU0YzhmODNkZDFlZWUyMDhiMTc1M2E2NTQ1OTc2MzAxY2NmOTU1OTRiMTZhYjg3Y2JiMWViNDYzMzAiLCJuYmYiOjE3NDU0NDEyNDIsImNvZGUiOiI1WWcwRmFhQ25UTG1MVnhxaFlZVGh1MmZOb1BjOFNzd0EiLCJpc3MiOiJ6bTpjaWQ6Sld4Tkpfc2lUczZXS1RCWlo5SUZ3IiwiZ25vIjowLCJleHAiOjE3NDU0NDQ4NDIsInR5cGUiOjAsImlhdCI6MTc0NTQ0MTI0MiwiYWlkIjoiOEtGelo4NFBUVGVOZm5GUjRsMG42USJ9.Ogdd7aMc0W8Gp3y73go-TuJFZqMaH2Sb0mb5D_IyfwjBgxNOJQuNwdaF6LsTZb6rvuIuCdEEjpZ15vgqMAor_Q', 'eyJzdiI6IjAwMDAwMiIsImFsZyI6IkhTNTEyIiwidiI6IjIuMCIsImtpZCI6ImY0YmVlZTRlLWJmNDItNGNhNC04MDUwLWY3YTA0OWYxYjYwMyJ9.eyJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJKcFd1S25WQVRYQzYwMC13Y2pTZjVRIiwidmVyIjoxMCwiYXVpZCI6IjE4NDY1YjU0YzhmODNkZDFlZWUyMDhiMTc1M2E2NTQ1OTc2MzAxY2NmOTU1OTRiMTZhYjg3Y2JiMWViNDYzMzAiLCJuYmYiOjE3NDU0NDEyNDIsImNvZGUiOiI1WWcwRmFhQ25UTG1MVnhxaFlZVGh1MmZOb1BjOFNzd0EiLCJpc3MiOiJ6bTpjaWQ6Sld4Tkpfc2lUczZXS1RCWlo5SUZ3IiwiZ25vIjowLCJleHAiOjE3NTMyMTcyNDIsInR5cGUiOjEsImlhdCI6MTc0NTQ0MTI0MiwiYWlkIjoiOEtGelo4NFBUVGVOZm5GUjRsMG42USJ9.id32kQ4Bz2DhsMgEt2o1N9_MKsZ0XerqTlSMWBz4YmTgeBAlfySg-wGuHAQ6XXKwqa5x7ycHNGHkbY9sED8y_Q', '2025-04-23 21:47:21', '2025-04-23 20:47:22'),
(2, 'eyJzdiI6IjAwMDAwMiIsImFsZyI6IkhTNTEyIiwidiI6IjIuMCIsImtpZCI6IjgyMjA5MjZkLTdmMGYtNGVlZS04OTNjLTgyNTExNWE2OTY1YiJ9.eyJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJKcFd1S25WQVRYQzYwMC13Y2pTZjVRIiwidmVyIjoxMCwiYXVpZCI6IjE4NDY1YjU0YzhmODNkZDFlZWUyMDhiMTc1M2E2NTQ1OTc2MzAxY2NmOTU1OTRiMTZhYjg3Y2JiMWViNDYzMzAiLCJuYmYiOjE3NDU1OTU1MTcsImNvZGUiOiI1WWcwRmFhQ25UTG1MVnhxaFlZVGh1MmZOb1BjOFNzd0EiLCJpc3MiOiJ6bTpjaWQ6Sld4Tkpfc2lUczZXS1RCWlo5SUZ3IiwiZ25vIjowLCJleHAiOjE3NDU1OTkxMTcsInR5cGUiOjAsImlhdCI6MTc0NTU5NTUxNywiYWlkIjoiOEtGelo4NFBUVGVOZm5GUjRsMG42USJ9.bVXWYXqaMMWjEW0dlWfLPHgXnIVlKnRlU46oLFLUFR9ryLDpkaAtiqEN-EcvpyANlmF1JzynhIxRxeQbxn2tSQ', 'eyJzdiI6IjAwMDAwMiIsImFsZyI6IkhTNTEyIiwidiI6IjIuMCIsImtpZCI6IjQ0OTQyMjQ4LWZhMGYtNDYzMC05MzYyLTBhZTkzOTBlMWZiNSJ9.eyJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJKcFd1S25WQVRYQzYwMC13Y2pTZjVRIiwidmVyIjoxMCwiYXVpZCI6IjE4NDY1YjU0YzhmODNkZDFlZWUyMDhiMTc1M2E2NTQ1OTc2MzAxY2NmOTU1OTRiMTZhYjg3Y2JiMWViNDYzMzAiLCJuYmYiOjE3NDU1OTU1MTcsImNvZGUiOiI1WWcwRmFhQ25UTG1MVnhxaFlZVGh1MmZOb1BjOFNzd0EiLCJpc3MiOiJ6bTpjaWQ6Sld4Tkpfc2lUczZXS1RCWlo5SUZ3IiwiZ25vIjowLCJleHAiOjE3NTMzNzE1MTcsInR5cGUiOjEsImlhdCI6MTc0NTU5NTUxNywiYWlkIjoiOEtGelo4NFBUVGVOZm5GUjRsMG42USJ9.ykxiaI1b3pQvtV8jbYMqZ5LLdDukZCHDJt4j8Y5x5lPP7WkDzIXpvcVR-EWpI1HHz9Oj22OI8RwttNTya023oQ', '2025-04-25 16:38:36', '2025-04-25 15:38:37');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `password`, `role`) VALUES
('00214898', '$2y$10$TBUS3N4tAOS/l7WPnj4s2eYopTm53nrEiN.yvIFB5/6LbggSJfb0G', 'Patient'),
('03658', '$2y$10$wIag7IwpJ0/vNsbQIDj6T.RyRsy1Ll9No/kYGfrKezLfuIhU.mCAe', 'Patient'),
('06798725', '$2y$10$bh55WSVS1A6ffgU029Ax8esbH4PwFPgUYn2QQsBkJd63Ao/lSskze', 'Admin'),
('104881', '$2y$10$L6g8RBOQw5d0pTE/Muyz2OuvuKsTn6AinLUJ6KRAARdVeyKo1qo0u', 'Patient'),
('105801', '$2y$10$QCn41nFuQpM9Xs3XNWMzbuSiUcNW/lSSOcJovSxCuhUaCn1S7BhWC', 'Patient'),
('107991', '$2y$10$7Qx9h4MAyyNheQLMkNVbCecca0u8a8CxNO7TF2mCCprpMEJZGe90i', 'Patient'),
('108401', '$2y$10$Qvl0FJh1d6w3pDevjMns0.ClRxxJMRCEUuXkkj8Tn1HRhsrZGErom', 'Patient'),
('10850167', '$2y$10$XF/wTyY7PnWwlurPElEmb.tHAt7xqnz9z9FADedu/.YEHrVMNHuVa', 'Patient'),
('108599', '$2y$10$hZ19Fb7ZJKlh3VZs9SBy/.EYUvPG7EhOP72DlaabDABtytN.QHccS', 'Patient'),
('108613', '$2y$10$NdTuZ3hN7UQZmlYFudFmweOfH2dbpDnN0F3fnvZn96M0y14gMTyza', 'Patient'),
('11567879', '$2y$10$FKjTay2TSJbQFp5bDks8F.ZKkzx23FGF.tFS8rc9xpTYV8PEe5.uq', 'Doctor'),
('12', '$2y$10$VTlOegU1E0RPB2qS1cPf7O7A.YLza6Wm1O.UsazFLoHcWEjb6zt1i', 'cardiologist'),
('14', '$2y$10$/6pC88V435QM/q0XKDEsOeu8BgBVox/nEe7uDGdBVYxxfPHvN8OBe', 'surgeon'),
('14561', '$2y$10$wiN4SvukxyVsaiZ3FWstD.8452eWJZDCP6Qzd4sqmqesCCuZKZMeu', 'Patient'),
('17', '$2y$10$7KGrlcj3KcpaqiCX45wESurMq0rAsHRXjeNRBTETLyjWyQQuZg8kS', 'resident'),
('178', '$2y$10$94RvZAdX7nEkLJiGi.uTuOpRRG3/hvCtIp1MOpW.wTAESUDEj4Lhu', 'family physician'),
('234567890', '$2y$10$hur2yQEy.LTgpzjSdI1fUuHy2UwAgp.YimmLfiXBXc.nqecT7tdqy', 'Pharmacist'),
('24396', '$2y$10$h9sCgQNEP2sVYuqfz9Itg.ofevG/3tvG7TN4pDCPT38pjctIdD6b2', 'Patient'),
('25689161', '$2y$10$NH7dJGd/awziwpHISiswQ.BYAi7DHOAEaukpUKm0WQKb05rHxj7aO', 'GYNEA'),
('25987', '$2y$10$O5xBJG9dq4dJrkb.lRXeqeS3yATiZdzWpPxoQ4GYgG6jBkE5cRhL2', 'Patient'),
('34869705', '$2y$10$bvro5I4tMrCrIYM0L30wRefEXBI2uC.3Izw0DaY7V2xQ33FhwPZcy', 'Cashier'),
('45968705', '$2y$10$DpqfKxO97GKhWlz2uVQQ5uoYapfTRwF8k/qi0k7MqfVJtI41fu48G', 'gynecologist'),
('47342025', '$2y$10$f6jvI4wVCKW05NmFMLIkZO3te2bCNHRMMOCUZjFqIBRCY9lmtceQO', 'Patient'),
('58603759', '$2y$10$SWRwrtKeUoAh9zJth2lj3OS80r/UWvrVIrc//SMJJVf4kkTAHSxoG', 'Lab Technician'),
('7890', '$2y$10$9OcP2.6t40emukxUIZWqnekQY/SX2it7nK/QNjNYTf82igXMuRsXC', 'Admin'),
('84923789', '$2y$10$JeIHUtcsxi0ByVI4bMQSLeRafA2pmTSYn9lItAqOhEGrkBRFRNDfK', 'Patient'),
('89546789', '$2y$10$T8CQh59JWv/KTCzdx4MecuoqPHxgxAK9i8R2d4m0zL0MtEFjam9mC', 'doctor'),
('bafoo1ad', '$2y$10$ycQ/4we1LzMcpYH3BdD77Okl5Wtm9gruHD2.7dp808Er.td44l/Jy', 'Admin'),
('SAdmin124', '$2y$10$SWRwrtKeUoAh9zJth2lj3OS80r/UWvrVIrc//SMJJVf4kkTAHSxoG', 'SuperAdmin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

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
-- Indexes for table `dispensed_medication_table`
--
ALTER TABLE `dispensed_medication_table`
  ADD PRIMARY KEY (`dispensed_id`),
  ADD KEY `medication_id` (`medication_id`),
  ADD KEY `prescription_id` (`prescription_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `pharmacist_id` (`pharmacist_id`);

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
  ADD KEY `test_type_id` (`test_type_id`),
  ADD KEY `lab_tech_id` (`lab_tech_id`);

--
-- Indexes for table `messages_table`
--
ALTER TABLE `messages_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sender` (`sender_id`),
  ADD KEY `idx_receiver` (`receiver_id`);

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
-- Indexes for table `prescription_notifications`
--
ALTER TABLE `prescription_notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `medication_id` (`medication_id`),
  ADD KEY `patient_id` (`patient_id`);

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
-- Indexes for table `super_admin`
--
ALTER TABLE `super_admin`
  ADD PRIMARY KEY (`super_id`);

--
-- Indexes for table `telemedicine_table`
--
ALTER TABLE `telemedicine_table`
  ADD PRIMARY KEY (`telemedicine_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `test_type_table`
--
ALTER TABLE `test_type_table`
  ADD PRIMARY KEY (`test_type_id`),
  ADD UNIQUE KEY `test_name` (`test_name`);

--
-- Indexes for table `token_table`
--
ALTER TABLE `token_table`
  ADD PRIMARY KEY (`token_id`);

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
  MODIFY `appointment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `appointment_timeslots`
--
ALTER TABLE `appointment_timeslots`
  MODIFY `timeslot_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `booking_table`
--
ALTER TABLE `booking_table`
  MODIFY `booking_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `clinic_table`
--
ALTER TABLE `clinic_table`
  MODIFY `clinic_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=893;

--
-- AUTO_INCREMENT for table `department_table`
--
ALTER TABLE `department_table`
  MODIFY `department_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9001;

--
-- AUTO_INCREMENT for table `dispensed_medication_table`
--
ALTER TABLE `dispensed_medication_table`
  MODIFY `dispensed_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lab_table`
--
ALTER TABLE `lab_table`
  MODIFY `lab_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lab_test_table`
--
ALTER TABLE `lab_test_table`
  MODIFY `lab_test_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `messages_table`
--
ALTER TABLE `messages_table`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prescription_medication_table`
--
ALTER TABLE `prescription_medication_table`
  MODIFY `medication_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `prescription_notifications`
--
ALTER TABLE `prescription_notifications`
  MODIFY `notification_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescription_table`
--
ALTER TABLE `prescription_table`
  MODIFY `prescription_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `receipt_table`
--
ALTER TABLE `receipt_table`
  MODIFY `receipt_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `telemedicine_table`
--
ALTER TABLE `telemedicine_table`
  MODIFY `telemedicine_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `test_type_table`
--
ALTER TABLE `test_type_table`
  MODIFY `test_type_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `token_table`
--
ALTER TABLE `token_table`
  MODIFY `token_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `user_table` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `dispensed_medication_table`
--
ALTER TABLE `dispensed_medication_table`
  ADD CONSTRAINT `dispensed_medication_table_ibfk_1` FOREIGN KEY (`medication_id`) REFERENCES `prescription_medication_table` (`medication_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dispensed_medication_table_ibfk_2` FOREIGN KEY (`prescription_id`) REFERENCES `prescription_table` (`prescription_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dispensed_medication_table_ibfk_3` FOREIGN KEY (`patient_id`) REFERENCES `patient_table` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dispensed_medication_table_ibfk_4` FOREIGN KEY (`pharmacist_id`) REFERENCES `staff_table` (`staff_id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
  ADD CONSTRAINT `lab_test_table_ibfk_2` FOREIGN KEY (`test_type_id`) REFERENCES `test_type_table` (`test_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lab_test_table_ibfk_3` FOREIGN KEY (`lab_tech_id`) REFERENCES `staff_table` (`staff_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `messages_table`
--
ALTER TABLE `messages_table`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `user_table` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `user_table` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `prescription_notifications`
--
ALTER TABLE `prescription_notifications`
  ADD CONSTRAINT `prescription_notifications_ibfk_1` FOREIGN KEY (`medication_id`) REFERENCES `prescription_medication_table` (`medication_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prescription_notifications_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patient_table` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `super_admin`
--
ALTER TABLE `super_admin`
  ADD CONSTRAINT `super_admin_ibfk_1` FOREIGN KEY (`super_id`) REFERENCES `user_table` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `telemedicine_table`
--
ALTER TABLE `telemedicine_table`
  ADD CONSTRAINT `telemedicine_table_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_table` (`booking_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `telemedicine_table_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patient_table` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `telemedicine_table_ibfk_3` FOREIGN KEY (`staff_id`) REFERENCES `staff_table` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
