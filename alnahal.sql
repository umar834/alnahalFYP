-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2022 at 08:28 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alnahal`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_fullname` varchar(255) DEFAULT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  `admin_password` varchar(255) DEFAULT NULL,
  `admin_profileimg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_fullname`, `admin_email`, `admin_password`, `admin_profileimg`) VALUES
(1, 'Alnahal Admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_books_cate`
--

CREATE TABLE `tbl_books_cate` (
  `BC_id` int(11) NOT NULL,
  `BC_name` varchar(255) DEFAULT NULL,
  `BC_status` enum('A','B') NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_books_cate`
--

INSERT INTO `tbl_books_cate` (`BC_id`, `BC_name`, `BC_status`) VALUES
(1, 'The Quran', 'A'),
(2, 'Hadith Book', 'A'),
(3, 'Seerah Books', 'A'),
(4, 'Translation Books', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_books_detail`
--

CREATE TABLE `tbl_books_detail` (
  `book_id` int(11) NOT NULL,
  `book_BCID` int(11) DEFAULT NULL,
  `book_title` varchar(255) DEFAULT NULL,
  `book_ISBN` varchar(255) DEFAULT NULL,
  `book_status` enum('A','B') DEFAULT 'A',
  `book_author` varchar(255) DEFAULT NULL,
  `book_desc` varchar(255) DEFAULT NULL,
  `book_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_books_detail`
--

INSERT INTO `tbl_books_detail` (`book_id`, `book_BCID`, `book_title`, `book_ISBN`, `book_status`, `book_author`, `book_desc`, `book_file`) VALUES
(4, 2, 'Hadees ', '67889', 'B', 'ali', 'this is dummy', 'uploads/1646557584-Muqadas\'s Resume.pdf'),
(5, 3, 'Sunte Nabwi PBUH', '12678', 'B', 'Muqadas', 'This is a dummy book', 'uploads/1646557794-esha lett.docx'),
(6, 1, 'Qurran1', '0987554', 'A', 'Ali', 'This is dummy', 'uploads/1646557936-DMC.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

CREATE TABLE `tbl_course` (
  `course_id` int(11) NOT NULL,
  `course_title` varchar(255) DEFAULT NULL,
  `course_img` varchar(255) NOT NULL,
  `course_duration` varchar(255) DEFAULT NULL,
  `course_start_date` date NOT NULL DEFAULT current_timestamp(),
  `course_code` varchar(255) DEFAULT NULL,
  `course_status` enum('P','A','B') NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`course_id`, `course_title`, `course_img`, `course_duration`, `course_start_date`, `course_code`, `course_status`) VALUES
(5, 'Taharat', 'uploads/1647674518-c1.png', '1', '2022-04-17', '321', 'P'),
(6, 'Basic Tajweed', 'uploads/1647680183-WhatsApp Image 2022-03-19 at 11.01.37 AM (1).jpeg', '2', '2022-04-17', '456', 'A'),
(7, 'test', '', '3', '2022-04-06', '34343', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course_book`
--

CREATE TABLE `tbl_course_book` (
  `cbook_id` int(11) NOT NULL,
  `cbook_courseId` int(11) DEFAULT NULL,
  `cbook_teacherId` int(11) DEFAULT NULL,
  `cbook_desc` varchar(255) DEFAULT NULL,
  `cbook_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_course_book`
--

INSERT INTO `tbl_course_book` (`cbook_id`, `cbook_courseId`, `cbook_teacherId`, `cbook_desc`, `cbook_path`) VALUES
(2, 2, 6, 'ewrtyuhjhgfdsvb', 'uploads/1648395115-DMC.pdf'),
(3, 2, 6, 'cgfftyf', 'uploads/1648395541-DMC.pdf'),
(5, 2, 6, 'efghjkl', 'uploads/1648396235-DMC.pdf'),
(9, 2, 6, 'asdfg', ''),
(10, 2, 6, '3434te5rtftffh', 'uploads/1648468906-SDP1 Evaluation Proforma.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course_lecture`
--

CREATE TABLE `tbl_course_lecture` (
  `course_lec_id` int(11) NOT NULL,
  `clecture_courseId` int(11) DEFAULT NULL,
  `clecture_teacherId` int(11) DEFAULT NULL,
  `week` int(11) NOT NULL,
  `clec_audiofile` varchar(255) DEFAULT NULL,
  `clec_notesfile` varchar(255) DEFAULT NULL,
  `clec_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_course_lecture`
--

INSERT INTO `tbl_course_lecture` (`course_lec_id`, `clecture_courseId`, `clecture_teacherId`, `week`, `clec_audiofile`, `clec_notesfile`, `clec_description`) VALUES
(3, 6, 2, 0, 'uploads/1650096615-WhatsApp Audio 2022-04-16 at 12.26.39 PM.mpeg', 'uploads/1650096615-Create Account.docx', 'THIS IS DUMMY'),
(4, 6, 2, 0, 'uploads/1650186444-1650096615-WhatsApp Audio 2022-04-16 at 12.26.39 PM.mpeg', 'uploads/1650186444-فورٹ ولی۔ کالج.docx', 'This is dummy');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course_outline`
--

CREATE TABLE `tbl_course_outline` (
  `outline_id` int(11) NOT NULL,
  `outline_discription` text DEFAULT NULL,
  `outline_courseID` int(11) DEFAULT NULL,
  `outline_teacherID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_course_outline`
--

INSERT INTO `tbl_course_outline` (`outline_id`, `outline_discription`, `outline_courseID`, `outline_teacherID`) VALUES
(1, '<p><strong>Outline</strong></p>\r\n\r\n<ul>\r\n	<li>Week One Topics\r\n	<ul>\r\n		<li>Topic A</li>\r\n		<li>Topic B</li>\r\n		<li>Topic C</li>\r\n	</ul>\r\n	</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>Week Two Topics\r\n	<ul>\r\n		<li>Topic A</li>\r\n		<li>Topic B</li>\r\n		<li>Topic C</li>\r\n	</ul>\r\n	</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>Week Three Topics\r\n	<ul>\r\n		<li>Topic A</li>\r\n		<li>Topic B</li>\r\n		<li>Topic C</li>\r\n	</ul>\r\n	</li>\r\n</ul>\r\n', 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_donation_cases`
--

CREATE TABLE `tbl_donation_cases` (
  `case_id` int(11) NOT NULL,
  `case_cate_id` int(11) DEFAULT NULL,
  `case_title` varchar(255) DEFAULT NULL,
  `case_description` text DEFAULT NULL,
  `case_image` varchar(255) DEFAULT NULL,
  `case_tot_amount_req` int(11) DEFAULT NULL,
  `case_for_name` varchar(255) DEFAULT NULL,
  `case_for_phoneNo` varchar(255) DEFAULT NULL,
  `case_for_address` text DEFAULT NULL,
  `case_for_CNIC` varchar(50) DEFAULT NULL,
  `case_status` enum('A','B','CL') NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_donation_cases`
--

INSERT INTO `tbl_donation_cases` (`case_id`, `case_cate_id`, `case_title`, `case_description`, `case_image`, `case_tot_amount_req`, `case_for_name`, `case_for_phoneNo`, `case_for_address`, `case_for_CNIC`, `case_status`) VALUES
(13, 1, 'Cancer ', 'dummyyyy', 'uploads/1647156206-ERD (1).jpg', 68788, 'Amna Ali', '1234567890', 'Gujar khan barki', '12345678', 'CL'),
(14, 2, 'Orphan', 'dummy case', 'uploads/1647156804-img.jpg', 20000, 'Ali Ch', '03125627981', 'Rawalpindi', '73470987654', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_donation_categories`
--

CREATE TABLE `tbl_donation_categories` (
  `donation_cate_id` int(11) NOT NULL,
  `donation_cate_title` varchar(255) DEFAULT NULL,
  `donation_cate_status` enum('A','B') NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_donation_categories`
--

INSERT INTO `tbl_donation_categories` (`donation_cate_id`, `donation_cate_title`, `donation_cate_status`) VALUES
(1, 'Zakat', 'B'),
(2, 'Sadqa', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_materials`
--

CREATE TABLE `tbl_materials` (
  `material_id` int(11) NOT NULL,
  `material_name` varchar(255) DEFAULT NULL,
  `material_status` enum('A','B') NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_materials`
--

INSERT INTO `tbl_materials` (`material_id`, `material_name`, `material_status`) VALUES
(1, 'Supplication', 'A'),
(3, 'Sunnahs', 'A'),
(4, 'Azkar', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_materials_details`
--

CREATE TABLE `tbl_materials_details` (
  `mat_detail_id` int(11) NOT NULL,
  `mat_detail_title` varchar(255) DEFAULT NULL,
  `mat_detail_desc` text DEFAULT NULL,
  `mat_detail_image` varchar(255) DEFAULT NULL,
  `mat_detail_materialID` int(11) DEFAULT NULL,
  `mat_detail_status` enum('A','B') NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_materials_details`
--

INSERT INTO `tbl_materials_details` (`mat_detail_id`, `mat_detail_title`, `mat_detail_desc`, `mat_detail_image`, `mat_detail_materialID`, `mat_detail_status`) VALUES
(2, 'Dua Sehar', 'This is duumy data', 'uploads/1646493899-content.jpeg', 1, 'B'),
(14, 'Wearing of Clothes', 'sunnah of wearing clothes', 'uploads/1646472986-img.jpg', 3, 'A'),
(15, 'duaa', 'dummy dua for test', 'uploads/1646473583-iiui.png', 1, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher`
--

CREATE TABLE `tbl_teacher` (
  `Teacher_Id` int(11) NOT NULL,
  `Teacher_Name` varchar(255) DEFAULT NULL,
  `Teacher_Email` varchar(255) DEFAULT NULL,
  `Teacher_Address` varchar(255) DEFAULT NULL,
  `Teacher_Course` varchar(255) DEFAULT NULL,
  `Teacher_Status` enum('A','B') DEFAULT 'A',
  `Teacher_ProfileImg` varchar(255) DEFAULT NULL,
  `Teacher_Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_teacher`
--

INSERT INTO `tbl_teacher` (`Teacher_Id`, `Teacher_Name`, `Teacher_Email`, `Teacher_Address`, `Teacher_Course`, `Teacher_Status`, `Teacher_ProfileImg`, `Teacher_Password`) VALUES
(1, 'Khawaja Ammad', 'ammad@gmail.com', 'Rawalpinid', '6', 'A', 'uploads/1647758526-1646473583-iiui.png', '6af7b658a5a31b4bccb5d29c262453e7'),
(2, 'Ali', 'ali@gmail.com', 'Islamabad', '6', 'A', 'uploads/1647759029-1647674518-c1.png', '7a9b46ab6d983a85dd4d9a1aa64a3945'),
(4, 'Muqadas', 'muqadas@yahoo.com', 'Gujar khan', '5', 'A', 'uploads/1648287134-8gvWeAcLBWkyohtUQfFIskKqlAS.jpg', 'a7f202e30e4a828275f8d9cfbf595dcc');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_contact` varchar(255) DEFAULT NULL,
  `user_address` varchar(255) DEFAULT NULL,
  `user_status` enum('A','B','P','R') NOT NULL DEFAULT 'A',
  `role_id` int(11) NOT NULL,
  `Teacher_Course` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_name`, `user_email`, `user_password`, `user_contact`, `user_address`, `user_status`, `role_id`, `Teacher_Course`) VALUES
(1, 'Muqadas', 'muqadas@gmail.com', 'a7f202e30e4a828275f8d9cfbf595dcc', '031287687864', 'Gujar Khan', 'B', 1, 0),
(2, 'Ghana', 'ghana@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '03129877554', 'Rawalpindi Pakistan', 'A', 2, 5),
(3, 'Ali', 'ali@gmail.com', '7a9b46ab6d983a85dd4d9a1aa64a3945', '0435667998', 'Lahore', 'A', 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_course_reg`
--

CREATE TABLE `tbl_user_course_reg` (
  `course_reg_id` int(11) NOT NULL,
  `course_userID` int(11) DEFAULT NULL,
  `course_reg_courseID` int(11) DEFAULT NULL,
  `course_reg_status` enum('A','P','R','B') NOT NULL DEFAULT 'P',
  `course_reg_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_role`
--

CREATE TABLE `tbl_user_role` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user_role`
--

INSERT INTO `tbl_user_role` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'teacher'),
(3, 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_books_cate`
--
ALTER TABLE `tbl_books_cate`
  ADD PRIMARY KEY (`BC_id`);

--
-- Indexes for table `tbl_books_detail`
--
ALTER TABLE `tbl_books_detail`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `tbl_course`
--
ALTER TABLE `tbl_course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `tbl_course_book`
--
ALTER TABLE `tbl_course_book`
  ADD PRIMARY KEY (`cbook_id`);

--
-- Indexes for table `tbl_course_lecture`
--
ALTER TABLE `tbl_course_lecture`
  ADD PRIMARY KEY (`course_lec_id`);

--
-- Indexes for table `tbl_course_outline`
--
ALTER TABLE `tbl_course_outline`
  ADD PRIMARY KEY (`outline_id`);

--
-- Indexes for table `tbl_donation_cases`
--
ALTER TABLE `tbl_donation_cases`
  ADD PRIMARY KEY (`case_id`);

--
-- Indexes for table `tbl_donation_categories`
--
ALTER TABLE `tbl_donation_categories`
  ADD PRIMARY KEY (`donation_cate_id`);

--
-- Indexes for table `tbl_materials`
--
ALTER TABLE `tbl_materials`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `tbl_materials_details`
--
ALTER TABLE `tbl_materials_details`
  ADD PRIMARY KEY (`mat_detail_id`);

--
-- Indexes for table `tbl_teacher`
--
ALTER TABLE `tbl_teacher`
  ADD PRIMARY KEY (`Teacher_Id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_user_course_reg`
--
ALTER TABLE `tbl_user_course_reg`
  ADD PRIMARY KEY (`course_reg_id`);

--
-- Indexes for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_books_cate`
--
ALTER TABLE `tbl_books_cate`
  MODIFY `BC_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_books_detail`
--
ALTER TABLE `tbl_books_detail`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_course`
--
ALTER TABLE `tbl_course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_course_book`
--
ALTER TABLE `tbl_course_book`
  MODIFY `cbook_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_course_lecture`
--
ALTER TABLE `tbl_course_lecture`
  MODIFY `course_lec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_course_outline`
--
ALTER TABLE `tbl_course_outline`
  MODIFY `outline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_donation_cases`
--
ALTER TABLE `tbl_donation_cases`
  MODIFY `case_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_donation_categories`
--
ALTER TABLE `tbl_donation_categories`
  MODIFY `donation_cate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_materials`
--
ALTER TABLE `tbl_materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_materials_details`
--
ALTER TABLE `tbl_materials_details`
  MODIFY `mat_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_teacher`
--
ALTER TABLE `tbl_teacher`
  MODIFY `Teacher_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_user_course_reg`
--
ALTER TABLE `tbl_user_course_reg`
  MODIFY `course_reg_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
