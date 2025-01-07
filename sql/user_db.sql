-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2024 at 08:35 PM
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
-- Database: `user_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gear_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1 CHECK (`quantity` > 0),
  `added_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `gear_id`, `quantity`, `added_on`) VALUES
(12, 12, 20, 2, '2024-12-28 15:33:56');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'AHANAF', 'srsrizon665@gmail.com', 'Hi, Nice website', '2024-12-20 15:46:28'),
(2, 'Fariha', 'titly@gmail.com', 'Thanks', '2024-12-20 15:47:31'),
(3, 'AHANAF ABID', 'ahanaf@gmail.com', 'thank you', '2024-12-20 15:49:37'),
(4, 'AHANAF ABID', 'ahanaf@gmail.com', 'thank you', '2024-12-20 15:50:04'),
(5, 'Nowrin', 'nowrin@gmail.com', 'It looks nice', '2024-12-20 15:52:45'),
(6, 'Nowrin', 'nowrin@gmail.com', 'Looks nice', '2024-12-20 15:53:53'),
(7, 'Fariha', 'fariha@gmail.com', 'Nice', '2024-12-20 15:55:12'),
(8, 'Fariha', 'fariha@gmail.com', 'Nice', '2024-12-20 15:57:19'),
(9, 'Fariha', 'fariha@gmail.com', 'nice', '2024-12-20 15:57:34'),
(10, 'Ahanaf abid sazid', 'ahanaf@gmail.com', 'nice page', '2024-12-20 17:11:48');

-- --------------------------------------------------------

--
-- Table structure for table `gear_list`
--

CREATE TABLE `gear_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gear_name` varchar(255) NOT NULL,
  `gear_type` varchar(100) NOT NULL,
  `transaction_type` enum('sell','rent') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `gear_description` text DEFAULT NULL,
  `gear_image` varchar(255) NOT NULL,
  `availability` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `status` enum('Available','Sold') DEFAULT 'Available',
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gear_list`
--

INSERT INTO `gear_list` (`id`, `user_id`, `gear_name`, `gear_type`, `transaction_type`, `price`, `gear_description`, `gear_image`, `availability`, `location`, `status`, `added_date`) VALUES
(20, 12, 'Ghost of tsushima', 'disk', 'sell', 1500.00, 'Tshushima game', 'uploads/ps5-ghostoftsushima-directorscut-game-box-front.webp', '2024-12-25', 'Mymensingh', 'Available', '2024-12-20 19:19:52');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Completed','Cancelled') DEFAULT 'Pending',
  `order_tracking` enum('Order Placed','Processing','Shipped','Delivered','Cancelled') DEFAULT 'Order Placed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `shipping_address`, `order_date`, `status`, `order_tracking`) VALUES
(10, 12, 200.00, 'dhaka', '2024-12-20 15:26:28', 'Pending', 'Cancelled'),
(11, 14, 1500.00, 'badda,dhaka', '2024-12-20 20:42:18', 'Pending', 'Order Placed');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `gear_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `gear_id`, `quantity`, `price`) VALUES
(17, 10, NULL, 1, 200.00),
(18, 11, 20, 1, 1500.00);

-- --------------------------------------------------------

--
-- Table structure for table `privacy_policy`
--

CREATE TABLE `privacy_policy` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `privacy_policy`
--

INSERT INTO `privacy_policy` (`id`, `content`, `last_updated`) VALUES
(1, 'Welcome to our platform. Your privacy is important to us, and we are committed to safeguarding your personal information. This Privacy Policy outlines how we collect, use, and protect your data. By using our services, you agree to the terms outlined in this policy.\r\n\r\nInformation We Collect\r\nWe collect the following types of information:\r\n\r\nPersonal Information: This includes your name, email address, contact number, address, and other details provided during registration or profile updates.\r\nUsage Data: Information about how you interact with our website, including pages viewed, clicks, and time spent on specific sections.\r\nDevice Information: Details about the device you use to access our services, such as IP address, browser type, and operating system.\r\nCookies: We use cookies to improve your browsing experience and customize content. You can manage your cookie preferences through your browser settings.\r\nHow We Use Your Information\r\nYour information is used for the following purposes:\r\n\r\nAccount Management: To create and maintain your account, process transactions, and provide customer support.\r\nImprovement of Services: To analyze user behavior and enhance website functionality and user experience.\r\nCommunication: To send updates, promotional materials, and notifications related to our services. You can opt out of promotional communications at any time.\r\nLegal Compliance: To comply with applicable laws and regulations, prevent fraud, and ensure the security of our platform.\r\nData Sharing and Disclosure\r\nWe do not sell your personal data to third parties. However, we may share your information in the following scenarios:\r\n\r\nService Providers: With trusted partners who assist in operating our platform and delivering services, such as payment processors and hosting providers.\r\nLegal Requirements: When required by law or to protect our legal rights and interests.\r\nBusiness Transfers: In the event of a merger, acquisition, or sale of assets, your information may be transferred to the new entity.\r\nData Security\r\nWe implement robust security measures to protect your information, including encryption, secure servers, and regular security audits. However, no system is completely secure, and we cannot guarantee the absolute security of your data.\r\n\r\nYour Rights\r\nYou have the right to:\r\n\r\nAccess your personal data and request corrections or updates.\r\nDelete your account and associated data.\r\nRestrict or object to certain data processing activities.\r\nWithdraw consent for data collection where applicable.\r\nTo exercise these rights, contact us at support@example.com.\r\n\r\nCookies and Tracking Technologies\r\nWe use cookies and similar technologies to enhance your experience. These tools help us understand user preferences, track website usage, and deliver tailored content. You can manage cookie settings through your browser.\r\n\r\nChildren’s Privacy\r\nOur services are not intended for users under the age of 13. We do not knowingly collect personal information from children. If we discover such data has been collected, we will take immediate steps to delete it.\r\n\r\nChanges to This Policy\r\nWe may update this Privacy Policy from time to time. Significant changes will be communicated through our website or email. We encourage you to review this page periodically to stay informed.\r\n\r\nContact Us\r\nIf you have questions or concerns about this Privacy Policy, please contact us at support@example.com.\r\n\r\nBy using our platform, you agree to this Privacy Policy. Thank you for trusting us with your information.', '2024-12-19 15:24:37');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_subscribed` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `date_subscribed`) VALUES
(1, 'srsrizon665@gmail.com', '2024-12-22 21:22:08'),
(2, 'ahanaf@gmail.com', '2024-12-22 21:28:12'),
(3, 'titly@gmail.com', '2024-12-22 21:30:13'),
(4, 'fariha@gmail.com', '2024-12-22 21:31:29'),
(5, 'apon@gmail.com', '2024-12-22 21:40:02');

-- --------------------------------------------------------

--
-- Table structure for table `terms_conditions`
--

CREATE TABLE `terms_conditions` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terms_conditions`
--

INSERT INTO `terms_conditions` (`id`, `content`) VALUES
(1, 'Welcome to our platform! By using our website, you agree to comply with and be bound by the following terms and conditions. Please read them carefully.\r\n\r\n1. Acceptance of Terms\r\nBy accessing or using this website, you agree to these terms and conditions. If you do not agree with any part of these terms, please refrain from using our services.\r\n\r\n2. Use of the Website\r\nYou are permitted to use this website for lawful purposes only. You agree not to engage in any activity that could harm the website, its users, or its content. Unauthorized use of this website may result in legal action.\r\n\r\n3. User Account\r\nIf you register for an account, you are responsible for maintaining the confidentiality of your login information. You are also responsible for all activities that occur under your account. Please notify us immediately of any unauthorized use.\r\n\r\n4. Content Ownership\r\nAll content provided on this website, including text, images, and other materials, is owned by us or our licensors. You may not reproduce, distribute, or modify any content without prior written consent.\r\n\r\n5. Limitation of Liability\r\nWe are not liable for any direct, indirect, or consequential damages arising from the use or inability to use this website. This includes, but is not limited to, loss of data, revenue, or profits.\r\n\r\n6. Privacy\r\nYour use of this website is also governed by our Privacy Policy. By using this website, you consent to the collection and use of your information as outlined in the policy.\r\n\r\n7. Changes to Terms\r\nWe reserve the right to modify these terms and conditions at any time. It is your responsibility to review them periodically for updates.\r\n\r\nThank you for using our platform! If you have any questions about these terms, please contact us.');

-- --------------------------------------------------------

--
-- Table structure for table `user_form`
--

CREATE TABLE `user_form` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `terms_accepted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_form`
--

INSERT INTO `user_form` (`id`, `name`, `email`, `password`, `reset_token`, `user_type`, `created_at`, `address`, `birthdate`, `bio`, `contact_number`, `profile_pic`, `updated_at`, `terms_accepted`) VALUES
(12, 'AHANAF', 'ahanaf@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'user', '2024-12-19 16:31:21', 'DIT project, Merul Badda, Dhaka', '2000-03-28', 'Turning dreams into plans. 🚀 | Adventure seeker | Coffee enthusiast ☕', '01706941756', 'uploads/IMG-20241209-WA0022.jpg', '2024-12-20 14:32:20', 1),
(13, 'admin', 'admin@example.com', '21232f297a57a5a743894a0e4a801fc3', NULL, 'admin', '2024-12-19 16:40:01', NULL, NULL, NULL, NULL, NULL, '2024-12-20 11:57:32', 0),
(14, 'AHANAF ABID SAZID', 'srsrizon665@gmail.com', '309d850b5b163b7848ded135811138ac', '15f56c0a9edf18acbdade850537f71293cc86fc4711cd9ce8dbf2d16a54cd9d62e9af515e781250cded45e19ba4a2420ee0e', 'user', '2024-12-20 10:27:11', NULL, NULL, NULL, NULL, NULL, '2024-12-20 20:41:57', 1),
(15, 'Srizon', 'srizon@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'user', '2024-12-26 16:08:05', 'Sherpur, Mymensingh', '2024-12-20', '', '01700000000', 'uploads/profile.webp', '2024-12-26 16:08:05', 1),
(16, 'avi', 'avi@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'user', '2024-12-30 19:13:43', 'middlebadda, Dhaka', '2000-06-13', '', '01700000000', 'uploads/profile.webp', '2024-12-30 19:13:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_queries`
--

CREATE TABLE `user_queries` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_queries`
--

INSERT INTO `user_queries` (`id`, `user_id`, `subject`, `message`, `created_at`) VALUES
(3, 12, 'help', 'angshu killing me', '2024-12-20 15:31:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `connection` (`gear_id`),
  ADD KEY `cart-user` (`user_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gear_list`
--
ALTER TABLE `gear_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);
ALTER TABLE `gear_list` ADD FULLTEXT KEY `gear_description` (`gear_description`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_ibfk_1` (`order_id`),
  ADD KEY `order_items_ibfk_2` (`gear_id`);

--
-- Indexes for table `privacy_policy`
--
ALTER TABLE `privacy_policy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `terms_conditions`
--
ALTER TABLE `terms_conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_form`
--
ALTER TABLE `user_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_queries`
--
ALTER TABLE `user_queries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gear_list`
--
ALTER TABLE `gear_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `privacy_policy`
--
ALTER TABLE `privacy_policy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `terms_conditions`
--
ALTER TABLE `terms_conditions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_form`
--
ALTER TABLE `user_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart-gear` FOREIGN KEY (`gear_id`) REFERENCES `gear_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart-user` FOREIGN KEY (`user_id`) REFERENCES `user_form` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gear_list`
--
ALTER TABLE `gear_list`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_form` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_form` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`gear_id`) REFERENCES `gear_list` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
