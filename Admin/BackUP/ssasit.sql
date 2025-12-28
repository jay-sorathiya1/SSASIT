-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2025 at 08:09 AM
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
-- Database: `ssasit`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `Dept_ID` int(11) NOT NULL,
  `Dept_Name` varchar(100) NOT NULL,
  `Dept_Description` text DEFAULT NULL,
  `Established_Year` year(4) NOT NULL,
  `Department_Status` enum('Active','Inactive','Under Development','Merged','Discontinued') NOT NULL DEFAULT 'Active',
  `HOD` int(11) DEFAULT NULL COMMENT 'Head of Department - References person.ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`Dept_ID`, `Dept_Name`, `Dept_Description`, `Established_Year`, `Department_Status`, `HOD`) VALUES
(1, 'Computer Science Engineering', 'Department focusing on software development, algorithms, AI, and data structures', '2010', 'Active', NULL),
(2, 'Information Technology', 'Department specializing in networking, web technologies, and system administration', '2012', 'Active', NULL),
(3, 'Electronics & Communication Engineering', 'Department covering embedded systems, telecommunications, and signal processing', '2008', 'Active', NULL),
(4, 'Mechanical Engineering', 'Department focusing on design, manufacturing, thermodynamics, and robotics', '2005', 'Active', NULL),
(5, 'Civil Engineering', 'Department specializing in construction, structural design, and infrastructure', '2005', 'Active', NULL),
(6, 'Electrical Engineering', 'Department covering power systems, control systems, and electrical machines', '2007', 'Active', NULL),
(7, 'Chemical Engineering', 'Department focusing on process engineering and chemical manufacturing', '2015', 'Inactive', NULL),
(8, 'Biotechnology', 'Department specializing in biological processes and genetic engineering', '2018', 'Active', NULL),
(9, 'Aerospace Engineering', 'Department covering aircraft design and space technology', '2020', 'Active', NULL),
(10, 'Environmental Engineering', 'Department focusing on pollution control and sustainable development', '2016', 'Active', NULL),
(11, 'Industrial Engineering', 'Department specializing in process optimization and quality management', '2014', 'Active', NULL),
(12, 'Materials Science', 'Department covering advanced materials and nanotechnology', '2019', 'Inactive', NULL),
(13, 'fdfddfd', 'dfdfdf', '0000', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `ID` int(11) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `DOB` date NOT NULL COMMENT 'Date of Birth',
  `Address` text NOT NULL,
  `City` varchar(50) NOT NULL,
  `Mobile` varchar(10) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Gender` enum('Male','Female','Other') NOT NULL,
  `Qualification` varchar(100) NOT NULL,
  `Photo` varchar(255) DEFAULT 'SSASIT.png',
  `Department_ID` int(11) NOT NULL,
  `Joining_Date` date DEFAULT NULL,
  `Status` enum('Active','Inactive','Graduated','Under Graduation','Post Graduation','Terminated','Resigned','Detained') NOT NULL DEFAULT 'Active',
  `Designation` varchar(50) NOT NULL COMMENT 'Student, Professor, etc.',
  `Experience` int(11) DEFAULT 0 COMMENT 'Years of experience for faculty'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`ID`, `First_Name`, `Last_Name`, `DOB`, `Address`, `City`, `Mobile`, `Email`, `Gender`, `Qualification`, `Photo`, `Department_ID`, `Joining_Date`, `Status`, `Designation`, `Experience`) VALUES
(1, 'Rajesh', 'Kumar', '1980-05-15', '123 MG Road, Satellite', 'Ahmedabad', '9876543210', 'rajesh.kumar@ssasit.edu.in', 'Male', 'Ph.D. in Computer Science', 'SSASIT.png', 1, '2010-07-01', 'Active', 'Professor', 15),
(2, 'Sneha', 'Desai', '1983-11-30', '321 Ashram Road, Paldi', 'Ahmedabad', '9876543213', 'sneha.desai@ssasit.edu.in', 'Female', 'Ph.D. in Information Technology', 'SSASIT.png', 2, '2012-07-10', 'Active', 'Professor', 13),
(3, 'Vikram', 'Mehta', '1982-02-14', '147 Satellite Road', 'Ahmedabad', '9876543216', 'vikram.mehta@ssasit.edu.in', 'Male', 'Ph.D. in Electronics Engineering', 'SSASIT.png', 3, '2010-08-01', 'Active', 'Professor', 15),
(4, 'Suresh', 'Rao', '1981-04-20', '741 Naranpura', 'Ahmedabad', '9876543219', 'suresh.rao@ssasit.edu.in', 'Male', 'Ph.D. in Mechanical Engineering', 'SSASIT.png', 4, '2010-07-15', 'Active', 'Professor', 14),
(5, 'Deepak', 'Singh', '1979-09-03', '159 Vastrapur', 'Ahmedabad', '9876543222', 'deepak.singh@ssasit.edu.in', 'Male', 'Ph.D. in Civil Engineering', 'SSASIT.png', 5, '2010-06-20', 'Active', 'Professor', 16),
(6, 'Priya', 'Sharma', '1985-08-22', '456 CG Road, Navrangpura', 'Ahmedabad', '9876543211', 'priya.sharma@ssasit.edu.in', 'Female', 'M.Tech in Software Engineering', 'SSASIT.png', 1, '2012-08-15', 'Active', 'Associate Professor', 12),
(7, 'Karan', 'Shah', '1987-06-18', '654 Relief Road, Lal Darwaja', 'Ahmedabad', '9876543214', 'karan.shah@ssasit.edu.in', 'Male', 'M.Tech in Cyber Security', 'SSASIT.png', 2, '2014-08-01', 'Active', 'Associate Professor', 11),
(8, 'Anjali', 'Trivedi', '1986-07-08', '258 Maninagar East', 'Ahmedabad', '9876543217', 'anjali.trivedi@ssasit.edu.in', 'Female', 'M.Tech in VLSI Design', 'SSASIT.png', 3, '2013-07-20', 'Active', 'Associate Professor', 11),
(9, 'Kavita', 'Nair', '1984-10-12', '852 Gurukul Road', 'Ahmedabad', '9876543220', 'kavita.nair@ssasit.edu.in', 'Female', 'M.Tech in Thermal Engineering', 'SSASIT.png', 4, '2013-08-10', 'Active', 'Associate Professor', 11),
(10, 'Pooja', 'Verma', '1985-03-17', '357 Prahlad Nagar', 'Ahmedabad', '9876543223', 'pooja.verma@ssasit.edu.in', 'Female', 'M.Tech in Construction Management', 'SSASIT.png', 5, '2014-07-25', 'Active', 'Associate Professor', 10),
(11, 'Amit', 'Joshi', '1988-12-05', '963 Bopal Road', 'Ahmedabad', '9876543212', 'amit.joshi@ssasit.edu.in', 'Male', 'M.Tech in Data Science', 'SSASIT.png', 1, '2015-07-01', 'Active', 'Assistant Professor', 9),
(12, 'Ritu', 'Agarwal', '1989-04-25', '741 Thaltej', 'Ahmedabad', '9876543215', 'ritu.agarwal@ssasit.edu.in', 'Female', 'M.Tech in Network Security', 'SSASIT.png', 2, '2016-08-10', 'Active', 'Assistant Professor', 8),
(13, 'Manish', 'Gupta', '1990-01-18', '852 Gota', 'Ahmedabad', '9876543218', 'manish.gupta@ssasit.edu.in', 'Male', 'M.Tech in Embedded Systems', 'SSASIT.png', 3, '2017-07-15', 'Active', 'Assistant Professor', 7),
(14, 'Neha', 'Pandey', '1991-09-30', '159 Maninagar', 'Ahmedabad', '9876543221', 'neha.pandey@ssasit.edu.in', 'Female', 'M.Tech in CAD/CAM', 'SSASIT.png', 4, '2018-08-01', 'Active', 'Assistant Professor', 6),
(15, 'Rohit', 'Mishra', '1992-06-12', '753 Satellite', 'Ahmedabad', '9876543224', 'rohit.mishra@ssasit.edu.in', 'Male', 'M.Tech in Structural Engineering', 'SSASIT.png', 5, '2019-07-20', 'Active', 'Assistant Professor', 5),
(16, 'Sonal', 'Patel', '1993-02-28', '456 Navrangpura', 'Ahmedabad', '9876543225', 'sonal.patel@ssasit.edu.in', 'Female', 'M.E. in Computer Engineering', 'SSASIT.png', 1, '2020-08-15', 'Active', 'Lecturer', 4),
(17, 'Vishal', 'Sharma', '1994-11-15', '789 Paldi', 'Ahmedabad', '9876543226', 'vishal.sharma@ssasit.edu.in', 'Male', 'M.E. in Information Technology', 'SSASIT.png', 2, '2021-07-01', 'Active', 'Lecturer', 3),
(18, 'Divya', 'Singh', '1995-08-07', '321 Ashram Road', 'Ahmedabad', '9876543227', 'divya.singh@ssasit.edu.in', 'Female', 'M.E. in Electronics', 'SSASIT.png', 3, '2022-08-10', 'Active', 'Lecturer', 2),
(19, 'Rahul', 'Agarwal', '2003-06-15', '12 Satellite Road', 'Ahmedabad', '9123456701', 'rahul.agarwal@student.ssasit.edu.in', 'Male', '12th Science', 'SSASIT.png', 1, '2021-08-01', 'Under Graduation', 'Student', 0),
(20, 'Divya', 'Kapoor', '2003-08-22', '34 Navrangpura', 'Ahmedabad', '9123456702', 'divya.kapoor@student.ssasit.edu.in', 'Female', '12th Science', 'SSASIT.png', 1, '2021-08-01', 'Under Graduation', 'Student', 0),
(21, 'Siddharth', 'Chopra', '2003-07-12', '22 Paldi', 'Ahmedabad', '9123456707', 'siddharth.chopra@student.ssasit.edu.in', 'Male', '12th Science', 'SSASIT.png', 2, '2021-08-01', 'Under Graduation', 'Student', 0),
(22, 'Riya', 'Saxena', '2003-09-05', '33 Ashram Road', 'Ahmedabad', '9123456708', 'riya.saxena@student.ssasit.edu.in', 'Female', '12th Science', 'SSASIT.png', 2, '2021-08-01', 'Under Graduation', 'Student', 0),
(23, 'Arjun', 'Patel', '2004-01-10', '45 Bopal', 'Ahmedabad', '9123456709', 'arjun.patel@student.ssasit.edu.in', 'Male', '12th Science', 'SSASIT.png', 3, '2022-08-01', 'Under Graduation', 'Student', 0),
(24, 'Kavya', 'Joshi', '2004-03-18', '67 Gota', 'Ahmedabad', '9123456710', 'kavya.joshi@student.ssasit.edu.in', 'Female', '12th Science', 'SSASIT.png', 4, '2022-08-01', 'Under Graduation', 'Student', 0),
(25, 'Rohan', 'Gupta', '2005-05-25', '89 Thaltej', 'Ahmedabad', '9123456711', 'rohan.gupta@student.ssasit.edu.in', 'Male', '12th Science', 'SSASIT.png', 5, '2023-08-01', 'Under Graduation', 'Student', 0),
(26, 'Ananya', 'Pillai', '2005-03-30', '11 Maninagar', 'Ahmedabad', '9123456706', 'ananya.pillai@student.ssasit.edu.in', 'Female', '12th Science', 'SSASIT.png', 1, '2023-08-01', 'Under Graduation', 'Student', 0),
(27, 'Karthik', 'Reddy', '2002-04-20', '78 Satellite', 'Ahmedabad', '9123456712', 'karthik.reddy@student.ssasit.edu.in', 'Male', 'B.Tech CSE', 'SSASIT.png', 1, '2024-08-01', 'Post Graduation', 'Student', 0),
(28, 'Shreya', 'Nair', '2002-11-15', '90 Navrangpura', 'Ahmedabad', '9123456713', 'shreya.nair@student.ssasit.edu.in', 'Female', 'B.Tech IT', 'SSASIT.png', 2, '2024-08-01', 'Post Graduation', 'Student', 0),
(29, 'Varun', 'Malhotra', '2001-12-08', '56 Paldi', 'Ahmedabad', '9123456714', 'varun.malhotra@student.ssasit.edu.in', 'Male', 'B.Tech ECE', 'SSASIT.png', 3, '2024-08-01', 'Post Graduation', 'Student', 0),
(30, 'Priyanka', 'Jain', '2000-06-25', '123 Bopal', 'Ahmedabad', '9123456715', 'priyanka.jain@alumni.ssasit.edu.in', 'Female', 'B.Tech CSE', 'SSASIT.png', 1, '2018-08-01', 'Graduated', 'Student', 0),
(31, 'Akash', 'Verma', '2000-09-12', '234 Gota', 'Ahmedabad', '9123456716', 'akash.verma@alumni.ssasit.edu.in', 'Male', 'B.Tech ME', 'SSASIT.png', 4, '2018-08-01', 'Graduated', 'Student', 0),
(32, 'Meera', 'Shah', '2000-03-18', '345 Thaltej', 'Ahmedabad', '9123456717', 'meera.shah@alumni.ssasit.edu.in', 'Female', 'B.Tech CE', 'SSASIT.png', 5, '2018-08-01', 'Graduated', 'Student', 0),
(33, 'Nikhil', 'Pandey', '2004-07-30', '456 Maninagar', 'Ahmedabad', '9123456718', 'nikhil.pandey@student.ssasit.edu.in', 'Male', '12th Science', 'SSASIT.png', 1, '2022-08-01', 'Detained', 'Student', 0),
(34, 'Pooja', 'Rao', '2004-10-14', '567 Satellite', 'Ahmedabad', '9123456719', 'pooja.rao@student.ssasit.edu.in', 'Female', '12th Science', 'SSASIT.png', 2, '2022-08-01', 'Detained', 'Student', 0),
(35, 'Rajiv', 'Khanna', '1978-05-10', '678 Navrangpura', 'Ahmedabad', '9876543228', 'rajiv.khanna@ssasit.edu.in', 'Male', 'Ph.D. in Mechanical Engineering', 'SSASIT.png', 4, '2008-07-01', 'Resigned', 'Professor', 18),
(36, 'Sunita', 'Gupta', '1982-12-22', '789 Paldi', 'Ahmedabad', '9876543229', 'sunita.gupta@ssasit.edu.in', 'Female', 'M.Tech in Civil Engineering', 'SSASIT.png', 5, '2012-08-15', 'Terminated', 'Associate Professor', 12),
(37, 'Arun', 'Tiwari', '1986-08-05', '890 Ashram Road', 'Ahmedabad', '9876543230', 'arun.tiwari@ssasit.edu.in', 'Male', 'M.E. in Electronics', 'SSASIT.png', 3, '2015-07-20', 'Inactive', 'Assistant Professor', 8),
(38, 'Tanvi', 'Mehta', '2003-01-25', '901 Bopal', 'Ahmedabad', '9123456720', 'tanvi.mehta@student.ssasit.edu.in', 'Female', '12th Science', 'SSASIT.png', 3, '2021-08-01', 'Active', 'Student', 0),
(39, 'Harsh', 'Agarwal', '2003-05-18', '012 Gota', 'Ahmedabad', '9123456721', 'harsh.agarwal@student.ssasit.edu.in', 'Male', '12th Science', 'SSASIT.png', 4, '2021-08-01', 'Active', 'Student', 0),
(40, 'Ishita', 'Sharma', '2003-11-08', '123 Thaltej', 'Ahmedabad', '9123456722', 'ishita.sharma@student.ssasit.edu.in', 'Female', '12th Science', 'SSASIT.png', 5, '2021-08-01', 'Active', 'Student', 0),
(41, 'Yash', 'Patel', '2004-02-14', '234 Maninagar', 'Ahmedabad', '9123456723', 'yash.patel@student.ssasit.edu.in', 'Male', '12th Science', 'SSASIT.png', 1, '2022-08-01', 'Active', 'Student', 0),
(42, 'Nisha', 'Singh', '2004-06-28', '345 Satellite', 'Ahmedabad', '9123456724', 'nisha.singh@student.ssasit.edu.in', 'Female', '12th Science', 'SSASIT.png', 2, '2022-08-01', 'Active', 'Student', 0),
(43, 'Abhishek', 'Joshi', '2004-09-12', '456 Navrangpura', 'Ahmedabad', '9123456725', 'abhishek.joshi@student.ssasit.edu.in', 'Male', '12th Science', 'SSASIT.png', 3, '2022-08-01', 'Active', 'Student', 0),
(44, 'Sakshi', 'Verma', '2004-12-03', '567 Paldi', 'Ahmedabad', '9123456726', 'sakshi.verma@student.ssasit.edu.in', 'Female', '12th Science', 'SSASIT.png', 4, '2022-08-01', 'Active', 'Student', 0),
(45, 'Rohit', 'Gupta', '2005-01-20', '678 Ashram Road', 'Ahmedabad', '9123456727', 'rohit.gupta@student.ssasit.edu.in', 'Male', '12th Science', 'SSASIT.png', 5, '2023-08-01', 'Active', 'Student', 0),
(46, 'Aditi', 'Nair', '2005-04-15', '789 Bopal', 'Ahmedabad', '9123456728', 'aditi.nair@student.ssasit.edu.in', 'Female', '12th Science', 'SSASIT.png', 1, '2023-08-01', 'Active', 'Student', 0),
(47, 'Vikash', 'Pandey', '2005-08-22', '890 Gota', 'Ahmedabad', '9123456729', 'vikash.pandey@student.ssasit.edu.in', 'Male', '12th Science', 'SSASIT.png', 2, '2023-08-01', 'Active', 'Student', 0),
(48, 'Ritika', 'Bajaj', '2005-07-21', '116 Navrangpura', 'Ahmedabad', '9123456730', 'ritika.bajaj@student.ssasit.edu.in', 'Female', '12th Science', 'SSASIT.png', 5, '2023-08-01', 'Active', 'Student', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`Dept_ID`),
  ADD KEY `HOD` (`HOD`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_person_department` (`Department_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `Dept_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`HOD`) REFERENCES `person` (`ID`);

--
-- Constraints for table `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `fk_person_department` FOREIGN KEY (`Department_ID`) REFERENCES `department` (`Dept_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
