-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2025 at 11:44 AM
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
-- Database: `tms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin_image` varchar(255) DEFAULT 'default.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `email`, `password`, `admin_image`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', '0192023a7bbd73250516f069d17b0500', 'default.png', '2025-08-26 18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog`
--

CREATE TABLE `tbl_blog` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author_name` varchar(100) DEFAULT 'Admin',
  `featured_image` varchar(255) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Published, 0=Draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_blog`
--

INSERT INTO `tbl_blog` (`id`, `title`, `content`, `author_name`, `featured_image`, `tags`, `status`, `created_at`) VALUES
(1, 'খাইতর্', 'trgdfbddff', 'Admin', '1758110904_Gemini_Generated_Image_uh0tczuh0tczuh0t.png', 'travel,kk,lll', 1, '2025-09-17 12:08:24');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking`
--

CREATE TABLE `tbl_booking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `comment` text NOT NULL,
  `num_people` int(11) NOT NULL DEFAULT 1,
  `promo_code_used` varchar(50) DEFAULT NULL,
  `discount_amount` decimal(10,2) DEFAULT 0.00,
  `payment_method` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=Pending, 1=Confirmed, 2=Cancelled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_booking`
--

INSERT INTO `tbl_booking` (`id`, `user_id`, `package_id`, `from_date`, `to_date`, `comment`, `num_people`, `promo_code_used`, `discount_amount`, `payment_method`, `transaction_id`, `paid_amount`, `status`, `created_at`) VALUES
(5, 5, 13, '2018-01-11', '2000-07-06', 'Sed eos iure offici', 1, NULL, 0.00, NULL, NULL, NULL, 1, '2025-08-31 08:48:44'),
(6, 9, 20, '2025-08-04', '2025-08-31', 'dfghdgh', 1, NULL, 0.00, NULL, NULL, NULL, 1, '2025-08-31 12:46:34'),
(7, 5, 11, '1975-03-15', '1976-04-12', 'Adipisicing quia vol', 1, NULL, 0.00, NULL, NULL, NULL, 1, '2025-09-05 06:10:55'),
(8, 5, 24, '1991-12-11', '1982-11-16', 'Commodo ut possimus', 1, NULL, 0.00, NULL, NULL, NULL, 1, '2025-09-05 06:11:04'),
(9, 5, 13, '2007-03-17', '2012-03-17', 'In quia sint adipis', 1, NULL, 0.00, NULL, NULL, NULL, 1, '2025-09-05 06:11:16'),
(10, 5, 20, '2023-03-23', '2007-11-09', 'Aut accusamus velit', 1, NULL, 0.00, 'bKash', '0', 40.00, 2, '2025-09-05 07:03:04'),
(11, 5, 14, '1992-09-14', '2021-11-03', 'Facilis incididunt e', 1, NULL, 0.00, 'Rocket', '0', 4800.00, 2, '2025-09-05 09:17:42'),
(12, 5, 27, '2025-09-11', '2025-09-11', ' ‍ুা্িা্ডযপ', 2, NULL, 0.00, 'Upay', '09yut5r6gtb78bh', 1500.00, 2, '2025-09-09 15:27:15'),
(13, 5, 28, '2025-09-12', '2025-09-12', '', 1, 'DU22', 700.00, 'Nagad', '09yut5r6gtb78bh', 10000.00, 2, '2025-09-09 18:47:39'),
(14, 5, 26, '2025-09-10', '2025-09-10', 'kjhgfdsa', 2, 'MOAZ', 500.00, 'bKash', 'hjgfdsftrg', 500.00, 2, '2025-09-10 09:06:54'),
(15, 9, 26, '2025-09-10', '2025-09-10', 'lkjhgf', 3, 'MOAZ', 500.00, 'Nagad', 'hjgfdsftrgkjhgfd', 1000.00, 1, '2025-09-10 09:14:01'),
(16, 11, 28, '2025-09-12', '2025-09-12', '', 1, 'BD10', 1400.00, 'Nagad', 'fhfjjjhjh', 5000.00, 1, '2025-09-10 12:05:42'),
(17, 11, 28, '2025-09-12', '2025-09-12', 'jhg', 2, 'BD10', 2800.00, 'bKash', 'oiuytre', 20000.00, 1, '2025-09-10 12:12:21'),
(18, 12, 26, '2025-09-20', '2025-09-20', '', 1, '', 0.00, 'bKash', 'Expedita aut fugiat ', 500.00, 1, '2025-09-17 10:51:44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customtrips`
--

CREATE TABLE `tbl_customtrips` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `num_travelers` int(11) NOT NULL,
  `budget_per_person` varchar(100) NOT NULL,
  `trip_type` varchar(100) NOT NULL,
  `interests` text DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'New',
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customtrips`
--

INSERT INTO `tbl_customtrips` (`id`, `user_id`, `full_name`, `email`, `phone`, `destination`, `from_date`, `to_date`, `num_travelers`, `budget_per_person`, `trip_type`, `interests`, `status`, `submitted_at`) VALUES
(1, 5, 'Leslie Parker', 'lyned@mailinator.com', '+1 (315) 698-9568', 'Id explicabo In et', '2001-06-20', '1999-05-10', 65, '10000-20000', 'Family Fun', 'Nesciunt illo hic q', 'Rejected', '2025-09-05 10:59:03'),
(2, 5, 'Zeus Bryan', 'xahobu@mailinator.com', '+1 (781) 883-4955', 'Voluptatem Maxime a', '1987-08-18', '1989-05-06', 12, '30000+', 'Family Fun', 'Accusamus non offici', 'Confirmed', '2025-09-05 10:59:16'),
(4, 9, 'sdgsf', 'grabbanibisew@gmail.com', '01736353994', 'Sundorban ', '2025-09-11', '2025-09-13', 4, '10000-20000', 'Relaxation & Leisure', 'ffdffddf', 'Confirmed', '2025-09-10 11:42:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gallery`
--

CREATE TABLE `tbl_gallery` (
  `id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `images` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_gallery`
--

INSERT INTO `tbl_gallery` (`id`, `location`, `images`) VALUES
(1, 'CoxS Bazar ', 'Cox\'s Bazar beach view.jpeg'),
(2, 'Sunamgang', 'Birdwatchers Paradise Tanguar Haor.jpg'),
(3, 'Kuakata ', 'Coastal Beauty of Kuakata.jpg'),
(4, 'Nafakhum', 'Nafakhum Waterfall Expedition.jpg'),
(5, 'Nilgiri', 'Touching the Clouds at Nilgiri.jpg'),
(6, 'Bandorban', 'Thrilling Bandarban Trek.jpg'),
(7, 'Hill Track,Bandorban', 'Colors of the Hill Tracts.jpg'),
(8, 'Hill & Lakes Rangamati', 'Hills & Lakes of Rangamati.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_guides`
--

CREATE TABLE `tbl_guides` (
  `id` int(11) NOT NULL,
  `guide_name` varchar(255) NOT NULL,
  `guide_specialty` varchar(255) NOT NULL,
  `guide_image` varchar(255) NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_guides`
--

INSERT INTO `tbl_guides` (`id`, `guide_name`, `guide_specialty`, `guide_image`, `display_order`, `created_at`) VALUES
(1, 'Sadia Jahan ', 'Hill Trac Speciallist', '1757180797_WhatsApp Image 2025-09-06 at 11.40.17 PM.jpeg', 12, '2025-09-06 17:22:37'),
(2, 'Emily Hadiyat', 'See Beach & Osean Specialist', '1757181054_2.jpeg', 10, '2025-09-06 17:50:54');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_packagetype`
--

CREATE TABLE `tbl_packagetype` (
  `id` int(11) NOT NULL,
  `package_type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_packagetype`
--

INSERT INTO `tbl_packagetype` (`id`, `package_type`, `created_at`) VALUES
(1, 'Family', '2025-08-26 18:00:00'),
(2, 'Couple', '2025-08-26 18:00:00'),
(3, 'Corporate', '2025-08-26 18:00:00'),
(4, 'Friends Group', '2025-08-26 18:00:00'),
(5, 'Study Tour', '2025-08-28 19:06:26'),
(6, 'Single', '2025-09-06 18:20:43');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_package_availability`
--

CREATE TABLE `tbl_package_availability` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `trip_date` date NOT NULL,
  `total_seats` int(11) NOT NULL,
  `booked_seats` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_package_availability`
--

INSERT INTO `tbl_package_availability` (`id`, `package_id`, `trip_date`, `total_seats`, `booked_seats`) VALUES
(2, 27, '2025-09-11', 2, 2),
(3, 28, '2025-09-12', 7, 4),
(4, 25, '2025-09-13', 7, 0),
(5, 26, '2025-09-20', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_promo_codes`
--

CREATE TABLE `tbl_promo_codes` (
  `id` int(11) NOT NULL,
  `promo_code` varchar(50) NOT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `expiry_date` date NOT NULL,
  `usage_limit` int(11) NOT NULL DEFAULT 1,
  `usage_count` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_promo_codes`
--

INSERT INTO `tbl_promo_codes` (`id`, `promo_code`, `discount_type`, `discount_value`, `expiry_date`, `usage_limit`, `usage_count`, `is_active`, `created_at`) VALUES
(2, 'MOAZ', 'fixed', 500.00, '2025-09-13', 5, 2, 1, '2025-09-10 09:04:31'),
(3, 'BD10', 'percentage', 10.00, '2025-09-11', 4, 2, 1, '2025-09-10 11:57:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscribers`
--

CREATE TABLE `tbl_subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subscribed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_subscribers`
--

INSERT INTO `tbl_subscribers` (`id`, `email`, `subscribed_at`) VALUES
(1, 'cogentpwad@gmail.com', '2025-08-29 08:21:06'),
(5, 'lamialusail@gmail.com', '2025-09-10 12:08:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_testimonials`
--

CREATE TABLE `tbl_testimonials` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `user_image` varchar(255) DEFAULT 'default_user.png',
  `rating` int(1) DEFAULT 5,
  `message` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=Pending, 1=Approved',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_testimonials`
--

INSERT INTO `tbl_testimonials` (`id`, `user_name`, `package_id`, `user_image`, `rating`, `message`, `status`, `created_at`) VALUES
(10, 'Cogent Pwad', NULL, '1757228757_7.jpg', 3, 'Reprehenderit excep', 1, '2025-09-07 07:05:57'),
(11, 'Cogent Pwad', NULL, '1757228773_8.png', 5, 'Reprehenderit fuga ', 1, '2025-09-07 07:06:13'),
(12, 'Cogent Pwad', NULL, '1757228788_9.jpeg', 3, 'Irure provident con', 1, '2025-09-07 07:06:28'),
(13, 'Cogent Pwad', NULL, '1757228800_10.jpg', 2, 'Autem quasi culpa a', 1, '2025-09-07 07:06:40'),
(14, 'Lamia', NULL, 'default_user.png', 4, 'loujnybrt', 1, '2025-09-10 12:15:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tourpackage`
--

CREATE TABLE `tbl_tourpackage` (
  `id` int(11) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `package_type` int(11) NOT NULL,
  `package_location` varchar(255) NOT NULL,
  `package_price` int(11) NOT NULL,
  `package_details` text NOT NULL,
  `package_image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_tourpackage`
--

INSERT INTO `tbl_tourpackage` (`id`, `package_name`, `package_type`, `package_location`, `package_price`, `package_details`, `package_image`, `created_at`) VALUES
(25, 'Sundarbans Wildlife Expedition', 1, 'Sundarbon ', 15000, 'Are you Looking for a Sundarban travel agency for your memorable weekend getaway? Planning a family tour can be both exciting and confusing. But worry no more! This winter, surprise your loved ones with an adventurous destination that promises thrills at every turn. Wondering where to go? Look no further! Book an unforgettable Sundarban tour 2 nights 3 days package with Touristhub Holidays, the most reliable and affordable Sundarban tour operator in Khulna.', '1.jpg', '2025-09-06 18:14:58'),
(26, 'Hilling Sitakundo', 6, 'Sitakundo,Chittagong', 699, '2 Days 1 Night', '3.jpeg', '2025-09-06 18:21:36'),
(27, 'Ranga Expedetion ', 3, 'Rangamati', 899, '2 days 1 night ', '4.jpeg', '2025-09-06 18:23:08'),
(28, 'Sitakundo Water Fall', 1, 'Sitakundo,Chittagong', 14000, '2 Days 1 Night', '6.jpg', '2025-09-07 05:31:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_userquery`
--

CREATE TABLE `tbl_userquery` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `emailid` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `status` int(11) DEFAULT 0 COMMENT '0=Pending, 1=Read',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_userquery`
--

INSERT INTO `tbl_userquery` (`id`, `name`, `emailid`, `mobile`, `subject`, `message`, `status`, `created_at`) VALUES
(2, 'Seth Webb', 'nyju@mailinator.com', 'Corporis libero', 'Facere illum numqua', 'Expedita sit numquam', 1, '2025-08-27 07:02:21'),
(6, 'Halee Ramos', '', 'Error libero at', 'Error deleniti excep', 'Quia harum asperiore', 1, '2025-08-31 08:49:02'),
(11, 'Simone Bailey', 'grabbanibisew@gmail.com', 'Quis laborum do', 'Placeat dolore in i', 'Et voluptatum eos sa', 1, '2025-09-06 14:44:13'),
(12, 'Resturent', 'grabbanibisew@gmail.com', '01771802756', 'Vero occaecat deleni', 'ytdfyj', 1, '2025-09-09 18:48:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_userregistration`
--

CREATE TABLE `tbl_userregistration` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `emailid` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Not Verified, 1=Verified',
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_userregistration`
--

INSERT INTO `tbl_userregistration` (`id`, `name`, `emailid`, `mobile`, `password`, `verification_token`, `is_verified`, `reset_token`, `reset_token_expiry`, `created_at`) VALUES
(11, 'Lamia', 'lamialusail@gmail.com', '0123054789', '$2y$10$r1.MY8gcWf1JDArUSljXMOdPa9uNwYXkpq/VjqAlPp7X/0THRanby', 'b52a9c2ff66e4ed795bf25f8582eab01', 1, NULL, NULL, '2025-09-10 09:16:42'),
(12, 'Cogent Pwad', 'cogentpwad@gmail.com', '01410236547', '$2y$10$eq4tocY1RTAl9pQdLcWKeO46dqhyowTbYjL1SyMycEneW0R4EtDjW', 'bdc1e4581a9227beec4a398792fbc079', 1, NULL, NULL, '2025-09-17 05:13:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customtrips`
--
ALTER TABLE `tbl_customtrips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_guides`
--
ALTER TABLE `tbl_guides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_packagetype`
--
ALTER TABLE `tbl_packagetype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_package_availability`
--
ALTER TABLE `tbl_package_availability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `tbl_promo_codes`
--
ALTER TABLE `tbl_promo_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promo_code` (`promo_code`);

--
-- Indexes for table `tbl_subscribers`
--
ALTER TABLE `tbl_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_testimonials`
--
ALTER TABLE `tbl_testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_package_id` (`package_id`);

--
-- Indexes for table `tbl_tourpackage`
--
ALTER TABLE `tbl_tourpackage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_userquery`
--
ALTER TABLE `tbl_userquery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_userregistration`
--
ALTER TABLE `tbl_userregistration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_customtrips`
--
ALTER TABLE `tbl_customtrips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_guides`
--
ALTER TABLE `tbl_guides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_packagetype`
--
ALTER TABLE `tbl_packagetype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_package_availability`
--
ALTER TABLE `tbl_package_availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_promo_codes`
--
ALTER TABLE `tbl_promo_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_subscribers`
--
ALTER TABLE `tbl_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_testimonials`
--
ALTER TABLE `tbl_testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_tourpackage`
--
ALTER TABLE `tbl_tourpackage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_userquery`
--
ALTER TABLE `tbl_userquery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_userregistration`
--
ALTER TABLE `tbl_userregistration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_package_availability`
--
ALTER TABLE `tbl_package_availability`
  ADD CONSTRAINT `tbl_package_availability_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `tbl_tourpackage` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
