-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2020 at 09:35 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `seizeit`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_id` int(10) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `name`, `sort_id`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'CASABLANCA DINNER', 0, '<p>Indulge in the collaboration between exotic Moroccan flavors and the Art Deco style of Casablanca.</p>', '', '2017-08-16 19:29:26', '2017-11-08 05:52:49'),
(2, 'ROCK OF AGES DINNER', 1, 'Travel through time with the music that has inspired us all.', '/activity/images/2/RockOfAges-251.jpg', '2017-08-28 07:44:27', '2017-09-01 17:26:30'),
(3, 'COASTAL HIKING', 2, 'Enjoy a 3.5 mile guided hike along La Jolla’s historic Cliffside Trail with breathtaking views of the Seven Caves.', '/activity/images/3/Coastal-Hike-251.jpg', '2017-08-28 07:45:01', '2017-09-01 14:51:06'),
(4, 'CHEF IN TRAINING', 3, 'Become a Top Chef as you create a three-course meal from start to finish in this hands-on cooking experience.', '/activity/images/4/Cooking-Class-251.jpg', '2017-08-28 07:46:32', '2017-09-01 14:51:33'),
(5, 'SEA CAVE KAYAKING', 4, 'Enjoy San Diego’s perfect climate as you observe sea lions, leopard sharks, pelicans and the kelp forest while kayaking through La Jolla’s famous sea caves.', '/activity/images/5/Kayak-251.jpg', '2017-08-28 07:47:40', '2017-09-01 17:25:05'),
(6, 'GOLF', 5, 'Play on a Tom Fazio course, featuring dramatic elevations, diverse bunkering and lush fairways in the Los Peñasquitos Canyon.', '/activity/images/6/Golf2.jpg', '2017-08-28 07:48:14', '2017-09-01 17:25:43');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `description` text,
  `url` varchar(300) DEFAULT NULL,
  `sort_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `url`, `sort_id`, `created_at`, `updated_at`) VALUES
(4, 'Internship', 'test desc', 'test url', 0, '2020-01-24 14:21:57', '2020-01-24 14:21:57'),
(5, 'Job', 'test', 'xcvxbvcb', 1, '2020-01-24 14:53:17', '2020-01-24 14:53:17');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(10) UNSIGNED NOT NULL,
  `place` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_text` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT 'Sessions',
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `place`, `session_text`, `date`, `created_at`, `updated_at`) VALUES
(34, NULL, 'Sessions', '2017-09-27', '2017-08-29 04:02:39', '2017-08-29 12:18:14'),
(35, NULL, 'Sessions', '2017-09-06', '2017-08-29 04:11:55', '2017-08-29 04:11:55'),
(36, NULL, 'Sessions', '2017-09-07', '2017-08-29 04:33:59', '2017-09-06 08:56:16'),
(39, NULL, 'Test1', '2017-09-27', '2017-09-26 01:04:59', '2017-09-26 01:04:59'),
(40, NULL, '26Sept.', '2017-09-27', '2017-09-26 01:21:59', '2017-09-26 01:21:59'),
(41, NULL, '26Sept-01', '2017-09-27', '2017-09-26 02:04:26', '2017-09-26 02:04:26'),
(42, NULL, '26 Sept 02', '2017-09-27', '2017-09-26 02:23:36', '2017-09-26 02:23:36'),
(43, NULL, 'Sept27 01', '2017-09-26', '2017-09-27 06:43:14', '2017-09-27 06:43:14');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(21) UNSIGNED NOT NULL,
  `login_image` text,
  `splash_image` text,
  `navigation_image` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `login_image`, `splash_image`, `navigation_image`, `created_at`, `updated_at`) VALUES
(1, '', '', '', NULL, '2017-09-26 04:57:53');

-- --------------------------------------------------------

--
-- Table structure for table `majors`
--

CREATE TABLE `majors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_id` int(10) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `signature_image` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `majors`
--

INSERT INTO `majors` (`id`, `name`, `sort_id`, `description`, `signature_image`, `image`, `created_at`, `updated_at`) VALUES
(7, 'Maths', 0, 'Maths', NULL, NULL, '2020-01-23 10:00:53', '2020-01-24 14:54:05'),
(8, 'Arts', 1, 'Arts', NULL, NULL, '2020-01-23 10:01:02', '2020-01-23 10:01:02'),
(9, 'Psychology', 2, 'test', NULL, NULL, '2020-01-24 13:32:55', '2020-01-24 13:32:55'),
(10, 'Sceince', 3, 'TEst', NULL, NULL, '2020-01-24 14:54:37', '2020-01-24 14:54:37');

-- --------------------------------------------------------

--
-- Table structure for table `major_categories`
--

CREATE TABLE `major_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `major_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `major_categories`
--

INSERT INTO `major_categories` (`id`, `major_id`, `category_id`, `created_at`, `updated_at`) VALUES
(3, 7, 4, '2020-01-24 14:54:05', '2020-01-24 14:54:05'),
(4, 7, 5, '2020-01-24 14:54:05', '2020-01-24 14:54:05'),
(5, 10, 5, '2020-01-24 14:54:37', '2020-01-24 14:54:37');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(25, '2014_10_12_000000_create_users_table', 1),
(26, '2014_10_12_100000_create_password_resets_table', 1),
(27, '2017_08_10_093121_create_speakers_table', 1),
(28, '2017_08_10_133513_create_events_table', 1),
(29, '2017_08_11_090705_create_session_table', 1),
(30, '2017_08_11_092034_create_sponsors_table', 1),
(31, '2017_08_11_105827_create_activities_table', 1),
(32, '2017_08_11_125819_create_welcome_table', 1),
(33, '2017_08_15_072112_create_session_speaker_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) NOT NULL,
  `session_id` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `session_id`, `created_at`, `updated_at`) VALUES
(2, 43, '2017-09-04 19:30:01', '2017-09-04 19:30:01'),
(3, 44, '2017-09-05 00:30:01', '2017-09-05 00:30:01'),
(4, 45, '2017-09-05 00:46:02', '2017-09-05 00:46:02'),
(5, 46, '2017-09-05 01:46:02', '2017-09-05 01:46:02'),
(6, 54, '2017-09-05 19:30:01', '2017-09-05 19:30:01'),
(7, 55, '2017-09-05 20:30:01', '2017-09-05 20:30:01'),
(8, 56, '2017-09-05 21:30:02', '2017-09-05 21:30:02'),
(9, 57, '2017-09-05 21:46:01', '2017-09-05 21:46:01'),
(10, 58, '2017-09-06 01:00:01', '2017-09-06 01:00:01'),
(11, 47, '2017-09-06 01:30:01', '2017-09-06 01:30:01'),
(12, 59, '2017-09-06 02:00:01', '2017-09-06 02:00:01'),
(13, 48, '2017-09-06 02:30:01', '2017-09-06 02:30:01'),
(14, 49, '2017-09-06 03:16:01', '2017-09-06 03:16:01'),
(15, 50, '2017-09-06 04:30:01', '2017-09-06 04:30:01'),
(16, 51, '2017-09-06 04:46:01', '2017-09-06 04:46:01'),
(17, 52, '2017-09-06 05:30:01', '2017-09-06 05:30:01'),
(18, 53, '2017-09-06 06:30:02', '2017-09-06 06:30:02'),
(19, 60, '2017-09-07 01:30:01', '2017-09-07 01:30:01'),
(20, 61, '2017-09-07 02:30:01', '2017-09-07 02:30:01'),
(21, 62, '2017-09-07 03:30:01', '2017-09-07 03:30:01'),
(22, 63, '2017-09-07 04:30:01', '2017-09-07 04:30:01'),
(23, 64, '2017-09-07 04:46:02', '2017-09-07 04:46:02'),
(24, 65, '2017-09-07 05:30:01', '2017-09-07 05:30:01'),
(25, 66, '2017-09-07 06:30:02', '2017-09-07 06:30:02'),
(26, 68, '2017-09-26 06:16:01', '2017-09-26 06:16:01'),
(27, 69, '2017-09-26 06:46:01', '2017-09-26 06:46:01'),
(28, 70, '2017-09-26 07:12:01', '2017-09-26 07:12:01'),
(29, 43, '2017-09-26 08:06:01', '2017-09-26 08:06:01'),
(30, 44, '2017-09-26 08:06:01', '2017-09-26 08:06:01'),
(31, 45, '2017-09-26 08:06:29', '2017-09-26 08:06:29'),
(32, 46, '2017-09-26 08:06:30', '2017-09-26 08:06:30'),
(33, 43, '2017-09-26 13:27:15', '2017-09-26 13:27:15'),
(34, 43, '2017-09-26 13:47:51', '2017-09-26 13:47:51'),
(35, 43, '2017-09-27 07:04:01', '2017-09-27 07:04:01'),
(36, 45, '2017-09-27 07:04:02', '2017-09-27 07:04:02'),
(37, 46, '2017-09-27 07:04:02', '2017-09-27 07:04:02'),
(38, 44, '2017-09-27 07:06:01', '2017-09-27 07:06:01'),
(39, 43, '2017-09-27 09:10:01', '2017-09-27 09:10:01'),
(40, 43, '2017-09-27 09:22:02', '2017-09-27 09:22:02'),
(41, 44, '2017-09-27 09:22:02', '2017-09-27 09:22:02'),
(42, 45, '2017-09-27 09:22:02', '2017-09-27 09:22:02'),
(43, 46, '2017-09-27 09:22:03', '2017-09-27 09:22:03'),
(44, 43, '2017-09-27 09:30:01', '2017-09-27 09:30:01'),
(45, 44, '2017-09-27 09:30:02', '2017-09-27 09:30:02'),
(46, 45, '2017-09-27 09:30:02', '2017-09-27 09:30:02'),
(47, 46, '2017-09-27 09:30:02', '2017-09-27 09:30:02'),
(48, 43, '2017-09-27 10:20:02', '2017-09-27 10:20:02'),
(49, 43, '2017-09-27 10:24:01', '2017-09-27 10:24:01'),
(50, 43, '2017-09-27 10:26:01', '2017-09-27 10:26:01'),
(51, 43, '2017-09-27 10:30:01', '2017-09-27 10:30:01'),
(52, 43, '2017-09-27 10:34:01', '2017-09-27 10:34:01'),
(53, 43, '2017-09-27 10:42:01', '2017-09-27 10:42:01'),
(54, 43, '2017-09-27 10:44:01', '2017-09-27 10:44:01'),
(55, 43, '2017-09-27 11:04:01', '2017-09-27 11:04:01'),
(56, 44, '2017-09-27 11:04:02', '2017-09-27 11:04:02'),
(57, 43, '2017-09-27 11:10:01', '2017-09-27 11:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(10) UNSIGNED NOT NULL,
  `event_id` int(10) UNSIGNED DEFAULT NULL,
  `time` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `place` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `speakers` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_status` int(10) DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `event_id`, `time`, `place`, `speakers`, `title`, `send_status`, `description`, `image`, `created_at`, `updated_at`) VALUES
(43, 34, '4:13 PM-4:30 PM', 'West Foyer', NULL, 'Check-In and Registration', 1, NULL, NULL, '2017-08-29 04:04:32', '2017-09-27 11:10:01'),
(44, 34, '4:08 PM-4:15 PM', 'Elizabeth Ballroom', NULL, 'Opening Remarks', 1, NULL, NULL, '2017-08-29 04:05:49', '2017-09-27 11:04:02'),
(45, 34, '2:40 PM-4:15 PM', 'Elizabeth Ballroom', NULL, 'Session 1: Keynote Address by President Bill Clinton', 1, 'SPEAKER: President Bill Clinton, introduced by Paul J. Geller', NULL, '2017-08-29 04:08:04', '2017-09-27 09:30:02'),
(46, 34, '2:50 PM-4:00 PM', 'Aria Lawn', NULL, 'Casablanca Dinner', 1, 'Indulge in the collaboration between exotic Moroccan flavors and the Art Deco style of Casablanca.', NULL, '2017-08-29 04:09:00', '2017-09-27 09:30:02'),
(47, 35, '7:00 AM-8:00 AM', 'North Foyer & Courtyard', NULL, 'Breakfast', 1, NULL, NULL, '2017-08-29 04:14:41', '2017-09-06 01:30:01'),
(48, 35, '8:00 AM-8:45 AM', 'Elizabeth Ballroom', NULL, 'Session 2: Investing in an Age of Uncertainty', 1, '<p>A visionary futurist reviews the big picture of emerging threats and opportunities in an unpredictable world, while providing actionable advice for protecting against downside risk while seeking superior returns, including a review of what questions you should be asking your investment managers to ensure that your fund can survive these uncertain times.</p>', '/session/images/48/Regera_front_banner2.jpg', '2017-08-29 04:18:03', '2017-09-26 04:25:07'),
(49, 35, '8:45 AM-10:00 AM', 'Elizabeth Ballroom', NULL, 'Session 3: Global Investor Roundup - Moderated by Patrick W. Daniels', 1, 'International experts and experienced asset managers cover the issues facing investors in regions around the world and explore the events that should be discussed in your boardroom.', NULL, '2017-08-29 04:19:03', '2017-09-06 03:16:01'),
(50, 35, '10:00 AM-10:15 AM', 'West Foyer', NULL, 'Networking Break', 1, NULL, NULL, '2017-08-29 04:19:56', '2017-09-06 04:30:01'),
(51, 35, '10:15 AM-11:00 AM', 'Elizabeth Ballroom', NULL, 'Session 4: Making Money Matter', 1, 'A leading thinker and investor reveals how to create an investment model that creates a bridge between philosophical values and investment management, which supports reasonable returns, long-term economic health, and a healthy future for the planet.', NULL, '2017-08-29 04:20:53', '2017-09-06 04:46:01'),
(52, 35, '11:00 AM-12:00 PM', 'Elizabeth Ballroom', NULL, 'Session 5: Impact Investing for Pension Funds', 1, 'A review of methods pension fund trustees can utilize to earn competitive returns while deploying capital to improve the world. Pension funds are feeling the heat from activists to “do good” on a host of issues. How are leading institutions responding? What are the most effective ways for fund trustees to have an impact while upholding their fiduciary duties?', NULL, '2017-08-29 04:22:44', '2017-09-06 05:30:01'),
(53, 35, '12:00 PM-1:00 PM', 'Aria Lawn', NULL, 'Lunch', 1, NULL, NULL, '2017-08-29 04:23:38', '2017-09-06 06:30:02'),
(54, 35, '1:00 PM-2:00 PM', 'Elizabeth Ballroom', NULL, 'Session 6: You Don’t Have to Be a Shark: Creating Your Own Success - Robert Herjavec, Introduced by Paul J Geller', 1, 'Dynamic entrepreneur and “Shark Tank” investor Robert Herjavec provides inspirational advice and reveals the keys to accomplishment in today’s fast-paced, disruptive and innovative business world.', NULL, '2017-08-29 04:24:55', '2017-09-05 19:30:01'),
(55, 35, '2:00 PM-3:00 PM', 'Elizabeth Ballroom', NULL, 'Session 7: The Opioid Epidemic - Moderated by Paul J. Geller', 1, 'A discussion of the role of litigation in combating one of the worst health crises in American history.', NULL, '2017-08-29 04:25:58', '2017-09-05 20:30:01'),
(56, 35, '3:00 PM-3:15 PM', 'West Foyer', NULL, 'Networking Break', 1, NULL, NULL, '2017-08-29 04:26:47', '2017-09-05 21:30:02'),
(57, 35, '3:15 PM-4:15 PM', 'Elizabeth Ballroom', NULL, 'Session 8: The Engagement Debate - Moderated by Richard A. Bennett', 1, 'As investors are insisting on more dialogue with public company management, and with a new U.S. investment stewardship code, experts review what works and what does not for improving accountability and performance through engagement between pension funds and their portfolio companies.', NULL, '2017-08-29 04:27:57', '2017-09-05 21:46:01'),
(58, 35, '6:30 PM-7:30 PM', 'West Foyer', NULL, 'Cocktail Reception', 1, NULL, NULL, '2017-08-29 04:28:35', '2017-09-06 01:00:01'),
(59, 35, '7:30 PM-11:59 PM', 'Elizabeth Ballroom', NULL, 'Rock of Ages Dinner', 1, NULL, NULL, '2017-08-29 04:33:05', '2017-09-06 02:00:01'),
(60, 36, '7:00 AM-8:00 AM', 'North Foyer & Courtyard', NULL, 'Breakfast', 1, NULL, NULL, '2017-08-29 04:34:52', '2017-09-07 01:30:01'),
(61, 36, '8:00 AM-9:00 AM', 'Elizabeth Ballroom', NULL, 'Session 9: Best Practices in Fund Governance', 1, 'A review of how pension funds are continually improving their own practices, from board governance and investment policy-making, to risk management and stakeholder relations. Learn what is working best from fund managers who are leading innovation and improving accountability for pension funds throughout the world.', NULL, '2017-08-29 04:35:35', '2017-09-07 02:30:01'),
(62, 36, '9:00 AM-10:00 AM', 'Elizabeth Ballroom', NULL, 'Session 10: Recoveries and Remedies: Protecting Your Portfolio Through Securities Litigation', 1, 'Leading securities lawyers and fund managers present case studies on the successful use of securities litigation by pension funds to improve returns, reduce risk and repair troubled companies in their portfolios.', NULL, '2017-08-29 04:36:56', '2017-09-07 03:30:01'),
(63, 36, '10:00 AM-10:15 AM', 'West Foyer', NULL, 'Networking Break', 1, NULL, NULL, '2017-08-29 04:37:43', '2017-09-07 04:30:01'),
(64, 36, '10:15 AM-11:00 AM', 'Elizabeth Ballroom', NULL, 'Session 11: Emerging Issues in Governance and Investing - Moderated by Richard A. Bennett', 1, 'Experienced practitioners and far-sighted thinkers discuss the current landscape of managing pensions, investing responsibly, changing the boardroom and protecting portfolio returns.', NULL, '2017-08-29 04:38:40', '2017-09-07 04:46:02'),
(65, 36, '11:00 AM-12:00 PM', 'Elizabeth Ballroom', NULL, 'Session 12: A New World Disorder - Introduced by Michael J. Dowd', 1, 'Described by The New York Times as “one of the nation’s most aggressive and outspoken prosecutors of public corruption and Wall Street crime,” former U.S. Attorney for the Southern District of New York Preet Bharara gives an overview of the future of Wall Street and the challenges faced by investors today.', NULL, '2017-08-29 04:39:50', '2017-09-07 05:30:01'),
(66, 36, '12:00 PM-5:30 PM', 'North Foyer', NULL, 'Lunch and Networking Activities: Coastal Hike, Sea Cave Kayaking, Chef in Training and Golf', 1, NULL, NULL, '2017-08-29 04:41:26', '2017-09-07 06:30:02'),
(68, 40, '11:45 AM-12:00 PM', NULL, NULL, NULL, 1, NULL, NULL, '2017-09-26 01:26:57', '2017-09-26 06:16:01'),
(69, 41, '12:15 PM-12:30 PM', NULL, NULL, NULL, 1, NULL, NULL, '2017-09-26 02:06:26', '2017-09-26 06:46:01'),
(70, 42, '12:30 PM-12:45 PM', NULL, NULL, NULL, 1, NULL, NULL, '2017-09-26 02:24:07', '2017-09-26 07:12:01'),
(71, 43, '12:30 PM-1:45 PM', NULL, NULL, NULL, 0, NULL, NULL, '2017-09-27 06:46:12', '2017-09-27 06:50:30');

-- --------------------------------------------------------

--
-- Table structure for table `session_speakers`
--

CREATE TABLE `session_speakers` (
  `id` int(10) UNSIGNED NOT NULL,
  `session_id` int(10) UNSIGNED NOT NULL,
  `speaker_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `session_speakers`
--

INSERT INTO `session_speakers` (`id`, `session_id`, `speaker_id`, `created_at`, `updated_at`) VALUES
(155, 44, 5, NULL, NULL),
(158, 45, 6, NULL, NULL),
(159, 45, 9, NULL, NULL),
(181, 55, 26, NULL, NULL),
(182, 55, 27, NULL, NULL),
(183, 55, 44, NULL, NULL),
(188, 57, 28, NULL, NULL),
(189, 57, 29, NULL, NULL),
(190, 57, 30, NULL, NULL),
(191, 57, 5, NULL, NULL),
(193, 49, 11, NULL, NULL),
(194, 49, 12, NULL, NULL),
(195, 49, 13, NULL, NULL),
(196, 49, 14, NULL, NULL),
(197, 49, 15, NULL, NULL),
(200, 52, 18, NULL, NULL),
(201, 52, 19, NULL, NULL),
(202, 54, 20, NULL, NULL),
(203, 54, 9, NULL, NULL),
(204, 61, 31, NULL, NULL),
(205, 61, 32, NULL, NULL),
(206, 61, 33, NULL, NULL),
(207, 62, 34, NULL, NULL),
(209, 62, 36, NULL, NULL),
(210, 64, 37, NULL, NULL),
(211, 64, 38, NULL, NULL),
(212, 64, 39, NULL, NULL),
(213, 64, 5, NULL, NULL),
(216, 65, 40, NULL, NULL),
(217, 65, 41, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(21) UNSIGNED NOT NULL,
  `speaker_sort` int(21) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `speaker_sort`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplements`
--

CREATE TABLE `supplements` (
  `id` int(11) NOT NULL,
  `name` varchar(220) DEFAULT NULL,
  `sort_id` int(11) DEFAULT NULL,
  `detail` text,
  `pdf_file` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplements`
--

INSERT INTO `supplements` (`id`, `name`, `sort_id`, `detail`, `pdf_file`, `created_at`, `updated_at`) VALUES
(3, '2017 Public Funds Forum Magazine', 1, 'The 2017 Public Funds Forum Magazine outlines speakers sessons and activites at the 2017 Public Funds Forum in San Diego, California.', '/supplement/files/3/2017 Public Funds Forum Magazine.pdf', '2017-08-30 12:17:17', '2017-08-30 12:17:17'),
(4, '2017 PFF Essays Book by ValueEdge Advisors LLC', 0, 'A Collection of Essays by ValueEdge Advisors LLC', NULL, '2017-08-30 12:22:40', '2017-08-30 12:22:40');

-- --------------------------------------------------------

--
-- Table structure for table `uni`
--

CREATE TABLE `uni` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_id` int(10) DEFAULT NULL,
  `uni_detail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `uni`
--

INSERT INTO `uni` (`id`, `name`, `designation`, `sort_id`, `uni_detail`, `image`, `created_at`, `updated_at`) VALUES
(5, 'Richard A. Bennett', 'President & CEO, ValueEdge Advisors', 25, 'Test description', '/speaker/images/5/Bennett.jpg', '2017-08-28 02:59:57', '2020-01-22 10:24:08'),
(6, 'President Bill Clinton', 'Founder, Clinton Foundation, 42nd President of the United States', 23, 'Test description', '/speaker/images/6/Clinton.jpg', '2017-08-28 05:04:28', '2020-01-22 10:24:08'),
(9, 'Paul J. Geller', 'Partner, Robbins Geller Rudman & Dowd LLP', 20, 'Test description', '/speaker/images/9/Geller.jpg', '2017-08-28 05:26:08', '2020-01-22 10:24:08'),
(11, 'David Couldridge', 'Head of ESG Engagement, Investec Asset Management', 7, 'Test description', '/speaker/images/11/Couldridge.jpg', '2017-08-28 05:30:36', '2020-01-22 10:24:08'),
(12, 'Michael D. Herrera', 'Senior Counsel, Los Angeles County Employees Retirement Association (LACERA)', 16, 'Test description', '/speaker/images/12/Herrera.jpg', '2017-08-28 05:33:00', '2020-01-22 10:24:08'),
(13, 'Melissa McDonald', 'Global Head of Product - Equity & Responsible Investment, HSBC Global Asset Management', 14, 'Test description', '/speaker/images/13/McDonald.jpg', '2017-08-28 05:35:58', '2020-01-22 10:24:08'),
(14, 'Gerard Noonan', 'President, Australian Council of Superannuation Investors (ACSI)', 8, 'Test description', '/speaker/images/14/Noonan.jpg', '2017-08-28 05:48:50', '2020-01-22 10:24:08'),
(15, 'Patrick W. Daniels', 'Partner, Robbins Geller Rudman & Dowd LLP', 19, 'Test description', '/speaker/images/15/Daniels.Patrick 8993 Final RP.jpg', '2017-08-28 05:52:17', '2020-01-22 10:24:08'),
(18, 'Harry Keiley', 'Chairman of the Investment Committee, California State Teachers\' Retirement System (CalSTRS)', 9, 'Test description', '/speaker/images/18/Keiley.jpg', '2017-08-28 06:13:51', '2020-01-22 10:24:08'),
(19, 'Councillor Kieran Quinn', 'Leader, Tameside Metropolitan Borough Council - Chair, Greater Manchester Pension Fund', 3, 'Test description', '/speaker/images/19/Quinn.jpg', '2017-08-28 06:16:31', '2020-01-22 10:24:08'),
(20, 'Robert Herjavec', 'Panelist on ABC\'s Shark Tank, Bestselling Author & Entrepreneur', 27, 'Test description', '/speaker/images/20/Herjavic.jpg', '2017-08-28 06:19:33', '2020-01-22 10:24:08'),
(26, 'Mark J. Dearman', 'Partner, Robbins Geller Rudman & Dowd LLP', 13, 'Test description', '/speaker/images/26/Dearman (1).jpg', '2017-08-28 06:42:59', '2020-01-22 10:24:08'),
(27, 'Cary D. Glickstein', 'Mayor, City of Delray Beach, Florida', 1, 'Test description', '/speaker/images/27/Glickstein.jpg', '2017-08-28 06:46:40', '2020-01-22 10:24:08'),
(28, 'Beverly Behan', 'President, Board Advisor, LLC', 0, 'Test description', '/speaker/images/28/Behan.jpg', '2017-08-28 06:49:14', '2020-01-22 10:24:08'),
(29, 'Meredith Miller', 'Chief Corporate Governance Officer, UAW Retiree Medical Benefits Trust', 15, 'Test description', '/speaker/images/29/Miller.jpg', '2017-08-28 06:52:07', '2020-01-22 10:24:08'),
(30, 'Stephen F. O\'Byrne', 'President and Co-Founder, Shareholder Value Advisors Inc.', 28, 'Test description', '/speaker/images/30/OByrne.jpg', '2017-08-28 06:54:54', '2020-01-22 10:24:08'),
(31, 'Dana Hollinger', 'Board Member, Insurance Industry Representative, California Public Employees\' Retirement System (CalPERS)', 4, 'Test description', '/speaker/images/31/Hollinger.jpg', '2017-08-28 06:57:35', '2020-01-22 10:24:08'),
(32, 'Luz M. Rodriguez', 'Director of Corporate Governance and Legal Services Colorado Public Employees\' Retirement Association (PERA)', 12, 'Test description', '/speaker/images/32/Rodriguez.jpg', '2017-08-28 07:01:44', '2020-01-22 10:24:08'),
(33, 'David B. Wescoe', 'CEO, San Diego County Employees Retirement Association (SDCERA)', 6, 'Test description', '/speaker/images/33/David Wescoe.jpg', '2017-08-28 07:06:53', '2020-01-22 10:24:08'),
(34, 'Jason A. Forge', 'Partner, Robbins Geller Rudman & Dowd LLP', 11, 'Test description', '/speaker/images/34/Forge.jpg', '2017-08-28 07:10:06', '2020-01-22 10:24:08'),
(36, 'Darren J. Robbins', 'Partner, Robbins Geller Rudman & Dowd LLP', 5, 'Test description', '/speaker/images/36/Robbins.jpg', '2017-08-28 07:15:52', '2020-01-22 10:24:08'),
(37, 'Jackie Cook', 'Director of Proxy Voting Research and Operations, SHARE', 10, 'Test description', '/speaker/images/37/Cook.jpg', '2017-08-28 07:17:17', '2020-01-22 10:24:08'),
(38, 'Nell Minow', 'Vice Chair, ValueEdge Advisors', 18, 'Test description', '/speaker/images/38/Minow.jpg', '2017-08-28 07:18:49', '2020-01-22 10:24:08'),
(39, 'Christianna Wood', 'CFA, CAIA Chairman, Global Reporting Initiative', 2, 'Test description', '/speaker/images/39/Wood.jpg', '2017-08-28 07:19:51', '2020-01-22 10:24:08'),
(40, 'Preet Bharara', 'U.S. Attorney for the Southern District of New York (2009-2017)', 22, 'Test description', '/speaker/images/40/Bharara.jpg', '2017-08-28 07:21:55', '2020-01-22 10:24:08'),
(41, 'Michael J. Dowd', 'Of Counsel, Robbins Geller Rudman & Dowd LLP', 17, 'Test description', '/speaker/images/41/Dowd3 (1).jpg', '2017-08-28 07:23:46', '2020-01-22 10:24:08'),
(44, 'Paul J. Geller', 'Partner, Robbins Geller Rudman & Dowd LLP', 21, 'Test description', '/speaker/images/44/Geller.jpg', '2017-08-30 09:16:16', '2020-01-22 10:24:08'),
(45, 'Richard A. Bennett', 'President & CEO, ValueEdge Advisors', 26, 'Test description', '/speaker/images/45/Bennett.jpg', '2017-08-30 09:58:41', '2020-01-22 10:24:08'),
(46, 'PUCIT', NULL, 24, 'TEste asda oilfadnfkasd', NULL, '2020-01-22 10:12:05', '2020-01-22 10:24:08'),
(47, 'FAST', NULL, 29, 'FAST', NULL, '2020-01-23 10:30:29', '2020-01-23 11:23:50'),
(48, 'LUMS', NULL, 30, 'sadsadasd', NULL, '2020-01-23 12:03:04', '2020-01-23 12:03:04');

-- --------------------------------------------------------

--
-- Table structure for table `uni_majors`
--

CREATE TABLE `uni_majors` (
  `id` int(11) NOT NULL,
  `uni_id` int(10) UNSIGNED NOT NULL,
  `major_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uni_majors`
--

INSERT INTO `uni_majors` (`id`, `uni_id`, `major_id`, `created_at`, `updated_at`) VALUES
(3, 47, 7, '2020-01-23 11:23:50', '2020-01-23 11:23:50'),
(4, 48, 7, '2020-01-23 12:03:04', '2020-01-23 12:03:04'),
(5, 48, 8, '2020-01-23 12:03:04', '2020-01-23 12:03:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_id` int(10) DEFAULT NULL,
  `user_type` int(11) NOT NULL DEFAULT '0',
  `image` text COLLATE utf8mb4_unicode_ci,
  `password_status` tinyint(11) DEFAULT '0',
  `user_pass` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '123456789',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `device_id` text COLLATE utf8mb4_unicode_ci,
  `device_type` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `user_name`, `email`, `phone`, `sort_id`, `user_type`, `image`, `password_status`, `user_pass`, `password`, `remember_token`, `token`, `created_at`, `updated_at`, `device_id`, `device_type`, `session_id`) VALUES
(1, NULL, NULL, 'Admin', 'mark@synconlinemedia.com', '234534', 0, 1, '/images/default/logo.jpg', NULL, 'admin123', '$2y$10$EZb1ZPZDFvUNbQeeO2aniuZaY.gAsUP8VF9T6hdo3w744RKSSgki2', 'xCZvvCh3yyDAZHUIQuyvqfS02YvdLm9ShmtJxymemUgTWfgh39DVZ19SNu8c', NULL, NULL, '2017-10-04 23:23:08', '123456789', NULL, '$2y$10$yIwSsvrOADCcb/ldd6EtZOZQsduXXPw8irwvfWmjhO2y6tiqQeOKu'),
(268, 'Wayne t', 'Rooney t', 'wayne', 'wayne@gmail.com', '2345235', 3, 1, NULL, NULL, '123456789', '$2y$10$/QJdHiMTOnC1o3l1/iP1se5/VuotvcPo3R2845lIMRNOLHdN/omRi', 'TV9t7tlf6qnXtPW6PH71i4ZNo5WvCekz0MMSOrhbKoVMu0PK387hC0wtVUNt', NULL, '2017-09-06 04:34:47', '2020-01-22 08:52:59', '123456789', NULL, '$2y$10$x0JwGn5gRxHSM1vhsS8iwutdrggwTp4XNRPZYCtSGCco0obQdxGEC'),
(281, 'Super', 'Admin', 'super admin', 'super@gmail.com', '6534', 4, 2, NULL, 0, '123456', '$2y$10$AKOBLmmiLKGqdcovB58.2unqiPRHYEFQ7TgwRLVSOd7PrOo1nIq6.', 'cwU7haL3g0f879MJfrNdIqDfdaVSZtZOVqm3OQn6NKzFYUXkORQjrNfcO2YM', NULL, '2020-01-22 08:34:53', '2020-01-22 08:39:32', NULL, NULL, '5e284f7ddc6a8'),
(282, 'asdaxzc', 'sadas', 'asdasd', 'cxzczxc@mail.com', '244', 5, 1, NULL, 0, 'asdaxzcsadas', '$2y$10$z0W8Ttplh6Tvp8JcG4pORu6qjjRDkBh.tiU7acQ5lMWR4UrqesnDC', NULL, NULL, '2020-01-23 12:02:18', '2020-01-23 12:02:29', NULL, NULL, '5e29d19af17f3');

-- --------------------------------------------------------

--
-- Table structure for table `welcome`
--

CREATE TABLE `welcome` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `map` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `signature` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `welcome`
--

INSERT INTO `welcome` (`id`, `name`, `description`, `map`, `image`, `signature`, `created_at`, `updated_at`) VALUES
(1, '<p>Hon. Richard A. Bennett</p>\r\n<p>Founder, President and CEO</p>\r\n<p>ValueEdge Advisors LLC</p>', '<p><strong>DEAR FRIENDS,</strong></p>\r\n<p>Welcome to our ninth annual Public Funds Forum &ndash; Protecting Portfolio Value!</p>\r\n<p>Today&rsquo;s world is fraught with uncertainty. Both the &ldquo;known unknowns&rdquo; and the &ldquo;unknown unknowns&rdquo; give market participants pause. Even the skies over developed economies are darkened by defined dangers and vague fears. Many are concerned that recent stock market gains may prove ephemeral. These are perilous times for public fund trustees and other investment fiduciaries.</p>\r\n<p>How can you best use your powers as an asset owner to make our markets deliver for your fund beneficiaries? How do you find value-winning investment strategies to boost returns while protecting assets against downside risk? Where do you find the leading-edge information and actionable tools needed to help you make the difficult choices confronting you?</p>\r\n<p><br />We have designed this conference with these questions in mind. Our goal is to give you insights and training on how to protect downside risk, how to be more engaged as an asset owner, and how to hold your portfolio companies accountable to deliver the returns you and your beneficiaries are relying on.</p>\r\n<p>We at ValueEdge Advisors are focused on the very important mission of helping institutional investors, particularly asset owners like public pension funds, understand and use their rights as shareowners to preserve portfolio value and diminish risk. And we are again grateful for our sponsoring partners in helping make our ninth annual forum successful: Gilardi &amp; Co. LLC and the leading plaintiffs&rsquo; securities law firm of Robbins Geller Rudman &amp; Dowd LLP.</p>\r\n<p>I look forward to our dialogue about how to protect portfolio value in challenging times.</p>\r\n<p><br />Sincerely,</p>', '/map/image/map.jpg', '/welcome_screen/images/1503926318/Bennett.jpg', '/welcome_screen/images/1503926318/Screenshot_2.png', NULL, '2017-10-26 12:33:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `majors`
--
ALTER TABLE `majors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `major_categories`
--
ALTER TABLE `major_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_event_id_index` (`event_id`);

--
-- Indexes for table `session_speakers`
--
ALTER TABLE `session_speakers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_speakers_session_id_index` (`session_id`),
  ADD KEY `session_speakers_speaker_id_index` (`speaker_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplements`
--
ALTER TABLE `supplements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uni`
--
ALTER TABLE `uni`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uni_majors`
--
ALTER TABLE `uni_majors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delete_uni` (`uni_id`),
  ADD KEY `delete_major` (`major_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `welcome`
--
ALTER TABLE `welcome`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(21) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `majors`
--
ALTER TABLE `majors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `major_categories`
--
ALTER TABLE `major_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `session_speakers`
--
ALTER TABLE `session_speakers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(21) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplements`
--
ALTER TABLE `supplements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `uni`
--
ALTER TABLE `uni`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `uni_majors`
--
ALTER TABLE `uni_majors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=283;

--
-- AUTO_INCREMENT for table `welcome`
--
ALTER TABLE `welcome`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `session_speakers`
--
ALTER TABLE `session_speakers`
  ADD CONSTRAINT `session_speakers_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `session_speakers_speaker_id_foreign` FOREIGN KEY (`speaker_id`) REFERENCES `uni` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `uni_majors`
--
ALTER TABLE `uni_majors`
  ADD CONSTRAINT `delete_major` FOREIGN KEY (`major_id`) REFERENCES `majors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `delete_uni` FOREIGN KEY (`uni_id`) REFERENCES `uni` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
