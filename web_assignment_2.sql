-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 04, 2023 at 01:44 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_assignment_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `crawler_data`
--

CREATE TABLE `crawler_data` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `keywords` varchar(255) DEFAULT NULL,
  `url` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `crawler_data`
--

INSERT INTO `crawler_data` (`id`, `title`, `description`, `keywords`, `url`) VALUES
(1, 'اپنے براؤزر کی تجدید کریں | Facebook', '', '', 'https://l.facebook.com/l.php?u=https%3A%2F%2Fwww.google.com%2Fchrome%2Fbrowser%2F&h=AT2ZUbvmETCM2nNlV17brM9uFHglGktJiJeq2HeJHbuArPfAJBEq7xcG5kXQ_xd_mRAZ4MN9rzZwX7eJKLCV2pXev0dHiaOhCnjQBuZ2ZE7z3F7N9fXSL5ZlJo2G0eYZG503dHq2AQ_bs53MdZzoYSQe-2phYg'),
(2, 'اپنے براؤزر کی تجدید کریں | Facebook', '', '', 'https://l.facebook.com/l.php?u=https%3A%2F%2Fwww.mozilla.org%2Ffirefox%2Fnew%2F%3Futm_source%3Dfacebook%26utm_medium%3Dreferral%26utm_campaign%3Dunsupported-browser-notification&h=AT0xlfULNH-Co10OOI7Ca372Uu87CO7HtGfBxkiXFHQ_O5Clhod3_IyyzhXRCoRopl0OBD8cxz7FIkuhHaiW9FQeIMrdbOtYEX_D1ykd697e9jQ7lRqfMrWFNoqOVj7XlYds9BnVWjOSHKNF'),
(3, 'اپنے براؤزر کی تجدید کریں | Facebook', '', '', 'https://facebook.com/mobile'),
(4, 'اپنے براؤزر کی تجدید کریں | Facebook', '', '', 'https://l.facebook.com/l.php?u=https%3A%2F%2Fwww.google.com%2Fchrome%2Fbrowser%2F&h=AT2PIVRVMPkj46vks-4QWdElz_EOq-1i1oiN9BDiqXcapKdVqtzJoHgCYpWX8SbKC4dCtL-CKkCQV5zpUB38S13ia3RpRchYMN52I-pkA3NXl5MBhDtk2NxUJbD6tqLVYb_tcHFF3CZTm0uA'),
(5, 'اپنے براؤزر کی تجدید کریں | Facebook', '', '', 'https://l.facebook.com/l.php?u=https%3A%2F%2Fwww.mozilla.org%2Ffirefox%2Fnew%2F%3Futm_source%3Dfacebook%26utm_medium%3Dreferral%26utm_campaign%3Dunsupported-browser-notification&h=AT2lduh2CAK36Q6My8QxqXm7Lg-CZLBk2LZXrH0xF6DOfOu317cmzrD8hiS1plfVfI6Ztk2sdMm-nEoom44qyLwqlmZp_v08WVtZqnMqgdvTXU54qfBDUL8QSbX_PEOrHFGyNXPtK_OcvEb1'),
(6, 'اپنے براؤزر کی تجدید کریں | Facebook', '', '', 'https://facebook.com/mobile'),
(7, 'اپنے براؤزر کی تجدید کریں | Facebook', '', '', 'https://l.facebook.com/l.php?u=https%3A%2F%2Fwww.google.com%2Fchrome%2Fbrowser%2F&h=AT1O2gD8KjKdcYBUumPQ_NqV1a8FFFGrIXb0gQUH0cMJ9GdmHDoXXl5c-yGAt4Nn09S6wxMed9-ADaWFyi6UQC2-GHVdZj_9bjx3MZH926YRuOvX0D2iz4NDkr4aL12wyN7KemTTCnxJLosy'),
(8, 'اپنے براؤزر کی تجدید کریں | Facebook', '', '', 'https://l.facebook.com/l.php?u=https%3A%2F%2Fwww.mozilla.org%2Ffirefox%2Fnew%2F%3Futm_source%3Dfacebook%26utm_medium%3Dreferral%26utm_campaign%3Dunsupported-browser-notification&h=AT3O3Nljux-StT9UBcOuYnNpxC_CIojsYtYdfU-iSRMfWZttiDe6RsFXBI2xZtvTMxmwqjBC5_SDPkFN0YMu325h8sgnsZQujX5UFVrdFQLlATlaF95FWR3oqniqeTM4v3y6jjQiIIWZMFbJ'),
(9, 'اپنے براؤزر کی تجدید کریں | Facebook', '', '', 'https://facebook.com/mobile'),
(10, 'Google', '', '', 'https://www.google.com.pk/webhp?tab=ww'),
(11, 'Google Images', 'Google Images. The most comprehensive image search on the web.', '', 'https://www.google.com/imghp?hl=en&tab=wi'),
(12, '  Google Maps  ', ' Find local businesses, view maps and get driving directions in Google Maps. ', '', 'https://maps.google.com/maps?hl=en&tab=wl'),
(13, 'Android Apps on Google Play', '', '', 'https://play.google.com/?hl=en&tab=w8'),
(14, 'YouTube', '', '', 'https://www.youtube.com/?tab=w1'),
(15, 'Google News', '', '', 'https://news.google.com/?tab=wn'),
(16, 'Gmail', '', '', 'https://mail.google.com/mail/?tab=wm'),
(17, 'Google Drive: Sign-in', '', '', 'https://drive.google.com/?tab=wo'),
(18, 'Browse All of Google\'s Products & Services - Google', '', '', 'https://www.google.com.pk/intl/en/about/products?tab=wh'),
(19, 'Google Calendar - Sign in to Access & Edit Your Schedule', '', '', 'https://calendar.google.com/calendar?tab=wc'),
(20, 'Google Translate', '', '', 'https://translate.google.com.pk/?hl=en&tab=wT'),
(21, 'Google Books', '', '', 'https://books.google.com.pk/?hl=en&tab=wp'),
(22, 'Google Shopping', '', '', 'https://www.google.com.pk/shopping?hl=en&source=og&tab=wf'),
(23, 'Blogger.com - Create a unique and beautiful blog easily.', '', '', 'https://www.blogger.com/?tab=wj'),
(24, 'Google Finance - Stock Market Prices, Real-time Quotes & Business News', '', '', 'https://www.google.com/finance?tab=we'),
(25, 'Google Photos', '', '', 'https://photos.google.com/?tab=wq&pageId=none'),
(26, '      Google Docs: Online Document Editor | Google Workspace    ', '', '', 'https://docs.google.com/document/?usp=docs_alc'),
(27, 'Sign in - Google Accounts', '', '', 'https://accounts.google.com/ServiceLogin?hl=en&passive=true&continue=https://www.google.com/&ec=GAZAAQ'),
(28, 'Search settings', '', '', 'http://www.google.com.pk/preferences?hl=en'),
(29, 'Search settings', '', '', 'https://google.com/preferences?hl=en'),
(30, 'Google - Search Customization', '', '', 'http://www.google.com.pk/history/optout?hl=en'),
(31, 'Google Advanced Search', '', '', 'https://google.com/advanced_search?hl=en-PK&authuser=0'),
(32, 'ÊáÇÔ ی ÊÑÊیÈÇÊ', '', '', 'https://www.google.com/setprefs?sig=0_91ecAg_Jg6tVh5QTwmr9xIz_jgo%3D&hl=ur&source=homepage&sa=X&ved=0ahUKEwjN5MPwwvSCAxXEdaQEHZhJBoMQ2ZgBCAU'),
(33, 'Search settings', '', '', 'https://www.google.com/setprefs?sig=0_91ecAg_Jg6tVh5QTwmr9xIz_jgo%3D&hl=ps&source=homepage&sa=X&ved=0ahUKEwjN5MPwwvSCAxXEdaQEHZhJBoMQ2ZgBCAY'),
(34, 'Search settings', '', '', 'https://www.google.com/setprefs?sig=0_91ecAg_Jg6tVh5QTwmr9xIz_jgo%3D&hl=sd&source=homepage&sa=X&ved=0ahUKEwjN5MPwwvSCAxXEdaQEHZhJBoMQ2ZgBCAc'),
(35, '      Google Ads - Get Customers and Sell More with Online Advertising    ', '', '', 'https://google.com/intl/en/ads/'),
(36, 'Google - About Google, Our Culture & Company News', '', '', 'https://google.com/intl/en/about.html'),
(37, 'Google', '', '', 'https://www.google.com/setprefdomain?prefdom=PK&prev=https://www.google.com.pk/&sig=K_XS9hhByPAkACGqs_ZE4mnVFIrZA%3D'),
(38, '', '', '', 'https://google.com/intl/en/policies/privacy/'),
(39, '', '', '', 'https://google.com/intl/en/policies/terms/'),
(40, 'Google', '', '', 'https://www.google.com.pk/webhp?tab=ww'),
(41, 'Google Images', 'Google Images. The most comprehensive image search on the web.', '', 'https://www.google.com/imghp?hl=en&tab=wi'),
(42, '  Google Maps  ', ' Find local businesses, view maps and get driving directions in Google Maps. ', '', 'https://maps.google.com/maps?hl=en&tab=wl'),
(43, 'Android Apps on Google Play', '', '', 'https://play.google.com/?hl=en&tab=w8'),
(44, 'YouTube', '', '', 'https://www.youtube.com/?tab=w1'),
(45, 'Google News', '', '', 'https://news.google.com/?tab=wn'),
(46, 'Gmail', '', '', 'https://mail.google.com/mail/?tab=wm'),
(47, 'Google Drive: Sign-in', '', '', 'https://drive.google.com/?tab=wo'),
(48, 'Browse All of Google\'s Products & Services - Google', '', '', 'https://www.google.com.pk/intl/en/about/products?tab=wh'),
(49, 'Google Calendar - Sign in to Access & Edit Your Schedule', '', '', 'https://calendar.google.com/calendar?tab=wc'),
(50, 'Google Translate', '', '', 'https://translate.google.com.pk/?hl=en&tab=wT'),
(51, 'Google Books', '', '', 'https://books.google.com.pk/?hl=en&tab=wp'),
(52, 'Google Shopping', '', '', 'https://www.google.com.pk/shopping?hl=en&source=og&tab=wf'),
(53, 'Blogger.com - Create a unique and beautiful blog easily.', '', '', 'https://www.blogger.com/?tab=wj'),
(54, 'Google Finance - Stock Market Prices, Real-time Quotes & Business News', '', '', 'https://www.google.com/finance?tab=we'),
(55, 'Google Photos', '', '', 'https://photos.google.com/?tab=wq&pageId=none'),
(56, '      Google Docs: Online Document Editor | Google Workspace    ', '', '', 'https://docs.google.com/document/?usp=docs_alc'),
(57, 'Sign in - Google Accounts', '', '', 'https://accounts.google.com/ServiceLogin?hl=en&passive=true&continue=https://www.google.com/&ec=GAZAAQ'),
(58, 'Search settings', '', '', 'http://www.google.com.pk/preferences?hl=en'),
(59, 'Search settings', '', '', 'https://google.com/preferences?hl=en'),
(60, 'Google - Search Customization', '', '', 'http://www.google.com.pk/history/optout?hl=en'),
(61, 'Google Advanced Search', '', '', 'https://google.com/advanced_search?hl=en-PK&authuser=0'),
(62, 'ÊáÇÔ ی ÊÑÊیÈÇÊ', '', '', 'https://www.google.com/setprefs?sig=0_rOo3L17L4MyDSOeCHHVXC3RcZWg%3D&hl=ur&source=homepage&sa=X&ved=0ahUKEwj2qabyw_SCAxU4g_0HHZ_8D9EQ2ZgBCAU'),
(63, 'Search settings', '', '', 'https://www.google.com/setprefs?sig=0_rOo3L17L4MyDSOeCHHVXC3RcZWg%3D&hl=ps&source=homepage&sa=X&ved=0ahUKEwj2qabyw_SCAxU4g_0HHZ_8D9EQ2ZgBCAY'),
(64, 'Search settings', '', '', 'https://www.google.com/setprefs?sig=0_rOo3L17L4MyDSOeCHHVXC3RcZWg%3D&hl=sd&source=homepage&sa=X&ved=0ahUKEwj2qabyw_SCAxU4g_0HHZ_8D9EQ2ZgBCAc'),
(65, '      Google Ads - Get Customers and Sell More with Online Advertising    ', '', '', 'https://google.com/intl/en/ads/'),
(66, 'Google - About Google, Our Culture & Company News', '', '', 'https://google.com/intl/en/about.html'),
(67, 'Google', '', '', 'https://www.google.com/setprefdomain?prefdom=PK&prev=https://www.google.com.pk/&sig=K_YqnegT7XLTg-rU0J3H2H5U9nZOg%3D'),
(68, '', '', '', 'https://google.com/intl/en/policies/privacy/'),
(69, '', '', '', 'https://google.com/intl/en/policies/terms/');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crawler_data`
--
ALTER TABLE `crawler_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crawler_data`
--
ALTER TABLE `crawler_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
