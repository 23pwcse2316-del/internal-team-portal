-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 27, 2026 at 01:54 AM
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
-- Database: `internal_team_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `can_invite` tinyint(1) NOT NULL DEFAULT 1,
  `admin_since` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`user_id`, `can_invite`, `admin_since`) VALUES
(1, 1, '2026-01-05 04:00:00'),
(2, 1, '2026-01-05 04:05:00'),
(11, 1, '2026-06-25 20:46:51'),
(12, 1, '2026-06-26 23:23:32'),
(12, 1, '2026-06-26 18:26:20');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `channels`
--

CREATE TABLE `channels` (
  `channel_id` bigint(20) UNSIGNED NOT NULL,
  `workspace_id` bigint(20) UNSIGNED NOT NULL,
  `channel_name` varchar(100) NOT NULL,
  `channel_type` enum('Public','Private') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `channels`
--

INSERT INTO `channels` (`channel_id`, `workspace_id`, `channel_name`, `channel_type`, `created_at`) VALUES
(1, 1, 'general', 'Public', '2026-01-05 04:31:00'),
(2, 1, 'project-announcements', 'Public', '2026-01-05 04:32:00'),
(3, 1, 'core-team-private', 'Private', '2026-01-06 05:30:00'),
(4, 2, 'fyp-general', 'Public', '2026-01-06 09:01:00'),
(5, 2, 'fyp-budget-private', 'Private', '2026-01-06 09:05:00'),
(6, 1, 'random', 'Public', '2026-01-07 06:30:00'),
(7, 3, 'GTA 6 Pre-Order', 'Private', '2026-06-25 20:46:51'),
(8, 3, 'PS5 Games', 'Private', '2026-06-25 20:46:51'),
(9, 5, 'Jewelry Desgins', 'Public', '2026-06-26 16:17:26'),
(10, 6, 'Hayatabad Times', 'Public', '2026-06-26 17:11:59');

-- --------------------------------------------------------

--
-- Table structure for table `file_attachments`
--

CREATE TABLE `file_attachments` (
  `attachment_id` bigint(20) UNSIGNED NOT NULL,
  `message_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_url` varchar(500) NOT NULL,
  `storage_key` varchar(255) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `file_size_bytes` bigint(20) UNSIGNED NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_attachments`
--

INSERT INTO `file_attachments` (`attachment_id`, `message_id`, `file_name`, `file_url`, `storage_key`, `mime_type`, `file_size_bytes`, `uploaded_at`) VALUES
(1, 7, 'normalization_notes.pdf', 'https://files.itcp.local/a1', 'key_a1', 'application/pdf', 482133, '2026-01-06 05:51:00'),
(2, 9, 'literature_review_v1.docx', 'https://files.itcp.local/a2', 'key_a2', 'application/msword', 201044, '2026-01-07 06:27:00'),
(3, 10, 'cloud_budget_estimate.xlsx', 'https://files.itcp.local/a3', 'key_a3', 'application/excel', 88210, '2026-01-06 09:07:00'),
(4, 15, 'relational_schema_v2.docx', 'https://files.itcp.local/a4', 'key_a4', 'application/msword', 412980, '2026-01-09 13:11:00'),
(5, 15, 'schema_diagram.png', 'https://files.itcp.local/a5', 'key_a5', 'image/png', 733500, '2026-01-09 13:11:30'),
(6, 6, 'draft_checklist.pdf', 'https://files.itcp.local/a6', 'key_a6', 'application/pdf', 56230, '2026-01-06 05:36:00'),
(7, 3, 'milestone1_template.docx', 'https://files.itcp.local/a7', 'key_a7', 'application/msword', 97650, '2026-01-05 04:47:00'),
(8, 12, 'study_room_booking.pdf', 'https://files.itcp.local/a8', 'key_a8', 'application/pdf', 30200, '2026-01-07 06:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `guest_users`
--

CREATE TABLE `guest_users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `invited_by` bigint(20) UNSIGNED NOT NULL,
  `guest_expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guest_users`
--

INSERT INTO `guest_users` (`user_id`, `invited_by`, `guest_expires_at`) VALUES
(8, 1, '2026-02-08 07:00:00'),
(9, 2, '2026-02-08 07:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` bigint(20) UNSIGNED NOT NULL,
  `channel_id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `parent_message_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content` text NOT NULL,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `pinned_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `edited_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `channel_id`, `author_id`, `parent_message_id`, `content`, `is_pinned`, `pinned_at`, `created_at`, `edited_at`) VALUES
(1, 1, 1, NULL, 'Welcome to the Internal Team Communication Portal!', 1, '2026-01-05 04:33:00', '2026-01-05 04:33:00', NULL),
(2, 1, 3, 1, 'Thanks! Excited to get started.', 0, NULL, '2026-01-05 04:40:00', NULL),
(3, 2, 2, NULL, 'Milestone 1 is due this Friday.', 1, '2026-01-05 04:46:00', '2026-01-05 04:45:00', NULL),
(4, 2, 4, 3, 'Noted, will start the ERD today.', 0, NULL, '2026-01-06 05:10:00', NULL),
(5, 2, 5, 3, 'Same here, syncing with Taufeeq on the EERD part.', 0, NULL, '2026-01-06 05:25:00', NULL),
(6, 3, 1, NULL, 'Core team: please review the normalization draft before submission.', 0, NULL, '2026-01-06 05:35:00', NULL),
(7, 3, 2, 6, 'Reviewed, 3NF looks solid. Added two notes on MESSAGE and TASKITEM.', 0, NULL, '2026-01-06 05:50:00', NULL),
(8, 4, 2, NULL, 'FYP kickoff: topic finalized as Internal Team Communication Portal.', 1, '2026-01-06 09:02:00', '2026-01-06 09:02:00', NULL),
(9, 4, 7, 8, 'Great, I will start drafting the literature review.', 0, NULL, '2026-01-07 06:26:00', NULL),
(10, 5, 2, NULL, 'Budget for cloud storage needs sign-off by Monday.', 0, NULL, '2026-01-06 09:06:00', NULL),
(11, 6, 6, NULL, 'Anyone up for a study session this weekend?', 0, NULL, '2026-01-07 06:31:00', NULL),
(12, 6, 7, 11, 'I am in, library at 4 PM?', 0, NULL, '2026-01-07 06:35:00', NULL),
(13, 1, 10, NULL, 'Hi all, just joined the workspace.', 0, NULL, '2026-01-09 08:06:00', NULL),
(14, 2, 1, NULL, 'Reminder: upload your Milestone 2 docx by tonight.', 1, '2026-01-09 13:00:00', '2026-01-09 12:55:00', NULL),
(15, 2, 6, 14, 'Uploaded, please check the schema diagram attachment.', 0, NULL, '2026-01-09 13:10:00', NULL),
(16, 7, 11, NULL, 'Live Now....', 0, NULL, '2026-06-26 16:07:51', NULL),
(17, 7, 11, 16, 'Price ?', 0, NULL, '2026-06-26 16:07:59', NULL),
(18, 7, 11, NULL, '$80.00 and 100.00 $', 0, NULL, '2026-06-26 16:08:35', NULL),
(19, 8, 11, NULL, 'Hi', 0, NULL, '2026-06-26 16:50:11', NULL),
(20, 7, 11, NULL, 'Hi', 0, NULL, '2026-06-26 16:56:24', NULL),
(21, 7, 11, NULL, 'Hey', 0, NULL, '2026-06-26 16:56:50', NULL),
(22, 7, 12, NULL, 'Hi', 0, NULL, '2026-06-26 17:08:57', NULL),
(23, 7, 11, NULL, 'Hey, wanna buy the game ?', 0, NULL, '2026-06-26 17:09:29', NULL),
(24, 7, 12, NULL, 'Umm, i will think.', 0, NULL, '2026-06-26 17:09:59', NULL),
(25, 10, 11, NULL, 'Hi', 0, NULL, '2026-06-26 17:35:36', NULL),
(26, 10, 2, NULL, 'Kesae ho', 0, NULL, '2026-06-26 17:36:04', NULL),
(27, 7, 11, NULL, 'Hey', 0, NULL, '2026-06-26 18:16:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '01_create_users_table', 1),
(2, '02_create_workspaces_table', 1),
(3, '03_create_workspace_memberships_table', 1),
(4, '04_create_channels_table', 1),
(5, '05_create_messages_table', 1),
(6, '06_create_file_attachments_table', 1),
(7, '07_create_task_items_table', 1),
(8, '08_create_admin_users_table', 1),
(9, '09_create_guest_users_table', 1),
(10, '10_create_public_channels_table', 1),
(11, '11_create_private_channels_table', 1),
(12, '12_create_private_channel_memberships_table', 1),
(13, '2026_06_26_015722_create_cache_table', 1),
(15, '2026_06_26_204644_create_password_reset_tokens_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('msamk2003@gmail.com', '$2y$12$yoDWWMZx2DNcdGnq661rLunQmZPOHHKw1pMKQyZUA8mQUYPBtIJmO', '2026-06-26 15:47:58');

-- --------------------------------------------------------

--
-- Table structure for table `private_channels`
--

CREATE TABLE `private_channels` (
  `channel_id` bigint(20) UNSIGNED NOT NULL,
  `invite_only` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `private_channels`
--

INSERT INTO `private_channels` (`channel_id`, `invite_only`) VALUES
(3, 1),
(5, 1),
(7, 1),
(8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `private_channel_memberships`
--

CREATE TABLE `private_channel_memberships` (
  `pcm_id` bigint(20) UNSIGNED NOT NULL,
  `channel_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `invited_by` bigint(20) UNSIGNED NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `private_channel_memberships`
--

INSERT INTO `private_channel_memberships` (`pcm_id`, `channel_id`, `user_id`, `invited_by`, `joined_at`) VALUES
(1, 3, 1, 1, '2026-01-06 05:30:00'),
(2, 3, 2, 1, '2026-01-06 05:31:00'),
(3, 3, 6, 1, '2026-01-07 06:06:00'),
(4, 5, 2, 2, '2026-01-06 09:05:00'),
(5, 5, 3, 2, '2026-01-06 09:11:00'),
(6, 7, 11, 11, '2026-06-25 20:46:51'),
(7, 8, 11, 11, '2026-06-25 20:46:51'),
(8, 7, 12, 11, '2026-06-26 17:08:40');

-- --------------------------------------------------------

--
-- Table structure for table `public_channels`
--

CREATE TABLE `public_channels` (
  `channel_id` bigint(20) UNSIGNED NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `public_channels`
--

INSERT INTO `public_channels` (`channel_id`, `is_default`) VALUES
(1, 1),
(2, 0),
(4, 1),
(6, 0),
(9, 0),
(10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `task_items`
--

CREATE TABLE `task_items` (
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `channel_id` bigint(20) UNSIGNED NOT NULL,
  `message_id` bigint(20) UNSIGNED NOT NULL,
  `assignee_id` bigint(20) UNSIGNED NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `status` enum('Open','In Progress','Completed') NOT NULL DEFAULT 'Open',
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_items`
--

INSERT INTO `task_items` (`task_id`, `channel_id`, `message_id`, `assignee_id`, `creator_id`, `description`, `status`, `due_date`, `created_at`) VALUES
(1, 2, 3, 4, 2, 'Complete ERD for Milestone 1', 'Completed', '2026-01-09', '2026-01-05 04:46:30'),
(2, 2, 3, 5, 2, 'Draft EERD specialization hierarchies', 'Completed', '2026-01-09', '2026-01-05 04:47:00'),
(3, 3, 6, 2, 1, 'Review normalization draft (1NF-3NF)', 'Completed', '2026-01-06', '2026-01-06 05:36:30'),
(4, 4, 8, 7, 2, 'Write FYP literature review section', 'In Progress', '2026-01-14', '2026-01-06 09:03:00'),
(5, 5, 10, 2, 2, 'Get cloud storage budget sign-off', 'Open', '2026-01-12', '2026-01-06 09:06:30'),
(6, 2, 14, 6, 1, 'Upload final Milestone 2 docx', 'Completed', '2026-01-09', '2026-01-09 12:56:00'),
(7, 2, 14, 3, 1, 'Prepare Milestone 3 SQL implementation', 'In Progress', '2026-01-16', '2026-01-09 12:56:30'),
(8, 6, 11, 7, 6, 'Reserve library study room for weekend', 'Completed', '2026-01-10', '2026-01-07 06:32:00'),
(9, 1, 1, 3, 1, 'Set up workspace onboarding guide', 'Open', '2026-01-15', '2026-01-05 04:34:00'),
(10, 4, 9, 4, 7, 'Cross-check literature review citations', 'Open', '2026-01-17', '2026-01-07 06:28:00'),
(11, 7, 18, 11, 11, 'Sell It', 'Open', '2026-06-30', '2026-06-26 16:09:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `user_type` enum('Admin','Member','Guest') NOT NULL DEFAULT 'Member',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `user_type`, `created_at`, `remember_token`) VALUES
(1, 'saad.m', 'saad.m@uet.edu.pk', '$2y$12$yRh7u/wLyjJLQ9iRMKhwU.o7HXJfc4jTMNuy9X5iCYjmlb0Ru5mNC', 'Admin', '2026-01-05 04:00:00', NULL),
(2, 'amina.i', 'amina.i@uet.edu.pk', '$2y$12$Iy2Z4XrtjidLcHa8rUAHCuEjcPSKyrjTJ4TIxDlwQeIAtkXrdYdri', 'Admin', '2026-01-05 04:05:00', NULL),
(3, 'taufeeq.u', 'taufeeq.u@uet.edu.pk', '$2y$12$C20YR8amY1eu3b5hhnzFVeWUweBxv390R/hFgnW4vwzzj9FXVNopu', 'Member', '2026-01-05 04:10:00', NULL),
(4, 'hassan.k', 'hassan.k@uet.edu.pk', '$2y$12$1oIbI8uMjrA4Xz6hUBvIUeTeIrAog.oyX2SgSVj/PzOFFFyNljmAK', 'Member', '2026-01-06 05:00:00', NULL),
(5, 'fatima.r', 'fatima.r@uet.edu.pk', '$2y$12$nVvPRl4gubLPV0eLUJ/XlObqokRMzxg4PNLn48YdsO7lWzrRwEqOm', 'Member', '2026-01-06 05:15:00', NULL),
(6, 'ali.zaman', 'ali.zaman@uet.edu.pk', '$2y$12$nqrIINr2jG3BnhRSamEL5eRiZglPtCIY5CvgtbPRvvR8XGHXI.MQS', 'Member', '2026-01-07 06:00:00', NULL),
(7, 'sara.n', 'sara.n@uet.edu.pk', '$2y$12$WwUyEcSPCA/nmj0u6jyDwujLdTyaPx4M8qdOvn9h4LGwp8XGe2kRG', 'Member', '2026-01-07 06:20:00', NULL),
(8, 'usman.t', 'usman.t@uet.edu.pk', '$2y$12$wUTobDfrZI0RaofTcnegtulAfEhJ7nsLvDGrUzNrjJj3b4ZL0KQCa', 'Guest', '2026-01-08 07:00:00', NULL),
(9, 'zainab.q', 'zainab.q@uet.edu.pk', '$2y$12$MwsdEN.zLUgj9boacbkn2OHRfTNi/Ey47BDdsipdeesTOLWA4Jzlq', 'Guest', '2026-01-08 07:30:00', NULL),
(10, 'bilal.h', 'bilal.h@uet.edu.pk', '$2y$12$L6ExpzMRAif5Gbifj/nQLuWD7MfmjMB3nBTco2YxQkeNJIVa2VE1S', 'Member', '2026-01-09 08:00:00', NULL),
(11, 'muhammadsaad', 'msamk2003@gmail.com', '$2y$12$Wgz0xf3zEjGXU54iHCAOmeWDhmSMaK64Z52zaD0JTfaJpRoLGH96S', 'Admin', '2026-06-25 20:46:51', NULL),
(12, 'aminaishtiaq', 'aminaishtiaq21@gmail.com', '$2y$12$46tuQgtI2rEJ4D5xH9PeR.LdqCBSz/rXiZOpMF8ZXUd72EUcgwNae', 'Admin', '2026-06-26 16:15:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `workspaces`
--

CREATE TABLE `workspaces` (
  `workspace_id` bigint(20) UNSIGNED NOT NULL,
  `workspace_name` varchar(100) NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workspaces`
--

INSERT INTO `workspaces` (`workspace_id`, `workspace_name`, `creator_id`, `created_at`) VALUES
(1, 'UET-CSE-Spring2026', 1, '2026-01-05 04:30:00'),
(2, 'FYP-Group27-Research', 2, '2026-01-06 09:00:00'),
(3, 'GTA 6', 11, '2026-06-25 20:46:51'),
(4, 'What\'s going in Peshawar', 11, '2026-06-26 16:07:21'),
(5, 'Funky Arts', 12, '2026-06-26 16:16:38'),
(6, 'Peshawar diaries', 11, '2026-06-26 17:11:37');

-- --------------------------------------------------------

--
-- Table structure for table `workspace_memberships`
--

CREATE TABLE `workspace_memberships` (
  `membership_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `workspace_id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('Admin','Member','Guest') NOT NULL DEFAULT 'Member',
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workspace_memberships`
--

INSERT INTO `workspace_memberships` (`membership_id`, `user_id`, `workspace_id`, `role`, `joined_at`) VALUES
(1, 1, 1, 'Admin', '2026-01-05 04:30:00'),
(2, 2, 1, 'Admin', '2026-01-05 04:35:00'),
(3, 3, 1, 'Member', '2026-01-05 04:40:00'),
(4, 4, 1, 'Member', '2026-01-06 05:05:00'),
(5, 5, 1, 'Member', '2026-01-06 05:20:00'),
(6, 6, 1, 'Member', '2026-01-07 06:05:00'),
(7, 8, 1, 'Guest', '2026-01-08 07:05:00'),
(8, 2, 2, 'Admin', '2026-01-06 09:00:00'),
(9, 3, 2, 'Member', '2026-01-06 09:10:00'),
(10, 7, 2, 'Member', '2026-01-07 06:25:00'),
(11, 9, 2, 'Guest', '2026-01-08 07:35:00'),
(12, 10, 1, 'Member', '2026-01-09 08:05:00'),
(13, 11, 3, 'Admin', '2026-06-25 20:46:51'),
(14, 11, 4, 'Admin', '2026-06-26 16:07:21'),
(15, 12, 5, 'Admin', '2026-06-26 16:16:38'),
(16, 12, 3, 'Member', '2026-06-26 22:08:29'),
(17, 3, 3, 'Member', '2026-06-26 22:08:29'),
(18, 11, 6, 'Admin', '2026-06-26 17:11:37'),
(29, 1, 4, 'Member', '2026-06-26 17:19:41'),
(30, 2, 4, 'Member', '2026-06-26 17:19:41'),
(31, 3, 4, 'Member', '2026-06-26 17:19:41'),
(32, 4, 4, 'Member', '2026-06-26 17:19:41'),
(33, 5, 4, 'Member', '2026-06-26 17:19:41'),
(34, 6, 4, 'Member', '2026-06-26 17:19:41'),
(35, 7, 4, 'Member', '2026-06-26 17:19:41'),
(36, 8, 4, 'Member', '2026-06-26 17:19:41'),
(37, 9, 4, 'Member', '2026-06-26 17:19:41'),
(38, 10, 4, 'Member', '2026-06-26 17:19:41'),
(40, 2, 5, 'Member', '2026-06-26 17:28:56'),
(41, 2, 6, 'Member', '2026-06-26 22:35:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD KEY `admin_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `channels`
--
ALTER TABLE `channels`
  ADD PRIMARY KEY (`channel_id`),
  ADD UNIQUE KEY `channels_workspace_id_channel_name_unique` (`workspace_id`,`channel_name`);

--
-- Indexes for table `file_attachments`
--
ALTER TABLE `file_attachments`
  ADD PRIMARY KEY (`attachment_id`),
  ADD UNIQUE KEY `file_attachments_file_url_storage_key_unique` (`file_url`,`storage_key`),
  ADD KEY `file_attachments_message_id_foreign` (`message_id`);

--
-- Indexes for table `guest_users`
--
ALTER TABLE `guest_users`
  ADD KEY `guest_users_user_id_foreign` (`user_id`),
  ADD KEY `guest_users_invited_by_foreign` (`invited_by`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `messages_channel_id_foreign` (`channel_id`),
  ADD KEY `messages_author_id_foreign` (`author_id`),
  ADD KEY `messages_parent_message_id_foreign` (`parent_message_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `private_channels`
--
ALTER TABLE `private_channels`
  ADD KEY `private_channels_channel_id_foreign` (`channel_id`);

--
-- Indexes for table `private_channel_memberships`
--
ALTER TABLE `private_channel_memberships`
  ADD PRIMARY KEY (`pcm_id`),
  ADD UNIQUE KEY `private_channel_memberships_channel_id_user_id_unique` (`channel_id`,`user_id`),
  ADD KEY `private_channel_memberships_user_id_foreign` (`user_id`),
  ADD KEY `private_channel_memberships_invited_by_foreign` (`invited_by`);

--
-- Indexes for table `public_channels`
--
ALTER TABLE `public_channels`
  ADD KEY `public_channels_channel_id_foreign` (`channel_id`);

--
-- Indexes for table `task_items`
--
ALTER TABLE `task_items`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `task_items_channel_id_foreign` (`channel_id`),
  ADD KEY `task_items_message_id_foreign` (`message_id`),
  ADD KEY `task_items_assignee_id_foreign` (`assignee_id`),
  ADD KEY `task_items_creator_id_foreign` (`creator_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `workspaces`
--
ALTER TABLE `workspaces`
  ADD PRIMARY KEY (`workspace_id`),
  ADD KEY `workspaces_creator_id_foreign` (`creator_id`);

--
-- Indexes for table `workspace_memberships`
--
ALTER TABLE `workspace_memberships`
  ADD PRIMARY KEY (`membership_id`),
  ADD UNIQUE KEY `workspace_memberships_user_id_workspace_id_unique` (`user_id`,`workspace_id`),
  ADD KEY `workspace_memberships_workspace_id_foreign` (`workspace_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `channels`
--
ALTER TABLE `channels`
  MODIFY `channel_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `file_attachments`
--
ALTER TABLE `file_attachments`
  MODIFY `attachment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `private_channel_memberships`
--
ALTER TABLE `private_channel_memberships`
  MODIFY `pcm_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `task_items`
--
ALTER TABLE `task_items`
  MODIFY `task_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `workspaces`
--
ALTER TABLE `workspaces`
  MODIFY `workspace_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `workspace_memberships`
--
ALTER TABLE `workspace_memberships`
  MODIFY `membership_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD CONSTRAINT `admin_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `channels`
--
ALTER TABLE `channels`
  ADD CONSTRAINT `channels_workspace_id_foreign` FOREIGN KEY (`workspace_id`) REFERENCES `workspaces` (`workspace_id`);

--
-- Constraints for table `file_attachments`
--
ALTER TABLE `file_attachments`
  ADD CONSTRAINT `file_attachments_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`message_id`) ON DELETE CASCADE;

--
-- Constraints for table `guest_users`
--
ALTER TABLE `guest_users`
  ADD CONSTRAINT `guest_users_invited_by_foreign` FOREIGN KEY (`invited_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `guest_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `messages_channel_id_foreign` FOREIGN KEY (`channel_id`) REFERENCES `channels` (`channel_id`),
  ADD CONSTRAINT `messages_parent_message_id_foreign` FOREIGN KEY (`parent_message_id`) REFERENCES `messages` (`message_id`);

--
-- Constraints for table `private_channels`
--
ALTER TABLE `private_channels`
  ADD CONSTRAINT `private_channels_channel_id_foreign` FOREIGN KEY (`channel_id`) REFERENCES `channels` (`channel_id`);

--
-- Constraints for table `private_channel_memberships`
--
ALTER TABLE `private_channel_memberships`
  ADD CONSTRAINT `private_channel_memberships_channel_id_foreign` FOREIGN KEY (`channel_id`) REFERENCES `private_channels` (`channel_id`),
  ADD CONSTRAINT `private_channel_memberships_invited_by_foreign` FOREIGN KEY (`invited_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `private_channel_memberships_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `public_channels`
--
ALTER TABLE `public_channels`
  ADD CONSTRAINT `public_channels_channel_id_foreign` FOREIGN KEY (`channel_id`) REFERENCES `channels` (`channel_id`);

--
-- Constraints for table `task_items`
--
ALTER TABLE `task_items`
  ADD CONSTRAINT `task_items_assignee_id_foreign` FOREIGN KEY (`assignee_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `task_items_channel_id_foreign` FOREIGN KEY (`channel_id`) REFERENCES `channels` (`channel_id`),
  ADD CONSTRAINT `task_items_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `task_items_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`message_id`);

--
-- Constraints for table `workspaces`
--
ALTER TABLE `workspaces`
  ADD CONSTRAINT `workspaces_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `workspace_memberships`
--
ALTER TABLE `workspace_memberships`
  ADD CONSTRAINT `workspace_memberships_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `workspace_memberships_workspace_id_foreign` FOREIGN KEY (`workspace_id`) REFERENCES `workspaces` (`workspace_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
