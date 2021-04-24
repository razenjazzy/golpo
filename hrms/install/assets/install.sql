-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2018 at 01:39 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrsale_prepare`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `ci_sessions`
--

TRUNCATE TABLE `ci_sessions`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_advance_salaries`
--

CREATE TABLE `xin_advance_salaries` (
  `advance_salary_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `month_year` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `advance_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `one_time_deduct` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `monthly_installment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_paid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reason` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) DEFAULT NULL,
  `is_deducted_from_salary` int(11) DEFAULT NULL,
  `created_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Truncate table before insert `xin_advance_salaries`
--

TRUNCATE TABLE `xin_advance_salaries`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_announcements`
--

CREATE TABLE `xin_announcements` (
  `announcement_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `company_id` int(111) NOT NULL,
  `department_id` int(111) NOT NULL,
  `published_by` int(111) NOT NULL,
  `summary` text NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_announcements`
--

TRUNCATE TABLE `xin_announcements`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_assets`
--

CREATE TABLE `xin_assets` (
  `assets_id` int(111) NOT NULL,
  `assets_category_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `company_asset_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `manufacturer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `serial_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `warranty_end_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `asset_note` text COLLATE utf8_unicode_ci NOT NULL,
  `asset_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_working` int(11) NOT NULL,
  `created_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Truncate table before insert `xin_assets`
--

TRUNCATE TABLE `xin_assets`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_assets_categories`
--

CREATE TABLE `xin_assets_categories` (
  `assets_category_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Truncate table before insert `xin_assets_categories`
--

TRUNCATE TABLE `xin_assets_categories`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_attendance_time`
--

CREATE TABLE `xin_attendance_time` (
  `time_attendance_id` int(111) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `attendance_date` varchar(255) NOT NULL,
  `clock_in` varchar(255) NOT NULL,
  `clock_in_ip_address` varchar(255) NOT NULL,
  `clock_out` varchar(255) NOT NULL,
  `clock_out_ip_address` varchar(255) NOT NULL,
  `clock_in_out` varchar(255) NOT NULL,
  `time_late` varchar(255) NOT NULL,
  `early_leaving` varchar(255) NOT NULL,
  `overtime` varchar(255) NOT NULL,
  `total_work` varchar(255) NOT NULL,
  `total_rest` varchar(255) NOT NULL,
  `attendance_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_attendance_time`
--

TRUNCATE TABLE `xin_attendance_time`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_awards`
--

CREATE TABLE `xin_awards` (
  `award_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(200) NOT NULL,
  `award_type_id` int(200) NOT NULL,
  `gift_item` varchar(200) NOT NULL,
  `cash_price` varchar(200) NOT NULL,
  `award_photo` varchar(255) NOT NULL,
  `award_month_year` varchar(200) NOT NULL,
  `award_information` text NOT NULL,
  `description` text NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_awards`
--

TRUNCATE TABLE `xin_awards`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_award_type`
--

CREATE TABLE `xin_award_type` (
  `award_type_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `award_type` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_award_type`
--

TRUNCATE TABLE `xin_award_type`;
--
-- Dumping data for table `xin_award_type`
--

INSERT INTO `xin_award_type` (`award_type_id`, `company_id`, `award_type`, `created_at`) VALUES
(1, 1, 'Performer of the Year', '22-03-2018 01:33:57');

-- --------------------------------------------------------

--
-- Table structure for table `xin_chat_messages`
--

CREATE TABLE `xin_chat_messages` (
  `message_id` int(11) UNSIGNED NOT NULL,
  `from_id` varchar(40) NOT NULL DEFAULT '',
  `to_id` varchar(50) NOT NULL DEFAULT '',
  `message_frm` varchar(255) NOT NULL,
  `is_read` int(11) NOT NULL DEFAULT '0',
  `message_content` longtext CHARACTER SET utf8 NOT NULL,
  `message_date` varchar(255) DEFAULT NULL,
  `recd` tinyint(1) NOT NULL DEFAULT '0',
  `message_type` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_chat_messages`
--

TRUNCATE TABLE `xin_chat_messages`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_clients`
--

CREATE TABLE `xin_clients` (
  `client_id` int(111) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `client_username` varchar(255) NOT NULL,
  `client_password` varchar(255) NOT NULL,
  `client_profile` varchar(255) NOT NULL,
  `contact_number` varchar(255) CHARACTER SET utf8 NOT NULL,
  `company_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `gender` varchar(200) NOT NULL,
  `website_url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `address_1` text NOT NULL,
  `address_2` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `country` int(111) NOT NULL,
  `is_active` int(11) NOT NULL,
  `last_logout_date` varchar(255) NOT NULL,
  `last_login_date` varchar(255) NOT NULL,
  `last_login_ip` varchar(255) NOT NULL,
  `is_logged_in` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_clients`
--

TRUNCATE TABLE `xin_clients`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_companies`
--

CREATE TABLE `xin_companies` (
  `company_id` int(111) NOT NULL,
  `type_id` int(111) NOT NULL,
  `name` varchar(255) NOT NULL,
  `trading_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_no` varchar(255) NOT NULL,
  `government_tax` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `website_url` varchar(255) NOT NULL,
  `address_1` text NOT NULL,
  `address_2` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `country` int(111) NOT NULL,
  `is_active` int(11) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_companies`
--

TRUNCATE TABLE `xin_companies`;
--
-- Dumping data for table `xin_companies`
--

INSERT INTO `xin_companies` (`company_id`, `type_id`, `name`, `trading_name`, `username`, `password`, `registration_no`, `government_tax`, `email`, `logo`, `contact_number`, `website_url`, `address_1`, `address_2`, `city`, `state`, `zipcode`, `country`, `is_active`, `added_by`, `created_at`) VALUES
(1, 1, 'HRSALE', 'testttt', 'test123', '', '', '', 'test@golpocom.com', 'logo_1531164972.png', '123456789', 'test.com', 'Test', 'Test2', 'Riyadh', 'Riyadh', '11461', 190, 0, 1, '22-05-2018');

-- --------------------------------------------------------

--
-- Table structure for table `xin_company_info`
--

CREATE TABLE `xin_company_info` (
  `company_info_id` int(111) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `logo_second` varchar(255) NOT NULL,
  `sign_in_logo` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `website_url` text NOT NULL,
  `starting_year` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_email` varchar(255) NOT NULL,
  `company_contact` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address_1` text NOT NULL,
  `address_2` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `country` int(111) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_company_info`
--

TRUNCATE TABLE `xin_company_info`;
--
-- Dumping data for table `xin_company_info`
--

INSERT INTO `xin_company_info` (`company_info_id`, `logo`, `logo_second`, `sign_in_logo`, `favicon`, `website_url`, `starting_year`, `company_name`, `company_email`, `company_contact`, `contact_person`, `email`, `phone`, `address_1`, `address_2`, `city`, `state`, `zipcode`, `country`, `updated_at`) VALUES
(1, 'logo_1520722747.png', 'logo2_1520609223.png', 'signin_logo_1520612279.png', 'favicon_1520722747.png', '', '', 'hrsale', '', '', 'Thomas Fleming', 'info@golpocom.com', '123456789', 'Address Line 1', 'Address Line 2', 'City', 'State', '11461', 190, '2017-05-20 12:05:53');

-- --------------------------------------------------------

--
-- Table structure for table `xin_company_policy`
--

CREATE TABLE `xin_company_policy` (
  `policy_id` int(111) NOT NULL,
  `company_id` int(111) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_company_policy`
--

TRUNCATE TABLE `xin_company_policy`;
--
-- Dumping data for table `xin_company_policy`
--

INSERT INTO `xin_company_policy` (`policy_id`, `company_id`, `title`, `description`, `added_by`, `created_at`) VALUES
(1, 1, 'Smoke-Free Work', '&lt;p&gt;Smoke-Free Work Environment Policy Close&lt;/p&gt;', 1, '28-02-2018');

-- --------------------------------------------------------

--
-- Table structure for table `xin_company_type`
--

CREATE TABLE `xin_company_type` (
  `type_id` int(111) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_company_type`
--

TRUNCATE TABLE `xin_company_type`;
--
-- Dumping data for table `xin_company_type`
--

INSERT INTO `xin_company_type` (`type_id`, `name`, `created_at`) VALUES
(1, 'Corporation', ''),
(2, 'Exempt Organization', ''),
(3, 'Partnership', ''),
(4, 'Private Foundation', ''),
(5, 'Limited Liability Company', '');

-- --------------------------------------------------------

--
-- Table structure for table `xin_contract_type`
--

CREATE TABLE `xin_contract_type` (
  `contract_type_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_contract_type`
--

TRUNCATE TABLE `xin_contract_type`;
--
-- Dumping data for table `xin_contract_type`
--

INSERT INTO `xin_contract_type` (`contract_type_id`, `company_id`, `name`, `created_at`) VALUES
(1, 1, 'Permanent', '05-04-2018 06:10:32');

-- --------------------------------------------------------

--
-- Table structure for table `xin_countries`
--

CREATE TABLE `xin_countries` (
  `country_id` int(11) NOT NULL,
  `country_code` varchar(255) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `country_flag` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `xin_countries`
--

TRUNCATE TABLE `xin_countries`;
--
-- Dumping data for table `xin_countries`
--

INSERT INTO `xin_countries` (`country_id`, `country_code`, `country_name`, `country_flag`) VALUES
(1, '+93', 'Afghanistan', 'flag_1500831780.gif'),
(2, '+355', 'Albania', 'flag_1500831815.gif'),
(3, 'DZ', 'Algeria', ''),
(4, 'DS', 'American Samoa', ''),
(5, 'AD', 'Andorra', ''),
(6, 'AO', 'Angola', ''),
(7, 'AI', 'Anguilla', ''),
(8, 'AQ', 'Antarctica', ''),
(9, 'AG', 'Antigua and Barbuda', ''),
(10, 'AR', 'Argentina', ''),
(11, 'AM', 'Armenia', ''),
(12, 'AW', 'Aruba', ''),
(13, 'AU', 'Australia', ''),
(14, 'AT', 'Austria', ''),
(15, 'AZ', 'Azerbaijan', ''),
(16, 'BS', 'Bahamas', ''),
(17, 'BH', 'Bahrain', ''),
(18, 'BD', 'Bangladesh', ''),
(19, 'BB', 'Barbados', ''),
(20, 'BY', 'Belarus', ''),
(21, 'BE', 'Belgium', ''),
(22, 'BZ', 'Belize', ''),
(23, 'BJ', 'Benin', ''),
(24, 'BM', 'Bermuda', ''),
(25, 'BT', 'Bhutan', ''),
(26, 'BO', 'Bolivia', ''),
(27, 'BA', 'Bosnia and Herzegovina', ''),
(28, 'BW', 'Botswana', ''),
(29, 'BV', 'Bouvet Island', ''),
(30, 'BR', 'Brazil', ''),
(31, 'IO', 'British Indian Ocean Territory', ''),
(32, 'BN', 'Brunei Darussalam', ''),
(33, 'BG', 'Bulgaria', ''),
(34, 'BF', 'Burkina Faso', ''),
(35, 'BI', 'Burundi', ''),
(36, 'KH', 'Cambodia', ''),
(37, 'CM', 'Cameroon', ''),
(38, 'CA', 'Canada', ''),
(39, 'CV', 'Cape Verde', ''),
(40, 'KY', 'Cayman Islands', ''),
(41, 'CF', 'Central African Republic', ''),
(42, 'TD', 'Chad', ''),
(43, 'CL', 'Chile', ''),
(44, 'CN', 'China', ''),
(45, 'CX', 'Christmas Island', ''),
(46, 'CC', 'Cocos (Keeling) Islands', ''),
(47, 'CO', 'Colombia', ''),
(48, 'KM', 'Comoros', ''),
(49, 'CG', 'Congo', ''),
(50, 'CK', 'Cook Islands', ''),
(51, 'CR', 'Costa Rica', ''),
(52, 'HR', 'Croatia (Hrvatska)', ''),
(53, 'CU', 'Cuba', ''),
(54, 'CY', 'Cyprus', ''),
(55, 'CZ', 'Czech Republic', ''),
(56, 'DK', 'Denmark', ''),
(57, 'DJ', 'Djibouti', ''),
(58, 'DM', 'Dominica', ''),
(59, 'DO', 'Dominican Republic', ''),
(60, 'TP', 'East Timor', ''),
(61, 'EC', 'Ecuador', ''),
(62, 'EG', 'Egypt', ''),
(63, 'SV', 'El Salvador', ''),
(64, 'GQ', 'Equatorial Guinea', ''),
(65, 'ER', 'Eritrea', ''),
(66, 'EE', 'Estonia', ''),
(67, 'ET', 'Ethiopia', ''),
(68, 'FK', 'Falkland Islands (Malvinas)', ''),
(69, 'FO', 'Faroe Islands', ''),
(70, 'FJ', 'Fiji', ''),
(71, 'FI', 'Finland', ''),
(72, 'FR', 'France', ''),
(73, 'FX', 'France, Metropolitan', ''),
(74, 'GF', 'French Guiana', ''),
(75, 'PF', 'French Polynesia', ''),
(76, 'TF', 'French Southern Territories', ''),
(77, 'GA', 'Gabon', ''),
(78, 'GM', 'Gambia', ''),
(79, 'GE', 'Georgia', ''),
(80, 'DE', 'Germany', ''),
(81, 'GH', 'Ghana', ''),
(82, 'GI', 'Gibraltar', ''),
(83, 'GK', 'Guernsey', ''),
(84, 'GR', 'Greece', ''),
(85, 'GL', 'Greenland', ''),
(86, 'GD', 'Grenada', ''),
(87, 'GP', 'Guadeloupe', ''),
(88, 'GU', 'Guam', ''),
(89, 'GT', 'Guatemala', ''),
(90, 'GN', 'Guinea', ''),
(91, 'GW', 'Guinea-Bissau', ''),
(92, 'GY', 'Guyana', ''),
(93, 'HT', 'Haiti', ''),
(94, 'HM', 'Heard and Mc Donald Islands', ''),
(95, 'HN', 'Honduras', ''),
(96, 'HK', 'Hong Kong', ''),
(97, 'HU', 'Hungary', ''),
(98, 'IS', 'Iceland', ''),
(99, 'IN', 'India', ''),
(100, 'IM', 'Isle of Man', ''),
(101, 'ID', 'Indonesia', ''),
(102, 'IR', 'Iran (Islamic Republic of)', ''),
(103, 'IQ', 'Iraq', ''),
(104, 'IE', 'Ireland', ''),
(105, 'IL', 'Israel', ''),
(106, 'IT', 'Italy', ''),
(107, 'CI', 'Ivory Coast', ''),
(108, 'JE', 'Jersey', ''),
(109, 'JM', 'Jamaica', ''),
(110, 'JP', 'Japan', ''),
(111, 'JO', 'Jordan', ''),
(112, 'KZ', 'Kazakhstan', ''),
(113, 'KE', 'Kenya', ''),
(114, 'KI', 'Kiribati', ''),
(115, 'KP', 'Korea, Democratic People\'s Republic of', ''),
(116, 'KR', 'Korea, Republic of', ''),
(117, 'XK', 'Kosovo', ''),
(118, 'KW', 'Kuwait', ''),
(119, 'KG', 'Kyrgyzstan', ''),
(120, 'LA', 'Lao People\'s Democratic Republic', ''),
(121, 'LV', 'Latvia', ''),
(122, 'LB', 'Lebanon', ''),
(123, 'LS', 'Lesotho', ''),
(124, 'LR', 'Liberia', ''),
(125, 'LY', 'Libyan Arab Jamahiriya', ''),
(126, 'LI', 'Liechtenstein', ''),
(127, 'LT', 'Lithuania', ''),
(128, 'LU', 'Luxembourg', ''),
(129, 'MO', 'Macau', ''),
(130, 'MK', 'Macedonia', ''),
(131, 'MG', 'Madagascar', ''),
(132, 'MW', 'Malawi', ''),
(133, 'MY', 'Malaysia', ''),
(134, 'MV', 'Maldives', ''),
(135, 'ML', 'Mali', ''),
(136, 'MT', 'Malta', ''),
(137, 'MH', 'Marshall Islands', ''),
(138, 'MQ', 'Martinique', ''),
(139, 'MR', 'Mauritania', ''),
(140, 'MU', 'Mauritius', ''),
(141, 'TY', 'Mayotte', ''),
(142, 'MX', 'Mexico', ''),
(143, 'FM', 'Micronesia, Federated States of', ''),
(144, 'MD', 'Moldova, Republic of', ''),
(145, 'MC', 'Monaco', ''),
(146, 'MN', 'Mongolia', ''),
(147, 'ME', 'Montenegro', ''),
(148, 'MS', 'Montserrat', ''),
(149, 'MA', 'Morocco', ''),
(150, 'MZ', 'Mozambique', ''),
(151, 'MM', 'Myanmar', ''),
(152, 'NA', 'Namibia', ''),
(153, 'NR', 'Nauru', ''),
(154, 'NP', 'Nepal', ''),
(155, 'NL', 'Netherlands', ''),
(156, 'AN', 'Netherlands Antilles', ''),
(157, 'NC', 'New Caledonia', ''),
(158, 'NZ', 'New Zealand', ''),
(159, 'NI', 'Nicaragua', ''),
(160, 'NE', 'Niger', ''),
(161, 'NG', 'Nigeria', ''),
(162, 'NU', 'Niue', ''),
(163, 'NF', 'Norfolk Island', ''),
(164, 'MP', 'Northern Mariana Islands', ''),
(165, 'NO', 'Norway', ''),
(166, 'OM', 'Oman', ''),
(167, 'PK', 'Pakistan', ''),
(168, 'PW', 'Palau', ''),
(169, 'PS', 'Palestine', ''),
(170, 'PA', 'Panama', ''),
(171, 'PG', 'Papua New Guinea', ''),
(172, 'PY', 'Paraguay', ''),
(173, 'PE', 'Peru', ''),
(174, 'PH', 'Philippines', ''),
(175, 'PN', 'Pitcairn', ''),
(176, 'PL', 'Poland', ''),
(177, 'PT', 'Portugal', ''),
(178, 'PR', 'Puerto Rico', ''),
(179, 'QA', 'Qatar', ''),
(180, 'RE', 'Reunion', ''),
(181, 'RO', 'Romania', ''),
(182, 'RU', 'Russian Federation', ''),
(183, 'RW', 'Rwanda', ''),
(184, 'KN', 'Saint Kitts and Nevis', ''),
(185, 'LC', 'Saint Lucia', ''),
(186, 'VC', 'Saint Vincent and the Grenadines', ''),
(187, 'WS', 'Samoa', ''),
(188, 'SM', 'San Marino', ''),
(189, 'ST', 'Sao Tome and Principe', ''),
(190, 'SA', 'Saudi Arabia', ''),
(191, 'SN', 'Senegal', ''),
(192, 'RS', 'Serbia', ''),
(193, 'SC', 'Seychelles', ''),
(194, 'SL', 'Sierra Leone', ''),
(195, 'SG', 'Singapore', ''),
(196, 'SK', 'Slovakia', ''),
(197, 'SI', 'Slovenia', ''),
(198, 'SB', 'Solomon Islands', ''),
(199, 'SO', 'Somalia', ''),
(200, 'ZA', 'South Africa', ''),
(201, 'GS', 'South Georgia South Sandwich Islands', ''),
(202, 'ES', 'Spain', ''),
(203, 'LK', 'Sri Lanka', ''),
(204, 'SH', 'St. Helena', ''),
(205, 'PM', 'St. Pierre and Miquelon', ''),
(206, 'SD', 'Sudan', ''),
(207, 'SR', 'Suriname', ''),
(208, 'SJ', 'Svalbard and Jan Mayen Islands', ''),
(209, 'SZ', 'Swaziland', ''),
(210, 'SE', 'Sweden', ''),
(211, 'CH', 'Switzerland', ''),
(212, 'SY', 'Syrian Arab Republic', ''),
(213, 'TW', 'Taiwan', ''),
(214, 'TJ', 'Tajikistan', ''),
(215, 'TZ', 'Tanzania, United Republic of', ''),
(216, 'TH', 'Thailand', ''),
(217, 'TG', 'Togo', ''),
(218, 'TK', 'Tokelau', ''),
(219, 'TO', 'Tonga', ''),
(220, 'TT', 'Trinidad and Tobago', ''),
(221, 'TN', 'Tunisia', ''),
(222, 'TR', 'Turkey', ''),
(223, 'TM', 'Turkmenistan', ''),
(224, 'TC', 'Turks and Caicos Islands', ''),
(225, 'TV', 'Tuvalu', ''),
(226, 'UG', 'Uganda', ''),
(227, 'UA', 'Ukraine', ''),
(228, 'AE', 'United Arab Emirates', ''),
(229, 'GB', 'United Kingdom', ''),
(230, 'US', 'United States', ''),
(231, 'UM', 'United States minor outlying islands', ''),
(232, 'UY', 'Uruguay', ''),
(233, 'UZ', 'Uzbekistan', ''),
(234, 'VU', 'Vanuatu', ''),
(235, 'VA', 'Vatican City State', ''),
(236, 'VE', 'Venezuela', ''),
(237, 'VN', 'Vietnam', ''),
(238, 'VG', 'Virgin Islands (British)', ''),
(239, 'VI', 'Virgin Islands (U.S.)', ''),
(240, 'WF', 'Wallis and Futuna Islands', ''),
(241, 'EH', 'Western Sahara', ''),
(242, 'YE', 'Yemen', ''),
(243, 'ZR', 'Zaire', ''),
(244, 'ZM', 'Zambia', ''),
(245, 'ZW', 'Zimbabwe', '');

-- --------------------------------------------------------

--
-- Table structure for table `xin_currencies`
--

CREATE TABLE `xin_currencies` (
  `currency_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `symbol` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_currencies`
--

TRUNCATE TABLE `xin_currencies`;
--
-- Dumping data for table `xin_currencies`
--

INSERT INTO `xin_currencies` (`currency_id`, `company_id`, `name`, `code`, `symbol`) VALUES
(1, 1, 'Dollars', 'USD', '$');

-- --------------------------------------------------------

--
-- Table structure for table `xin_database_backup`
--

CREATE TABLE `xin_database_backup` (
  `backup_id` int(111) NOT NULL,
  `backup_file` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_database_backup`
--

TRUNCATE TABLE `xin_database_backup`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_departments`
--

CREATE TABLE `xin_departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(200) NOT NULL,
  `company_id` int(11) NOT NULL,
  `location_id` int(111) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `xin_departments`
--

TRUNCATE TABLE `xin_departments`;
--
-- Dumping data for table `xin_departments`
--

INSERT INTO `xin_departments` (`department_id`, `department_name`, `company_id`, `location_id`, `employee_id`, `added_by`, `created_at`, `status`) VALUES
(1, 'MD Office', 1, 1, 1, 0, '06-03-2018', 1),
(2, 'Accounts and  Finances', 1, 0, 5, 1, '17-03-2018', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xin_designations`
--

CREATE TABLE `xin_designations` (
  `designation_id` int(11) NOT NULL,
  `top_designation_id` int(11) NOT NULL DEFAULT '0',
  `department_id` int(200) NOT NULL,
  `company_id` int(11) NOT NULL,
  `designation_name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_designations`
--

TRUNCATE TABLE `xin_designations`;
--
-- Dumping data for table `xin_designations`
--

INSERT INTO `xin_designations` (`designation_id`, `top_designation_id`, `department_id`, `company_id`, `designation_name`, `added_by`, `created_at`, `status`) VALUES
(9, 0, 1, 1, 'Manager', 1, '06-03-2018', 1),
(10, 0, 2, 1, 'Finance', 1, '18-03-2018', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xin_document_type`
--

CREATE TABLE `xin_document_type` (
  `document_type_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_document_type`
--

TRUNCATE TABLE `xin_document_type`;
--
-- Dumping data for table `xin_document_type`
--

INSERT INTO `xin_document_type` (`document_type_id`, `company_id`, `document_type`, `created_at`) VALUES
(1, 1, 'Driving License', '09-05-2018 12:34:55');

-- --------------------------------------------------------

--
-- Table structure for table `xin_email_template`
--

CREATE TABLE `xin_email_template` (
  `template_id` int(111) NOT NULL,
  `template_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_email_template`
--

TRUNCATE TABLE `xin_email_template`;
--
-- Dumping data for table `xin_email_template`
--

INSERT INTO `xin_email_template` (`template_id`, `template_code`, `name`, `subject`, `message`, `status`) VALUES
(2, 'code1', 'Forgot Password', 'Forgot Password', '&lt;p&gt;There was recently a request for password for your  {var site_name} account.&lt;/p&gt;&lt;p&gt;Please, keep it in your records so you don\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&#039;t forget it.&lt;/p&gt;&lt;p&gt;Your username: {var username}&lt;br&gt;Your email address: {var email}&lt;br&gt;Your password: {var password}&lt;/p&gt;&lt;p&gt;Thank you,&lt;br&gt;The {var site_name} Team&lt;/p&gt;', 1),
(3, 'code2', 'New Project', 'New Project', '&lt;p&gt;Dear {var name},&lt;/p&gt;&lt;p&gt;New project has been assigned to you.&lt;/p&gt;&lt;p&gt;Project Name: {var project_name}&lt;/p&gt;&lt;p&gt;Project Start Date:&amp;nbsp;&lt;span 1rem;\\\\\\&quot;=\\&quot;\\&quot;&gt;{var project_start_date}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span 1rem;\\\\\\&quot;=\\&quot;\\&quot;&gt;Thank you,&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;The {var site_name} Team&lt;/p&gt;', 1),
(5, 'code3', 'Leave Request ', 'A Leave Request from you', '&lt;p&gt;Dear Admin,&lt;/p&gt;&lt;p&gt;{var employee_name} wants a leave from you.&lt;/p&gt;&lt;p&gt;You can view this leave request by logging in to the portal using the link below.&lt;/p&gt;&lt;p&gt;{var site_url}admin/&lt;br&gt;&lt;br&gt;Regards&lt;/p&gt;&lt;p&gt;The {var site_name} Team&lt;/p&gt;', 1),
(6, 'code4', 'Leave Approve', 'Your leave request has been approved', '&lt;p&gt;Your leave request has been approved&lt;/p&gt;&lt;p&gt;&lt;span style=\\&quot;font-size: 1rem;\\&quot;&gt;Congratulations! Your leave request from&lt;/span&gt;&lt;font color=\\&quot;#333333\\&quot; face=\\&quot;sans-serif, Arial, Verdana, Trebuchet MS\\&quot;&gt;&amp;nbsp;&lt;/font&gt;{var leave_start_date}&amp;nbsp;to&amp;nbsp;{var leave_end_date}&amp;nbsp;has been approved by your company management.&lt;/p&gt;&lt;p&gt;Check here&lt;/p&gt;&lt;p&gt;{var site_url}hr/user/leave/&lt;br&gt;&lt;/p&gt;&lt;p&gt;Regards&lt;br&gt;The {var site_name} Team&lt;/p&gt;', 1),
(7, 'code5', 'Leave Reject', 'Your leave request has been Rejected', '&lt;p&gt;Your leave request has been Rejected&lt;/p&gt;&lt;p&gt;Unfortunately ! Your leave request from {var leave_start_date} to {var leave_end_date} has been Rejected by your company management.&lt;/p&gt;&lt;p&gt;Check here&lt;/p&gt;&lt;p&gt;{var site_url}hr/user/leave/&lt;/p&gt;&lt;p&gt;Regards&lt;/p&gt;&lt;p&gt;The {var site_name} Team&lt;/p&gt;', 1),
(8, 'code6', 'Welcome Email ', 'Welcome Email ', '&lt;p&gt;Hello&amp;nbsp;{var employee_name},&lt;/p&gt;&lt;p&gt;Welcome to&amp;nbsp;{var site_name}&amp;nbsp;.Thanks for joining&amp;nbsp;{var site_name}. We listed your sign in details below, make sure you keep them safe.&lt;/p&gt;&lt;p&gt;Your Username: {var username}&lt;/p&gt;&lt;p&gt;Your Employee ID: {var employee_id}&lt;br&gt;Your Email Address: {var email}&lt;br&gt;Your Password: {var password}&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;a href=\\&quot;{var site_url}\\&quot;&gt;&lt;a href=\\&quot;{var site_url}/hr/\\&quot;&gt;Login Panel&lt;/a&gt;&lt;/a&gt;&lt;/p&gt;&lt;p&gt;Link doesn\\&#039;t work? Copy the following link to your browser address bar:&lt;/p&gt;&lt;p&gt;{var site_url}/hr/&lt;/p&gt;&lt;p&gt;Have fun!&lt;/p&gt;&lt;p&gt;The&amp;nbsp;{var site_name}&amp;nbsp;Team.&lt;/p&gt;', 1),
(9, 'code7', 'Transfer', 'New Transfer', '&lt;p&gt;Hello&amp;nbsp;{var employee_name},&lt;/p&gt;&lt;p&gt;You have been&amp;nbsp;transfered to another department and location.&lt;/p&gt;&lt;p&gt;You can view the transfer details by logging in to the portal using the link below.&lt;/p&gt;&lt;p&gt;{var site_url}hr/user/transfer/&lt;/p&gt;&lt;p&gt;Regards&lt;/p&gt;&lt;p&gt;The {var site_name} Team&lt;/p&gt;', 1),
(10, 'code8', 'Award', 'Award Received', '&lt;p&gt;Hello&amp;nbsp;{var employee_name},&lt;/p&gt;&lt;p&gt;You have been&amp;nbsp;awarded&amp;nbsp;{var award_name}.&lt;/p&gt;&lt;p&gt;You can view this award by logging in to the portal using the link below.&lt;/p&gt;&lt;p&gt;&lt;span style=\\&quot;font-size: 1rem;\\&quot;&gt;{var site_url}hr/&lt;/span&gt;&lt;span style=\\&quot;font-size: 1rem;\\&quot;&gt;user/awards/&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;Regards&lt;/p&gt;&lt;p&gt;The {var site_name} Team&lt;/p&gt;', 1),
(14, 'code9', 'New Task', 'Task assigned', '&lt;p&gt;Dear Employee,&lt;/p&gt;&lt;p&gt;A new task&amp;nbsp;&lt;span style=\\&quot;\\\\&amp;quot;font-weight:\\&quot; bolder;\\\\\\&quot;=\\&quot;\\&quot;&gt;{var task_name}&lt;/span&gt;&amp;nbsp;has been assigned to you by&amp;nbsp;&lt;span style=\\&quot;\\\\&amp;quot;font-weight:\\&quot; bolder;\\\\\\&quot;=\\&quot;\\&quot;&gt;{var task_assigned_by}&lt;/span&gt;.&lt;/p&gt;&lt;p&gt;You can view this task by logging in to the portal using the link below.&lt;/p&gt;&lt;p&gt;{var site_url}hr/user/tasks/&lt;br&gt;&lt;/p&gt;&lt;p&gt;Link doesn\\\\\\&#039;t work? Copy the following link to your browser address bar:&lt;/p&gt;&lt;p&gt;{var site_url}&lt;/p&gt;&lt;p&gt;Regards,&lt;/p&gt;&lt;p&gt;The {var site_name} Team&lt;/p&gt;', 1),
(15, 'code10', 'New Inquiry', 'New Inquiry [#{var ticket_code}]', '&lt;p xss=removed rgb(51,=\\&quot;\\\\\\&quot; font-family:=\\&quot;\\\\\\&quot; sans-serif,=\\&quot;\\\\\\&quot; arial,=\\&quot;\\\\\\&quot; verdana,=\\&quot;\\\\\\&quot; trebuchet=\\&quot;\\\\\\\\\\&quot;&gt;&lt;span xss=removed&gt;Dear Admin,&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p xss=removed rgb(51,=\\&quot;\\\\\\&quot; font-family:=\\&quot;\\\\\\&quot; sans-serif,=\\&quot;\\\\\\&quot; arial,=\\&quot;\\\\\\&quot; verdana,=\\&quot;\\\\\\&quot; trebuchet=\\&quot;\\\\\\\\\\&quot;&gt;&lt;span xss=removed&gt;Your received a new inquiry.&lt;/span&gt;&lt;/p&gt;&lt;p xss=removed rgb(51,=\\&quot;\\\\\\&quot; font-family:=\\&quot;\\\\\\&quot; sans-serif,=\\&quot;\\\\\\&quot; arial,=\\&quot;\\\\\\&quot; verdana,=\\&quot;\\\\\\&quot; trebuchet=\\&quot;\\\\\\\\\\&quot;&gt;&lt;span xss=removed&gt;Inquiry Code: #{var ticket_code}&lt;/span&gt;&lt;/p&gt;&lt;p xss=removed rgb(51,=\\&quot;\\\\\\&quot; font-family:=\\&quot;\\\\\\&quot; sans-serif,=\\&quot;\\\\\\&quot; arial,=\\&quot;\\\\\\&quot; verdana,=\\&quot;\\\\\\&quot; trebuchet=\\&quot;\\\\\\\\\\&quot;&gt;Status : Open&lt;br&gt;&lt;br&gt;Click on the below link to see the inquiry details and post additional comments.&lt;/p&gt;&lt;p xss=removed rgb(51,=\\&quot;\\\\\\&quot; font-family:=\\&quot;\\\\\\&quot; sans-serif,=\\&quot;\\\\\\&quot; arial,=\\&quot;\\\\\\&quot; verdana,=\\&quot;\\\\\\&quot; trebuchet=\\&quot;\\\\\\\\\\&quot;&gt;{var site_url}admin/tickets/&lt;br&gt;&lt;br&gt;Regards&lt;/p&gt;&lt;p xss=removed rgb(51,=\\&quot;\\\\\\&quot; font-family:=\\&quot;\\\\\\&quot; sans-serif,=\\&quot;\\\\\\&quot; arial,=\\&quot;\\\\\\&quot; verdana,=\\&quot;\\\\\\&quot; trebuchet=\\&quot;\\\\\\\\\\&quot;&gt;The {var site_name} Team&lt;/p&gt;', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xin_employees`
--

CREATE TABLE `xin_employees` (
  `user_id` int(11) NOT NULL,
  `employee_id` varchar(200) NOT NULL,
  `office_shift_id` int(111) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `date_of_birth` varchar(200) NOT NULL,
  `gender` varchar(200) NOT NULL,
  `e_status` int(11) NOT NULL,
  `user_role_id` int(100) NOT NULL,
  `department_id` int(100) NOT NULL,
  `designation_id` int(100) NOT NULL,
  `company_id` int(111) DEFAULT NULL,
  `salary_template` varchar(255) NOT NULL,
  `hourly_grade_id` int(111) NOT NULL,
  `monthly_grade_id` int(111) NOT NULL,
  `date_of_joining` varchar(200) NOT NULL,
  `date_of_leaving` varchar(255) NOT NULL,
  `marital_status` varchar(255) NOT NULL,
  `salary` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `profile_picture` text NOT NULL,
  `profile_background` text NOT NULL,
  `resume` text NOT NULL,
  `skype_id` varchar(200) NOT NULL,
  `contact_no` varchar(200) NOT NULL,
  `facebook_link` text NOT NULL,
  `twitter_link` text NOT NULL,
  `blogger_link` text NOT NULL,
  `linkdedin_link` text NOT NULL,
  `google_plus_link` text NOT NULL,
  `instagram_link` varchar(255) NOT NULL,
  `pinterest_link` varchar(255) NOT NULL,
  `youtube_link` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `last_login_date` varchar(255) NOT NULL,
  `last_logout_date` varchar(255) NOT NULL,
  `last_login_ip` varchar(255) NOT NULL,
  `is_logged_in` int(111) NOT NULL,
  `online_status` int(111) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employees`
--

TRUNCATE TABLE `xin_employees`;
--
-- Dumping data for table `xin_employees`
--

INSERT INTO `xin_employees` (`user_id`, `employee_id`, `office_shift_id`, `first_name`, `last_name`, `username`, `email`, `password`, `date_of_birth`, `gender`, `e_status`, `user_role_id`, `department_id`, `designation_id`, `company_id`, `salary_template`, `hourly_grade_id`, `monthly_grade_id`, `date_of_joining`, `date_of_leaving`, `marital_status`, `salary`, `address`, `profile_picture`, `profile_background`, `resume`, `skype_id`, `contact_no`, `facebook_link`, `twitter_link`, `blogger_link`, `linkdedin_link`, `google_plus_link`, `instagram_link`, `pinterest_link`, `youtube_link`, `is_active`, `last_login_date`, `last_logout_date`, `last_login_ip`, `is_logged_in`, `online_status`, `created_at`) VALUES
(1, 'fionagrace', 1, 'Fiona', 'Grace', 'fionagrace', 'administrator@golpocom.com', '$2y$12$WLO5WeDraB1SskXJhYq2dufmQ9PtfIQRReXkj37/hLc2aTdlYfv.C', '2018-03-28', 'Male', 0, 1, 1, 9, 1, 'monthly', 0, 0, '2018-02-01', '', 'Single', '', 'Test Addresss', 'profile_1528205632.jpg', 'profile_background_1519924152.jpg', '', '', '12345678900', '', '', '', '', '', '', '', '', 1, '10-07-2018 01:23:32', '10-07-2018 02:09:03', '::1', 1, 1, '2018-02-28 05:30:44'),
(5, 'jsmith12', 1, 'Jhon', 'Smith', 'jhonsmith', 'jsmt12@golpocom.com', '$2y$12$zjBiQwIQG7vmgGeq935iqOCDiQVREZgA3VsN44YderDI5YoXKkWdi', '2018-03-31', 'Male', 0, 2, 2, 10, 1, 'monthly', 0, 0, '2018-03-02', '', 'Single', '', 'jsmt12', 'profile_1526034654.jpg', '', '', '', '1232', '', '', '', '', '', '', '', '', 1, '08-07-2018 00:14:52', '08-07-2018 04:11:00', '::1', 1, 1, '2018-03-18 01:10:04');

-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_bankaccount`
--

CREATE TABLE `xin_employee_bankaccount` (
  `bankaccount_id` int(111) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `is_primary` int(11) NOT NULL,
  `account_title` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `bank_code` varchar(255) NOT NULL,
  `bank_branch` text NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_bankaccount`
--

TRUNCATE TABLE `xin_employee_bankaccount`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_complaints`
--

CREATE TABLE `xin_employee_complaints` (
  `complaint_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `complaint_from` int(111) NOT NULL,
  `title` varchar(255) NOT NULL,
  `complaint_date` varchar(255) NOT NULL,
  `complaint_against` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(2) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_complaints`
--

TRUNCATE TABLE `xin_employee_complaints`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_contacts`
--

CREATE TABLE `xin_employee_contacts` (
  `contact_id` int(111) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `relation` varchar(255) NOT NULL,
  `is_primary` int(111) NOT NULL,
  `is_dependent` int(111) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `work_phone` varchar(255) NOT NULL,
  `work_phone_extension` varchar(255) NOT NULL,
  `mobile_phone` varchar(255) NOT NULL,
  `home_phone` varchar(255) NOT NULL,
  `work_email` varchar(255) NOT NULL,
  `personal_email` varchar(255) NOT NULL,
  `address_1` text NOT NULL,
  `address_2` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_contacts`
--

TRUNCATE TABLE `xin_employee_contacts`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_contract`
--

CREATE TABLE `xin_employee_contract` (
  `contract_id` int(111) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `contract_type_id` int(111) NOT NULL,
  `from_date` varchar(255) NOT NULL,
  `designation_id` int(111) NOT NULL,
  `title` varchar(255) NOT NULL,
  `to_date` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_contract`
--

TRUNCATE TABLE `xin_employee_contract`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_documents`
--

CREATE TABLE `xin_employee_documents` (
  `document_id` int(111) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `document_type_id` int(111) NOT NULL,
  `date_of_expiry` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `notification_email` varchar(255) NOT NULL,
  `is_alert` tinyint(1) NOT NULL,
  `description` text NOT NULL,
  `document_file` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_documents`
--

TRUNCATE TABLE `xin_employee_documents`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_exit`
--

CREATE TABLE `xin_employee_exit` (
  `exit_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `exit_date` varchar(255) NOT NULL,
  `exit_type_id` int(111) NOT NULL,
  `exit_interview` int(111) NOT NULL,
  `is_inactivate_account` int(111) NOT NULL,
  `reason` text NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_exit`
--

TRUNCATE TABLE `xin_employee_exit`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_exit_type`
--

CREATE TABLE `xin_employee_exit_type` (
  `exit_type_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_exit_type`
--

TRUNCATE TABLE `xin_employee_exit_type`;
--
-- Dumping data for table `xin_employee_exit_type`
--

INSERT INTO `xin_employee_exit_type` (`exit_type_id`, `company_id`, `type`, `created_at`) VALUES
(1, 1, 'Test', '');

-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_immigration`
--

CREATE TABLE `xin_employee_immigration` (
  `immigration_id` int(111) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `document_type_id` int(111) NOT NULL,
  `document_number` varchar(255) NOT NULL,
  `document_file` varchar(255) NOT NULL,
  `issue_date` varchar(255) NOT NULL,
  `expiry_date` varchar(255) NOT NULL,
  `country_id` varchar(255) NOT NULL,
  `eligible_review_date` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_immigration`
--

TRUNCATE TABLE `xin_employee_immigration`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_leave`
--

CREATE TABLE `xin_employee_leave` (
  `leave_id` int(111) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `contract_id` int(111) NOT NULL,
  `casual_leave` varchar(255) NOT NULL,
  `medical_leave` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_leave`
--

TRUNCATE TABLE `xin_employee_leave`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_location`
--

CREATE TABLE `xin_employee_location` (
  `office_location_id` int(111) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `location_id` int(111) NOT NULL,
  `from_date` varchar(255) NOT NULL,
  `to_date` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_location`
--

TRUNCATE TABLE `xin_employee_location`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_promotions`
--

CREATE TABLE `xin_employee_promotions` (
  `promotion_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `title` varchar(255) NOT NULL,
  `promotion_date` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_promotions`
--

TRUNCATE TABLE `xin_employee_promotions`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_qualification`
--

CREATE TABLE `xin_employee_qualification` (
  `qualification_id` int(111) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `name` varchar(255) NOT NULL,
  `education_level_id` int(111) NOT NULL,
  `from_year` varchar(255) NOT NULL,
  `language_id` int(111) NOT NULL,
  `to_year` varchar(255) NOT NULL,
  `skill_id` text NOT NULL,
  `description` text NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_qualification`
--

TRUNCATE TABLE `xin_employee_qualification`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_resignations`
--

CREATE TABLE `xin_employee_resignations` (
  `resignation_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `notice_date` varchar(255) NOT NULL,
  `resignation_date` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_resignations`
--

TRUNCATE TABLE `xin_employee_resignations`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_shift`
--

CREATE TABLE `xin_employee_shift` (
  `emp_shift_id` int(111) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `shift_id` int(111) NOT NULL,
  `from_date` varchar(255) NOT NULL,
  `to_date` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_shift`
--

TRUNCATE TABLE `xin_employee_shift`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_terminations`
--

CREATE TABLE `xin_employee_terminations` (
  `termination_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `terminated_by` int(111) NOT NULL,
  `termination_type_id` int(111) NOT NULL,
  `termination_date` varchar(255) NOT NULL,
  `notice_date` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(2) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_terminations`
--

TRUNCATE TABLE `xin_employee_terminations`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_transfer`
--

CREATE TABLE `xin_employee_transfer` (
  `transfer_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `transfer_date` varchar(255) NOT NULL,
  `transfer_department` int(111) NOT NULL,
  `transfer_location` int(111) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(2) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_transfer`
--

TRUNCATE TABLE `xin_employee_transfer`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_travels`
--

CREATE TABLE `xin_employee_travels` (
  `travel_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `visit_purpose` varchar(255) NOT NULL,
  `visit_place` varchar(255) NOT NULL,
  `travel_mode` int(111) DEFAULT NULL,
  `arrangement_type` int(111) DEFAULT NULL,
  `expected_budget` varchar(255) NOT NULL,
  `actual_budget` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(2) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_travels`
--

TRUNCATE TABLE `xin_employee_travels`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_warnings`
--

CREATE TABLE `xin_employee_warnings` (
  `warning_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `warning_to` int(111) NOT NULL,
  `warning_by` int(111) NOT NULL,
  `warning_date` varchar(255) NOT NULL,
  `warning_type_id` int(111) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(2) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_warnings`
--

TRUNCATE TABLE `xin_employee_warnings`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_employee_work_experience`
--

CREATE TABLE `xin_employee_work_experience` (
  `work_experience_id` int(111) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `from_date` varchar(255) NOT NULL,
  `to_date` varchar(255) NOT NULL,
  `post` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_employee_work_experience`
--

TRUNCATE TABLE `xin_employee_work_experience`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_events`
--

CREATE TABLE `xin_events` (
  `event_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_date` varchar(255) NOT NULL,
  `event_time` varchar(255) NOT NULL,
  `event_note` text NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_events`
--

TRUNCATE TABLE `xin_events`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_expenses`
--

CREATE TABLE `xin_expenses` (
  `expense_id` int(11) NOT NULL,
  `employee_id` int(200) NOT NULL,
  `company_id` int(11) NOT NULL,
  `expense_type_id` int(200) NOT NULL,
  `billcopy_file` text NOT NULL,
  `amount` varchar(200) NOT NULL,
  `purchase_date` varchar(200) NOT NULL,
  `remarks` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `status_remarks` text NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_expenses`
--

TRUNCATE TABLE `xin_expenses`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_expense_type`
--

CREATE TABLE `xin_expense_type` (
  `expense_type_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_expense_type`
--

TRUNCATE TABLE `xin_expense_type`;
--
-- Dumping data for table `xin_expense_type`
--

INSERT INTO `xin_expense_type` (`expense_type_id`, `company_id`, `name`, `status`, `created_at`) VALUES
(1, 1, 'Supplies', 1, '22-03-2018 01:17:42'),
(2, 1, 'Utility', 1, '22-03-2018 01:17:48');

-- --------------------------------------------------------

--
-- Table structure for table `xin_file_manager`
--

CREATE TABLE `xin_file_manager` (
  `file_id` int(111) NOT NULL,
  `user_id` int(111) NOT NULL,
  `department_id` int(111) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_size` varchar(255) NOT NULL,
  `file_extension` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_file_manager`
--

TRUNCATE TABLE `xin_file_manager`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_file_manager_settings`
--

CREATE TABLE `xin_file_manager_settings` (
  `setting_id` int(111) NOT NULL,
  `allowed_extensions` text NOT NULL,
  `maximum_file_size` varchar(255) NOT NULL,
  `is_enable_all_files` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_file_manager_settings`
--

TRUNCATE TABLE `xin_file_manager_settings`;
--
-- Dumping data for table `xin_file_manager_settings`
--

INSERT INTO `xin_file_manager_settings` (`setting_id`, `allowed_extensions`, `maximum_file_size`, `is_enable_all_files`, `updated_at`) VALUES
(1, 'gif,png,pdf,txt,doc,docx', '10', '', '2018-07-08 05:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `xin_finance_bankcash`
--

CREATE TABLE `xin_finance_bankcash` (
  `bankcash_id` int(111) NOT NULL,
  `account_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_balance` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `branch_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank_branch` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Truncate table before insert `xin_finance_bankcash`
--

TRUNCATE TABLE `xin_finance_bankcash`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_finance_deposit`
--

CREATE TABLE `xin_finance_deposit` (
  `deposit_id` int(111) NOT NULL,
  `account_type_id` int(111) NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deposit_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(111) NOT NULL,
  `payer_id` int(111) NOT NULL,
  `payment_method` int(111) NOT NULL,
  `deposit_reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deposit_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Truncate table before insert `xin_finance_deposit`
--

TRUNCATE TABLE `xin_finance_deposit`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_finance_expense`
--

CREATE TABLE `xin_finance_expense` (
  `expense_id` int(111) NOT NULL,
  `account_type_id` int(111) NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expense_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(111) NOT NULL,
  `payee_id` int(111) NOT NULL,
  `payment_method` int(111) NOT NULL,
  `expense_reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expense_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Truncate table before insert `xin_finance_expense`
--

TRUNCATE TABLE `xin_finance_expense`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_finance_payees`
--

CREATE TABLE `xin_finance_payees` (
  `payee_id` int(11) NOT NULL,
  `payee_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Truncate table before insert `xin_finance_payees`
--

TRUNCATE TABLE `xin_finance_payees`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_finance_payers`
--

CREATE TABLE `xin_finance_payers` (
  `payer_id` int(11) NOT NULL,
  `payer_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Truncate table before insert `xin_finance_payers`
--

TRUNCATE TABLE `xin_finance_payers`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_finance_transactions`
--

CREATE TABLE `xin_finance_transactions` (
  `transaction_id` int(111) NOT NULL,
  `account_type_id` int(111) NOT NULL,
  `deposit_id` int(111) NOT NULL,
  `expense_id` int(111) NOT NULL,
  `transfer_id` int(111) NOT NULL,
  `transaction_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_debit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_credit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Truncate table before insert `xin_finance_transactions`
--

TRUNCATE TABLE `xin_finance_transactions`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_finance_transfer`
--

CREATE TABLE `xin_finance_transfer` (
  `transfer_id` int(111) NOT NULL,
  `from_account_id` int(111) NOT NULL,
  `to_account_id` int(111) NOT NULL,
  `transfer_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transfer_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_method` varchar(111) COLLATE utf8_unicode_ci NOT NULL,
  `transfer_reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Truncate table before insert `xin_finance_transfer`
--

TRUNCATE TABLE `xin_finance_transfer`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_goal_tracking`
--

CREATE TABLE `xin_goal_tracking` (
  `tracking_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `tracking_type_id` int(200) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `target_achiement` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `goal_progress` varchar(200) NOT NULL,
  `goal_status` int(11) NOT NULL DEFAULT '0',
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_goal_tracking`
--

TRUNCATE TABLE `xin_goal_tracking`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_goal_tracking_type`
--

CREATE TABLE `xin_goal_tracking_type` (
  `tracking_type_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_goal_tracking_type`
--

TRUNCATE TABLE `xin_goal_tracking_type`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_holidays`
--

CREATE TABLE `xin_holidays` (
  `holiday_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `event_name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `is_publish` tinyint(1) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_holidays`
--

TRUNCATE TABLE `xin_holidays`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_hourly_templates`
--

CREATE TABLE `xin_hourly_templates` (
  `hourly_rate_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `hourly_grade` varchar(255) NOT NULL,
  `hourly_rate` varchar(255) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_hourly_templates`
--

TRUNCATE TABLE `xin_hourly_templates`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_hrsale_invoices`
--

CREATE TABLE `xin_hrsale_invoices` (
  `invoice_id` int(111) NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `project_id` int(111) NOT NULL,
  `invoice_date` varchar(255) NOT NULL,
  `invoice_due_date` varchar(255) NOT NULL,
  `sub_total_amount` varchar(255) NOT NULL,
  `discount_type` varchar(11) NOT NULL,
  `discount_figure` varchar(255) NOT NULL,
  `total_tax` varchar(255) NOT NULL,
  `total_discount` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `invoice_note` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_hrsale_invoices`
--

TRUNCATE TABLE `xin_hrsale_invoices`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_hrsale_invoices_items`
--

CREATE TABLE `xin_hrsale_invoices_items` (
  `invoice_item_id` int(111) NOT NULL,
  `invoice_id` int(111) NOT NULL,
  `project_id` int(111) NOT NULL,
  `item_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `item_tax_type` varchar(255) NOT NULL,
  `item_tax_rate` varchar(255) NOT NULL,
  `item_qty` varchar(255) NOT NULL,
  `item_unit_price` varchar(255) NOT NULL,
  `item_sub_total` varchar(255) NOT NULL,
  `sub_total_amount` varchar(255) NOT NULL,
  `total_tax` varchar(255) NOT NULL,
  `discount_type` int(11) NOT NULL,
  `discount_figure` varchar(255) NOT NULL,
  `total_discount` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_hrsale_invoices_items`
--

TRUNCATE TABLE `xin_hrsale_invoices_items`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_income_categories`
--

CREATE TABLE `xin_income_categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_income_categories`
--

TRUNCATE TABLE `xin_income_categories`;
--
-- Dumping data for table `xin_income_categories`
--

INSERT INTO `xin_income_categories` (`category_id`, `name`, `status`, `created_at`) VALUES
(1, 'Envato', 1, '25-03-2018 09:36:20'),
(2, 'Salary', 1, '25-03-2018 09:36:28'),
(3, 'Other Income', 1, '25-03-2018 09:36:32'),
(4, 'Interest Income', 1, '25-03-2018 09:36:53'),
(5, 'Part Time Work', 1, '25-03-2018 09:37:13'),
(6, 'Regular Income', 1, '25-03-2018 09:37:17');

-- --------------------------------------------------------

--
-- Table structure for table `xin_jobs`
--

CREATE TABLE `xin_jobs` (
  `job_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `designation_id` int(111) NOT NULL,
  `job_type` int(225) NOT NULL,
  `is_featured` int(11) NOT NULL,
  `job_vacancy` int(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `minimum_experience` varchar(255) NOT NULL,
  `date_of_closing` varchar(200) NOT NULL,
  `short_description` text NOT NULL,
  `long_description` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_jobs`
--

TRUNCATE TABLE `xin_jobs`;
--
-- Dumping data for table `xin_jobs`
--

INSERT INTO `xin_jobs` (`job_id`, `company_id`, `job_title`, `designation_id`, `job_type`, `is_featured`, `job_vacancy`, `gender`, `minimum_experience`, `date_of_closing`, `short_description`, `long_description`, `status`, `created_at`) VALUES
(1, 1, 'Marketing Coordinator - SEO / SEM Experience 1', 9, 1, 0, 12, '0', '0', '2018-03-22', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor..', '&lt;p class=\\&quot;\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&amp;quot;margin-reset\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\&amp;quot;\\&quot;&gt;\r\nThe Food Service Specialist ensures outstanding customer service is provided to food customers and that all food offerings meet the required stock levels and presentation standards. Beginning your career as a Food Steward will give you a strong foundation in Speedway’s food segment that can make you a vital member of the front line team!\r\n&lt;/p&gt;\r\n\r\n&lt;br&gt;\r\n&lt;p&gt;The &lt;strong&gt;Food Service Specialist&lt;/strong&gt; will have responsibilities that include:&lt;/p&gt;\r\n\r\n&lt;ul class=\\&quot;\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&amp;quot;list-1\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\&amp;quot;\\&quot;&gt;\r\n&lt;li&gt;Executing the Food Service program, including preparing and presenting our wonderful food offerings\r\nto hungry customers on the go!\r\n&lt;/li&gt;\r\n&lt;li&gt;Greeting customers in a friendly manner and suggestive selling and sampling items to help increase sales.&lt;/li&gt;\r\n&lt;li&gt;Keeping our Store food area looking terrific and ready for our valued customers by managing product \r\ninventory, stocking, cleaning, etc.&lt;/li&gt;\r\n&lt;li&gt;We’re looking for associates who enjoy interacting with people and working in a fast-paced environment!&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;br&gt;\r\n\r\n&lt;h4 class=\\&quot;\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&amp;quot;margin-bottom-10\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\&amp;quot;\\&quot;&gt;Job Requirment&lt;/h4&gt;\r\n\r\n&lt;ul class=\\&quot;\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&amp;quot;list-1\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\&amp;quot;\\&quot;&gt;\r\n&lt;li&gt;Excellent customer service skills, communication skills, and a happy, smiling attitude are essential.&lt;/li&gt;\r\n&lt;li&gt;Must be available to work required shifts including weekends, evenings and holidays.&lt;/li&gt;\r\n&lt;li&gt;Must be able to perform repeated bending, standing and reaching.&lt;/li&gt;\r\n&lt;li&gt; Must be able to occasionally lift up to 50 pounds&lt;/li&gt;\r\n&lt;/ul&gt;', 1, '2018-03-22 02:19:10'),
(2, 1, 'Core PHP Developer for Site Maintenance ', 9, 2, 1, 9, '0', '0', '2018-04-27', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '&lt;p class=\\\\\\&quot;margin-reset\\\\\\&quot;&gt;\r\nThe Food Service Specialist ensures outstanding customer service is provided to food customers and that all food offerings meet the required stock levels and presentation standards. Beginning your career as a Food Steward will give you a strong foundation in Speedway’s food segment that can make you a vital member of the front line team!\r\n&lt;/p&gt;\r\n\r\n&lt;br&gt;\r\n&lt;p&gt;The &lt;strong&gt;Food Service Specialist&lt;/strong&gt; will have responsibilities that include:&lt;/p&gt;\r\n\r\n&lt;ul class=\\\\\\&quot;list-1\\\\\\&quot;&gt;\r\n&lt;li&gt;Executing the Food Service program, including preparing and presenting our wonderful food offerings\r\nto hungry customers on the go!\r\n&lt;/li&gt;\r\n&lt;li&gt;Greeting customers in a friendly manner and suggestive selling and sampling items to help increase sales.&lt;/li&gt;\r\n&lt;li&gt;Keeping our Store food area looking terrific and ready for our valued customers by managing product \r\ninventory, stocking, cleaning, etc.&lt;/li&gt;\r\n&lt;li&gt;We’re looking for associates who enjoy interacting with people and working in a fast-paced environment!&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;br&gt;\r\n\r\n&lt;h4 class=\\\\\\&quot;margin-bottom-10\\\\\\&quot;&gt;Job Requirment&lt;/h4&gt;\r\n\r\n&lt;ul class=\\\\\\&quot;list-1\\\\\\&quot;&gt;\r\n&lt;li&gt;Excellent customer service skills, communication skills, and a happy, smiling attitude are essential.&lt;/li&gt;\r\n&lt;li&gt;Must be available to work required shifts including weekends, evenings and holidays.&lt;/li&gt;\r\n&lt;li&gt;Must be able to perform repeated bending, standing and reaching.&lt;/li&gt;\r\n&lt;li&gt; Must be able to occasionally lift up to 50 pounds&lt;/li&gt;\r\n&lt;/ul&gt;', 1, '2018-04-16 06:09:33'),
(3, 1, 'Power Systems User Experience Designer ', 9, 2, 0, 8, '0', '0', '2018-05-01', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '&lt;p class=\\\\\\&quot;margin-reset\\\\\\&quot;&gt;\r\nThe Food Service Specialist ensures outstanding customer service is provided to food customers and that all food offerings meet the required stock levels and presentation standards. Beginning your career as a Food Steward will give you a strong foundation in Speedway’s food segment that can make you a vital member of the front line team!\r\n&lt;/p&gt;\r\n\r\n&lt;br&gt;\r\n&lt;p&gt;The &lt;strong&gt;Food Service Specialist&lt;/strong&gt; will have responsibilities that include:&lt;/p&gt;\r\n\r\n&lt;ul class=\\\\\\&quot;list-1\\\\\\&quot;&gt;\r\n&lt;li&gt;Executing the Food Service program, including preparing and presenting our wonderful food offerings\r\nto hungry customers on the go!\r\n&lt;/li&gt;\r\n&lt;li&gt;Greeting customers in a friendly manner and suggestive selling and sampling items to help increase sales.&lt;/li&gt;\r\n&lt;li&gt;Keeping our Store food area looking terrific and ready for our valued customers by managing product \r\ninventory, stocking, cleaning, etc.&lt;/li&gt;\r\n&lt;li&gt;We’re looking for associates who enjoy interacting with people and working in a fast-paced environment!&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;br&gt;\r\n\r\n&lt;h4 class=\\\\\\&quot;margin-bottom-10\\\\\\&quot;&gt;Job Requirment&lt;/h4&gt;\r\n\r\n&lt;ul class=\\\\\\&quot;list-1\\\\\\&quot;&gt;\r\n&lt;li&gt;Excellent customer service skills, communication skills, and a happy, smiling attitude are essential.&lt;/li&gt;\r\n&lt;li&gt;Must be available to work required shifts including weekends, evenings and holidays.&lt;/li&gt;\r\n&lt;li&gt;Must be able to perform repeated bending, standing and reaching.&lt;/li&gt;\r\n&lt;li&gt; Must be able to occasionally lift up to 50 pounds&lt;/li&gt;\r\n&lt;/ul&gt;', 1, '2018-04-16 06:48:47'),
(4, 1, 'Graphic Designer', 9, 3, 1, 12, '0', '0', '2018-04-30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '&lt;p class=\\\\\\&quot;margin-reset\\\\\\&quot;&gt;\r\nThe Food Service Specialist ensures outstanding customer service is provided to food customers and that all food offerings meet the required stock levels and presentation standards. Beginning your career as a Food Steward will give you a strong foundation in Speedway’s food segment that can make you a vital member of the front line team!\r\n&lt;/p&gt;\r\n\r\n&lt;br&gt;\r\n&lt;p&gt;The &lt;strong&gt;Food Service Specialist&lt;/strong&gt; will have responsibilities that include:&lt;/p&gt;\r\n\r\n&lt;ul class=\\\\\\&quot;list-1\\\\\\&quot;&gt;\r\n&lt;li&gt;Executing the Food Service program, including preparing and presenting our wonderful food offerings\r\nto hungry customers on the go!\r\n&lt;/li&gt;\r\n&lt;li&gt;Greeting customers in a friendly manner and suggestive selling and sampling items to help increase sales.&lt;/li&gt;\r\n&lt;li&gt;Keeping our Store food area looking terrific and ready for our valued customers by managing product \r\ninventory, stocking, cleaning, etc.&lt;/li&gt;\r\n&lt;li&gt;We’re looking for associates who enjoy interacting with people and working in a fast-paced environment!&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;br&gt;\r\n\r\n&lt;h4 class=\\\\\\&quot;margin-bottom-10\\\\\\&quot;&gt;Job Requirment&lt;/h4&gt;\r\n\r\n&lt;ul class=\\\\\\&quot;list-1\\\\\\&quot;&gt;\r\n&lt;li&gt;Excellent customer service skills, communication skills, and a happy, smiling attitude are essential.&lt;/li&gt;\r\n&lt;li&gt;Must be available to work required shifts including weekends, evenings and holidays.&lt;/li&gt;\r\n&lt;li&gt;Must be able to perform repeated bending, standing and reaching.&lt;/li&gt;\r\n&lt;li&gt; Must be able to occasionally lift up to 50 pounds&lt;/li&gt;\r\n&lt;/ul&gt;', 1, '2018-04-16 11:03:59'),
(5, 1, 'Project Managers', 9, 4, 0, 22, '0', '2', '2018-03-31', 'sdafadsf', 'sd asdfads fsdf asdfsdf', 1, '2018-04-19 04:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `xin_job_applications`
--

CREATE TABLE `xin_job_applications` (
  `application_id` int(111) NOT NULL,
  `job_id` int(111) NOT NULL,
  `user_id` int(111) NOT NULL,
  `message` text NOT NULL,
  `job_resume` text NOT NULL,
  `application_status` varchar(200) NOT NULL,
  `application_remarks` text NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_job_applications`
--

TRUNCATE TABLE `xin_job_applications`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_job_categories`
--

CREATE TABLE `xin_job_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_url` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_job_categories`
--

TRUNCATE TABLE `xin_job_categories`;
--
-- Dumping data for table `xin_job_categories`
--

INSERT INTO `xin_job_categories` (`category_id`, `category_name`, `category_url`, `created_at`) VALUES
(1, 'PHP', 'php', '2018-04-15'),
(2, 'Android', 'andriod', '2018-04-15'),
(3, 'WordPress', 'wordpress', '2018-04-15'),
(4, 'Design', 'design', '2018-04-15'),
(5, 'Developer', 'developer', '2018-04-15'),
(6, 'iOS', 'ios', '2018-04-15'),
(7, 'Mobile', 'mobile', '2018-04-15'),
(8, 'MySQL', 'mysql', '2018-04-15'),
(9, 'JavaScript', 'javascript', ''),
(10, 'Software', 'software', ''),
(11, 'Website Design', '', ''),
(12, 'Programming', '', ''),
(13, 'SEO', '', ''),
(14, 'Java', '', ''),
(15, 'CSS', '', ''),
(16, 'HTML5', '', ''),
(17, 'Web Development', '', ''),
(18, 'Web Design', '', ''),
(19, 'eCommerce', '', ''),
(20, 'Design', '', ''),
(21, 'Logo Design', '', ''),
(22, 'Graphic Design', '', ''),
(23, 'Video', '', ''),
(24, 'Animation', '', ''),
(25, 'Adobe Photoshop', '', ''),
(26, 'Illustration', '', ''),
(27, 'Art', '', ''),
(28, '3D', '', ''),
(29, 'Adobe Illustrator', '', ''),
(30, 'Drawing', '', ''),
(31, 'Web Design', '', ''),
(32, 'Cartoon', '', ''),
(33, 'Graphics', '', ''),
(34, 'Fashion Design', '', ''),
(35, 'WordPress', '', ''),
(36, 'Editing', '', ''),
(37, 'Writing', '', ''),
(38, 'T-Shirt Design', '', ''),
(39, 'Display Advertising', '', ''),
(40, 'Email Marketing', '', ''),
(41, 'Lead Generation', '', ''),
(42, 'Market & Customer Research', '', ''),
(43, 'Marketing Strategy', '', ''),
(44, 'Public Relations', '', ''),
(45, 'Telemarketing & Telesales', '', ''),
(46, 'Other - Sales & Marketing', '', ''),
(47, 'SEM - Search Engine Marketing', '', ''),
(48, 'SEO - Search Engine Optimization', '', ''),
(49, 'SMM - Social Media Marketing', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `xin_job_interviews`
--

CREATE TABLE `xin_job_interviews` (
  `job_interview_id` int(111) NOT NULL,
  `job_id` int(111) NOT NULL,
  `interviewers_id` varchar(255) NOT NULL,
  `interview_place` varchar(255) NOT NULL,
  `interview_date` varchar(255) NOT NULL,
  `interview_time` varchar(255) NOT NULL,
  `interviewees_id` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_job_interviews`
--

TRUNCATE TABLE `xin_job_interviews`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_job_type`
--

CREATE TABLE `xin_job_type` (
  `job_type_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `type_url` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_job_type`
--

TRUNCATE TABLE `xin_job_type`;
--
-- Dumping data for table `xin_job_type`
--

INSERT INTO `xin_job_type` (`job_type_id`, `company_id`, `type`, `type_url`, `created_at`) VALUES
(1, 1, 'Full Time', 'full-time', '22-03-2018 02:18:48'),
(2, 1, 'Part Time', 'part-time', '16-04-2018 06:29:45'),
(3, 1, 'Internship', 'internship', '16-04-2018 06:30:06'),
(4, 1, 'Freelance', 'freelance', '16-04-2018 06:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `xin_languages`
--

CREATE TABLE `xin_languages` (
  `language_id` int(111) NOT NULL,
  `language_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language_flag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Truncate table before insert `xin_languages`
--

TRUNCATE TABLE `xin_languages`;
--
-- Dumping data for table `xin_languages`
--

INSERT INTO `xin_languages` (`language_id`, `language_name`, `language_code`, `language_flag`, `is_active`, `created_at`) VALUES
(1, 'English', 'english', 'language_flag_1520564355.gif', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `xin_leave_applications`
--

CREATE TABLE `xin_leave_applications` (
  `leave_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(222) NOT NULL,
  `leave_type_id` int(222) NOT NULL,
  `from_date` varchar(200) NOT NULL,
  `to_date` varchar(200) NOT NULL,
  `applied_on` varchar(200) NOT NULL,
  `reason` text NOT NULL,
  `remarks` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_leave_applications`
--

TRUNCATE TABLE `xin_leave_applications`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_leave_type`
--

CREATE TABLE `xin_leave_type` (
  `leave_type_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `type_name` varchar(200) NOT NULL,
  `days_per_year` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_leave_type`
--

TRUNCATE TABLE `xin_leave_type`;
--
-- Dumping data for table `xin_leave_type`
--

INSERT INTO `xin_leave_type` (`leave_type_id`, `company_id`, `type_name`, `days_per_year`, `status`, `created_at`) VALUES
(1, 1, 'Casual Leave', '12', 1, '19-03-2018 07:52:20'),
(2, 1, 'Medical', '12', 1, '19-03-2018 07:52:30');

-- --------------------------------------------------------

--
-- Table structure for table `xin_make_payment`
--

CREATE TABLE `xin_make_payment` (
  `make_payment_id` int(111) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `department_id` int(111) NOT NULL,
  `company_id` int(111) NOT NULL,
  `location_id` int(111) NOT NULL,
  `designation_id` int(111) NOT NULL,
  `payment_date` varchar(200) NOT NULL,
  `basic_salary` varchar(255) NOT NULL,
  `payment_amount` varchar(255) NOT NULL,
  `gross_salary` varchar(255) NOT NULL,
  `total_allowances` varchar(255) NOT NULL,
  `total_deductions` varchar(255) NOT NULL,
  `net_salary` varchar(255) NOT NULL,
  `house_rent_allowance` varchar(255) NOT NULL,
  `medical_allowance` varchar(255) NOT NULL,
  `travelling_allowance` varchar(255) NOT NULL,
  `dearness_allowance` varchar(255) NOT NULL,
  `provident_fund` varchar(255) NOT NULL,
  `tax_deduction` varchar(255) NOT NULL,
  `security_deposit` varchar(255) NOT NULL,
  `overtime_rate` varchar(255) NOT NULL,
  `is_advance_salary_deduct` int(11) NOT NULL,
  `advance_salary_amount` varchar(255) NOT NULL,
  `is_payment` tinyint(1) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `hourly_rate` varchar(255) NOT NULL,
  `total_hours_work` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_make_payment`
--

TRUNCATE TABLE `xin_make_payment`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_meetings`
--

CREATE TABLE `xin_meetings` (
  `meeting_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `meeting_title` varchar(255) NOT NULL,
  `meeting_date` varchar(255) NOT NULL,
  `meeting_time` varchar(255) NOT NULL,
  `meeting_note` text NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_meetings`
--

TRUNCATE TABLE `xin_meetings`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_office_location`
--

CREATE TABLE `xin_office_location` (
  `location_id` int(11) NOT NULL,
  `company_id` int(111) NOT NULL,
  `location_head` int(111) NOT NULL,
  `location_manager` int(111) NOT NULL,
  `location_name` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `address_1` text NOT NULL,
  `address_2` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `country` int(111) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_office_location`
--

TRUNCATE TABLE `xin_office_location`;
--
-- Dumping data for table `xin_office_location`
--

INSERT INTO `xin_office_location` (`location_id`, `company_id`, `location_head`, `location_manager`, `location_name`, `email`, `phone`, `fax`, `address_1`, `address_2`, `city`, `state`, `zipcode`, `country`, `added_by`, `created_at`, `status`) VALUES
(1, 1, 1, 0, 'Main Office', 'test@golpocom.com', '1234567890', '1234567890', 'Address Line 1', 'Address Line 2', 'City', 'State', '12345', 230, 1, '28-02-2018', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xin_office_shift`
--

CREATE TABLE `xin_office_shift` (
  `office_shift_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `shift_name` varchar(255) NOT NULL,
  `default_shift` int(111) NOT NULL,
  `monday_in_time` varchar(222) NOT NULL,
  `monday_out_time` varchar(222) NOT NULL,
  `tuesday_in_time` varchar(222) NOT NULL,
  `tuesday_out_time` varchar(222) NOT NULL,
  `wednesday_in_time` varchar(222) NOT NULL,
  `wednesday_out_time` varchar(222) NOT NULL,
  `thursday_in_time` varchar(222) NOT NULL,
  `thursday_out_time` varchar(222) NOT NULL,
  `friday_in_time` varchar(222) NOT NULL,
  `friday_out_time` varchar(222) NOT NULL,
  `saturday_in_time` varchar(222) NOT NULL,
  `saturday_out_time` varchar(222) NOT NULL,
  `sunday_in_time` varchar(222) NOT NULL,
  `sunday_out_time` varchar(222) NOT NULL,
  `created_at` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_office_shift`
--

TRUNCATE TABLE `xin_office_shift`;
--
-- Dumping data for table `xin_office_shift`
--

INSERT INTO `xin_office_shift` (`office_shift_id`, `company_id`, `shift_name`, `default_shift`, `monday_in_time`, `monday_out_time`, `tuesday_in_time`, `tuesday_out_time`, `wednesday_in_time`, `wednesday_out_time`, `thursday_in_time`, `thursday_out_time`, `friday_in_time`, `friday_out_time`, `saturday_in_time`, `saturday_out_time`, `sunday_in_time`, `sunday_out_time`, `created_at`) VALUES
(1, 1, 'Morning Shift', 1, '08:00', '18:00', '03:00', '18:00', '08:00', '18:00', '08:00', '18:00', '08:00', '18:00', '', '', '', '', '2018-02-28');

-- --------------------------------------------------------

--
-- Table structure for table `xin_payment_method`
--

CREATE TABLE `xin_payment_method` (
  `payment_method_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `method_name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_payment_method`
--

TRUNCATE TABLE `xin_payment_method`;
--
-- Dumping data for table `xin_payment_method`
--

INSERT INTO `xin_payment_method` (`payment_method_id`, `company_id`, `method_name`, `created_at`) VALUES
(1, 1, 'Credit Card', '23-04-2018 05:13:52');

-- --------------------------------------------------------

--
-- Table structure for table `xin_payroll_custom_fields`
--

CREATE TABLE `xin_payroll_custom_fields` (
  `payroll_custom_id` int(11) NOT NULL,
  `allow_custom_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active_allow_1` int(11) NOT NULL,
  `allow_custom_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active_allow_2` int(11) NOT NULL,
  `allow_custom_3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active_allow_3` int(11) NOT NULL,
  `allow_custom_4` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active_allow_4` int(11) NOT NULL,
  `allow_custom_5` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active_allow_5` int(111) NOT NULL,
  `deduct_custom_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active_deduct_1` int(11) NOT NULL,
  `deduct_custom_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active_deduct_2` int(11) NOT NULL,
  `deduct_custom_3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active_deduct_3` int(11) NOT NULL,
  `deduct_custom_4` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active_deduct_4` int(11) NOT NULL,
  `deduct_custom_5` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active_deduct_5` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Truncate table before insert `xin_payroll_custom_fields`
--

TRUNCATE TABLE `xin_payroll_custom_fields`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_performance_appraisal`
--

CREATE TABLE `xin_performance_appraisal` (
  `performance_appraisal_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `appraisal_year_month` varchar(255) NOT NULL,
  `customer_experience` int(111) NOT NULL,
  `marketing` int(111) NOT NULL,
  `management` int(111) NOT NULL,
  `administration` int(111) NOT NULL,
  `presentation_skill` int(111) NOT NULL,
  `quality_of_work` int(111) NOT NULL,
  `efficiency` int(111) NOT NULL,
  `integrity` int(111) NOT NULL,
  `professionalism` int(111) NOT NULL,
  `team_work` int(111) NOT NULL,
  `critical_thinking` int(111) NOT NULL,
  `conflict_management` int(111) NOT NULL,
  `attendance` int(111) NOT NULL,
  `ability_to_meet_deadline` int(111) NOT NULL,
  `remarks` text NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_performance_appraisal`
--

TRUNCATE TABLE `xin_performance_appraisal`;
--
-- Dumping data for table `xin_performance_appraisal`
--

INSERT INTO `xin_performance_appraisal` (`performance_appraisal_id`, `company_id`, `employee_id`, `appraisal_year_month`, `customer_experience`, `marketing`, `management`, `administration`, `presentation_skill`, `quality_of_work`, `efficiency`, `integrity`, `professionalism`, `team_work`, `critical_thinking`, `conflict_management`, `attendance`, `ability_to_meet_deadline`, `remarks`, `added_by`, `created_at`) VALUES
(1, 1, 5, '2018-03', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 1, '22-03-2018');

-- --------------------------------------------------------

--
-- Table structure for table `xin_performance_indicator`
--

CREATE TABLE `xin_performance_indicator` (
  `performance_indicator_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `designation_id` int(111) NOT NULL,
  `customer_experience` int(111) NOT NULL,
  `marketing` int(111) NOT NULL,
  `management` int(111) NOT NULL,
  `administration` int(111) NOT NULL,
  `presentation_skill` int(111) NOT NULL,
  `quality_of_work` int(111) NOT NULL,
  `efficiency` int(111) NOT NULL,
  `integrity` int(111) NOT NULL,
  `professionalism` int(111) NOT NULL,
  `team_work` int(111) NOT NULL,
  `critical_thinking` int(111) NOT NULL,
  `conflict_management` int(111) NOT NULL,
  `attendance` int(111) NOT NULL,
  `ability_to_meet_deadline` int(111) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_performance_indicator`
--

TRUNCATE TABLE `xin_performance_indicator`;
--
-- Dumping data for table `xin_performance_indicator`
--

INSERT INTO `xin_performance_indicator` (`performance_indicator_id`, `company_id`, `designation_id`, `customer_experience`, `marketing`, `management`, `administration`, `presentation_skill`, `quality_of_work`, `efficiency`, `integrity`, `professionalism`, `team_work`, `critical_thinking`, `conflict_management`, `attendance`, `ability_to_meet_deadline`, `added_by`, `created_at`) VALUES
(1, 1, 10, 3, 4, 2, 3, 0, 0, 0, 0, 2, 0, 3, 3, 2, 3, 1, '05-04-2018');

-- --------------------------------------------------------

--
-- Table structure for table `xin_projects`
--

CREATE TABLE `xin_projects` (
  `project_id` int(111) NOT NULL,
  `title` varchar(255) NOT NULL,
  `client_id` int(100) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `company_id` int(111) NOT NULL,
  `assigned_to` text NOT NULL,
  `priority` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `description` text NOT NULL,
  `added_by` int(111) NOT NULL,
  `project_progress` varchar(255) NOT NULL,
  `project_note` longtext NOT NULL,
  `status` tinyint(2) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_projects`
--

TRUNCATE TABLE `xin_projects`;
--
-- Dumping data for table `xin_projects`
--

INSERT INTO `xin_projects` (`project_id`, `title`, `client_id`, `start_date`, `end_date`, `company_id`, `assigned_to`, `priority`, `summary`, `description`, `added_by`, `project_progress`, `project_note`, `status`, `created_at`) VALUES
(5, 'CodeIgniter', 1, '2018-05-16', '2018-05-18', 1, '1', '1', 'Test Summary', '&lt;p xss=removed&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque magna augue, euismod at tortor et, laoreet maximus risus. Ut neque felis, luctus ut rhoncus id, elementum vitae lorem. Ut ac turpis sit amet lorem volutpat tincidunt. Vestibulum dui sapien, porttitor eget pellentesque id, ultrices id ipsum. Nam augue mi, maximus ut tortor et, fermentum efficitur diam. Suspendisse eget urna lorem. Fusce ligula augue, malesuada ullamcorper est nec, commodo laoreet tellus.&lt;/p&gt;&lt;p xss=removed&gt;Proin imperdiet purus et lectus luctus, rutrum fermentum lorem molestie. Nam urna felis, elementum elementum placerat id, fermentum ac urna. Etiam libero sem, porttitor ultrices efficitur condimentum, lobortis sit amet enim. Sed vitae orci nulla.&lt;/p&gt;&lt;p xss=removed&gt;Cras ultrices, dui id vulputate laoreet, diam orci semper ipsum, a aliquet nunc quam vitae turpis. Donec cursus tortor nec turpis semper, ac luctus mauris sagittis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.&lt;/p&gt;&lt;p xss=removed&gt;Aliquam ornare nisl semper nisl porttitor commodo vel vel libero. Pellentesque faucibus, nisl vel luctus porttitor, leo felis pellentesque augue, dignissim tempus risus odio sed lorem. Nunc nec malesuada nunc, ut mollis dui. Vestibulum ac lacinia massa. Phasellus eget purus nisi. Quisque sodales, tortor et elementum dapibus, nisl urna hendrerit metus, a rhoncus magna sem in libero. Aliquam mattis erat ut diam viverra, quis iaculis sem pulvinar. Vivamus ut mi vitae arcu finibus convallis. Nulla turpis lacus, tempor et sagittis non, egestas nec ante.&lt;/p&gt;&lt;p xss=removed&gt;Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque pharetra turpis non aliquet ornare. Duis euismod ultricies est sed auctor. Sed luctus accumsan enim ut efficitur.&lt;/p&gt;', 1, '70', 'sdfasdfdsfd', 1, '15-05-2018');

-- --------------------------------------------------------

--
-- Table structure for table `xin_projects_attachment`
--

CREATE TABLE `xin_projects_attachment` (
  `project_attachment_id` int(11) NOT NULL,
  `project_id` int(200) NOT NULL,
  `upload_by` int(255) NOT NULL,
  `file_title` varchar(255) NOT NULL,
  `file_description` text NOT NULL,
  `attachment_file` text NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_projects_attachment`
--

TRUNCATE TABLE `xin_projects_attachment`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_projects_bugs`
--

CREATE TABLE `xin_projects_bugs` (
  `bug_id` int(11) NOT NULL,
  `project_id` int(111) NOT NULL,
  `user_id` int(200) NOT NULL,
  `attachment_file` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_projects_bugs`
--

TRUNCATE TABLE `xin_projects_bugs`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_projects_discussion`
--

CREATE TABLE `xin_projects_discussion` (
  `discussion_id` int(11) NOT NULL,
  `project_id` int(111) NOT NULL,
  `user_id` int(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `attachment_file` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_projects_discussion`
--

TRUNCATE TABLE `xin_projects_discussion`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_qualification_education_level`
--

CREATE TABLE `xin_qualification_education_level` (
  `education_level_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_qualification_education_level`
--

TRUNCATE TABLE `xin_qualification_education_level`;
--
-- Dumping data for table `xin_qualification_education_level`
--

INSERT INTO `xin_qualification_education_level` (`education_level_id`, `company_id`, `name`, `created_at`) VALUES
(1, 1, 'High School Diploma / GED', '09-05-2018 03:11:59');

-- --------------------------------------------------------

--
-- Table structure for table `xin_qualification_language`
--

CREATE TABLE `xin_qualification_language` (
  `language_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_qualification_language`
--

TRUNCATE TABLE `xin_qualification_language`;
--
-- Dumping data for table `xin_qualification_language`
--

INSERT INTO `xin_qualification_language` (`language_id`, `company_id`, `name`, `created_at`) VALUES
(1, 1, 'English', '09-05-2018 03:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `xin_qualification_skill`
--

CREATE TABLE `xin_qualification_skill` (
  `skill_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_qualification_skill`
--

TRUNCATE TABLE `xin_qualification_skill`;
--
-- Dumping data for table `xin_qualification_skill`
--

INSERT INTO `xin_qualification_skill` (`skill_id`, `company_id`, `name`, `created_at`) VALUES
(1, 1, 'jQuery', '09-05-2018 03:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `xin_recruitment_pages`
--

CREATE TABLE `xin_recruitment_pages` (
  `page_id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_details` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_recruitment_pages`
--

TRUNCATE TABLE `xin_recruitment_pages`;
--
-- Dumping data for table `xin_recruitment_pages`
--

INSERT INTO `xin_recruitment_pages` (`page_id`, `page_title`, `page_details`, `status`, `created_at`) VALUES
(1, 'Pages', 'Nulla dignissim gravida\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \n\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.', 1, ''),
(2, 'About Us', 'Nulla dignissim gravida\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \n\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.', 1, ''),
(3, 'Career Services', 'Career Services', 1, ''),
(4, 'Success Stories', 'Success Stories', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `xin_recruitment_subpages`
--

CREATE TABLE `xin_recruitment_subpages` (
  `subpages_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `sub_page_title` varchar(255) NOT NULL,
  `sub_page_details` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_recruitment_subpages`
--

TRUNCATE TABLE `xin_recruitment_subpages`;
--
-- Dumping data for table `xin_recruitment_subpages`
--

INSERT INTO `xin_recruitment_subpages` (`subpages_id`, `page_id`, `sub_page_title`, `sub_page_details`, `status`, `created_at`) VALUES
(1, 1, 'Sub Menu 1', 'Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.', 1, ''),
(2, 1, 'Sub Menu 2', 'Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.', 1, ''),
(3, 1, 'Sub Menu 3', 'Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.', 1, ''),
(4, 1, 'Sub Menu 4', 'Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.', 1, ''),
(5, 1, 'Sub Menu 5', 'Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.', 1, ''),
(6, 1, 'Sub Menu 6', 'Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `xin_salary_templates`
--

CREATE TABLE `xin_salary_templates` (
  `salary_template_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `salary_grades` varchar(255) NOT NULL,
  `basic_salary` varchar(255) NOT NULL,
  `overtime_rate` varchar(255) NOT NULL,
  `house_rent_allowance` varchar(255) NOT NULL,
  `medical_allowance` varchar(255) NOT NULL,
  `travelling_allowance` varchar(255) NOT NULL,
  `dearness_allowance` varchar(255) NOT NULL,
  `security_deposit` varchar(255) NOT NULL,
  `provident_fund` varchar(255) NOT NULL,
  `tax_deduction` varchar(255) NOT NULL,
  `gross_salary` varchar(255) NOT NULL,
  `total_allowance` varchar(255) NOT NULL,
  `total_deduction` varchar(255) NOT NULL,
  `net_salary` varchar(255) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_salary_templates`
--

TRUNCATE TABLE `xin_salary_templates`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_support_tickets`
--

CREATE TABLE `xin_support_tickets` (
  `ticket_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `ticket_code` varchar(200) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `ticket_priority` varchar(255) NOT NULL,
  `department_id` int(111) NOT NULL,
  `assigned_to` text NOT NULL,
  `message` text NOT NULL,
  `description` text NOT NULL,
  `ticket_remarks` text NOT NULL,
  `ticket_status` varchar(200) NOT NULL,
  `ticket_note` text NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_support_tickets`
--

TRUNCATE TABLE `xin_support_tickets`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_support_ticket_files`
--

CREATE TABLE `xin_support_ticket_files` (
  `ticket_file_id` int(111) NOT NULL,
  `ticket_id` int(111) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `ticket_files` varchar(255) NOT NULL,
  `file_size` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_support_ticket_files`
--

TRUNCATE TABLE `xin_support_ticket_files`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_system_setting`
--

CREATE TABLE `xin_system_setting` (
  `setting_id` int(111) NOT NULL,
  `application_name` varchar(255) NOT NULL,
  `default_currency` varchar(255) NOT NULL,
  `default_currency_symbol` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `show_currency` varchar(255) NOT NULL,
  `currency_position` varchar(255) NOT NULL,
  `notification_position` varchar(255) NOT NULL,
  `notification_close_btn` varchar(255) NOT NULL,
  `notification_bar` varchar(255) NOT NULL,
  `enable_registration` varchar(255) NOT NULL,
  `login_with` varchar(255) NOT NULL,
  `date_format_xi` varchar(255) NOT NULL,
  `employee_manage_own_contact` varchar(255) NOT NULL,
  `employee_manage_own_profile` varchar(255) NOT NULL,
  `employee_manage_own_qualification` varchar(255) NOT NULL,
  `employee_manage_own_work_experience` varchar(255) NOT NULL,
  `employee_manage_own_document` varchar(255) NOT NULL,
  `employee_manage_own_picture` varchar(255) NOT NULL,
  `employee_manage_own_social` varchar(255) NOT NULL,
  `employee_manage_own_bank_account` varchar(255) NOT NULL,
  `enable_attendance` varchar(255) NOT NULL,
  `enable_clock_in_btn` varchar(255) NOT NULL,
  `enable_email_notification` varchar(255) NOT NULL,
  `payroll_include_day_summary` varchar(255) NOT NULL,
  `payroll_include_hour_summary` varchar(255) NOT NULL,
  `payroll_include_leave_summary` varchar(255) NOT NULL,
  `enable_job_application_candidates` varchar(255) NOT NULL,
  `job_logo` varchar(255) NOT NULL,
  `payroll_logo` varchar(255) NOT NULL,
  `is_payslip_password_generate` int(11) NOT NULL,
  `payslip_password_format` varchar(255) NOT NULL,
  `enable_profile_background` varchar(255) NOT NULL,
  `enable_policy_link` varchar(255) NOT NULL,
  `enable_layout` varchar(255) NOT NULL,
  `job_application_format` text NOT NULL,
  `project_email` varchar(255) NOT NULL,
  `holiday_email` varchar(255) NOT NULL,
  `leave_email` varchar(255) NOT NULL,
  `payslip_email` varchar(255) NOT NULL,
  `award_email` varchar(255) NOT NULL,
  `recruitment_email` varchar(255) NOT NULL,
  `announcement_email` varchar(255) NOT NULL,
  `training_email` varchar(255) NOT NULL,
  `task_email` varchar(255) NOT NULL,
  `compact_sidebar` varchar(255) NOT NULL,
  `fixed_header` varchar(255) NOT NULL,
  `fixed_sidebar` varchar(255) NOT NULL,
  `boxed_wrapper` varchar(255) NOT NULL,
  `layout_static` varchar(255) NOT NULL,
  `system_skin` varchar(255) NOT NULL,
  `animation_effect` varchar(255) NOT NULL,
  `animation_effect_modal` varchar(255) NOT NULL,
  `animation_effect_topmenu` varchar(255) NOT NULL,
  `footer_text` varchar(255) NOT NULL,
  `system_timezone` varchar(200) NOT NULL,
  `system_ip_address` varchar(255) NOT NULL,
  `system_ip_restriction` varchar(200) NOT NULL,
  `google_maps_api_key` text NOT NULL,
  `module_recruitment` varchar(100) NOT NULL,
  `module_travel` varchar(100) NOT NULL,
  `module_performance` varchar(100) NOT NULL,
  `module_files` varchar(100) NOT NULL,
  `module_awards` varchar(100) NOT NULL,
  `module_training` varchar(100) NOT NULL,
  `module_inquiry` varchar(100) NOT NULL,
  `module_language` varchar(100) NOT NULL,
  `module_orgchart` varchar(100) NOT NULL,
  `module_accounting` varchar(111) NOT NULL,
  `module_events` varchar(100) NOT NULL,
  `module_goal_tracking` varchar(100) NOT NULL,
  `module_assets` varchar(100) NOT NULL,
  `module_projects_tasks` varchar(100) NOT NULL,
  `module_chat_box` varchar(100) NOT NULL,
  `enable_page_rendered` varchar(255) NOT NULL,
  `enable_current_year` varchar(255) NOT NULL,
  `employee_login_id` varchar(200) NOT NULL,
  `enable_auth_background` varchar(11) NOT NULL,
  `hr_version` varchar(200) NOT NULL,
  `hr_release_date` varchar(100) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_system_setting`
--

TRUNCATE TABLE `xin_system_setting`;
--
-- Dumping data for table `xin_system_setting`
--

INSERT INTO `xin_system_setting` (`setting_id`, `application_name`, `default_currency`, `default_currency_symbol`, `show_currency`, `currency_position`, `notification_position`, `notification_close_btn`, `notification_bar`, `enable_registration`, `login_with`, `date_format_xi`, `employee_manage_own_contact`, `employee_manage_own_profile`, `employee_manage_own_qualification`, `employee_manage_own_work_experience`, `employee_manage_own_document`, `employee_manage_own_picture`, `employee_manage_own_social`, `employee_manage_own_bank_account`, `enable_attendance`, `enable_clock_in_btn`, `enable_email_notification`, `payroll_include_day_summary`, `payroll_include_hour_summary`, `payroll_include_leave_summary`, `enable_job_application_candidates`, `job_logo`, `payroll_logo`, `is_payslip_password_generate`, `payslip_password_format`, `enable_profile_background`, `enable_policy_link`, `enable_layout`, `job_application_format`, `project_email`, `holiday_email`, `leave_email`, `payslip_email`, `award_email`, `recruitment_email`, `announcement_email`, `training_email`, `task_email`, `compact_sidebar`, `fixed_header`, `fixed_sidebar`, `boxed_wrapper`, `layout_static`, `system_skin`, `animation_effect`, `animation_effect_modal`, `animation_effect_topmenu`, `footer_text`, `system_timezone`, `system_ip_address`, `system_ip_restriction`, `google_maps_api_key`, `module_recruitment`, `module_travel`, `module_performance`, `module_files`, `module_awards`, `module_training`, `module_inquiry`, `module_language`, `module_orgchart`, `module_accounting`, `module_events`, `module_goal_tracking`, `module_assets`, `module_projects_tasks`, `module_chat_box`, `enable_page_rendered`, `enable_current_year`, `employee_login_id`, `enable_auth_background`, `hr_version`, `hr_release_date`, `updated_at`) VALUES
(1, 'HRSALE', 'USD - $', 'USD - $', 'symbol', 'Prefix', 'toast-top-center', 'false', 'true', 'no', 'username', 'M-d-Y', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', '', '', 'yes', 'yes', 'yes', 'yes', 'job_logo_1520612591.png', 'payroll_logo_1520612316.png', 0, 'employee_id', 'yes', 'yes', 'yes', 'doc,docx,pdf', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', '', 'fixed-header', 'fixed-sidebar', '', '', 'skin-default', 'fadeInDown', 'tada', 'tada', 'hrsale', 'Asia/Riyadh', '::1', '', 'AIzaSyB3gP8H3eypotNeoEtezbRiF_f8Zh_p4ck', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', '', 'yes', 'username', 'yes', '1.0.3', '2018-03-28', '2018-03-28 04:27:32');

-- --------------------------------------------------------

--
-- Table structure for table `xin_tasks`
--

CREATE TABLE `xin_tasks` (
  `task_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(111) NOT NULL,
  `created_by` int(111) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `assigned_to` varchar(255) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `task_hour` varchar(200) NOT NULL,
  `task_progress` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `task_status` int(5) NOT NULL,
  `task_note` text NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_tasks`
--

TRUNCATE TABLE `xin_tasks`;
--
-- Dumping data for table `xin_tasks`
--

INSERT INTO `xin_tasks` (`task_id`, `company_id`, `project_id`, `created_by`, `task_name`, `assigned_to`, `start_date`, `end_date`, `task_hour`, `task_progress`, `description`, `task_status`, `task_note`, `created_at`) VALUES
(1, 1, 5, 1, 'jQuery Conflict', '5,6,11', '2018-03-23', '2018-03-26', '16', '69', 'Test Description', 1, 'sdfdsfsdfdfd', '2018-03-19 10:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `xin_tasks_attachment`
--

CREATE TABLE `xin_tasks_attachment` (
  `task_attachment_id` int(11) NOT NULL,
  `task_id` int(200) NOT NULL,
  `upload_by` int(255) NOT NULL,
  `file_title` varchar(255) NOT NULL,
  `file_description` text NOT NULL,
  `attachment_file` text NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_tasks_attachment`
--

TRUNCATE TABLE `xin_tasks_attachment`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_tasks_comments`
--

CREATE TABLE `xin_tasks_comments` (
  `comment_id` int(11) NOT NULL,
  `task_id` int(200) NOT NULL,
  `user_id` int(200) NOT NULL,
  `task_comments` text NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_tasks_comments`
--

TRUNCATE TABLE `xin_tasks_comments`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_tax_types`
--

CREATE TABLE `xin_tax_types` (
  `tax_id` int(111) NOT NULL,
  `name` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_tax_types`
--

TRUNCATE TABLE `xin_tax_types`;
--
-- Dumping data for table `xin_tax_types`
--

INSERT INTO `xin_tax_types` (`tax_id`, `name`, `rate`, `type`, `description`, `created_at`) VALUES
(1, 'No Tax', '0', 'fixed', 'test', '25-05-2018'),
(2, 'IVU', '2', 'fixed', 'test', '25-05-2018'),
(3, 'VAT', '5', 'percentage', 'testttt', '25-05-2018');

-- --------------------------------------------------------

--
-- Table structure for table `xin_termination_type`
--

CREATE TABLE `xin_termination_type` (
  `termination_type_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_termination_type`
--

TRUNCATE TABLE `xin_termination_type`;
--
-- Dumping data for table `xin_termination_type`
--

INSERT INTO `xin_termination_type` (`termination_type_id`, `company_id`, `type`, `created_at`) VALUES
(1, 1, 'Voluntary Termination', '22-03-2018 01:38:41');

-- --------------------------------------------------------

--
-- Table structure for table `xin_theme_settings`
--

CREATE TABLE `xin_theme_settings` (
  `theme_settings_id` int(11) NOT NULL,
  `fixed_layout` varchar(200) NOT NULL,
  `fixed_footer` varchar(200) NOT NULL,
  `boxed_layout` varchar(200) NOT NULL,
  `page_header` varchar(200) NOT NULL,
  `footer_layout` varchar(200) NOT NULL,
  `statistics_cards` varchar(200) NOT NULL,
  `statistics_cards_background` varchar(200) NOT NULL,
  `employee_cards` varchar(200) NOT NULL,
  `card_border_color` varchar(200) NOT NULL,
  `compact_menu` varchar(200) NOT NULL,
  `flipped_menu` varchar(200) NOT NULL,
  `right_side_icons` varchar(200) NOT NULL,
  `bordered_menu` varchar(200) NOT NULL,
  `form_design` varchar(200) NOT NULL,
  `is_semi_dark` int(11) NOT NULL,
  `semi_dark_color` varchar(200) NOT NULL,
  `top_nav_dark_color` varchar(200) NOT NULL,
  `menu_color_option` varchar(200) NOT NULL,
  `export_orgchart` varchar(100) NOT NULL,
  `export_file_title` text NOT NULL,
  `org_chart_layout` varchar(200) NOT NULL,
  `org_chart_zoom` varchar(100) NOT NULL,
  `org_chart_pan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_theme_settings`
--

TRUNCATE TABLE `xin_theme_settings`;
--
-- Dumping data for table `xin_theme_settings`
--

INSERT INTO `xin_theme_settings` (`theme_settings_id`, `fixed_layout`, `fixed_footer`, `boxed_layout`, `page_header`, `footer_layout`, `statistics_cards`, `statistics_cards_background`, `employee_cards`, `card_border_color`, `compact_menu`, `flipped_menu`, `right_side_icons`, `bordered_menu`, `form_design`, `is_semi_dark`, `semi_dark_color`, `top_nav_dark_color`, `menu_color_option`, `export_orgchart`, `export_file_title`, `org_chart_layout`, `org_chart_zoom`, `org_chart_pan`) VALUES
(1, 'false', 'true', 'false', '', '', '4', '', '', '', 'true', 'false', 'false', 'false', 'basic_form', 1, 'bg-primary', 'bg-blue-grey', 'menu-dark', 'true', 'HRSALE', 't2b', 'true', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `xin_tickets_attachment`
--

CREATE TABLE `xin_tickets_attachment` (
  `ticket_attachment_id` int(11) NOT NULL,
  `ticket_id` int(200) NOT NULL,
  `upload_by` int(255) NOT NULL,
  `file_title` varchar(255) NOT NULL,
  `file_description` text NOT NULL,
  `attachment_file` text NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_tickets_attachment`
--

TRUNCATE TABLE `xin_tickets_attachment`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_tickets_comments`
--

CREATE TABLE `xin_tickets_comments` (
  `comment_id` int(11) NOT NULL,
  `ticket_id` int(200) NOT NULL,
  `user_id` int(200) NOT NULL,
  `ticket_comments` text NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_tickets_comments`
--

TRUNCATE TABLE `xin_tickets_comments`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_trainers`
--

CREATE TABLE `xin_trainers` (
  `trainer_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `designation_id` int(111) NOT NULL,
  `expertise` text NOT NULL,
  `address` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_trainers`
--

TRUNCATE TABLE `xin_trainers`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_training`
--

CREATE TABLE `xin_training` (
  `training_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` varchar(200) NOT NULL,
  `training_type_id` int(200) NOT NULL,
  `trainer_id` int(200) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `finish_date` varchar(200) NOT NULL,
  `training_cost` varchar(200) NOT NULL,
  `training_status` int(200) NOT NULL,
  `description` text NOT NULL,
  `performance` varchar(200) NOT NULL,
  `remarks` text NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_training`
--

TRUNCATE TABLE `xin_training`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_training_types`
--

CREATE TABLE `xin_training_types` (
  `training_type_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_training_types`
--

TRUNCATE TABLE `xin_training_types`;
-- --------------------------------------------------------

--
-- Table structure for table `xin_travel_arrangement_type`
--

CREATE TABLE `xin_travel_arrangement_type` (
  `arrangement_type_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_travel_arrangement_type`
--

TRUNCATE TABLE `xin_travel_arrangement_type`;
--
-- Dumping data for table `xin_travel_arrangement_type`
--

INSERT INTO `xin_travel_arrangement_type` (`arrangement_type_id`, `company_id`, `type`, `status`, `created_at`) VALUES
(1, 1, 'Corporation', 1, '19-03-2018 08:45:17'),
(2, 1, 'Guest House', 1, '19-03-2018 08:45:27');

-- --------------------------------------------------------

--
-- Table structure for table `xin_users`
--

CREATE TABLE `xin_users` (
  `user_id` int(11) NOT NULL,
  `user_role` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'administrator',
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_background` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `address_1` text COLLATE utf8_unicode_ci NOT NULL,
  `address_2` text COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zipcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` int(11) NOT NULL,
  `last_login_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login_ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_logged_in` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Truncate table before insert `xin_users`
--

TRUNCATE TABLE `xin_users`;
--
-- Dumping data for table `xin_users`
--

INSERT INTO `xin_users` (`user_id`, `user_role`, `first_name`, `last_name`, `company_name`, `company_logo`, `user_type`, `email`, `username`, `password`, `profile_photo`, `profile_background`, `contact_number`, `gender`, `address_1`, `address_2`, `city`, `state`, `zipcode`, `country`, `last_login_date`, `last_login_ip`, `is_logged_in`, `is_active`, `created_at`) VALUES
(1, 'administrator', 'Thomas', 'Fleming', '', '', 2, 'test1@test.com', 'admin', 'test123', 'user_1520720863.jpg', 'profile_background_1505458640.jpg', '12333332', 'Male', 'Address Line 1', 'Address Line 2', 'City', 'State', '12345', 230, '15-04-2018 07:36:12', '::1', 0, 1, '14-09-2017 10:02:54'),
(2, 'administrator', 'Main', 'Office', '', '', 2, 'test@test.com', 'test', 'test123', 'user_1523821315.jpg', '', '1234567890', 'Male', 'Address Line 1', 'Address Line 2', 'City', 'State', '11461', 190, '23-04-2018 05:34:47', '::1', 0, 1, '15-04-2018 06:13:08'),
(4, 'administrator', 'Fiona', 'Grace', 'HRSALE', 'employer_1524025572.jpg', 1, 'employer@test.com', '', 'test123', '', '', '1234567890', 'Male', 'Address Line 1', 'Address Line 2', 'City', 'State', '11461', 190, '23-04-2018 05:34:54', '::1', 0, 1, '18-04-2018 07:26:12');

-- --------------------------------------------------------

--
-- Table structure for table `xin_user_roles`
--

CREATE TABLE `xin_user_roles` (
  `role_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `role_name` varchar(200) NOT NULL,
  `role_access` varchar(200) NOT NULL,
  `role_resources` text NOT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_user_roles`
--

TRUNCATE TABLE `xin_user_roles`;
--
-- Dumping data for table `xin_user_roles`
--

INSERT INTO `xin_user_roles` (`role_id`, `company_id`, `role_name`, `role_access`, `role_resources`, `created_at`) VALUES
(1, 1, 'Super Admin', '1', '0,103,13,92,88,12,14,15,16,17,18,19,20,21,22,23,2,11,9,96,3,4,5,6,7,8,10,24,25,26,97,98,99,27,28,29,30,31,48,49,50,51,52,32,33,34,35,36,37,38,39,40,41,42,43,46,104,44,45,119,120,121,122,106,107,108,47,53,54,55,56,57,60,61,62,63,93,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,89,90,91,94,95,110,111,112,113,114,115,116,117,118', '28-02-2018'),
(2, 1, 'Employee', '2', '0,50,47,91,118', '21-03-2018');

-- --------------------------------------------------------

--
-- Table structure for table `xin_warning_type`
--

CREATE TABLE `xin_warning_type` (
  `warning_type_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `xin_warning_type`
--

TRUNCATE TABLE `xin_warning_type`;
--
-- Dumping data for table `xin_warning_type`
--

INSERT INTO `xin_warning_type` (`warning_type_id`, `company_id`, `type`, `created_at`) VALUES
(1, 1, 'First Written Warning', '22-03-2018 01:38:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `xin_advance_salaries`
--
ALTER TABLE `xin_advance_salaries`
  ADD PRIMARY KEY (`advance_salary_id`);

--
-- Indexes for table `xin_announcements`
--
ALTER TABLE `xin_announcements`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `xin_assets`
--
ALTER TABLE `xin_assets`
  ADD PRIMARY KEY (`assets_id`);

--
-- Indexes for table `xin_assets_categories`
--
ALTER TABLE `xin_assets_categories`
  ADD PRIMARY KEY (`assets_category_id`);

--
-- Indexes for table `xin_attendance_time`
--
ALTER TABLE `xin_attendance_time`
  ADD PRIMARY KEY (`time_attendance_id`);

--
-- Indexes for table `xin_awards`
--
ALTER TABLE `xin_awards`
  ADD PRIMARY KEY (`award_id`);

--
-- Indexes for table `xin_award_type`
--
ALTER TABLE `xin_award_type`
  ADD PRIMARY KEY (`award_type_id`);

--
-- Indexes for table `xin_chat_messages`
--
ALTER TABLE `xin_chat_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `xin_clients`
--
ALTER TABLE `xin_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `xin_companies`
--
ALTER TABLE `xin_companies`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `xin_company_info`
--
ALTER TABLE `xin_company_info`
  ADD PRIMARY KEY (`company_info_id`);

--
-- Indexes for table `xin_company_policy`
--
ALTER TABLE `xin_company_policy`
  ADD PRIMARY KEY (`policy_id`);

--
-- Indexes for table `xin_company_type`
--
ALTER TABLE `xin_company_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `xin_contract_type`
--
ALTER TABLE `xin_contract_type`
  ADD PRIMARY KEY (`contract_type_id`);

--
-- Indexes for table `xin_countries`
--
ALTER TABLE `xin_countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `xin_currencies`
--
ALTER TABLE `xin_currencies`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `xin_database_backup`
--
ALTER TABLE `xin_database_backup`
  ADD PRIMARY KEY (`backup_id`);

--
-- Indexes for table `xin_departments`
--
ALTER TABLE `xin_departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `xin_designations`
--
ALTER TABLE `xin_designations`
  ADD PRIMARY KEY (`designation_id`);

--
-- Indexes for table `xin_document_type`
--
ALTER TABLE `xin_document_type`
  ADD PRIMARY KEY (`document_type_id`);

--
-- Indexes for table `xin_email_template`
--
ALTER TABLE `xin_email_template`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `xin_employees`
--
ALTER TABLE `xin_employees`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `xin_employee_bankaccount`
--
ALTER TABLE `xin_employee_bankaccount`
  ADD PRIMARY KEY (`bankaccount_id`);

--
-- Indexes for table `xin_employee_complaints`
--
ALTER TABLE `xin_employee_complaints`
  ADD PRIMARY KEY (`complaint_id`);

--
-- Indexes for table `xin_employee_contacts`
--
ALTER TABLE `xin_employee_contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `xin_employee_contract`
--
ALTER TABLE `xin_employee_contract`
  ADD PRIMARY KEY (`contract_id`);

--
-- Indexes for table `xin_employee_documents`
--
ALTER TABLE `xin_employee_documents`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `xin_employee_exit`
--
ALTER TABLE `xin_employee_exit`
  ADD PRIMARY KEY (`exit_id`);

--
-- Indexes for table `xin_employee_exit_type`
--
ALTER TABLE `xin_employee_exit_type`
  ADD PRIMARY KEY (`exit_type_id`);

--
-- Indexes for table `xin_employee_immigration`
--
ALTER TABLE `xin_employee_immigration`
  ADD PRIMARY KEY (`immigration_id`);

--
-- Indexes for table `xin_employee_leave`
--
ALTER TABLE `xin_employee_leave`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `xin_employee_location`
--
ALTER TABLE `xin_employee_location`
  ADD PRIMARY KEY (`office_location_id`);

--
-- Indexes for table `xin_employee_promotions`
--
ALTER TABLE `xin_employee_promotions`
  ADD PRIMARY KEY (`promotion_id`);

--
-- Indexes for table `xin_employee_qualification`
--
ALTER TABLE `xin_employee_qualification`
  ADD PRIMARY KEY (`qualification_id`);

--
-- Indexes for table `xin_employee_resignations`
--
ALTER TABLE `xin_employee_resignations`
  ADD PRIMARY KEY (`resignation_id`);

--
-- Indexes for table `xin_employee_shift`
--
ALTER TABLE `xin_employee_shift`
  ADD PRIMARY KEY (`emp_shift_id`);

--
-- Indexes for table `xin_employee_terminations`
--
ALTER TABLE `xin_employee_terminations`
  ADD PRIMARY KEY (`termination_id`);

--
-- Indexes for table `xin_employee_transfer`
--
ALTER TABLE `xin_employee_transfer`
  ADD PRIMARY KEY (`transfer_id`);

--
-- Indexes for table `xin_employee_travels`
--
ALTER TABLE `xin_employee_travels`
  ADD PRIMARY KEY (`travel_id`);

--
-- Indexes for table `xin_employee_warnings`
--
ALTER TABLE `xin_employee_warnings`
  ADD PRIMARY KEY (`warning_id`);

--
-- Indexes for table `xin_employee_work_experience`
--
ALTER TABLE `xin_employee_work_experience`
  ADD PRIMARY KEY (`work_experience_id`);

--
-- Indexes for table `xin_events`
--
ALTER TABLE `xin_events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `xin_expenses`
--
ALTER TABLE `xin_expenses`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `xin_expense_type`
--
ALTER TABLE `xin_expense_type`
  ADD PRIMARY KEY (`expense_type_id`);

--
-- Indexes for table `xin_file_manager`
--
ALTER TABLE `xin_file_manager`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `xin_file_manager_settings`
--
ALTER TABLE `xin_file_manager_settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `xin_finance_bankcash`
--
ALTER TABLE `xin_finance_bankcash`
  ADD PRIMARY KEY (`bankcash_id`);

--
-- Indexes for table `xin_finance_deposit`
--
ALTER TABLE `xin_finance_deposit`
  ADD PRIMARY KEY (`deposit_id`);

--
-- Indexes for table `xin_finance_expense`
--
ALTER TABLE `xin_finance_expense`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `xin_finance_payees`
--
ALTER TABLE `xin_finance_payees`
  ADD PRIMARY KEY (`payee_id`);

--
-- Indexes for table `xin_finance_payers`
--
ALTER TABLE `xin_finance_payers`
  ADD PRIMARY KEY (`payer_id`);

--
-- Indexes for table `xin_finance_transactions`
--
ALTER TABLE `xin_finance_transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `xin_finance_transfer`
--
ALTER TABLE `xin_finance_transfer`
  ADD PRIMARY KEY (`transfer_id`);

--
-- Indexes for table `xin_goal_tracking`
--
ALTER TABLE `xin_goal_tracking`
  ADD PRIMARY KEY (`tracking_id`);

--
-- Indexes for table `xin_goal_tracking_type`
--
ALTER TABLE `xin_goal_tracking_type`
  ADD PRIMARY KEY (`tracking_type_id`);

--
-- Indexes for table `xin_holidays`
--
ALTER TABLE `xin_holidays`
  ADD PRIMARY KEY (`holiday_id`);

--
-- Indexes for table `xin_hourly_templates`
--
ALTER TABLE `xin_hourly_templates`
  ADD PRIMARY KEY (`hourly_rate_id`);

--
-- Indexes for table `xin_hrsale_invoices`
--
ALTER TABLE `xin_hrsale_invoices`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `xin_hrsale_invoices_items`
--
ALTER TABLE `xin_hrsale_invoices_items`
  ADD PRIMARY KEY (`invoice_item_id`);

--
-- Indexes for table `xin_income_categories`
--
ALTER TABLE `xin_income_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `xin_jobs`
--
ALTER TABLE `xin_jobs`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `xin_job_applications`
--
ALTER TABLE `xin_job_applications`
  ADD PRIMARY KEY (`application_id`);

--
-- Indexes for table `xin_job_categories`
--
ALTER TABLE `xin_job_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `xin_job_interviews`
--
ALTER TABLE `xin_job_interviews`
  ADD PRIMARY KEY (`job_interview_id`);

--
-- Indexes for table `xin_job_type`
--
ALTER TABLE `xin_job_type`
  ADD PRIMARY KEY (`job_type_id`);

--
-- Indexes for table `xin_languages`
--
ALTER TABLE `xin_languages`
  ADD PRIMARY KEY (`language_id`);

--
-- Indexes for table `xin_leave_applications`
--
ALTER TABLE `xin_leave_applications`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `xin_leave_type`
--
ALTER TABLE `xin_leave_type`
  ADD PRIMARY KEY (`leave_type_id`);

--
-- Indexes for table `xin_make_payment`
--
ALTER TABLE `xin_make_payment`
  ADD PRIMARY KEY (`make_payment_id`);

--
-- Indexes for table `xin_meetings`
--
ALTER TABLE `xin_meetings`
  ADD PRIMARY KEY (`meeting_id`);

--
-- Indexes for table `xin_office_location`
--
ALTER TABLE `xin_office_location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `xin_office_shift`
--
ALTER TABLE `xin_office_shift`
  ADD PRIMARY KEY (`office_shift_id`);

--
-- Indexes for table `xin_payment_method`
--
ALTER TABLE `xin_payment_method`
  ADD PRIMARY KEY (`payment_method_id`);

--
-- Indexes for table `xin_payroll_custom_fields`
--
ALTER TABLE `xin_payroll_custom_fields`
  ADD PRIMARY KEY (`payroll_custom_id`);

--
-- Indexes for table `xin_performance_appraisal`
--
ALTER TABLE `xin_performance_appraisal`
  ADD PRIMARY KEY (`performance_appraisal_id`);

--
-- Indexes for table `xin_performance_indicator`
--
ALTER TABLE `xin_performance_indicator`
  ADD PRIMARY KEY (`performance_indicator_id`);

--
-- Indexes for table `xin_projects`
--
ALTER TABLE `xin_projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `xin_projects_attachment`
--
ALTER TABLE `xin_projects_attachment`
  ADD PRIMARY KEY (`project_attachment_id`);

--
-- Indexes for table `xin_projects_bugs`
--
ALTER TABLE `xin_projects_bugs`
  ADD PRIMARY KEY (`bug_id`);

--
-- Indexes for table `xin_projects_discussion`
--
ALTER TABLE `xin_projects_discussion`
  ADD PRIMARY KEY (`discussion_id`);

--
-- Indexes for table `xin_qualification_education_level`
--
ALTER TABLE `xin_qualification_education_level`
  ADD PRIMARY KEY (`education_level_id`);

--
-- Indexes for table `xin_qualification_language`
--
ALTER TABLE `xin_qualification_language`
  ADD PRIMARY KEY (`language_id`);

--
-- Indexes for table `xin_qualification_skill`
--
ALTER TABLE `xin_qualification_skill`
  ADD PRIMARY KEY (`skill_id`);

--
-- Indexes for table `xin_recruitment_pages`
--
ALTER TABLE `xin_recruitment_pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `xin_recruitment_subpages`
--
ALTER TABLE `xin_recruitment_subpages`
  ADD PRIMARY KEY (`subpages_id`);

--
-- Indexes for table `xin_salary_templates`
--
ALTER TABLE `xin_salary_templates`
  ADD PRIMARY KEY (`salary_template_id`);

--
-- Indexes for table `xin_support_tickets`
--
ALTER TABLE `xin_support_tickets`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `xin_support_ticket_files`
--
ALTER TABLE `xin_support_ticket_files`
  ADD PRIMARY KEY (`ticket_file_id`);

--
-- Indexes for table `xin_system_setting`
--
ALTER TABLE `xin_system_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `xin_tasks`
--
ALTER TABLE `xin_tasks`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `xin_tasks_attachment`
--
ALTER TABLE `xin_tasks_attachment`
  ADD PRIMARY KEY (`task_attachment_id`);

--
-- Indexes for table `xin_tasks_comments`
--
ALTER TABLE `xin_tasks_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `xin_tax_types`
--
ALTER TABLE `xin_tax_types`
  ADD PRIMARY KEY (`tax_id`);

--
-- Indexes for table `xin_termination_type`
--
ALTER TABLE `xin_termination_type`
  ADD PRIMARY KEY (`termination_type_id`);

--
-- Indexes for table `xin_theme_settings`
--
ALTER TABLE `xin_theme_settings`
  ADD PRIMARY KEY (`theme_settings_id`);

--
-- Indexes for table `xin_tickets_attachment`
--
ALTER TABLE `xin_tickets_attachment`
  ADD PRIMARY KEY (`ticket_attachment_id`);

--
-- Indexes for table `xin_tickets_comments`
--
ALTER TABLE `xin_tickets_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `xin_trainers`
--
ALTER TABLE `xin_trainers`
  ADD PRIMARY KEY (`trainer_id`);

--
-- Indexes for table `xin_training`
--
ALTER TABLE `xin_training`
  ADD PRIMARY KEY (`training_id`);

--
-- Indexes for table `xin_training_types`
--
ALTER TABLE `xin_training_types`
  ADD PRIMARY KEY (`training_type_id`);

--
-- Indexes for table `xin_travel_arrangement_type`
--
ALTER TABLE `xin_travel_arrangement_type`
  ADD PRIMARY KEY (`arrangement_type_id`);

--
-- Indexes for table `xin_users`
--
ALTER TABLE `xin_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `xin_user_roles`
--
ALTER TABLE `xin_user_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `xin_warning_type`
--
ALTER TABLE `xin_warning_type`
  ADD PRIMARY KEY (`warning_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `xin_advance_salaries`
--
ALTER TABLE `xin_advance_salaries`
  MODIFY `advance_salary_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_announcements`
--
ALTER TABLE `xin_announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_assets`
--
ALTER TABLE `xin_assets`
  MODIFY `assets_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_assets_categories`
--
ALTER TABLE `xin_assets_categories`
  MODIFY `assets_category_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_attendance_time`
--
ALTER TABLE `xin_attendance_time`
  MODIFY `time_attendance_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_awards`
--
ALTER TABLE `xin_awards`
  MODIFY `award_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_award_type`
--
ALTER TABLE `xin_award_type`
  MODIFY `award_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_chat_messages`
--
ALTER TABLE `xin_chat_messages`
  MODIFY `message_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_clients`
--
ALTER TABLE `xin_clients`
  MODIFY `client_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_companies`
--
ALTER TABLE `xin_companies`
  MODIFY `company_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_company_info`
--
ALTER TABLE `xin_company_info`
  MODIFY `company_info_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_company_policy`
--
ALTER TABLE `xin_company_policy`
  MODIFY `policy_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_company_type`
--
ALTER TABLE `xin_company_type`
  MODIFY `type_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `xin_contract_type`
--
ALTER TABLE `xin_contract_type`
  MODIFY `contract_type_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_countries`
--
ALTER TABLE `xin_countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `xin_currencies`
--
ALTER TABLE `xin_currencies`
  MODIFY `currency_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_database_backup`
--
ALTER TABLE `xin_database_backup`
  MODIFY `backup_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_departments`
--
ALTER TABLE `xin_departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `xin_designations`
--
ALTER TABLE `xin_designations`
  MODIFY `designation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `xin_document_type`
--
ALTER TABLE `xin_document_type`
  MODIFY `document_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_email_template`
--
ALTER TABLE `xin_email_template`
  MODIFY `template_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `xin_employees`
--
ALTER TABLE `xin_employees`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `xin_employee_bankaccount`
--
ALTER TABLE `xin_employee_bankaccount`
  MODIFY `bankaccount_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_employee_complaints`
--
ALTER TABLE `xin_employee_complaints`
  MODIFY `complaint_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_employee_contacts`
--
ALTER TABLE `xin_employee_contacts`
  MODIFY `contact_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_employee_contract`
--
ALTER TABLE `xin_employee_contract`
  MODIFY `contract_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_employee_documents`
--
ALTER TABLE `xin_employee_documents`
  MODIFY `document_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_employee_exit`
--
ALTER TABLE `xin_employee_exit`
  MODIFY `exit_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_employee_exit_type`
--
ALTER TABLE `xin_employee_exit_type`
  MODIFY `exit_type_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_employee_immigration`
--
ALTER TABLE `xin_employee_immigration`
  MODIFY `immigration_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_employee_leave`
--
ALTER TABLE `xin_employee_leave`
  MODIFY `leave_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_employee_location`
--
ALTER TABLE `xin_employee_location`
  MODIFY `office_location_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_employee_promotions`
--
ALTER TABLE `xin_employee_promotions`
  MODIFY `promotion_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_employee_qualification`
--
ALTER TABLE `xin_employee_qualification`
  MODIFY `qualification_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_employee_resignations`
--
ALTER TABLE `xin_employee_resignations`
  MODIFY `resignation_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_employee_shift`
--
ALTER TABLE `xin_employee_shift`
  MODIFY `emp_shift_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_employee_terminations`
--
ALTER TABLE `xin_employee_terminations`
  MODIFY `termination_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_employee_transfer`
--
ALTER TABLE `xin_employee_transfer`
  MODIFY `transfer_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_employee_travels`
--
ALTER TABLE `xin_employee_travels`
  MODIFY `travel_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_employee_warnings`
--
ALTER TABLE `xin_employee_warnings`
  MODIFY `warning_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_employee_work_experience`
--
ALTER TABLE `xin_employee_work_experience`
  MODIFY `work_experience_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_events`
--
ALTER TABLE `xin_events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_expenses`
--
ALTER TABLE `xin_expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_expense_type`
--
ALTER TABLE `xin_expense_type`
  MODIFY `expense_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `xin_file_manager`
--
ALTER TABLE `xin_file_manager`
  MODIFY `file_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_file_manager_settings`
--
ALTER TABLE `xin_file_manager_settings`
  MODIFY `setting_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_finance_bankcash`
--
ALTER TABLE `xin_finance_bankcash`
  MODIFY `bankcash_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_finance_deposit`
--
ALTER TABLE `xin_finance_deposit`
  MODIFY `deposit_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_finance_expense`
--
ALTER TABLE `xin_finance_expense`
  MODIFY `expense_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_finance_payees`
--
ALTER TABLE `xin_finance_payees`
  MODIFY `payee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_finance_payers`
--
ALTER TABLE `xin_finance_payers`
  MODIFY `payer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_finance_transactions`
--
ALTER TABLE `xin_finance_transactions`
  MODIFY `transaction_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_finance_transfer`
--
ALTER TABLE `xin_finance_transfer`
  MODIFY `transfer_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_goal_tracking`
--
ALTER TABLE `xin_goal_tracking`
  MODIFY `tracking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_goal_tracking_type`
--
ALTER TABLE `xin_goal_tracking_type`
  MODIFY `tracking_type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_holidays`
--
ALTER TABLE `xin_holidays`
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_hourly_templates`
--
ALTER TABLE `xin_hourly_templates`
  MODIFY `hourly_rate_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_hrsale_invoices`
--
ALTER TABLE `xin_hrsale_invoices`
  MODIFY `invoice_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_hrsale_invoices_items`
--
ALTER TABLE `xin_hrsale_invoices_items`
  MODIFY `invoice_item_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_income_categories`
--
ALTER TABLE `xin_income_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `xin_jobs`
--
ALTER TABLE `xin_jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `xin_job_applications`
--
ALTER TABLE `xin_job_applications`
  MODIFY `application_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_job_categories`
--
ALTER TABLE `xin_job_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `xin_job_interviews`
--
ALTER TABLE `xin_job_interviews`
  MODIFY `job_interview_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_job_type`
--
ALTER TABLE `xin_job_type`
  MODIFY `job_type_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `xin_languages`
--
ALTER TABLE `xin_languages`
  MODIFY `language_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `xin_leave_applications`
--
ALTER TABLE `xin_leave_applications`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_leave_type`
--
ALTER TABLE `xin_leave_type`
  MODIFY `leave_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `xin_make_payment`
--
ALTER TABLE `xin_make_payment`
  MODIFY `make_payment_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_meetings`
--
ALTER TABLE `xin_meetings`
  MODIFY `meeting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_office_location`
--
ALTER TABLE `xin_office_location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_office_shift`
--
ALTER TABLE `xin_office_shift`
  MODIFY `office_shift_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_payment_method`
--
ALTER TABLE `xin_payment_method`
  MODIFY `payment_method_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_payroll_custom_fields`
--
ALTER TABLE `xin_payroll_custom_fields`
  MODIFY `payroll_custom_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_performance_appraisal`
--
ALTER TABLE `xin_performance_appraisal`
  MODIFY `performance_appraisal_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_performance_indicator`
--
ALTER TABLE `xin_performance_indicator`
  MODIFY `performance_indicator_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_projects`
--
ALTER TABLE `xin_projects`
  MODIFY `project_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `xin_projects_attachment`
--
ALTER TABLE `xin_projects_attachment`
  MODIFY `project_attachment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_projects_bugs`
--
ALTER TABLE `xin_projects_bugs`
  MODIFY `bug_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_projects_discussion`
--
ALTER TABLE `xin_projects_discussion`
  MODIFY `discussion_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_qualification_education_level`
--
ALTER TABLE `xin_qualification_education_level`
  MODIFY `education_level_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_qualification_language`
--
ALTER TABLE `xin_qualification_language`
  MODIFY `language_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_qualification_skill`
--
ALTER TABLE `xin_qualification_skill`
  MODIFY `skill_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_recruitment_pages`
--
ALTER TABLE `xin_recruitment_pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `xin_recruitment_subpages`
--
ALTER TABLE `xin_recruitment_subpages`
  MODIFY `subpages_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `xin_salary_templates`
--
ALTER TABLE `xin_salary_templates`
  MODIFY `salary_template_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_support_tickets`
--
ALTER TABLE `xin_support_tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_support_ticket_files`
--
ALTER TABLE `xin_support_ticket_files`
  MODIFY `ticket_file_id` int(111) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_system_setting`
--
ALTER TABLE `xin_system_setting`
  MODIFY `setting_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_tasks`
--
ALTER TABLE `xin_tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `xin_tasks_attachment`
--
ALTER TABLE `xin_tasks_attachment`
  MODIFY `task_attachment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_tasks_comments`
--
ALTER TABLE `xin_tasks_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_tax_types`
--
ALTER TABLE `xin_tax_types`
  MODIFY `tax_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `xin_termination_type`
--
ALTER TABLE `xin_termination_type`
  MODIFY `termination_type_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_theme_settings`
--
ALTER TABLE `xin_theme_settings`
  MODIFY `theme_settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xin_tickets_attachment`
--
ALTER TABLE `xin_tickets_attachment`
  MODIFY `ticket_attachment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_tickets_comments`
--
ALTER TABLE `xin_tickets_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_trainers`
--
ALTER TABLE `xin_trainers`
  MODIFY `trainer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_training`
--
ALTER TABLE `xin_training`
  MODIFY `training_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_training_types`
--
ALTER TABLE `xin_training_types`
  MODIFY `training_type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xin_travel_arrangement_type`
--
ALTER TABLE `xin_travel_arrangement_type`
  MODIFY `arrangement_type_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `xin_users`
--
ALTER TABLE `xin_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `xin_user_roles`
--
ALTER TABLE `xin_user_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `xin_warning_type`
--
ALTER TABLE `xin_warning_type`
  MODIFY `warning_type_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
