-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2025 at 06:57 PM
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
-- Database: `unicare`
--
CREATE DATABASE IF NOT EXISTS `unicare` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `unicare`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `school_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_password`, `school_id`) VALUES
('Adm0001', 'admin123', 1),
('Adm0002', 'admin123', 2),
('Adm0003', 'admin123', 3),
('Adm0004', 'admin123', 4),
('Adm0005', 'admin123', 5),
('Adm0006', 'admin123', 6),
('Adm0007', 'admin123', 7),
('Adm0008', 'admin123', 8),
('Adm0009', 'admin123', 9),
('Adm0010', 'admin123', 10);

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(255) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_start_time` time(6) NOT NULL,
  `booking_end_time` time(6) NOT NULL,
  `remark` text NOT NULL,
  `counselor_id` int(255) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `booking_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `booking_date`, `booking_start_time`, `booking_end_time`, `remark`, `counselor_id`, `student_id`, `booking_status`) VALUES
(1, '2025-09-05', '10:00:00.000000', '11:00:00.000000', 'Stress from exams', 1, 'UM1001', 'approved'),
(2, '2025-09-06', '14:00:00.000000', '15:00:00.000000', 'Time management issue', 2, 'UM1002', 'pending'),
(3, '2025-09-07', '09:30:00.000000', '10:30:00.000000', 'Career advice', 1, 'UM1003', 'approved'),
(4, '2025-09-08', '11:00:00.000000', '12:00:00.000000', 'Homesick feeling', 2, 'UM1004', 'reschedule'),
(5, '2025-09-09', '15:00:00.000000', '16:00:00.000000', 'Exam anxiety', 1, 'UM1005', 'approved'),
(6, '2025-09-10', '13:00:00.000000', '14:00:00.000000', 'Difficulty concentrating', 2, 'UM1006', 'approved'),
(7, '2025-09-11', '16:00:00.000000', '17:00:00.000000', 'Group conflict', 1, 'UM1007', 'pending'),
(8, '2025-09-12', '10:30:00.000000', '11:30:00.000000', 'Family problems', 2, 'UM1008', 'approved'),
(9, '2025-09-13', '14:30:00.000000', '15:30:00.000000', 'Feeling isolated', 1, 'UM1009', 'reschedule'),
(10, '2025-09-14', '09:00:00.000000', '10:00:00.000000', 'Academic pressure', 2, 'UM1010', 'approved'),
(11, '2025-09-05', '09:00:00.000000', '10:00:00.000000', 'Assignment stress', 3, 'UTM2001', 'approved'),
(12, '2025-09-06', '13:00:00.000000', '14:00:00.000000', 'Personal issues', 4, 'UTM2002', 'pending'),
(13, '2025-09-07', '11:30:00.000000', '12:30:00.000000', 'Internship planning', 3, 'UTM2003', 'approved'),
(14, '2025-09-08', '16:00:00.000000', '17:00:00.000000', 'Family problems', 4, 'UTM2004', 'reschedule'),
(15, '2025-09-09', '10:30:00.000000', '11:30:00.000000', 'Exam preparation', 3, 'UTM2005', 'approved'),
(16, '2025-09-10', '09:30:00.000000', '10:30:00.000000', 'Anxiety management', 4, 'UTM2006', 'approved'),
(17, '2025-09-11', '15:00:00.000000', '16:00:00.000000', 'Feeling homesick', 3, 'UTM2007', 'pending'),
(18, '2025-09-12', '14:00:00.000000', '15:00:00.000000', 'Time stress', 4, 'UTM2008', 'approved'),
(19, '2025-09-13', '11:00:00.000000', '12:00:00.000000', 'Peer conflict', 3, 'UTM2009', 'approved'),
(20, '2025-09-14', '13:00:00.000000', '14:00:00.000000', 'Career worries', 4, 'UTM2010', 'reschedule'),
(21, '2025-09-05', '09:00:00.000000', '10:00:00.000000', 'Difficulties in group project', 5, 'UPM3001', 'approved'),
(22, '2025-09-06', '14:00:00.000000', '15:00:00.000000', 'Motivation problem', 6, 'UPM3002', 'pending'),
(23, '2025-09-07', '15:00:00.000000', '16:00:00.000000', 'Thesis stress', 5, 'UPM3003', 'approved'),
(24, '2025-09-08', '11:00:00.000000', '12:00:00.000000', 'Relationship issue', 6, 'UPM3004', 'approved'),
(25, '2025-09-09', '13:00:00.000000', '14:00:00.000000', 'Feeling lonely', 5, 'UPM3005', 'reschedule'),
(26, '2025-09-10', '09:30:00.000000', '10:30:00.000000', 'Exam stress', 6, 'UPM3006', 'approved'),
(27, '2025-09-11', '16:00:00.000000', '17:00:00.000000', 'Lack of focus', 5, 'UPM3007', 'pending'),
(28, '2025-09-12', '10:30:00.000000', '11:30:00.000000', 'Internship confusion', 6, 'UPM3008', 'approved'),
(29, '2025-09-13', '14:30:00.000000', '15:30:00.000000', 'Roommate issue', 5, 'UPM3009', 'approved'),
(30, '2025-09-14', '09:00:00.000000', '10:00:00.000000', 'Stress management', 6, 'UPM3010', 'approved'),
(31, '2025-09-05', '11:00:00.000000', '12:00:00.000000', 'Exam preparation', 7, 'UKM4001', 'approved'),
(32, '2025-09-06', '14:00:00.000000', '15:00:00.000000', 'Relationship issue', 8, 'UKM4002', 'pending'),
(33, '2025-09-07', '15:00:00.000000', '16:00:00.000000', 'Family concern', 7, 'UKM4003', 'approved'),
(34, '2025-09-08', '09:00:00.000000', '10:00:00.000000', 'Low motivation', 8, 'UKM4004', 'approved'),
(35, '2025-09-09', '13:00:00.000000', '14:00:00.000000', 'Project stress', 7, 'UKM4005', 'reschedule'),
(36, '2025-09-10', '11:30:00.000000', '12:30:00.000000', 'Peer pressure', 8, 'UKM4006', 'approved'),
(37, '2025-09-11', '10:00:00.000000', '11:00:00.000000', 'Sleep problems', 7, 'UKM4007', 'pending'),
(38, '2025-09-12', '14:30:00.000000', '15:30:00.000000', 'Thesis concern', 8, 'UKM4008', 'approved'),
(39, '2025-09-13', '09:30:00.000000', '10:30:00.000000', 'Loneliness', 7, 'UKM4009', 'approved'),
(40, '2025-09-14', '16:00:00.000000', '17:00:00.000000', 'Stress balancing studies', 8, 'UKM4010', 'approved'),
(41, '2025-09-05', '08:00:00.000000', '09:00:00.000000', 'Exam anxiety', 9, 'USM5001', 'approved'),
(42, '2025-09-06', '13:00:00.000000', '14:00:00.000000', 'Time management', 10, 'USM5002', 'pending'),
(43, '2025-09-07', '09:30:00.000000', '10:30:00.000000', 'Group project conflict', 9, 'USM5003', 'approved'),
(44, '2025-09-08', '14:00:00.000000', '15:00:00.000000', 'Homesickness', 10, 'USM5004', 'approved'),
(45, '2025-09-09', '11:00:00.000000', '12:00:00.000000', 'Exam stress', 9, 'USM5005', 'reschedule'),
(46, '2025-09-10', '15:00:00.000000', '16:00:00.000000', 'Future career concern', 10, 'USM5006', 'approved'),
(47, '2025-09-11', '10:30:00.000000', '11:30:00.000000', 'Low self-esteem', 9, 'USM5007', 'pending'),
(48, '2025-09-12', '09:00:00.000000', '10:00:00.000000', 'Overloaded with tasks', 10, 'USM5008', 'approved'),
(49, '2025-09-13', '16:00:00.000000', '17:00:00.000000', 'Anxiety', 9, 'USM5009', 'approved'),
(50, '2025-09-14', '14:30:00.000000', '15:30:00.000000', 'Sleep cycle issues', 10, 'USM5010', 'approved'),
(51, '2025-09-05', '09:00:00.000000', '10:00:00.000000', 'Exam pressure', 11, 'UiTM6001', 'approved'),
(52, '2025-09-06', '13:00:00.000000', '14:00:00.000000', 'Family issue', 12, 'UiTM6002', 'pending'),
(53, '2025-09-07', '15:00:00.000000', '16:00:00.000000', 'Thesis deadline stress', 11, 'UiTM6003', 'approved'),
(54, '2025-09-08', '11:00:00.000000', '12:00:00.000000', 'Feeling isolated', 12, 'UiTM6004', 'approved'),
(55, '2025-09-09', '14:00:00.000000', '15:00:00.000000', 'Relationship worry', 11, 'UiTM6005', 'reschedule'),
(56, '2025-09-10', '10:30:00.000000', '11:30:00.000000', 'Sleep issues', 12, 'UiTM6006', 'approved'),
(57, '2025-09-11', '16:00:00.000000', '17:00:00.000000', 'Stress balancing study and work', 11, 'UiTM6007', 'pending'),
(58, '2025-09-12', '09:30:00.000000', '10:30:00.000000', 'Low confidence', 12, 'UiTM6008', 'approved'),
(59, '2025-09-13', '14:30:00.000000', '15:30:00.000000', 'Exam anxiety', 11, 'UiTM6009', 'approved'),
(60, '2025-09-14', '08:30:00.000000', '09:30:00.000000', 'Motivation concern', 12, 'UiTM6010', 'approved'),
(61, '2025-09-05', '09:00:00.000000', '10:00:00.000000', 'Internship anxiety', 13, 'UNIMAS7001', 'approved'),
(62, '2025-09-06', '13:00:00.000000', '14:00:00.000000', 'Family conflict', 14, 'UNIMAS7002', 'pending'),
(63, '2025-09-07', '10:00:00.000000', '11:00:00.000000', 'Project stress', 13, 'UNIMAS7003', 'approved'),
(64, '2025-09-08', '14:00:00.000000', '15:00:00.000000', 'Exam anxiety', 14, 'UNIMAS7004', 'approved'),
(65, '2025-09-09', '16:00:00.000000', '17:00:00.000000', 'Relationship breakup', 13, 'UNIMAS7005', 'reschedule'),
(66, '2025-09-10', '11:00:00.000000', '12:00:00.000000', 'Sleep problems', 14, 'UNIMAS7006', 'approved'),
(67, '2025-09-11', '15:00:00.000000', '16:00:00.000000', 'Lack of concentration', 13, 'UNIMAS7007', 'pending'),
(68, '2025-09-12', '09:30:00.000000', '10:30:00.000000', 'Group conflict', 14, 'UNIMAS7008', 'approved'),
(69, '2025-09-13', '14:30:00.000000', '15:30:00.000000', 'Stress before presentation', 13, 'UNIMAS7009', 'approved'),
(70, '2025-09-14', '10:00:00.000000', '11:00:00.000000', 'Future career worry', 14, 'UNIMAS7010', 'approved'),
(71, '2025-09-05', '08:30:00.000000', '09:30:00.000000', 'Exam panic', 15, 'UMS8001', 'approved'),
(72, '2025-09-06', '13:30:00.000000', '14:30:00.000000', 'Time pressure', 16, 'UMS8002', 'pending'),
(73, '2025-09-07', '09:30:00.000000', '10:30:00.000000', 'Family expectations', 15, 'UMS8003', 'approved'),
(74, '2025-09-08', '11:00:00.000000', '12:00:00.000000', 'Stress handling thesis', 16, 'UMS8004', 'approved'),
(75, '2025-09-09', '15:00:00.000000', '16:00:00.000000', 'Conflict with peers', 15, 'UMS8005', 'reschedule'),
(76, '2025-09-10', '09:00:00.000000', '10:00:00.000000', 'Low motivation', 16, 'UMS8006', 'approved'),
(77, '2025-09-11', '14:30:00.000000', '15:30:00.000000', 'Financial stress', 15, 'UMS8007', 'pending'),
(78, '2025-09-12', '10:30:00.000000', '11:30:00.000000', 'Career advice', 16, 'UMS8008', 'approved'),
(79, '2025-09-13', '16:00:00.000000', '17:00:00.000000', 'Feeling alone', 15, 'UMS8009', 'approved'),
(80, '2025-09-14', '09:00:00.000000', '10:00:00.000000', 'Exam stress', 16, 'UMS8010', 'approved'),
(81, '2025-09-05', '11:00:00.000000', '12:00:00.000000', 'Group project burden', 17, 'MMU9001', 'approved'),
(82, '2025-09-06', '14:00:00.000000', '15:00:00.000000', 'Stress about grades', 18, 'MMU9002', 'pending'),
(83, '2025-09-07', '15:00:00.000000', '16:00:00.000000', 'Relationship concern', 17, 'MMU9003', 'approved'),
(84, '2025-09-08', '09:30:00.000000', '10:30:00.000000', 'Homesick', 18, 'MMU9004', 'approved'),
(85, '2025-09-09', '13:00:00.000000', '14:00:00.000000', 'Financial stress', 17, 'MMU9005', 'reschedule'),
(86, '2025-09-10', '16:00:00.000000', '17:00:00.000000', 'Exam anxiety', 18, 'MMU9006', 'approved'),
(87, '2025-09-11', '10:00:00.000000', '11:00:00.000000', 'Career doubts', 17, 'MMU9007', 'pending'),
(88, '2025-09-12', '14:30:00.000000', '15:30:00.000000', 'Difficulty focusing', 18, 'MMU9008', 'approved'),
(89, '2025-09-13', '09:30:00.000000', '10:30:00.000000', 'Peer conflict', 17, 'MMU9009', 'approved'),
(90, '2025-09-14', '11:00:00.000000', '12:00:00.000000', 'Stress handling workload', 18, 'MMU9010', 'approved'),
(91, '2025-09-05', '09:00:00.000000', '10:00:00.000000', 'Assignment deadline worry', 19, 'TP0001', 'approved'),
(92, '2025-09-06', '13:00:00.000000', '14:00:00.000000', 'Family problem', 20, 'TP0002', 'pending'),
(93, '2025-09-07', '14:00:00.000000', '15:00:00.000000', 'Exam stress', 19, 'TP0003', 'approved'),
(94, '2025-09-08', '10:00:00.000000', '11:00:00.000000', 'Relationship stress', 20, 'TP0004', 'approved'),
(95, '2025-09-09', '15:00:00.000000', '16:00:00.000000', 'Sleep cycle issue', 19, 'TP0005', 'reschedule'),
(96, '2025-09-10', '09:30:00.000000', '10:30:00.000000', 'Motivation loss', 20, 'TP0006', 'approved'),
(97, '2025-09-11', '16:00:00.000000', '17:00:00.000000', 'Peer pressure', 19, 'TP0007', 'pending'),
(98, '2025-09-12', '11:30:00.000000', '12:30:00.000000', 'Overloaded with tasks', 20, 'TP0008', 'approved'),
(99, '2025-09-13', '09:30:00.000000', '10:30:00.000000', 'Career confusion', 19, 'TP0009', 'approved'),
(100, '2025-09-14', '14:00:00.000000', '15:00:00.000000', 'Feeling anxious', 20, 'TP0010', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(255) NOT NULL,
  `confession_id` int(255) NOT NULL,
  `comment_message` text NOT NULL,
  `comment_date_time` datetime(6) NOT NULL,
  `comment_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `confession_id`, `comment_message`, `comment_date_time`, `comment_status`) VALUES
(1, 1, 'I totally understand how you feel 😢', '2025-09-30 10:15:00.000000', 'approved'),
(2, 2, 'So happy for you! Making friends is the best 😊', '2025-09-28 14:30:00.000000', 'approved'),
(3, 3, 'Library struggles are real, hang in there!', '2025-09-18 09:50:00.000000', 'approved'),
(4, 4, 'Congrats on your research breakthrough! 🎉', '2025-09-30 17:40:00.000000', 'approved'),
(5, 5, 'Don’t worry, you’ll do fine in exams!', '2025-09-22 21:00:00.000000', 'approved'),
(6, 6, 'Nasi lemak lovers unite! 😋', '2025-09-22 08:20:00.000000', 'approved'),
(7, 7, '12 hours?! That’s dedication!', '2025-09-21 13:15:00.000000', 'approved'),
(8, 8, 'I miss my family too sometimes...', '2025-09-25 23:40:00.000000', 'approved'),
(9, 9, 'Cafe vibes are the best for studying ☕', '2025-09-30 11:05:00.000000', 'approved'),
(10, 10, 'Deadlines can be overwhelming 😩', '2025-09-20 18:45:00.000000', 'approved'),
(11, 11, 'Great to hear your lecturer is inspiring!', '2025-09-15 09:00:00.000000', 'approved'),
(12, 12, 'Rainy days are tough, hope you stayed dry!', '2025-09-16 12:30:00.000000', 'rejected'),
(13, 13, 'Lab success is so satisfying 🌱', '2025-09-15 15:20:00.000000', 'approved'),
(14, 14, 'Homesickness is normal, hang in there ❤️', '2025-09-29 20:30:00.000000', 'approved'),
(15, 15, 'Study groups make learning fun!', '2025-09-25 14:10:00.000000', 'approved'),
(16, 16, 'Sleep is important, try to rest 😴', '2025-09-22 22:40:00.000000', 'approved'),
(17, 17, 'Congrats on the futsal win! 🏆', '2025-09-19 16:25:00.000000', 'approved'),
(18, 18, 'Internet issues can be frustrating', '2025-09-30 09:35:00.000000', 'rejected'),
(19, 19, 'Group projects are hard, I feel you 😓', '2025-09-27 11:30:00.000000', 'approved'),
(20, 20, 'Inspiring lecture, lucky you!', '2025-09-13 15:15:00.000000', 'approved'),
(21, 21, 'Festival vibes are always fun 🎉', '2025-10-01 20:40:00.000000', 'approved'),
(22, 22, 'Finals anxiety is real, deep breaths!', '2025-09-22 10:25:00.000000', 'approved'),
(23, 23, 'Gym workout feeling strong 💪', '2025-09-19 18:30:00.000000', 'approved'),
(24, 24, 'Too much work can be draining 😩', '2025-09-16 21:10:00.000000', 'rejected'),
(25, 25, 'Excited for new lab equipment too!', '2025-09-18 12:15:00.000000', 'approved'),
(26, 26, 'Hang in there, assignments will pass 😅', '2025-09-26 19:30:00.000000', 'approved'),
(27, 27, 'Caffeine is life ☕', '2025-09-25 09:45:00.000000', 'approved'),
(28, 28, 'Oh no, lost notes are the worst!', '2025-10-01 14:20:00.000000', 'approved'),
(29, 29, 'Study buddies make everything easier 😊', '2025-09-26 16:30:00.000000', 'approved'),
(30, 30, 'Messy dorms are part of student life 😩', '2025-09-20 20:05:00.000000', 'approved'),
(31, 31, 'Morning jogs are refreshing! 🌅', '2025-09-18 07:40:00.000000', 'approved'),
(32, 32, 'Missing the bus happens to me too!', '2025-09-15 08:50:00.000000', 'approved'),
(33, 33, 'Congrats on acing your practice test!', '2025-09-26 15:10:00.000000', 'approved'),
(38, 17, 'Wow!', '2025-09-22 17:24:11.000000', 'pending'),
(42, 17, 'Wow！', '2025-09-22 17:28:07.000000', 'pending'),
(43, 17, 'Wow!', '2025-09-22 21:34:51.000000', 'pending'),
(44, 17, 'Congratz', '2025-09-22 21:35:56.000000', 'pending'),
(46, 17, 'Congratz bro!', '2025-09-22 21:59:52.000000', 'pending'),
(47, 32, 'Damn, me too! Miss my class somemore!', '2025-09-22 22:15:09.000000', 'pending'),
(48, 48, 'Assignments right, I feel u!', '2025-09-22 22:16:00.000000', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `confession`
--

CREATE TABLE `confession` (
  `confession_id` int(255) NOT NULL,
  `confession_title` varchar(255) NOT NULL,
  `confession_message` text DEFAULT NULL,
  `confession_post` text DEFAULT NULL,
  `confession_date_time` datetime(6) NOT NULL,
  `mode` varchar(255) NOT NULL,
  `confession_status` varchar(255) NOT NULL,
  `student_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `confession`
--

INSERT INTO `confession` (`confession_id`, `confession_title`, `confession_message`, `confession_post`, `confession_date_time`, `mode`, `confession_status`, `student_id`) VALUES
(1, 'First day nerves', 'I was really nervous on my first day but things are better now.', '8.jpg', '2025-09-10 10:15:00.000000', 'sad', 'approved', 'UM1001'),
(2, 'Made new friends', 'Happy to find supportive classmates already!', '1.jpg', '2025-09-11 14:30:00.000000', 'happy', 'approved', 'UM1001'),
(3, 'Library struggles', 'The library is always packed, can’t find seats 😩', '', '2025-09-12 09:50:00.000000', 'sad', 'rejected', 'UM1001'),
(4, 'Research breakthrough', 'Finally got results for my thesis experiment 🎉', '4.jpg', '2025-09-13 17:40:00.000000', 'happy', 'approved', 'UM1005'),
(5, 'Exam panic', 'Exams coming soon and I don’t feel prepared 😭', '9.jpg', '2025-09-14 21:00:00.000000', 'sad', 'approved', 'UM1005'),
(6, 'Canteen food', 'Best nasi lemak ever in campus!', '5.jpg', '2025-09-15 08:20:00.000000', 'happy', 'approved', 'UM1005'),
(7, 'Coding assignment', 'Spent 12 hours debugging, but it finally works!', '3.jpg', '2025-09-10 13:15:00.000000', 'happy', 'approved', 'UTM2001'),
(8, 'Lonely nights', 'Missing my family back home tonight...', '9.jpg', '2025-09-11 23:40:00.000000', 'sad', 'approved', 'UTM2001'),
(9, 'Cafe vibes', 'Studying at the campus cafe, feels productive ☕', '5.jpg', '2025-09-12 11:05:00.000000', 'happy', 'approved', 'UTM2001'),
(10, 'Stress overload', 'Too many deadlines in one week 😩', '8.jpg', '2025-09-13 18:45:00.000000', 'sad', 'approved', 'UTM2007'),
(11, 'Good lecturer', 'Our lecturer today made the class really engaging!', '2.jpg', '2025-09-14 09:00:00.000000', 'happy', 'approved', 'UTM2007'),
(12, 'Rainy campus', 'Walking in heavy rain to class, drenched!', '', '2025-09-15 12:30:00.000000', 'sad', 'rejected', 'UTM2007'),
(13, 'Lab success', 'After 3 weeks, finally got my plant samples growing 🌱', '4.jpg', '2025-09-11 15:20:00.000000', 'happy', 'approved', 'UPM3002'),
(14, 'Homesick', 'Really missing my mom’s cooking tonight.', '11.jpg', '2025-09-12 20:30:00.000000', 'sad', 'approved', 'UPM3002'),
(15, 'Study group fun', 'Had a fun time revising with friends!', '1.jpg', '2025-09-13 14:10:00.000000', 'happy', 'approved', 'UPM3002'),
(16, 'Sleep deprived', 'Assignments are killing my sleep cycle 😴', '9.jpg', '2025-09-14 22:40:00.000000', 'sad', 'approved', 'UPM3008'),
(17, 'Sports event', 'Won second place in interfaculty futsal!', '6.jpg', '2025-09-15 16:25:00.000000', 'happy', 'approved', 'UPM3008'),
(18, 'Internet issues', 'WiFi went down in the middle of online lecture.', '', '2025-09-16 09:35:00.000000', 'sad', 'rejected', 'UPM3008'),
(19, 'Group project issues', 'Hard to coordinate with groupmates 😓', '8.jpg', '2025-09-10 11:30:00.000000', 'sad', 'approved', 'UKM4003'),
(20, 'Great lecture', 'Today’s lecture was really inspiring.', '2.jpg', '2025-09-11 15:15:00.000000', 'happy', 'approved', 'UKM4003'),
(21, 'Campus festival', 'Had fun at the cultural festival 🎉', '1.jpg', '2025-09-12 20:40:00.000000', 'happy', 'approved', 'UKM4003'),
(22, 'Exam fear', 'Finals are coming and I feel anxious.', '9.jpg', '2025-09-13 10:25:00.000000', 'sad', 'approved', 'UKM4006'),
(23, 'Gym workout', 'Feeling fresh after workout 💪', '6.jpg', '2025-09-14 18:30:00.000000', 'happy', 'approved', 'UKM4006'),
(24, 'Too much work', 'Deadlines piling up again 😩', '', '2025-09-15 21:10:00.000000', 'sad', 'rejected', 'UKM4006'),
(25, 'New lab equipment', 'Excited to try out the new lab tools!', '4.jpg', '2025-09-10 12:15:00.000000', 'happy', 'approved', 'USM5001'),
(26, 'Feeling stressed', 'So many assignments due this week...', '8.jpg', '2025-09-11 19:30:00.000000', 'sad', 'approved', 'USM5001'),
(27, 'Coffee break', 'Needed some caffeine to survive today ☕', '5.jpg', '2025-09-12 09:45:00.000000', 'happy', 'approved', 'USM5001'),
(28, 'Lost notes', 'Accidentally deleted my lecture notes 😭', '10.jpg', '2025-09-13 14:20:00.000000', 'sad', 'approved', 'USM5005'),
(29, 'Found a study buddy', 'Finally found someone to study together with!', '1.jpg', '2025-09-14 16:30:00.000000', 'happy', 'approved', 'USM5005'),
(30, 'Messy dorm', 'My room is a disaster today 😩', '12.jpg', '2025-09-15 20:05:00.000000', 'sad', 'approved', 'USM5005'),
(31, 'Morning jog', 'Feeling energized after a morning run!', '6.jpg', '2025-09-10 07:40:00.000000', 'happy', 'approved', 'UiTM6001'),
(32, 'Missed the bus', 'Late to class again...', '12.jpg', '2025-09-11 08:50:00.000000', 'sad', 'approved', 'UiTM6001'),
(33, 'Group study', 'We aced the practice test together!', '1.jpg', '2025-09-12 15:10:00.000000', 'happy', 'approved', 'UiTM6001'),
(34, 'Library headache', 'Too many students and no seats!', '9.jpg', '2025-09-13 10:15:00.000000', 'sad', 'approved', 'UiTM6005'),
(35, 'New hobby', 'Started painting during free time 🎨', '7.jpg', '2025-09-14 18:40:00.000000', 'happy', 'approved', 'UiTM6005'),
(36, 'Night shift', 'Stayed up too late finishing assignments 😴', '11.jpg', '2025-09-15 23:20:00.000000', 'sad', 'approved', 'UiTM6005'),
(37, 'Futsal win', 'Our team won the inter-dorm futsal match!', '6.jpg', '2025-09-10 16:50:00.000000', 'happy', 'approved', 'UNIMAS7001'),
(38, 'Rainy walk', 'Caught in the rain without umbrella...', '12.jpg', '2025-09-11 07:30:00.000000', 'sad', 'approved', 'UNIMAS7001'),
(39, 'Study success', 'Finally understood the toughest topic in class!', '3.jpg', '2025-09-12 13:20:00.000000', 'happy', 'approved', 'UNIMAS7001'),
(40, 'Lost wallet', 'Forgot my wallet at the cafeteria 😭', '10.jpg', '2025-09-13 11:40:00.000000', 'sad', 'approved', 'UNIMAS7005'),
(41, 'Good lecture', 'Today’s lecture was very engaging!', '2.jpg', '2025-09-14 15:30:00.000000', 'happy', 'approved', 'UNIMAS7005'),
(42, 'Overwhelmed', 'Too many tasks piling up 😩', '8.jpg', '2025-09-15 21:50:00.000000', 'sad', 'approved', 'UNIMAS7005'),
(43, 'Campus event', 'Had a blast at the campus carnival 🎡', '1.jpg', '2025-09-10 14:00:00.000000', 'happy', 'approved', 'UMS8001'),
(44, 'Missed lecture', 'Overslept and missed morning class 😭', '12.jpg', '2025-09-11 09:20:00.000000', 'sad', 'approved', 'UMS8001'),
(45, 'Assignment done', 'Finally submitted my project!', '1.jpg', '2025-09-12 22:10:00.000000', 'happy', 'approved', 'UMS8001'),
(46, 'Lost notes', 'Accidentally left notes in library 😩', '10.jpg', '2025-09-13 17:45:00.000000', 'sad', 'approved', 'UMS8005'),
(47, 'Great teamwork', 'Team presentation went smoothly!', '1.jpg', '2025-09-14 14:25:00.000000', 'happy', 'approved', 'UMS8005'),
(48, 'Late night coding', 'Coding all night for the hackathon 😴', '11.jpg', '2025-09-15 23:55:00.000000', 'sad', 'approved', 'UMS8005'),
(49, 'Lab fun', 'Had fun with experiments today 🌡️', '4.jpg', '2025-09-10 10:10:00.000000', 'happy', 'approved', 'MMU9001'),
(50, 'Stressful day', 'Too many deadlines at once 😩', '8.jpg', '2025-09-11 20:45:00.000000', 'sad', 'approved', 'MMU9001'),
(51, 'Movie night', 'Watched a movie with friends 🎬', '7.jpg', '2025-09-12 21:15:00.000000', 'happy', 'approved', 'MMU9001'),
(52, 'Computer crash', 'Lost unsaved work 😭', '10.jpg', '2025-09-13 13:50:00.000000', 'sad', 'approved', 'MMU9005'),
(53, 'Good grades', 'Scored well in the quiz!', '1.jpg', '2025-09-14 18:10:00.000000', 'happy', 'approved', 'MMU9005'),
(54, 'Tired', 'Stayed up too late studying 😴', '11.jpg', '2025-09-15 22:40:00.000000', 'sad', 'approved', 'MMU9005'),
(55, 'Workshop fun', 'Learned a lot at today’s workshop 🎓', '1.jpg', '2025-09-10 11:55:00.000000', 'happy', 'approved', 'TP0001'),
(56, 'Late night', 'Burning midnight oil for assignment 😩', '11.jpg', '2025-09-11 23:15:00.000000', 'sad', 'approved', 'TP0001'),
(57, 'Found a new cafe', 'Chilled at a new cafe near campus ☕', '5.jpg', '2025-09-12 16:05:00.000000', 'happy', 'approved', 'TP0001'),
(58, 'Missed bus', 'Ran to catch bus, almost missed it 😭', '12.jpg', '2025-09-13 07:50:00.000000', 'sad', 'approved', 'TP0005'),
(59, 'Lecture fun', 'Enjoyed interactive session today!', '2.jpg', '2025-09-14 12:30:00.000000', 'happy', 'approved', 'TP0005'),
(60, 'Sleepy day', 'Felt exhausted after a long day 😴', '11.jpg', '2025-09-15 22:15:00.000000', 'sad', 'approved', 'TP0005'),
(73, 'Testing Media Size', '', '1758557054_Lukrembo - Dream With Tea (freetouse.com).mp3', '2025-09-23 00:04:14.000000', 'happy', 'pending', 'TP0001'),
(74, 'Test GIF', NULL, '1758558318_Working Chis Sweet Home GIF.gif', '2025-09-23 00:25:18.000000', 'happy', 'pending', 'TP0001'),
(75, 'Test Video', NULL, '1758558760_4274798-uhd_3840_2160_25fps (1).mp4', '2025-09-23 00:32:40.000000', 'happy', 'pending', 'TP0001'),
(76, 'Testing Text', 'Hi, I dun wanna die!', NULL, '2025-09-23 20:30:08.000000', 'happy', 'pending', 'TP0001'),
(85, 'Test Sad Text', 'Die come on!', NULL, '2025-09-23 20:41:39.000000', 'sad', 'pending', 'TP0001'),
(86, 'Test Sad Image', NULL, '1758631335_breakfast.jpg', '2025-09-23 20:42:15.000000', 'sad', 'pending', 'TP0001'),
(87, 'Test Sad GIF', NULL, '1758631357_Working Chis Sweet Home GIF.gif', '2025-09-23 20:42:37.000000', 'sad', 'pending', 'TP0001'),
(88, 'Test Sad Video', 'Hope i skate n die!', '1758631385_4274798-uhd_3840_2160_25fps (1).mp4', '2025-09-23 20:43:05.000000', 'sad', 'pending', 'TP0001'),
(89, 'Test Sad Audio', 'Is sound of heartbreak!', '1758631412_Lukrembo - Dream With Tea (freetouse.com).mp3', '2025-09-23 20:43:32.000000', 'sad', 'pending', 'TP0001');

-- --------------------------------------------------------

--
-- Table structure for table `counselor`
--

CREATE TABLE `counselor` (
  `counselor_id` int(255) NOT NULL,
  `counselor_name` varchar(255) NOT NULL,
  `school_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `counselor`
--

INSERT INTO `counselor` (`counselor_id`, `counselor_name`, `school_id`) VALUES
(1, 'Dr. Noraini Yusuf', 1),
(2, 'Mr. Ahmad Fauzi', 1),
(3, 'Dr. Lim Wei Han', 2),
(4, 'Ms. Farah Azzahra', 2),
(5, 'Dr. Siti Hajar', 3),
(6, 'Mr. Mohd Rizal', 3),
(7, 'Dr. Roslan Ibrahim', 4),
(8, 'Ms. Aida Kamal', 4),
(9, 'Dr. Tan Mei Ling', 5),
(10, 'Mr. Zulkifli Hassan', 5),
(11, 'Dr. Khairul Anuar', 6),
(12, 'Ms. Nurul Huda', 6),
(13, 'Dr. Joseph Ting', 7),
(14, 'Ms. Marina Abdullah', 7),
(15, 'Dr. Rahimah Said', 8),
(16, 'Mr. Chong Wei Lun', 8),
(17, 'Dr. Daniel Ong', 9),
(18, 'Ms. Sharifah Nur', 9),
(19, 'Dr. Melissa Tan', 10),
(20, 'Mr. James Wong', 10);

-- --------------------------------------------------------

--
-- Table structure for table `feeling`
--

CREATE TABLE `feeling` (
  `feeling_id` int(255) NOT NULL,
  `feeling_status` varchar(255) NOT NULL,
  `feeling_date_time` datetime(6) NOT NULL,
  `student_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feeling`
--

INSERT INTO `feeling` (`feeling_id`, `feeling_status`, `feeling_date_time`, `student_id`) VALUES
(1, 'happy', '2025-09-01 09:05:00.000000', 'UM1001'),
(2, 'calm', '2025-09-03 14:20:00.000000', 'UM1001'),
(3, 'sad', '2025-09-05 18:10:00.000000', 'UM1001'),
(4, 'angry', '2025-09-08 10:45:00.000000', 'UM1001'),
(5, 'happy', '2025-09-12 11:30:00.000000', 'UM1001'),
(6, 'calm', '2025-09-02 09:15:00.000000', 'UM1005'),
(7, 'sad', '2025-09-04 13:25:00.000000', 'UM1005'),
(8, 'manic', '2025-09-07 16:40:00.000000', 'UM1005'),
(9, 'happy', '2025-09-10 08:50:00.000000', 'UM1005'),
(10, 'angry', '2025-09-13 15:00:00.000000', 'UM1005'),
(11, 'sad', '2025-09-01 08:45:00.000000', 'UTM2002'),
(12, 'angry', '2025-09-03 12:30:00.000000', 'UTM2002'),
(13, 'calm', '2025-09-06 09:10:00.000000', 'UTM2002'),
(14, 'happy', '2025-09-09 14:15:00.000000', 'UTM2002'),
(15, 'sad', '2025-09-12 11:05:00.000000', 'UTM2002'),
(16, 'calm', '2025-09-02 10:00:00.000000', 'UTM2007'),
(17, 'happy', '2025-09-04 15:35:00.000000', 'UTM2007'),
(18, 'sad', '2025-09-07 17:20:00.000000', 'UTM2007'),
(19, 'manic', '2025-09-11 08:40:00.000000', 'UTM2007'),
(20, 'angry', '2025-09-14 10:55:00.000000', 'UTM2007'),
(21, 'calm', '2025-09-01 09:40:00.000000', 'UPM3003'),
(22, 'happy', '2025-09-05 10:15:00.000000', 'UPM3003'),
(23, 'angry', '2025-09-08 13:25:00.000000', 'UPM3003'),
(24, 'sad', '2025-09-10 16:05:00.000000', 'UPM3003'),
(25, 'happy', '2025-09-14 11:50:00.000000', 'UPM3003'),
(26, 'manic', '2025-09-02 09:25:00.000000', 'UPM3009'),
(27, 'sad', '2025-09-04 12:40:00.000000', 'UPM3009'),
(28, 'happy', '2025-09-06 14:55:00.000000', 'UPM3009'),
(29, 'angry', '2025-09-09 09:05:00.000000', 'UPM3009'),
(30, 'calm', '2025-09-13 15:35:00.000000', 'UPM3009'),
(31, 'happy', '2025-09-01 08:55:00.000000', 'UKM4001'),
(32, 'sad', '2025-09-03 11:45:00.000000', 'UKM4001'),
(33, 'angry', '2025-09-07 15:30:00.000000', 'UKM4001'),
(34, 'calm', '2025-09-10 17:15:00.000000', 'UKM4001'),
(35, 'happy', '2025-09-13 09:40:00.000000', 'UKM4001'),
(36, 'manic', '2025-09-02 08:50:00.000000', 'UKM4008'),
(37, 'angry', '2025-09-05 13:05:00.000000', 'UKM4008'),
(38, 'calm', '2025-09-08 14:20:00.000000', 'UKM4008'),
(39, 'sad', '2025-09-12 16:30:00.000000', 'UKM4008'),
(40, 'happy', '2025-09-15 10:25:00.000000', 'UKM4008'),
(41, 'calm', '2025-09-01 09:20:00.000000', 'USM5004'),
(42, 'sad', '2025-09-04 11:35:00.000000', 'USM5004'),
(43, 'angry', '2025-09-07 14:05:00.000000', 'USM5004'),
(44, 'happy', '2025-09-09 16:25:00.000000', 'USM5004'),
(45, 'calm', '2025-09-13 10:40:00.000000', 'USM5004'),
(46, 'sad', '2025-09-02 09:15:00.000000', 'USM5007'),
(47, 'happy', '2025-09-05 12:50:00.000000', 'USM5007'),
(48, 'manic', '2025-09-08 15:30:00.000000', 'USM5007'),
(49, 'angry', '2025-09-11 08:55:00.000000', 'USM5007'),
(50, 'calm', '2025-09-14 14:10:00.000000', 'USM5007'),
(51, 'happy', '2025-09-01 10:00:00.000000', 'UiTM6002'),
(52, 'calm', '2025-09-03 12:20:00.000000', 'UiTM6002'),
(53, 'sad', '2025-09-06 13:40:00.000000', 'UiTM6002'),
(54, 'angry', '2025-09-08 15:25:00.000000', 'UiTM6002'),
(55, 'happy', '2025-09-12 11:15:00.000000', 'UiTM6002'),
(56, 'manic', '2025-09-02 08:40:00.000000', 'UiTM6009'),
(57, 'calm', '2025-09-05 10:25:00.000000', 'UiTM6009'),
(58, 'sad', '2025-09-09 14:30:00.000000', 'UiTM6009'),
(59, 'angry', '2025-09-11 09:20:00.000000', 'UiTM6009'),
(60, 'happy', '2025-09-15 16:05:00.000000', 'UiTM6009'),
(61, 'sad', '2025-09-01 08:50:00.000000', 'UNIMAS7001'),
(62, 'calm', '2025-09-04 11:10:00.000000', 'UNIMAS7001'),
(63, 'happy', '2025-09-07 13:50:00.000000', 'UNIMAS7001'),
(64, 'angry', '2025-09-10 15:35:00.000000', 'UNIMAS7001'),
(65, 'sad', '2025-09-14 10:05:00.000000', 'UNIMAS7001'),
(66, 'happy', '2025-09-02 09:35:00.000000', 'UNIMAS7006'),
(67, 'sad', '2025-09-05 13:15:00.000000', 'UNIMAS7006'),
(68, 'manic', '2025-09-08 16:20:00.000000', 'UNIMAS7006'),
(69, 'angry', '2025-09-11 08:45:00.000000', 'UNIMAS7006'),
(70, 'calm', '2025-09-15 14:55:00.000000', 'UNIMAS7006'),
(71, 'happy', '2025-09-01 09:10:00.000000', 'UMS8003'),
(72, 'angry', '2025-09-04 12:25:00.000000', 'UMS8003'),
(73, 'calm', '2025-09-06 14:45:00.000000', 'UMS8003'),
(74, 'sad', '2025-09-09 16:00:00.000000', 'UMS8003'),
(75, 'happy', '2025-09-13 09:30:00.000000', 'UMS8003'),
(76, 'manic', '2025-09-02 08:55:00.000000', 'UMS8009'),
(77, 'calm', '2025-09-05 11:40:00.000000', 'UMS8009'),
(78, 'sad', '2025-09-07 15:20:00.000000', 'UMS8009'),
(79, 'angry', '2025-09-11 10:35:00.000000', 'UMS8009'),
(80, 'happy', '2025-09-15 13:25:00.000000', 'UMS8009'),
(81, 'calm', '2025-09-01 09:25:00.000000', 'MMU9002'),
(82, 'sad', '2025-09-04 11:55:00.000000', 'MMU9002'),
(83, 'happy', '2025-09-07 14:35:00.000000', 'MMU9002'),
(84, 'manic', '2025-09-10 16:45:00.000000', 'MMU9002'),
(85, 'angry', '2025-09-13 10:20:00.000000', 'MMU9002'),
(86, 'happy', '2025-09-02 09:15:00.000000', 'MMU9008'),
(87, 'sad', '2025-09-05 12:35:00.000000', 'MMU9008'),
(88, 'calm', '2025-09-08 15:15:00.000000', 'MMU9008'),
(89, 'angry', '2025-09-11 09:25:00.000000', 'MMU9008'),
(90, 'manic', '2025-09-14 14:40:00.000000', 'MMU9008'),
(91, 'happy', '2025-09-01 08:40:00.000000', 'TP0001'),
(92, 'calm', '2025-09-03 12:05:00.000000', 'TP0001'),
(93, 'sad', '2025-09-06 13:50:00.000000', 'TP0001'),
(94, 'angry', '2025-09-08 15:15:00.000000', 'TP0001'),
(95, 'happy', '2025-09-12 11:35:00.000000', 'TP0001'),
(96, 'manic', '2025-09-02 09:30:00.000000', 'TP0007'),
(97, 'sad', '2025-09-05 13:40:00.000000', 'TP0007'),
(98, 'happy', '2025-09-09 14:25:00.000000', 'TP0007'),
(99, 'angry', '2025-09-11 08:55:00.000000', 'TP0007'),
(100, 'calm', '2025-09-15 15:45:00.000000', 'TP0007');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `login_id` int(255) NOT NULL,
  `login_date` date NOT NULL,
  `login_time` time(6) NOT NULL,
  `student_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `login_date`, `login_time`, `student_id`) VALUES
(1, '2025-09-01', '08:15:00.000000', 'UM1001'),
(2, '2025-09-01', '09:20:00.000000', 'UM1002'),
(3, '2025-09-02', '10:05:00.000000', 'UM1003'),
(4, '2025-09-02', '11:30:00.000000', 'UM1004'),
(5, '2025-09-03', '14:10:00.000000', 'UM1005'),
(6, '2025-09-03', '15:45:00.000000', 'UM1006'),
(7, '2025-09-04', '16:20:00.000000', 'UM1007'),
(8, '2025-09-04', '18:00:00.000000', 'UM1008'),
(9, '2025-09-05', '19:25:00.000000', 'UM1009'),
(10, '2025-09-05', '20:50:00.000000', 'UM1010'),
(11, '2025-09-01', '08:25:00.000000', 'UTM2001'),
(12, '2025-09-01', '09:40:00.000000', 'UTM2002'),
(13, '2025-09-02', '10:15:00.000000', 'UTM2003'),
(14, '2025-09-02', '11:35:00.000000', 'UTM2004'),
(15, '2025-09-03', '14:20:00.000000', 'UTM2005'),
(16, '2025-09-03', '15:55:00.000000', 'UTM2006'),
(17, '2025-09-04', '16:35:00.000000', 'UTM2007'),
(18, '2025-09-04', '18:10:00.000000', 'UTM2008'),
(19, '2025-09-05', '19:30:00.000000', 'UTM2009'),
(20, '2025-09-05', '20:55:00.000000', 'UTM2010'),
(21, '2025-09-01', '08:35:00.000000', 'UPM3001'),
(22, '2025-09-01', '09:50:00.000000', 'UPM3002'),
(23, '2025-09-02', '10:25:00.000000', 'UPM3003'),
(24, '2025-09-02', '11:40:00.000000', 'UPM3004'),
(25, '2025-09-03', '14:30:00.000000', 'UPM3005'),
(26, '2025-09-03', '16:05:00.000000', 'UPM3006'),
(27, '2025-09-04', '16:45:00.000000', 'UPM3007'),
(28, '2025-09-04', '18:20:00.000000', 'UPM3008'),
(29, '2025-09-05', '19:35:00.000000', 'UPM3009'),
(30, '2025-09-05', '21:05:00.000000', 'UPM3010'),
(31, '2025-09-01', '08:45:00.000000', 'UKM4001'),
(32, '2025-09-01', '09:55:00.000000', 'UKM4002'),
(33, '2025-09-02', '10:35:00.000000', 'UKM4003'),
(34, '2025-09-02', '11:50:00.000000', 'UKM4004'),
(35, '2025-09-03', '14:40:00.000000', 'UKM4005'),
(36, '2025-09-03', '16:15:00.000000', 'UKM4006'),
(37, '2025-09-04', '16:55:00.000000', 'UKM4007'),
(38, '2025-09-04', '18:30:00.000000', 'UKM4008'),
(39, '2025-09-05', '19:45:00.000000', 'UKM4009'),
(40, '2025-09-05', '21:15:00.000000', 'UKM4010'),
(41, '2025-09-01', '08:55:00.000000', 'USM5001'),
(42, '2025-09-01', '10:05:00.000000', 'USM5002'),
(43, '2025-09-02', '10:45:00.000000', 'USM5003'),
(44, '2025-09-02', '12:00:00.000000', 'USM5004'),
(45, '2025-09-03', '14:50:00.000000', 'USM5005'),
(46, '2025-09-03', '16:25:00.000000', 'USM5006'),
(47, '2025-09-04', '17:05:00.000000', 'USM5007'),
(48, '2025-09-04', '18:40:00.000000', 'USM5008'),
(49, '2025-09-05', '19:55:00.000000', 'USM5009'),
(50, '2025-09-05', '21:25:00.000000', 'USM5010'),
(51, '2025-09-01', '09:05:00.000000', 'UiTM6001'),
(52, '2025-09-01', '10:15:00.000000', 'UiTM6002'),
(53, '2025-09-02', '10:55:00.000000', 'UiTM6003'),
(54, '2025-09-02', '12:10:00.000000', 'UiTM6004'),
(55, '2025-09-03', '15:00:00.000000', 'UiTM6005'),
(56, '2025-09-03', '16:35:00.000000', 'UiTM6006'),
(57, '2025-09-04', '17:15:00.000000', 'UiTM6007'),
(58, '2025-09-04', '18:50:00.000000', 'UiTM6008'),
(59, '2025-09-05', '20:05:00.000000', 'UiTM6009'),
(60, '2025-09-05', '21:35:00.000000', 'UiTM6010'),
(61, '2025-09-01', '09:15:00.000000', 'UNIMAS7001'),
(62, '2025-09-01', '10:25:00.000000', 'UNIMAS7002'),
(63, '2025-09-02', '11:05:00.000000', 'UNIMAS7003'),
(64, '2025-09-02', '12:20:00.000000', 'UNIMAS7004'),
(65, '2025-09-03', '15:10:00.000000', 'UNIMAS7005'),
(66, '2025-09-03', '16:45:00.000000', 'UNIMAS7006'),
(67, '2025-09-04', '17:25:00.000000', 'UNIMAS7007'),
(68, '2025-09-04', '19:00:00.000000', 'UNIMAS7008'),
(69, '2025-09-05', '20:15:00.000000', 'UNIMAS7009'),
(70, '2025-09-05', '21:45:00.000000', 'UNIMAS7010'),
(71, '2025-09-01', '09:25:00.000000', 'UMS8001'),
(72, '2025-09-01', '10:35:00.000000', 'UMS8002'),
(73, '2025-09-02', '11:15:00.000000', 'UMS8003'),
(74, '2025-09-02', '12:30:00.000000', 'UMS8004'),
(75, '2025-09-03', '15:20:00.000000', 'UMS8005'),
(76, '2025-09-03', '16:55:00.000000', 'UMS8006'),
(77, '2025-09-04', '17:35:00.000000', 'UMS8007'),
(78, '2025-09-04', '19:10:00.000000', 'UMS8008'),
(79, '2025-09-05', '20:25:00.000000', 'UMS8009'),
(80, '2025-09-05', '21:55:00.000000', 'UMS8010'),
(81, '2025-09-01', '09:35:00.000000', 'MMU9001'),
(82, '2025-09-01', '10:45:00.000000', 'MMU9002'),
(83, '2025-09-02', '11:25:00.000000', 'MMU9003'),
(84, '2025-09-02', '12:40:00.000000', 'MMU9004'),
(85, '2025-09-03', '15:30:00.000000', 'MMU9005'),
(86, '2025-09-03', '17:05:00.000000', 'MMU9006'),
(87, '2025-09-04', '17:45:00.000000', 'MMU9007'),
(88, '2025-09-04', '19:20:00.000000', 'MMU9008'),
(89, '2025-09-05', '20:35:00.000000', 'MMU9009'),
(90, '2025-09-05', '22:05:00.000000', 'MMU9010'),
(91, '2025-09-01', '09:45:00.000000', 'TP0001'),
(92, '2025-09-01', '10:55:00.000000', 'TP0002'),
(93, '2025-09-02', '11:35:00.000000', 'TP0003'),
(94, '2025-09-02', '12:50:00.000000', 'TP0004'),
(95, '2025-09-03', '15:40:00.000000', 'TP0005'),
(96, '2025-09-03', '17:15:00.000000', 'TP0006'),
(97, '2025-09-04', '17:55:00.000000', 'TP0007'),
(98, '2025-09-04', '19:30:00.000000', 'TP0008'),
(99, '2025-09-05', '20:45:00.000000', 'TP0009'),
(100, '2025-09-05', '22:15:00.000000', 'TP0010'),
(101, '2025-09-21', '14:02:07.000000', 'TP0001'),
(102, '2025-09-21', '14:16:13.000000', 'TP0001'),
(103, '2025-09-23', '21:24:07.000000', 'TP0002'),
(104, '2025-09-23', '22:06:34.000000', 'TP0002');

-- --------------------------------------------------------

--
-- Table structure for table `notification_admin`
--

CREATE TABLE `notification_admin` (
  `message_id` int(255) NOT NULL,
  `message` text NOT NULL,
  `message_date_time` datetime(6) NOT NULL,
  `booking_id` int(255) NOT NULL,
  `admin_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification_admin`
--

INSERT INTO `notification_admin` (`message_id`, `message`, `message_date_time`, `booking_id`, `admin_id`) VALUES
(1, 'Your booking \"Homesick feeling\" has been marked for reschedule. Please check new time slots.', '2025-09-08 10:30:00.000000', 4, 'Adm0001'),
(2, 'Your booking \"Feeling isolated\" has been marked for reschedule. Please check new time slots.', '2025-09-13 14:00:00.000000', 9, 'Adm0001'),
(3, 'Your booking \"Family problems\" has been marked for reschedule. Please check new time slots.', '2025-09-08 15:30:00.000000', 14, 'Adm0002'),
(4, 'Your booking \"Career worries\" has been marked for reschedule. Please check new time slots.', '2025-09-14 12:30:00.000000', 20, 'Adm0002'),
(5, 'Your booking \"Feeling lonely\" has been marked for reschedule. Please check new time slots.', '2025-09-09 12:30:00.000000', 25, 'Adm0003'),
(6, 'Your booking \"Project stress\" has been marked for reschedule. Please check new time slots.', '2025-09-09 12:30:00.000000', 35, 'Adm0004'),
(7, 'Your booking \"Exam stress\" has been marked for reschedule. Please check new time slots.', '2025-09-09 10:30:00.000000', 45, 'Adm0005'),
(8, 'Your booking \"Relationship worry\" has been marked for reschedule. Please check new time slots.', '2025-09-09 13:30:00.000000', 55, 'Adm0006'),
(9, 'Your booking \"Relationship breakup\" has been marked for reschedule. Please check new time slots.', '2025-09-09 15:30:00.000000', 65, 'Adm0007'),
(10, 'Your booking \"Conflict with peers\" has been marked for reschedule. Please check new time slots.', '2025-09-09 14:30:00.000000', 75, 'Adm0008'),
(11, 'Your booking \"Financial stress\" has been marked for reschedule. Please check new time slots.', '2025-09-09 12:30:00.000000', 85, 'Adm0009'),
(12, 'Your booking \"Sleep cycle issue\" has been marked for reschedule. Please check new time slots.', '2025-09-09 14:30:00.000000', 95, 'Adm0010');

-- --------------------------------------------------------

--
-- Table structure for table `notification_system`
--

CREATE TABLE `notification_system` (
  `notification_id` int(255) NOT NULL,
  `notification_date_time` datetime(6) NOT NULL,
  `booking_id` int(255) NOT NULL,
  `read_status` varchar(255) NOT NULL,
  `system_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification_system`
--

INSERT INTO `notification_system` (`notification_id`, `notification_date_time`, `booking_id`, `read_status`, `system_id`) VALUES
(1, '2025-09-05 09:45:00.000000', 1, 'unread', 1),
(2, '2025-09-07 09:15:00.000000', 3, 'unread', 1),
(3, '2025-09-09 14:45:00.000000', 5, 'unread', 1),
(4, '2025-09-10 12:45:00.000000', 6, 'unread', 1),
(5, '2025-09-12 10:15:00.000000', 8, 'unread', 1),
(6, '2025-09-14 08:45:00.000000', 10, 'unread', 1),
(7, '2025-09-05 08:45:00.000000', 11, 'unread', 1),
(8, '2025-09-07 11:15:00.000000', 13, 'unread', 1),
(9, '2025-09-09 10:15:00.000000', 15, 'unread', 1),
(10, '2025-09-10 09:15:00.000000', 16, 'unread', 1),
(11, '2025-09-12 13:45:00.000000', 18, 'unread', 1),
(12, '2025-09-13 10:45:00.000000', 19, 'unread', 1),
(13, '2025-09-05 08:45:00.000000', 21, 'unread', 1),
(14, '2025-09-07 14:45:00.000000', 23, 'unread', 1),
(15, '2025-09-08 10:45:00.000000', 24, 'unread', 1),
(16, '2025-09-10 09:15:00.000000', 26, 'unread', 1),
(17, '2025-09-12 10:15:00.000000', 28, 'unread', 1),
(18, '2025-09-13 14:15:00.000000', 29, 'unread', 1),
(19, '2025-09-14 08:45:00.000000', 30, 'unread', 1),
(20, '2025-09-05 10:45:00.000000', 31, 'unread', 1),
(21, '2025-09-07 14:45:00.000000', 33, 'unread', 1),
(22, '2025-09-08 08:45:00.000000', 34, 'unread', 1),
(23, '2025-09-10 11:15:00.000000', 36, 'unread', 1),
(24, '2025-09-12 14:15:00.000000', 38, 'unread', 1),
(25, '2025-09-13 09:15:00.000000', 39, 'unread', 1),
(26, '2025-09-14 15:45:00.000000', 40, 'unread', 1),
(27, '2025-09-05 07:45:00.000000', 41, 'unread', 1),
(28, '2025-09-07 09:15:00.000000', 43, 'unread', 1),
(29, '2025-09-08 13:45:00.000000', 44, 'unread', 1),
(30, '2025-09-10 14:45:00.000000', 46, 'unread', 1),
(31, '2025-09-12 08:45:00.000000', 48, 'unread', 1),
(32, '2025-09-13 15:45:00.000000', 49, 'unread', 1),
(33, '2025-09-14 14:15:00.000000', 50, 'unread', 1),
(34, '2025-09-05 08:45:00.000000', 51, 'unread', 1),
(35, '2025-09-07 14:45:00.000000', 53, 'unread', 1),
(36, '2025-09-08 10:45:00.000000', 54, 'unread', 1),
(37, '2025-09-10 10:15:00.000000', 56, 'unread', 1),
(38, '2025-09-12 09:15:00.000000', 58, 'unread', 1),
(39, '2025-09-13 14:15:00.000000', 59, 'unread', 1),
(40, '2025-09-14 08:15:00.000000', 60, 'unread', 1),
(41, '2025-09-05 08:15:00.000000', 61, 'unread', 1),
(42, '2025-09-07 09:45:00.000000', 63, 'unread', 1),
(43, '2025-09-08 13:45:00.000000', 64, 'unread', 1),
(44, '2025-09-10 10:45:00.000000', 66, 'unread', 1),
(45, '2025-09-12 09:15:00.000000', 68, 'unread', 1),
(46, '2025-09-13 14:15:00.000000', 69, 'unread', 1),
(47, '2025-09-14 09:45:00.000000', 70, 'unread', 1),
(48, '2025-09-05 08:15:00.000000', 71, 'unread', 1),
(49, '2025-09-07 09:15:00.000000', 73, 'unread', 1),
(50, '2025-09-08 10:45:00.000000', 74, 'unread', 1),
(51, '2025-09-10 08:45:00.000000', 76, 'unread', 1),
(52, '2025-09-12 10:15:00.000000', 78, 'unread', 1),
(53, '2025-09-13 15:45:00.000000', 79, 'unread', 1),
(54, '2025-09-14 08:45:00.000000', 80, 'unread', 1),
(55, '2025-09-05 10:45:00.000000', 81, 'unread', 1),
(56, '2025-09-07 14:45:00.000000', 83, 'unread', 1),
(57, '2025-09-08 09:45:00.000000', 84, 'unread', 1),
(58, '2025-09-10 15:45:00.000000', 86, 'unread', 1),
(59, '2025-09-12 14:15:00.000000', 88, 'unread', 1),
(60, '2025-09-13 09:15:00.000000', 89, 'unread', 1),
(61, '2025-09-14 10:45:00.000000', 90, 'unread', 1),
(62, '2025-09-05 08:45:00.000000', 91, 'unread', 1),
(63, '2025-09-07 13:45:00.000000', 93, 'unread', 1),
(64, '2025-09-08 09:45:00.000000', 94, 'unread', 1),
(65, '2025-09-10 09:15:00.000000', 96, 'unread', 1),
(66, '2025-09-12 11:15:00.000000', 98, 'unread', 1),
(67, '2025-09-13 09:15:00.000000', 99, 'unread', 1),
(68, '2025-09-14 13:45:00.000000', 100, 'unread', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `reply_id` int(255) NOT NULL,
  `comment_id` int(255) NOT NULL,
  `reply_message` text NOT NULL,
  `reply_date_time` datetime(6) NOT NULL,
  `reply_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reply`
--

INSERT INTO `reply` (`reply_id`, `comment_id`, `reply_message`, `reply_date_time`, `reply_status`) VALUES
(1, 1, 'I know right! First days are always nerve-wracking 😢', '2025-10-10 10:15:00.000000', 'approved'),
(2, 2, 'Thanks! It’s such a relief to find good friends 😊', '2025-09-29 14:30:00.000000', 'approved'),
(3, 3, 'Yes, sometimes I have to stand for 30 mins just to get a seat 😩', '2025-09-20 09:50:00.000000', 'approved'),
(4, 4, 'Congrats again! Your experiment sounds exciting 🎉', '2025-10-08 17:40:00.000000', 'approved'),
(5, 5, 'I hope your exams go well too! You’ve got this!', '2025-09-24 21:00:00.000000', 'approved'),
(6, 6, 'Totally! Nasi lemak is life 😋', '2025-09-28 08:20:00.000000', 'approved'),
(7, 7, 'Dedication pays off! 12 hours is intense 😅', '2025-09-24 13:15:00.000000', 'approved'),
(8, 8, 'Distance makes you appreciate family even more ❤️', '2025-09-30 23:40:00.000000', 'approved'),
(9, 9, 'Agreed! The cafe ambiance really helps focus ☕', '2025-10-09 11:05:00.000000', 'approved'),
(10, 10, 'Deadlines are brutal, but we survive 😩', '2025-09-28 18:45:00.000000', 'approved'),
(11, 11, 'Nice! Glad your lecturer is so motivating 😊', '2025-09-16 09:00:00.000000', 'approved'),
(12, 12, 'Oh no! Hope you had an umbrella 😅', '2025-09-18 12:30:00.000000', 'rejected'),
(13, 13, 'That feeling when experiments finally work is amazing 🌱', '2025-09-21 15:20:00.000000', 'approved'),
(14, 14, 'Homesickness is tough, but you’re not alone ❤️', '2025-10-04 20:30:00.000000', 'approved'),
(15, 15, 'Study groups are always more fun together!', '2025-10-01 14:10:00.000000', 'approved'),
(16, 16, 'Sleep is gold 😴 Don’t forget to rest!', '2025-09-24 22:40:00.000000', 'approved'),
(17, 17, 'Futsal champions! Congrats again 🏆', '2025-09-22 16:25:00.000000', 'approved'),
(18, 18, 'WiFi issues are the worst 😩', '2025-10-10 09:35:00.000000', 'rejected'),
(19, 19, 'Group coordination is always tricky 😓', '2025-10-07 11:30:00.000000', 'approved'),
(20, 20, 'Lucky you! Inspiring lectures make learning enjoyable 😊', '2025-09-22 15:15:00.000000', 'approved'),
(21, 21, 'Festivals always boost my mood 🎉', '0000-00-00 00:00:00.000000', 'approved'),
(22, 22, 'Take deep breaths, you’ll ace your finals!', '2025-09-28 10:25:00.000000', 'approved'),
(23, 23, 'Gym gains! Keep it up 💪', '2025-09-29 18:30:00.000000', 'approved'),
(24, 24, 'Deadlines piling up is rough 😩', '2025-09-18 21:10:00.000000', 'rejected'),
(25, 25, 'Can’t wait to try it out too! 😄', '2025-09-19 12:15:00.000000', 'approved'),
(26, 26, 'Hang in there, you’ll get through the assignments!', '2025-10-02 19:30:00.000000', 'approved'),
(27, 27, 'Caffeine really is a lifesaver ☕', '2025-10-03 09:45:00.000000', 'approved'),
(28, 28, 'Lost notes are a nightmare, hope you recover them!', '0000-00-00 00:00:00.000000', 'approved'),
(29, 29, 'Study buddies make everything better 😊', '2025-09-27 16:30:00.000000', 'approved'),
(30, 30, 'Messy dorms are part of the experience 😅', '2025-09-21 20:05:00.000000', 'approved'),
(31, 31, 'Morning jogs set the tone for the day 🌅', '2025-09-21 07:40:00.000000', 'approved'),
(32, 32, 'Missing the bus happens to me too 😭', '2025-09-17 08:50:00.000000', 'approved'),
(33, 33, 'Practice tests feel amazing when you ace them!', '2025-10-06 15:10:00.000000', 'approved'),
(35, 17, 'Wow bro! You dun it!', '2025-09-22 22:00:05.000000', 'pending'),
(36, 32, 'Yo bro, feel bad for u!', '2025-09-22 22:15:21.000000', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `school_id` int(255) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `school_logo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`school_id`, `school_name`, `school_logo`) VALUES
(1, 'University of Malaya (UM)', 'um_logo.png'),
(2, 'Universiti Teknologi Malaysia (UTM)', 'utm_logo.png'),
(3, 'Universiti Putra Malaysia (UPM)', 'upm_logo.png'),
(4, 'Universiti Kebangsaan Malaysia (UKM)', 'ukm_logo.png'),
(5, 'Universiti Sains Malaysia (USM)', 'usm_logo.png'),
(6, 'Universiti Teknologi MARA (UiTM)', 'uitm_logo.png'),
(7, 'Universiti Malaysia Sarawak (UNIMAS)', 'unimas_logo.png'),
(8, 'Universiti Malaysia Sabah (UMS)', 'ums_logo.png'),
(9, 'Multimedia University (MMU)', 'mmu_logo.png'),
(10, 'Asia Pacific University (APU)', 'apu_logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` varchar(255) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `student_password` varchar(255) NOT NULL,
  `student_account_status` varchar(255) NOT NULL,
  `last_login_time` time(6) NOT NULL,
  `last_login_date` date NOT NULL,
  `school_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_name`, `student_password`, `student_account_status`, `last_login_time`, `last_login_date`, `school_id`) VALUES
('MMU9001', 'Syazwan Aziz', 'pass123', 'active', '19:00:00.000000', '2025-09-01', 9),
('MMU9002', 'Heng Yi Xian', 'pass123', 'active', '19:05:00.000000', '2025-09-01', 9),
('MMU9003', 'Amira Rosli', 'pass123', 'active', '19:10:00.000000', '2025-09-01', 9),
('MMU9004', 'Chen Li Wei', 'pass123', 'active', '19:15:00.000000', '2025-09-01', 9),
('MMU9005', 'Mohd Arif', 'pass123', 'active', '19:20:00.000000', '2025-09-01', 9),
('MMU9006', 'Lydia Tan', 'pass123', 'active', '19:25:00.000000', '2025-09-01', 9),
('MMU9007', 'Zulkifli Hassan', 'pass123', 'active', '19:30:00.000000', '2025-09-01', 9),
('MMU9008', 'Chong Wei Han', 'pass123', 'active', '19:35:00.000000', '2025-09-01', 9),
('MMU9009', 'Nur Aisyah', 'pass123', 'active', '19:40:00.000000', '2025-09-01', 9),
('MMU9010', 'Hariz Naim', 'pass123', 'active', '19:45:00.000000', '2025-09-01', 9),
('TP0001', 'Adam Lee', 'pass123', 'active', '14:16:13.000000', '2025-09-21', 10),
('TP0002', 'Nur Aina', 'pass123', 'active', '22:06:34.000000', '2025-09-23', 10),
('TP0003', 'James Wong', 'pass123', 'active', '20:10:00.000000', '2025-09-01', 10),
('TP0004', 'Chong Li Mei', 'pass123', 'active', '20:15:00.000000', '2025-09-01', 10),
('TP0005', 'Suresh Kumar', 'pass123', 'active', '20:20:00.000000', '2025-09-01', 10),
('TP0006', 'Farah Hanis', 'pass123', 'active', '20:25:00.000000', '2025-09-01', 10),
('TP0007', 'Mohd Irfan', 'pass123', 'active', '20:30:00.000000', '2025-09-01', 10),
('TP0008', 'Ong Jia Wen', 'pass123', 'active', '20:35:00.000000', '2025-09-01', 10),
('TP0009', 'Khairul Fahmi', 'pass123', 'active', '20:40:00.000000', '2025-09-01', 10),
('TP0010', 'Melissa Chong', 'pass123', 'active', '20:45:00.000000', '2025-09-01', 10),
('UiTM6001', 'Hafiz Rahman', 'pass123', 'active', '17:00:00.000000', '2025-09-01', 6),
('UiTM6002', 'Nor Aida', 'pass123', 'active', '17:05:00.000000', '2025-09-01', 6),
('UiTM6003', 'Chong Jia Wei', 'pass123', 'active', '17:10:00.000000', '2025-09-01', 6),
('UiTM6004', 'Daniel Ong', 'pass123', 'active', '17:15:00.000000', '2025-09-01', 6),
('UiTM6005', 'Yasmin Azhari', 'pass123', 'active', '17:20:00.000000', '2025-09-01', 6),
('UiTM6006', 'Abu Bakar', 'pass123', 'active', '17:25:00.000000', '2025-09-01', 6),
('UiTM6007', 'Lim Zi Hao', 'pass123', 'active', '17:30:00.000000', '2025-09-01', 6),
('UiTM6008', 'Sabrina Mohd', 'pass123', 'active', '17:35:00.000000', '2025-09-01', 6),
('UiTM6009', 'Nabilah Hassan', 'pass123', 'active', '17:40:00.000000', '2025-09-01', 6),
('UiTM6010', 'Khalid Yusof', 'pass123', 'active', '17:45:00.000000', '2025-09-01', 6),
('UKM4001', 'Khairul Anwar', 'pass123', 'active', '15:00:00.000000', '2025-09-01', 4),
('UKM4002', 'Amirah Zainal', 'pass123', 'active', '15:05:00.000000', '2025-09-01', 4),
('UKM4003', 'Ong Wei Jie', 'pass123', 'active', '15:10:00.000000', '2025-09-01', 4),
('UKM4004', 'Rashid Ali', 'pass123', 'active', '15:15:00.000000', '2025-09-01', 4),
('UKM4005', 'Chong Kai Min', 'pass123', 'active', '15:20:00.000000', '2025-09-01', 4),
('UKM4006', 'Nora Binti Yusof', 'pass123', 'active', '15:25:00.000000', '2025-09-01', 4),
('UKM4007', 'Lim Xin Yi', 'pass123', 'active', '15:30:00.000000', '2025-09-01', 4),
('UKM4008', 'Azlan Hakim', 'pass123', 'active', '15:35:00.000000', '2025-09-01', 4),
('UKM4009', 'Leong Kar Hui', 'pass123', 'active', '15:40:00.000000', '2025-09-01', 4),
('UKM4010', 'Rosmah Hassan', 'pass123', 'active', '15:45:00.000000', '2025-09-01', 4),
('UM1001', 'Ali Bin Ahmad', 'pass123', 'active', '10:00:00.000000', '2025-09-01', 1),
('UM1002', 'Siti Nurhaliza', 'pass123', 'active', '10:10:00.000000', '2025-09-01', 1),
('UM1003', 'Tan Wei Ming', 'pass123', 'active', '10:20:00.000000', '2025-09-01', 1),
('UM1004', 'Aisyah Binti Omar', 'pass123', 'active', '10:30:00.000000', '2025-09-01', 1),
('UM1005', 'Raj Kumar', 'pass123', 'active', '10:40:00.000000', '2025-09-01', 1),
('UM1006', 'Nurul Izzah', 'pass123', 'active', '10:50:00.000000', '2025-09-01', 1),
('UM1007', 'Chong Mei Ling', 'pass123', 'active', '11:00:00.000000', '2025-09-01', 1),
('UM1008', 'Mohd Faiz', 'pass123', 'active', '11:10:00.000000', '2025-09-01', 1),
('UM1009', 'Lim Jia Hui', 'pass123', 'active', '11:20:00.000000', '2025-09-01', 1),
('UM1010', 'Zul Ariffin', 'pass123', 'active', '11:30:00.000000', '2025-09-01', 1),
('UMS8001', 'Nur Syahira', 'pass123', 'active', '18:00:00.000000', '2025-09-01', 8),
('UMS8002', 'Roslan Ibrahim', 'pass123', 'active', '18:05:00.000000', '2025-09-01', 8),
('UMS8003', 'Chee Yong Sheng', 'pass123', 'active', '18:10:00.000000', '2025-09-01', 8),
('UMS8004', 'Ismail Omar', 'pass123', 'active', '18:15:00.000000', '2025-09-01', 8),
('UMS8005', 'Tan Wei Ling', 'pass123', 'active', '18:20:00.000000', '2025-09-01', 8),
('UMS8006', 'Fadzil Hamid', 'pass123', 'active', '18:25:00.000000', '2025-09-01', 8),
('UMS8007', 'Stephanie Wong', 'pass123', 'active', '18:30:00.000000', '2025-09-01', 8),
('UMS8008', 'Nor Hidayah', 'pass123', 'active', '18:35:00.000000', '2025-09-01', 8),
('UMS8009', 'Koh Jia Ming', 'pass123', 'active', '18:40:00.000000', '2025-09-01', 8),
('UMS8010', 'Ahmad Rafi', 'pass123', 'active', '18:45:00.000000', '2025-09-01', 8),
('UNIMAS7001', 'Rahim Bujang', 'pass123', 'active', '12:00:00.000000', '2025-09-01', 7),
('UNIMAS7002', 'Siti Mariani', 'pass123', 'active', '12:05:00.000000', '2025-09-01', 7),
('UNIMAS7003', 'Chai Tze Ming', 'pass123', 'active', '12:10:00.000000', '2025-09-01', 7),
('UNIMAS7004', 'Syahrul Nizam', 'pass123', 'active', '12:15:00.000000', '2025-09-01', 7),
('UNIMAS7005', 'Jessica Ting', 'pass123', 'active', '12:20:00.000000', '2025-09-01', 7),
('UNIMAS7006', 'Mohd Ikmal', 'pass123', 'active', '12:25:00.000000', '2025-09-01', 7),
('UNIMAS7007', 'Ng Kok Hwa', 'pass123', 'active', '12:30:00.000000', '2025-09-01', 7),
('UNIMAS7008', 'Faridah Zain', 'pass123', 'active', '12:35:00.000000', '2025-09-01', 7),
('UNIMAS7009', 'Lee Chia Hui', 'pass123', 'active', '12:40:00.000000', '2025-09-01', 7),
('UNIMAS7010', 'Mohd Zul', 'pass123', 'active', '12:45:00.000000', '2025-09-01', 7),
('UPM3001', 'Zara Khadijah', 'pass123', 'active', '14:00:00.000000', '2025-09-01', 3),
('UPM3002', 'Muhammad Firdaus', 'pass123', 'active', '14:05:00.000000', '2025-09-01', 3),
('UPM3003', 'Low Wei Shan', 'pass123', 'active', '14:10:00.000000', '2025-09-01', 3),
('UPM3004', 'Nadia Rahim', 'pass123', 'active', '14:15:00.000000', '2025-09-01', 3),
('UPM3005', 'Ravi Chandran', 'pass123', 'active', '14:20:00.000000', '2025-09-01', 3),
('UPM3006', 'Fatimah Zahra', 'pass123', 'active', '14:25:00.000000', '2025-09-01', 3),
('UPM3007', 'Cheong Siew Ling', 'pass123', 'active', '14:30:00.000000', '2025-09-01', 3),
('UPM3008', 'Hakim Roslan', 'pass123', 'active', '14:35:00.000000', '2025-09-01', 3),
('UPM3009', 'Nur Syafiqah', 'pass123', 'active', '14:40:00.000000', '2025-09-01', 3),
('UPM3010', 'Tan Chun Kit', 'pass123', 'active', '14:45:00.000000', '2025-09-01', 3),
('USM5001', 'Hanisah Binti Rahman', 'pass123', 'active', '08:00:00.000000', '2025-09-01', 5),
('USM5002', 'Goh Yee Ling', 'pass123', 'active', '08:05:00.000000', '2025-09-01', 5),
('USM5003', 'Syed Ahmad', 'pass123', 'active', '08:10:00.000000', '2025-09-01', 5),
('USM5004', 'Wong Zi Xuan', 'pass123', 'active', '08:15:00.000000', '2025-09-01', 5),
('USM5005', 'Nur Fatin Nabila', 'pass123', 'active', '08:20:00.000000', '2025-09-01', 5),
('USM5006', 'Kumaravel', 'pass123', 'active', '08:25:00.000000', '2025-09-01', 5),
('USM5007', 'Melissa Tan', 'pass123', 'active', '08:30:00.000000', '2025-09-01', 5),
('USM5008', 'Ahmad Zulfikar', 'pass123', 'active', '08:35:00.000000', '2025-09-01', 5),
('USM5009', 'Lee Mei Xin', 'pass123', 'active', '08:40:00.000000', '2025-09-01', 5),
('USM5010', 'Sharifah Aini', 'pass123', 'active', '08:45:00.000000', '2025-09-01', 5),
('UTM2001', 'Amirul Hakim', 'pass123', 'active', '09:00:00.000000', '2025-09-01', 2),
('UTM2002', 'Liyana Binti Azman', 'pass123', 'active', '09:05:00.000000', '2025-09-01', 2),
('UTM2003', 'Ganesh Subramaniam', 'pass123', 'active', '09:10:00.000000', '2025-09-01', 2),
('UTM2004', 'Wong Kok Leong', 'pass123', 'active', '09:15:00.000000', '2025-09-01', 2),
('UTM2005', 'Ainul Mardhiah', 'pass123', 'active', '09:20:00.000000', '2025-09-01', 2),
('UTM2006', 'Syafiq Iskandar', 'pass123', 'active', '09:25:00.000000', '2025-09-01', 2),
('UTM2007', 'Ho Jia Xian', 'pass123', 'active', '09:30:00.000000', '2025-09-01', 2),
('UTM2008', 'Farah Amira', 'pass123', 'active', '09:35:00.000000', '2025-09-01', 2),
('UTM2009', 'Mohd Danish', 'pass123', 'active', '09:40:00.000000', '2025-09-01', 2),
('UTM2010', 'Lim Kok Seng', 'pass123', 'active', '09:45:00.000000', '2025-09-01', 2);

-- --------------------------------------------------------

--
-- Table structure for table `system`
--

CREATE TABLE `system` (
  `system_id` int(255) NOT NULL,
  `system_message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system`
--

INSERT INTO `system` (`system_id`, `system_message`) VALUES
(1, 'Your booking has been successfully submitted and confirmed.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `admin - school` (`school_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `booking - counselor` (`counselor_id`),
  ADD KEY `booking_student` (`student_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment - confession` (`confession_id`);

--
-- Indexes for table `confession`
--
ALTER TABLE `confession`
  ADD PRIMARY KEY (`confession_id`),
  ADD KEY `confession - student` (`student_id`);

--
-- Indexes for table `counselor`
--
ALTER TABLE `counselor`
  ADD PRIMARY KEY (`counselor_id`),
  ADD KEY `counselor - school` (`school_id`);

--
-- Indexes for table `feeling`
--
ALTER TABLE `feeling`
  ADD PRIMARY KEY (`feeling_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_id`),
  ADD KEY `login - student` (`student_id`);

--
-- Indexes for table `notification_admin`
--
ALTER TABLE `notification_admin`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `notification_admin - booking` (`booking_id`),
  ADD KEY `notification_admin - admin` (`admin_id`);

--
-- Indexes for table `notification_system`
--
ALTER TABLE `notification_system`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `notification_system - system` (`system_id`),
  ADD KEY `notification_system - booking` (`booking_id`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `reply - comment` (`comment_id`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`school_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `student - school` (`school_id`);

--
-- Indexes for table `system`
--
ALTER TABLE `system`
  ADD PRIMARY KEY (`system_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `confession`
--
ALTER TABLE `confession`
  MODIFY `confession_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `counselor`
--
ALTER TABLE `counselor`
  MODIFY `counselor_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `feeling`
--
ALTER TABLE `feeling`
  MODIFY `feeling_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `notification_admin`
--
ALTER TABLE `notification_admin`
  MODIFY `message_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notification_system`
--
ALTER TABLE `notification_system`
  MODIFY `notification_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `reply_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `school_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `system`
--
ALTER TABLE `system`
  MODIFY `system_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin - school` FOREIGN KEY (`school_id`) REFERENCES `school` (`school_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking - counselor` FOREIGN KEY (`counselor_id`) REFERENCES `counselor` (`counselor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment - confession` FOREIGN KEY (`confession_id`) REFERENCES `confession` (`confession_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `confession`
--
ALTER TABLE `confession`
  ADD CONSTRAINT `confession - student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `counselor`
--
ALTER TABLE `counselor`
  ADD CONSTRAINT `counselor - school` FOREIGN KEY (`school_id`) REFERENCES `school` (`school_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login - student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification_admin`
--
ALTER TABLE `notification_admin`
  ADD CONSTRAINT `notification_admin - admin` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_admin - booking` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification_system`
--
ALTER TABLE `notification_system`
  ADD CONSTRAINT `notification_system - booking` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_system - system` FOREIGN KEY (`system_id`) REFERENCES `system` (`system_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply - comment` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`comment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student - school` FOREIGN KEY (`school_id`) REFERENCES `school` (`school_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
