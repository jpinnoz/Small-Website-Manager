-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 16, 2024 at 07:48 AM
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
(1, 1, 0, 'Welcome', 'This is the homepage!', '2024-05-17 17:21:52', 35),
(2, 1, 0, 'Page 2', 'Testaroo!', '2024-05-17 17:29:01', 35),
(2, 2, 1, 'Page 2', 'Version 2', '2024-05-17 17:29:32', 35),
(2, 3, 1, 'Page 2', 'Testaroo! Testaroo!', '2024-05-17 17:29:54', 35),
(2, 4, 1, 'Page 2', 'Testaroo! Yeah!', '2024-05-18 10:49:34', 35),
(2, 5, 4, 'Page 2', 'Testaroo! Double Yeah!', '2024-05-19 13:42:06', 35),
(3, 1, 0, 'Page 3', 'Testin!', '2024-05-19 13:29:44', 35),
(4, 1, 0, 'Page 4', 'Page 4', '2024-05-19 13:35:50', 35),
(5, 1, 0, 'Page 5', 'Batman was here!', '2024-06-12 19:00:20', 37);

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
(1, 1, 1),
(2, 5, 1),
(3, 1, 1),
(4, 1, 1),
(5, 1, 0);

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
('URL', 'https://www.joepinzone.com'),
('Site Email Address', 'jpinnoz@yahoo.com');

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
(1, 2, 2, 'Page 2.1', 'index.php?page=Page 2', 1),
(1, 3, 3, 'Page 3', 'index.php?page=Page 3', 1),
(1, 4, 4, 'Page 4', 'index.php?page=Page 4', 1),
(1, 5, 5, 'Page 5', 'index.php?page=Page 5', 0);

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

--
-- Dumping data for table `SubMenus_BACKUP`
--

INSERT INTO `SubMenus_BACKUP` (`Page_ID`, `Page_Iteration`, `Menu_ID`, `Link_ID`, `Menu_Entry`, `Title`) VALUES
(1, 1, 1, 1, 'Home', 'index.php'),
(2, 1, 1, 2, 'Page 2', 'index.php?page=Page 2'),
(2, 4, 1, 3, 'Page 2', 'index.php?page=Page 2'),
(3, 1, 1, 3, 'Page 3', 'index.php?page=Page 3'),
(4, 1, 1, 4, 'Page 4', 'index.php?page=Page 4'),
(2, 5, 1, 5, 'Page 2.1', 'index.php?page=Page 2'),
(5, 1, 1, 5, 'Page 5', 'index.php?page=Page 5');

-- --------------------------------------------------------

--
-- Table structure for table `Username_Change_Log`
--

CREATE TABLE `Username_Change_Log` (
  `ID` int(11) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `DateTime` datetime NOT NULL
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
(35, 'First_Name', 'Family_Name', 'jpinnoz@yahoo.com', 'admin2', '$2y$10$eZK.6hAn.eqdDx1uuKU/tee4jzLRWzknnCgvsNN7DQh9rM20V4Zey', '$2y$10$BFBfu5lIRrr5oYVouelvO.XYfxGx3vQVj2ZCNut1yRNtKdwOck6Nq', '$2y$10$Yr34a2gba0mWN9BJMKme.e5vx.Z8Bdw.L2lqrGvqc75atvCBphUCq', '2024-04-30 16:48:43', NULL, NULL, '2024-04-02 20:52:43', '2024-05-29 18:26:25', 3, 1),
(37, 'First Name', 'Last Name', 'jpinnoz@gmail.com', 'admin', '$2y$10$giFVXqze/eqqXGlaG.c7aek30lN/5PWljqx..MouWCO9QdcRcX/1u', '$2y$10$BFBfu5lIRrr5oYVouelvO.XYfxGx3vQVj2ZCNut1yRNtKdwOck6Nq', '$2y$10$Yr34a2gba0mWN9BJMKme.e5vx.Z8Bdw.L2lqrGvqc75atvCBphUCq', '2024-04-30 16:48:43', NULL, NULL, '2024-04-02 20:52:43', '2024-06-15 20:06:05', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Cust_Pages`
--
ALTER TABLE `Cust_Pages`
  ADD UNIQUE KEY `Page_ID` (`Page_ID`,`Page_Iteration`);

--
-- Indexes for table `News`
--
ALTER TABLE `News`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `News_Comments`
--
ALTER TABLE `News_Comments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`,`News_Article`);

--
-- Indexes for table `SubMenus`
--
ALTER TABLE `SubMenus`
  ADD PRIMARY KEY (`LinkID`,`MenuID`),
  ADD KEY `MenuID` (`MenuID`,`LinkID`);

--
-- Indexes for table `Username_Change_Log`
--
ALTER TABLE `Username_Change_Log`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD UNIQUE KEY `User_Name` (`User_Name`) USING HASH,
  ADD UNIQUE KEY `eMail` (`eMail`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Cust_Pages`
--
ALTER TABLE `Cust_Pages`
  MODIFY `Page_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `News`
--
ALTER TABLE `News`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `News_Comments`
--
ALTER TABLE `News_Comments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
