-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 05:23 AM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `first_name`, `last_name`, `contact`, `role`) VALUES
('986758495', 'Shawn', 'aasd', '0551718956', 'Admin');

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
(2, '623744348888', '2025-04-18'),
(3, '623744348888', '2025-04-17'),
(4, '238983009', '2025-04-17');

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
(8, 2, '10:00:00', 'Booked'),
(9, 3, '07:00:00', 'Available'),
(10, 3, '12:00:00', 'Available'),
(11, 3, '13:00:00', 'Available'),
(12, 3, '14:00:00', 'Available'),
(13, 4, '15:00:00', 'Available'),
(14, 4, '16:00:00', 'Available'),
(15, 4, '17:00:00', 'Available');

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
(16, '12345678', 10, 'Virtual', 9345678, 'Cancelled'),
(23, '12345678', 4, 'Virtual', 9345678, 'Cancelled'),
(34, '12345678', 3, 'Virtual', 9345678, 'Cancelled'),
(36, '12345678', 1, 'Virtual', 9345678, 'Cancelled'),
(37, '12345678', 12, 'Virtual', 9345678, 'Cancelled'),
(38, '12345678', 15, 'Virtual', 9345678, 'Cancelled'),
(39, '12345678', 8, 'Virtual', 9345678, 'Scheduled');

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
-- Table structure for table `dispensed_medication_table`
--

CREATE TABLE `dispensed_medication_table` (
  `dispensed_id` int(11) NOT NULL,
  `medication_id` int(11) NOT NULL,
  `prescription_id` int(11) NOT NULL,
  `patient_id` varchar(50) NOT NULL,
  `quantity_dispensed` varchar(100) NOT NULL,
  `dispensed_date` datetime DEFAULT current_timestamp(),
  `pharmacist_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dispensed_medication_table`
--

INSERT INTO `dispensed_medication_table` (`dispensed_id`, `medication_id`, `prescription_id`, `patient_id`, `quantity_dispensed`, `dispensed_date`, `pharmacist_id`) VALUES
(1, 8, 5, '13456789', '30', '2025-04-19 23:17:35', '623746795'),
(2, 9, 5, '13456789', '50', '2025-04-19 23:17:35', '623746795');

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

-- --------------------------------------------------------

--
-- Table structure for table `lab_test_table`
--

CREATE TABLE `lab_test_table` (
  `lab_test_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `test_type_id` int(11) NOT NULL,
  `result` text DEFAULT NULL,
  `result_status` enum('Pending','Completed','Abnormal') DEFAULT 'Pending',
  `specimen_received_by` varchar(100) DEFAULT NULL,
  `specimen_date` date DEFAULT NULL,
  `specimen_time` time DEFAULT NULL,
  `sample_accepted` enum('YES','NO') DEFAULT NULL,
  `lab_tech_id` varchar(50) DEFAULT NULL,
  `lab_tech_signature` varchar(100) DEFAULT NULL,
  `lab_tech_date` date DEFAULT NULL,
  `supervisor_signature` varchar(100) DEFAULT NULL,
  `supervisor_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages_table`
--

CREATE TABLE `messages_table` (
  `id` int(11) NOT NULL,
  `sender_id` varchar(50) NOT NULL,
  `receiver_id` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `sent_at` datetime NOT NULL,
  `read_at` datetime DEFAULT NULL
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
('12345678', 'Fat', 'dairy', '2003-05-05', 'Male', 34.00, 'hgkjd', '0551718945', 'kwaku', '0551718945', 'Male', 'brother'),
('13456789', 'Kwame', 'emerole', '2025-04-03', 'Male', 50.00, 'Bort 36', '0551718945', 'kwaku', '0551718945', 'Female', 'brother');

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
-- Table structure for table `prescription_notifications`
--

CREATE TABLE `prescription_notifications` (
  `notification_id` int(11) NOT NULL,
  `medication_id` int(11) NOT NULL,
  `patient_id` varchar(50) NOT NULL,
  `enabled` enum('Yes','No') DEFAULT 'No',
  `notification_time` time NOT NULL,
  `interval_hours` int(11) DEFAULT NULL,
  `last_sent` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescription_notifications`
--

INSERT INTO `prescription_notifications` (`notification_id`, `medication_id`, `patient_id`, `enabled`, `notification_time`, `interval_hours`, `last_sent`, `created_at`) VALUES
(36, 8, '13456789', 'Yes', '02:26:00', NULL, NULL, '2025-04-20 02:25:11'),
(37, 9, '13456789', 'Yes', '00:00:00', NULL, NULL, NULL),
(38, 9, '13456789', 'Yes', '02:27:00', NULL, NULL, '2025-04-20 02:25:24');

-- --------------------------------------------------------

--
-- Table structure for table `prescription_table`
--

CREATE TABLE `prescription_table` (
  `prescription_id` int(11) NOT NULL,
  `patient_id` varchar(50) DEFAULT NULL,
  `staff_id` varchar(50) DEFAULT NULL,
  `medication_date` date NOT NULL,
  `status` enum('Pending','Dispensed','Cancelled') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescription_table`
--

INSERT INTO `prescription_table` (`prescription_id`, `patient_id`, `staff_id`, `medication_date`, `status`) VALUES
(5, '13456789', '238983009', '2025-04-04', 'Dispensed');

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
('238983009', 'Fatou', 'Waggeh', 'Female', 756545, '0551718945', 'ktprodu@ashesi.edu.gh', 'Doctor'),
('45678956', 'Morgan', 'emerole', 'Male', 756545, '0551718945', 'ktprodu@ashesi.edu.gh', 'Cashier'),
('62374434', 'Kwame', 'emerole', 'Female', 756545, '0551718945', 'mntawiah@gmail.com', 'Staff'),
('623744348888', 'Kay', 'emerole', 'Male', 88567, '0551718945', 'ktproductions124@ashesi.edu.gh', 'Doctor'),
('623746795', 'Kwame', 'Waggeh', 'Female', NULL, '0551718945', 'mntawiah@gmail.com', 'Lab Technician');

-- --------------------------------------------------------

--
-- Table structure for table `super_admin`
--

CREATE TABLE `super_admin` (
  `super_id` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `telemedicine_table`
--

CREATE TABLE `telemedicine_table` (
  `telemedicine_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `patient_id` varchar(50) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `meeting_id` varchar(50) NOT NULL,
  `join_url` text NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `duration` int(11) NOT NULL,
  `status` enum('Scheduled','Completed','Cancelled') DEFAULT 'Scheduled',
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `telemedicine_table`
--

INSERT INTO `telemedicine_table` (`telemedicine_id`, `booking_id`, `patient_id`, `staff_id`, `meeting_id`, `join_url`, `password`, `topic`, `start_time`, `duration`, `status`, `notes`) VALUES
(5, 23, '12345678', '623744348888', '81670602143', 'https://us05web.zoom.us/j/81670602143?pwd=nEccWOr44TGmSUGwt9jFOD7puXQJMy.1', 'd580hibv', 'Virtual Consultation with Patient 12345678', '2025-04-15 15:00:00', 30, 'Cancelled', NULL),
(6, 34, '12345678', '623744348888', '84067002072', 'https://us05web.zoom.us/j/84067002072?pwd=UiADaCixwtMbHNxnAQDT0sQkSmSPP6.1', '0uk5yw1j', 'Virtual Consultation with Patient 12345678', '2025-04-16 12:00:00', 30, 'Cancelled', NULL),
(7, 36, '12345678', '623744348888', '89197974570', 'https://us05web.zoom.us/j/89197974570?pwd=Nt2YZ8Aa2aRt4x4OSLvEbJkYF9JKEY.1', 'auwsyji2', 'Virtual Consultation with Patient 12345678', '2025-04-16 07:00:00', 30, 'Cancelled', NULL),
(8, 37, '12345678', '623744348888', '85897844423', 'https://us05web.zoom.us/j/85897844423?pwd=8ZdoevPHwoASYw9no5vQc703a6Ikgt.1', 'b9qkusjf', 'Virtual Consultation with Patient 12345678', '2025-04-17 14:00:00', 30, 'Cancelled', NULL),
(9, 38, '12345678', '238983009', '89615331050', 'https://us05web.zoom.us/j/89615331050?pwd=PTZ8ERmPHENNuk8mfVakgkqNiGbrhj.1', '96g4axl0', 'Virtual Consultation with Patient 12345678', '2025-04-17 17:00:00', 30, 'Cancelled', NULL),
(10, 39, '12345678', '623744348888', '85370032285', 'https://us05web.zoom.us/j/85370032285?pwd=ag4bR4NtiErUU2Usl0bgWHSUfVHrdc.1', 'f3ij42uo', 'Virtual Consultation with Patient 12345678', '2025-04-18 10:00:00', 30, 'Scheduled', NULL);

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
-- Table structure for table `token_table`
--

CREATE TABLE `token_table` (
  `token_id` int(11) NOT NULL,
  `access_token` text NOT NULL,
  `refresh_token` text DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `token_table`
--

INSERT INTO `token_table` (`token_id`, `access_token`, `refresh_token`, `expires_at`, `created_at`) VALUES
(8, 'eyJzdiI6IjAwMDAwMiIsImFsZyI6IkhTNTEyIiwidiI6IjIuMCIsImtpZCI6ImUxMDk4OTM2LTAwNTYtNDdjOC05NDE1LTc1NDY2ODRiY2Y4NCJ9.eyJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJKcFd1S25WQVRYQzYwMC13Y2pTZjVRIiwidmVyIjoxMCwiYXVpZCI6IjE4NDY1YjU0YzhmODNkZDFlZWUyMDhiMTc1M2E2NTQ1OTc2MzAxY2NmOTU1OTRiMTZhYjg3Y2JiMWViNDYzMzAiLCJuYmYiOjE3NDQ3NTU1NjAsImNvZGUiOiI1dk5nQTQ3OG1nMFdrV3FsZHgxVHJTMGxnT0xydTlVSkEiLCJpc3MiOiJ6bTpjaWQ6Sld4Tkpfc2lUczZXS1RCWlo5SUZ3IiwiZ25vIjowLCJleHAiOjE3NDQ3NTkxNjAsInR5cGUiOjAsImlhdCI6MTc0NDc1NTU2MCwiYWlkIjoiOEtGelo4NFBUVGVOZm5GUjRsMG42USJ9.Bxg7DLC4fORKDU3-6qU0hbk_X_ELit0tKGlU-Ph3vXRo-t-9T8HoFI7lHW3XgT-4PdO5-6eZfcEBIuHp9Pf_UA', 'eyJzdiI6IjAwMDAwMiIsImFsZyI6IkhTNTEyIiwidiI6IjIuMCIsImtpZCI6IjRhYjBmNTBiLTI4MWEtNDBhZS1iN2JiLTYxMzViNTY3ODk4ZSJ9.eyJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJKcFd1S25WQVRYQzYwMC13Y2pTZjVRIiwidmVyIjoxMCwiYXVpZCI6IjE4NDY1YjU0YzhmODNkZDFlZWUyMDhiMTc1M2E2NTQ1OTc2MzAxY2NmOTU1OTRiMTZhYjg3Y2JiMWViNDYzMzAiLCJuYmYiOjE3NDQ3NTU2MCwiY29kZSI6IjV2TmdBNDc4bWcwV2tXcWxkeDFUcVMwbGdPTFJudTVVSkEiLCJpc3MiOiJ6bTpjaWQ6Sld4Tkpfc2lUczZXS1RCWlo5SUZ3IiwiZ25vIjowLCJleHAiOjE3NTI1MzE1NjAsInR5cGUiOjEsImlhdCI6MTc0NDc1NTU2MCwiYWlkIjoiOEtGelo4NFBUVGVOZm5GUjRsMG42USJ9.bxo613Wj5Bd56f9yf6niMhUVeidsUTD8NIUjrPHxpPgB-ntLQ_G1RInBQHLSiVZKn0zd-UhIo5dbMHS6qRrvwA', '2025-04-16 01:19:20', '2025-04-15 22:19:21'),
(9, 'eyJzdiI6IjAwMDAwMiIsImFsZyI6IkhTNTEyIiwidiI6IjIuMCIsImtpZCI6IjQyNzBhNzExLWIzZjYtNGUxZS1hNmYzLTA4NTc5YTM1NjFjZiJ9.eyJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJKcFd1S25WQVRYQzYwMC13Y2pTZjVRIiwidmVyIjoxMCwiYXVpZCI6IjE4NDY1YjU0YzhmODNkZDFlZWUyMDhiMTc1M2E2NTQ1OTc2MzAxY2NmOTU1OTRiMTZhYjg3Y2JiMWViNDYzMzAiLCJuYmYiOjE3NDQ4NDk3NjQsImNvZGUiOiI1dk5nQTQ3OG1nMFdrV3FsZHgxVHJTMGxnT0xydTlVSkEiLCJpc3MiOiJ6bTpjaWQ6Sld4Tkpfc2lUczZXS1RCWlo5SUZ3IiwiZ25vIjowLCJleHAiOjE3NDQ4NTMzNjQsInR5cGUiOjAsImlhdCI6MTc0NDg0OTc2NCwiYWlkIjoiOEtGelo4NFBUVGVOZm5GUjRsMG42USJ9.BPvNPeme9lVcrEjtoTTCEGhMYoq4DCs0mXdwLBJrIx85nwDUS3XL4FYLe5S7GgQBsekqQZqVPOMfWoc4mJ7qrg', 'eyJzdiI6IjAwMDAwMiIsImFsZyI6IkhTNTEyIiwidiI6IjIuMCIsImtpZCI6IjQ5ZmQwYmRkLWM4ZTAtNDUwZC1hMzMxLTI2MDhiYjZjNWUzOCJ9.eyJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJKcFd1S25WQVRYQzYwMC13Y2pTZjVRIiwidmVyIjoxMCwiYXVpZCI6IjE4NDY1YjU0YzhmODNkZDFlZWUyMDhiMTc1M2E2NTQ1OTc2MzAxY2NmOTU1OTRiMTZhYjg3Y2JiMWViNDYzMzAiLCJuYmYiOjE3NDQ4NDk3NjQsImNvZGUiOiI1dk5nQTQ3OG1nMFdrV3FsZHgxVHJTMGxnT0xydTlVSkEiLCJpc3MiOiJ6bTpjaWQ6Sld4Tkpfc2lUczZXS1RCWlo5SUZ3IiwiZ25vIjowLCJleHAiOjE3NTI2MjU3NjQsInR5cGUiOjEsImlhdCI6MTc0NDg0OTc2NCwiYWlkIjoiOEtGelo4NFBUVGVOZm5GUjRsMG42USJ9.ujaAD-5KTJarrrA3Sx1FbbOAu1RsSheDR4hmszuq4celuLEGHIrT-TMyL5VyNtMRSAoajbrWc47xo9H6zXWVWg', '2025-04-17 03:29:23', '2025-04-17 00:29:24'),
(10, 'eyJzdiI6IjAwMDAwMiIsImFsZyI6IkhTNTEyIiwidiI6IjIuMCIsImtpZCI6IjNlMzcwMzRmLWI3YTItNDc5Yi04ZTQyLTFiYTg4MTczOWZmZCJ9.eyJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJKcFd1S25WQVRYQzYwMC13Y2pTZjVRIiwidmVyIjoxMCwiYXVpZCI6IjE4NDY1YjU0YzhmODNkZDFlZWUyMDhiMTc1M2E2NTQ1OTc2MzAxY2NmOTU1OTRiMTZhYjg3Y2JiMWViNDYzMzAiLCJuYmYiOjE3NDQ5MTQ3NjgsImNvZGUiOiI1dk5nQTQ3OG1nMFdrV3FsZHgxVHJTMGxnT0xydTlVSkEiLCJpc3MiOiJ6bTpjaWQ6Sld4Tkpfc2lUczZXS1RCWlo5SUZ3IiwiZ25vIjowLCJleHAiOjE3NDQ5MTgzNjgsInR5cGUiOjAsImlhdCI6MTc0NDkxNDc2OCwiYWlkIjoiOEtGelo4NFBUVGVOZm5GUjRsMG42USJ9.nyDd6G6QADWVEdvLAzTmI8MpiEXibj0Nu8fkfvipqPrdM43RaRTZV03WB4MYmBPFKWJwatvhdXyDFgopXUW_QA', 'eyJzdiI6IjAwMDAwMiIsImFsZyI6IkhTNTEyIiwidiI6IjIuMCIsImtpZCI6ImFiYmVkYzZmLWY5MmQtNDVhMi1hMGI0LTI3OWUxZmQ0NjQ2NiJ9.eyJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJKcFd1S25WQVRYQzYwMC13Y2pTZjVRIiwidmVyIjoxMCwiYXVpZCI6IjE4NDY1YjU0YzhmODNkZDFlZWUyMDhiMTc1M2E2NTQ1OTc2MzAxY2NmOTU1OTRiMTZhYjg3Y2JiMWViNDYzMzAiLCJuYmYiOjE3NDQ5MTQ3NjgsImNvZGUiOiI1dk5nQTQ3OG1nMFdrV3FsZHgxVHJTMGxnT0xydTlVSkEiLCJpc3MiOiJ6bTpjaWQ6Sld4Tkpfc2lUczZXS1RCWlo5SUZ3IiwiZ25vIjowLCJleHAiOjE3NTI2OTA3NjgsInR5cGUiOjEsImlhdCI6MTc0NDkxNDc2OCwiYWlkIjoiOEtGelo4NFBUVGVOZm5GUjRsMG42USJ9.INJXhCk25EgjCfzftEgSyEyp2eeFB42EhvASjpBpRjXwtUMXwYyvavMXqJErIyRLEhL7OsAtLd7hOivKeNvZMg', '2025-04-17 21:32:46', '2025-04-17 18:32:47');

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
('13456789', '$2y$10$lddjxVm7VReYtJgsVS6GSeDYtzES.qOAiSOACuH3AH.nn9lcmS2/.', 'Patient'),
('238983009', '$2y$10$o6EDE7J18uvRUKTrh3kzReFGi1eW0UFZCC7c7XTm5xQZFDpaGdBQ6', 'Doctor'),
('45678956', '$2y$10$bAuI/QQklqgBk5bfaNn4zekFn8/P3Q626TuazNIcq50XxMF2FA3v6', 'Cashier'),
('62374434', '$2y$10$tH3AMK4whtrQ.Y7h7/RuYO1yYeSXIwSNjoWfcbcrUcqNhei1aKcRy', 'Lab Technician'),
('623744348888', '$2y$10$OHXlwKATE/RdaGXcZ7O2qORpQq34b99Cf1vI8K4Iaqt8acvSbjlpC', 'Doctor'),
('623746795', '$2y$10$dmwwQvujqkrSyb46BLgXAOi9FHRxPbozXFkcUV8F9glnysfhwPyL2', 'Pharmacist'),
('986758495', '$2y$10$kJ5bImKIe2xF7vgfOzYj0OfT97RIGwifq0qFXAJeFplHRSkw6qQiu', 'Admin');

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
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `appointment_timeslots`
--
ALTER TABLE `appointment_timeslots`
  MODIFY `timeslot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `booking_table`
--
ALTER TABLE `booking_table`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

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
-- AUTO_INCREMENT for table `dispensed_medication_table`
--
ALTER TABLE `dispensed_medication_table`
  MODIFY `dispensed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `messages_table`
--
ALTER TABLE `messages_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescription_medication_table`
--
ALTER TABLE `prescription_medication_table`
  MODIFY `medication_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `prescription_notifications`
--
ALTER TABLE `prescription_notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

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
-- AUTO_INCREMENT for table `telemedicine_table`
--
ALTER TABLE `telemedicine_table`
  MODIFY `telemedicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `test_type_table`
--
ALTER TABLE `test_type_table`
  MODIFY `test_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `token_table`
--
ALTER TABLE `token_table`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
