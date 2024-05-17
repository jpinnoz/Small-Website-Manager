-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 17, 2024 at 07:09 AM
-- Server version: 10.11.6-MariaDB-0+deb12u1
-- PHP Version: 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `SWM`
--
CREATE DATABASE IF NOT EXISTS `SWM` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `SWM`;

-- --------------------------------------------------------

--
-- Table structure for table `Cust_Pages`
--

CREATE TABLE `Cust_Pages` (
  `Page_ID` int(11) NOT NULL,
  `Page_Iteration` int(11) NOT NULL,
  `Parent_Iteration` int(11) NOT NULL DEFAULT 0,
  `Title` text NOT NULL,
  `Body` text NOT NULL,
  `Last_Modified` datetime NOT NULL DEFAULT current_timestamp(),
  `Last_Author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Cust_Pages`
--

INSERT INTO `Cust_Pages` (`Page_ID`, `Page_Iteration`, `Parent_Iteration`, `Title`, `Body`, `Last_Modified`, `Last_Author`) VALUES
(1, 1, 0, 'Welcome', 'Welcome to version 3 of my Homepage. Test Test', '2024-03-11 13:02:44', 0),
(1, 2, 1, 'Welcome', 'Welcome to version 3 of my Homepage. Test Test', '2024-03-11 12:49:59', 1),
(1, 3, 2, 'Welcome', 'Welcome to version 3 of my Homepage. Test Test', '2024-03-11 12:13:03', 1),
(1, 4, 3, 'Welcome', 'Test 2', '2024-03-11 12:43:13', 1),
(1, 5, 4, 'Welcome', 'Test 3', '2024-03-11 12:49:37', 1),
(1, 6, 5, 'Welcome', 'Test 6', '2024-03-11 12:50:26', 1),
(1, 7, 6, 'Welcome', 'Test 7', '2024-03-11 12:52:07', 1),
(1, 8, 7, 'Welcome', 'Test 9', '2024-03-11 12:59:40', 1),
(1, 9, 0, 'Welcome', 'Testarooni', '2024-03-11 13:00:11', 1),
(1, 10, 1, 'Welcome', 'Testa', '2024-03-11 13:02:10', 1),
(1, 11, 10, 'Welcome', 'Testa', '2024-03-11 13:02:37', 1),
(1, 12, 1, 'Welcome', 'Cool', '2024-03-11 13:02:53', 1),
(1, 13, 12, 'Welcome', 'Cool 2', '2024-03-11 13:05:21', 1),
(1, 14, 13, 'Welcome', 'Cool 2', '2024-05-06 16:01:05', 35),
(1, 15, 14, 'Welcome', 'Cool 2', '2024-05-06 16:24:39', 35),
(2, 1, 0, 'Page 1', 'Testarooni', '2024-05-06 16:25:01', 35),
(1, 16, 15, 'Welcome', 'Cool 2', '2024-05-10 15:52:58', 35),
(2, 2, 1, 'Page 1', 'Testarooni 2', '2024-05-10 15:58:42', 35),
(3, 1, 0, 'Page 2', 'Joe lives here', '2024-05-10 16:19:45', 35),
(3, 2, 1, '1', '1', '2024-05-10 16:20:04', 35),
(1, 17, 16, 'Welcome', 'Cool 2', '2024-05-10 16:43:09', 35),
(1, 18, 17, 'Welcome', 'Cool 222', '2024-05-10 23:12:21', 35),
(1, 19, 18, 'Welcome', 'Cool 222', '2024-05-10 23:12:30', 35),
(4, 1, 0, 'Page 3', 'Bingo', '2024-05-10 23:14:55', 35),
(4, 2, 1, 'Page 3', 'Bingo Bingo', '2024-05-10 23:15:13', 35),
(4, 3, 2, 'Page 3', 'Bingo Bingo', '2024-05-10 23:15:24', 35),
(4, 4, 3, 'Page 3', 'Bingo Bingo', '2024-05-10 23:16:40', 35),
(4, 5, 4, 'Page 3', 'Bingo Bingo', '2024-05-10 23:23:39', 35),
(4, 6, 5, 'Page 3', 'Bingo Bingo', '2024-05-10 23:31:14', 35),
(4, 6, 5, 'Page 3', 'Bingo Bingo', '2024-05-10 23:31:19', 35),
(4, 7, 6, 'Page 3', 'Bingo Bingo', '2024-05-10 23:32:51', 35),
(4, 8, 7, 'Page 3', 'Bingo Bingo', '2024-05-10 23:34:27', 35),
(4, 9, 8, 'Page 3', 'Bingo Bingo', '2024-05-10 23:40:31', 35),
(4, 10, 9, 'Page 3', 'Bingo Bingo', '2024-05-10 23:40:46', 35),
(4, 11, 10, 'Page 3', 'Bingo Bingo', '2024-05-10 23:40:57', 35),
(4, 12, 11, 'Page 3', 'Bingo Bingo', '2024-05-10 23:41:06', 35),
(4, 13, 12, 'Page 3', 'Bingo Bingo', '2024-05-10 23:42:06', 35),
(4, 14, 13, 'Page 3', 'Bingo Bingo', '2024-05-10 23:43:29', 35),
(4, 15, 14, 'Page 3', 'Bingo Bingo', '2024-05-10 23:43:39', 35),
(4, 16, 15, 'Page 3', 'Bingo Bingo', '2024-05-10 23:43:44', 35),
(4, 17, 16, 'Page 3', 'Bingo Bingo', '2024-05-10 23:43:47', 35),
(1, 20, 19, 'Welcome', 'Cool 222', '2024-05-10 23:44:47', 35);

-- --------------------------------------------------------

--
-- Table structure for table `Cust_Pages_DATA`
--

CREATE TABLE `Cust_Pages_DATA` (
  `Page_ID` int(11) NOT NULL,
  `Page_Iteration` int(11) NOT NULL,
  `Active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Cust_Pages_DATA`
--

INSERT INTO `Cust_Pages_DATA` (`Page_ID`, `Page_Iteration`, `Active`) VALUES
(1, 20, 1),
(2, 2, 1),
(3, 1, 0),
(4, 17, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Globals`
--

CREATE TABLE `Globals` (
  `Global` varchar(1000) NOT NULL,
  `Value` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Globals`
--

INSERT INTO `Globals` (`Global`, `Value`) VALUES
('Website Name', 'Small Website Manager'),
('URL', 'https://www.joepinzone.com');

-- --------------------------------------------------------

--
-- Table structure for table `Logging`
--

CREATE TABLE `Logging` (
  `UserID` int(11) NOT NULL,
  `Logged_On` datetime NOT NULL,
  `Logged_Off` datetime NOT NULL,
  `Auth_Level` tinyint(4) NOT NULL,
  `IP_Address` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Menus`
--

CREATE TABLE `Menus` (
  `ID` int(11) NOT NULL,
  `Description` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `News`
--

CREATE TABLE `News` (
  `ID` int(11) NOT NULL,
  `Heading` varchar(1000) NOT NULL,
  `Body` text NOT NULL,
  `Author` int(11) NOT NULL,
  `DateTime` datetime NOT NULL,
  `Last_Edited` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `News`
--

INSERT INTO `News` (`ID`, `Heading`, `Body`, `Author`, `DateTime`, `Last_Edited`) VALUES
(1, 'First Post! ;-D', 'Welcome to my website!', 1, '2023-08-31 14:28:05', '2023-08-31 14:28:52'),
(2, 'Second Post... :-(', 'Hello Again!', 1, '2023-08-31 15:39:21', '2023-08-31 15:39:21'),
(3, 'Microsoft Edge is now on Linux', 'Wow', 1, '2023-09-08 15:57:37', '2023-09-08 15:58:50');

-- --------------------------------------------------------

--
-- Table structure for table `News_Comments`
--

CREATE TABLE `News_Comments` (
  `ID` int(11) NOT NULL,
  `News_Article` int(11) NOT NULL,
  `Body` text NOT NULL,
  `Author` int(11) NOT NULL,
  `DateTime` datetime NOT NULL,
  `Last_Edited` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `SubMenus`
--

CREATE TABLE `SubMenus` (
  `MenuID` int(11) NOT NULL,
  `LinkID` int(11) NOT NULL,
  `Page_ID` int(11) NOT NULL DEFAULT 0,
  `Menu_Entry` varchar(20) NOT NULL,
  `Title` varchar(500) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `SubMenus`
--

INSERT INTO `SubMenus` (`MenuID`, `LinkID`, `Page_ID`, `Menu_Entry`, `Title`, `Active`) VALUES
(1, 1, 1, 'Home', 'index.php', 1),
(1, 3, 0, 'News', 'news.php', 1),
(1, 4, 2, 'Page 1', 'index.php?page=Page 1', 1),
(1, 5, 3, '1', 'index.php?page=Page 2', 0),
(1, 6, 4, 'Page 3b', 'index.php?page=Page 3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `SubMenusData`
--

CREATE TABLE `SubMenusData` (
  `Type` varchar(500) NOT NULL,
  `Default Menu Title` varchar(20) NOT NULL,
  `LinkData` text NOT NULL,
  `GetData` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `SubMenusData`
--

INSERT INTO `SubMenusData` (`Type`, `Default Menu Title`, `LinkData`, `GetData`) VALUES
('Custom Page', 'New Page', 'index.php?page=', 1),
('Forums Module', 'Forums', 'forums.php', 0),
('News Module', 'News', 'news.php', 0);

-- --------------------------------------------------------

--
-- Table structure for table `SubMenus_BACKUP`
--

CREATE TABLE `SubMenus_BACKUP` (
  `Page_ID` int(11) NOT NULL,
  `Page_Iteration` int(11) NOT NULL,
  `Menu_ID` int(11) NOT NULL,
  `Link_ID` int(11) NOT NULL,
  `Menu_Entry` varchar(20) NOT NULL,
  `Title` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `ID` int(11) NOT NULL,
  `First_Name` varchar(250) NOT NULL,
  `Last_Name` varchar(250) NOT NULL,
  `eMail` varchar(1000) NOT NULL,
  `User_Name` varchar(1000) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Activate_Pass` varchar(100) DEFAULT NULL,
  `Change_Pass` varchar(100) DEFAULT NULL,
  `Change_Pass_Expire` datetime DEFAULT NULL,
  `Forgot_Pass` varchar(100) DEFAULT NULL,
  `Forgot_Pass_Expire` datetime DEFAULT NULL,
  `DateTime_Joined` datetime NOT NULL,
  `Last_Logged` datetime NOT NULL DEFAULT current_timestamp(),
  `Authority_Level` tinyint(4) DEFAULT 1,
  `Active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`ID`, `First_Name`, `Last_Name`, `eMail`, `User_Name`, `Password`, `Activate_Pass`, `Change_Pass`, `Change_Pass_Expire`, `Forgot_Pass`, `Forgot_Pass_Expire`, `DateTime_Joined`, `Last_Logged`, `Authority_Level`, `Active`) VALUES
(35, 'First_Name', 'Family_Name', 'jpinnoz@yahoo.com', 'admin', '$2y$10$eZK.6hAn.eqdDx1uuKU/tee4jzLRWzknnCgvsNN7DQh9rM20V4Zey', '$2y$10$BFBfu5lIRrr5oYVouelvO.XYfxGx3vQVj2ZCNut1yRNtKdwOck6Nq', '$2y$10$Yr34a2gba0mWN9BJMKme.e5vx.Z8Bdw.L2lqrGvqc75atvCBphUCq', '2024-04-30 16:48:43', NULL, NULL, '2024-04-02 20:52:43', '2024-05-11 18:50:18', 3, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
