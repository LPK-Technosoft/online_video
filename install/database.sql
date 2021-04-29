-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2020 at 11:49 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_radio_app_buyer`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_active_log`
--

CREATE TABLE `tbl_active_log` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `date_time` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `password`, `email`, `image`) VALUES
(1, 'admin', 'admin', 'viaviwebtech@gmail.com', 'profile.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cid` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`cid`, `category_name`, `category_image`, `status`) VALUES
(1, 'Mega Bollywood', '15156_95035_banner_2.jpg', 1),
(2, 'DJ Rock', '56861_68785_banner_3.jpg', 1),
(3, 'Cocktail Party', '22129_61734_banner_4.jpg', 1),
(4, 'Hip Hop Night', '4714_43998_banner_5.jpg', 1),
(5, 'Abhijit Singh', '67193_20950_banner_6.jpg', 1),
(6, 'Neha Thakkar', '76765_53195_banner_7.jpg', 1),
(8, 'Kishore Khumar', '70027_98866_banner_9.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE `tbl_city` (
  `cid` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `city_status` int(1) NOT NULL DEFAULT 1,
  `city_tagline` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_city`
--

INSERT INTO `tbl_city` (`cid`, `city_name`, `city_status`, `city_tagline`) VALUES
(2, 'Mumbai', 1, 'Listen radios from Mumbai'),
(3, 'Delhi', 1, 'Listen radios from Delhi'),
(4, 'Cape Town', 1, 'Listen radios from Cape Town'),
(5, 'Paris', 1, 'Listen radios from Paris'),
(6, 'Montréal', 1, 'Listen radios from Montréal');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_favorite`
--

CREATE TABLE `tbl_favorite` (
  `id` int(10) NOT NULL,
  `post_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `type` varchar(20) NOT NULL,
  `created_at` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_language`
--

CREATE TABLE `tbl_language` (
  `lid` int(11) NOT NULL,
  `language_name` varchar(255) NOT NULL,
  `language_status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_language`
--

INSERT INTO `tbl_language` (`lid`, `language_name`, `language_status`) VALUES
(1, 'English', 1),
(2, 'Hindi', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mp3`
--

CREATE TABLE `tbl_mp3` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `mp3_type` varchar(255) NOT NULL,
  `mp3_title` varchar(100) NOT NULL,
  `mp3_url` text NOT NULL,
  `mp3_thumbnail` varchar(255) NOT NULL,
  `mp3_duration` varchar(255) NOT NULL,
  `mp3_description` text NOT NULL,
  `total_views` int(11) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_mp3`
--

INSERT INTO `tbl_mp3` (`id`, `cat_id`, `mp3_type`, `mp3_title`, `mp3_url`, `mp3_thumbnail`, `mp3_duration`, `mp3_description`, `total_views`, `status`) VALUES
(6, 2, 'local', 'Overboard - Justin Bieber', 'http://www.viaviweb.in/envato/cc/demo/mp3/file_example_MP3_5MG.mp3', '46935_artworks-000045309231-lsd832-t500x500.jpg', '4.11', '<p>Overboard - Justin Bieber</p>\r\n', 142, 1),
(7, 5, 'server_url', 'Vashmale - Thugs Of Hindustn', 'http://www.viaviweb.in/envato/cc/demo/mp3/file_example_MP3_5MG.mp3', '99390_maxresdefault.jpg', '1:53', '<p>Vashmale - Thugs Of Hindustn</p>\r\n', 113, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_radio`
--

CREATE TABLE `tbl_radio` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `radio_name` varchar(255) NOT NULL,
  `radio_url` varchar(255) NOT NULL,
  `radio_frequency` varchar(255) NOT NULL,
  `radio_image` varchar(255) NOT NULL,
  `radio_description` text NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `featured_radio` int(1) DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_radio`
--

INSERT INTO `tbl_radio` (`id`, `lang_id`, `city_id`, `radio_name`, `radio_url`, `radio_frequency`, `radio_image`, `radio_description`, `views`, `featured_radio`, `status`) VALUES
(20, 2, 3, 'Radio Madhuban', 'http://prclive1.listenon.in:9960', '90.4', '61548_26205_bg_play_list_2.png', '', 1202, 1, 1),
(22, 2, 2, 'Red FM', 'http://jazzradio.ice.infomaniak.ch/jazzradio-high.mp3', '93.5', '67671_836e84586da179931d04e8aafa0a672f.jpg', '', 1654, 0, 1),
(23, 2, 3, 'Radio city', 'http://knight.wavestreamer.com:4462/listen.m3u?sid=1', '91.1', '43911_31776485-party-music-background-for-flyers-and-nightclub-posters.jpg', '<p>This is<strong> Radio city</strong>.</p>\r\n\r\n<p>This is for demo purpose.</p>\r\n\r\n<p>This is<strong> Radio city</strong>.</p>\r\n\r\n<p>This is for demo purpose.</p>\r\n\r\n<p>This is<strong> Radio city</strong>.</p>\r\n\r\n<p>This is for demo purpose.</p>\r\n', 1993, 0, 1),
(24, 1, 6, 'Jazz Radio', 'http://jazzradio.ice.infomaniak.ch/jazzradio-high.mp3', '91.7', '35293_bg_play_list_1.png', '<p>This is<strong> Jazz Radio</strong>.</p>\r\n\r\n<p>This is for demo purpose.</p>\r\n', 3650, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reports`
--

CREATE TABLE `tbl_reports` (
  `id` int(10) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `report` text NOT NULL,
  `report_on` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `email_from` varchar(255) NOT NULL,
  `onesignal_app_id` varchar(500) NOT NULL,
  `onesignal_rest_key` varchar(500) NOT NULL,
  `envato_buyer_name` varchar(200) NOT NULL,
  `envato_purchase_code` text NOT NULL,
  `envato_buyer_email` varchar(150) NOT NULL,
  `envato_purchased_status` int(1) NOT NULL DEFAULT 0,
  `package_name` varchar(150) NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `app_logo` varchar(255) NOT NULL,
  `app_email` varchar(255) NOT NULL,
  `app_version` varchar(255) NOT NULL,
  `app_author` varchar(255) NOT NULL,
  `app_contact` varchar(255) NOT NULL,
  `app_website` varchar(255) NOT NULL,
  `app_description` text NOT NULL,
  `app_fb_url` varchar(255) NOT NULL,
  `app_twitter_url` varchar(255) NOT NULL,
  `app_developed_by` varchar(255) NOT NULL,
  `app_privacy_policy` text NOT NULL,
  `api_latest_limit` int(3) NOT NULL,
  `api_city_order_by` varchar(255) NOT NULL,
  `api_city_post_order_by` varchar(255) NOT NULL,
  `api_lang_order_by` varchar(255) NOT NULL,
  `publisher_id` varchar(500) NOT NULL,
  `interstital_ad` varchar(500) NOT NULL,
  `interstital_ad_id` varchar(500) NOT NULL,
  `interstital_ad_click` varchar(500) NOT NULL,
  `banner_ad` varchar(500) NOT NULL,
  `banner_ad_id` varchar(500) NOT NULL,
  `banner_ad_type` varchar(30) NOT NULL DEFAULT 'admob',
  `banner_facebook_id` text NOT NULL,
  `interstital_ad_type` varchar(30) NOT NULL DEFAULT 'admob',
  `interstital_facebook_id` text NOT NULL,
  `native_ad` varchar(20) NOT NULL DEFAULT 'false',
  `native_ad_type` varchar(30) NOT NULL DEFAULT 'admob',
  `native_ad_id` text NOT NULL,
  `native_facebook_id` text NOT NULL,
  `native_position` int(10) NOT NULL DEFAULT 5,
  `app_update_status` varchar(10) NOT NULL DEFAULT 'false',
  `app_new_version` double NOT NULL DEFAULT 1,
  `app_update_desc` text NOT NULL,
  `app_redirect_url` text NOT NULL,
  `cancel_update_status` varchar(10) NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `email_from`, `onesignal_app_id`, `onesignal_rest_key`, `envato_buyer_name`, `envato_purchase_code`, `envato_buyer_email`, `envato_purchased_status`, `package_name`, `app_name`, `app_logo`, `app_email`, `app_version`, `app_author`, `app_contact`, `app_website`, `app_description`, `app_fb_url`, `app_twitter_url`, `app_developed_by`, `app_privacy_policy`, `api_latest_limit`, `api_city_order_by`, `api_city_post_order_by`, `api_lang_order_by`, `publisher_id`, `interstital_ad`, `interstital_ad_id`, `interstital_ad_click`, `banner_ad`, `banner_ad_id`, `banner_ad_type`, `banner_facebook_id`, `interstital_ad_type`, `interstital_facebook_id`, `native_ad`, `native_ad_type`, `native_ad_id`, `native_facebook_id`, `native_position`, `app_update_status`, `app_new_version`, `app_update_desc`, `app_redirect_url`, `cancel_update_status`) VALUES
(1, 'info@viaviweb.in', '', '', '', '', 'user@viaviweb.in', 0, 'com.vpapps.onlineradio', 'Online Radio App', 'app_icon_round.png', 'info@viaviweb.in', '2.1.5', 'viaviwebtech', '+91 1234567891', 'www.viaviweb.com', '<p>As Viavi Webtech is finest offshore IT company which has expertise in the below mentioned all technologies and our professional, dedicated approach towards our work has always satisfied our clients as well as users. We have reached to this level because of the dedication and hard work of our 10+ years experienced team as well as new ideas of freshers, they always provide the best solutions. Here are the promising services served by Viavi Webtech.</p>\r\n\r\n<p>Contact on Skype &amp; Email for more information.</p>\r\n\r\n<p><strong>Skype ID:</strong> support.viaviweb <strong>OR</strong> viaviwebtech<br />\r\n<strong>Email:</strong> info@viaviweb.com <strong>OR</strong> viaviwebtech@gmail.com<br />\r\n<strong>Website:</strong> http://www.viaviweb.com</p>\r\n', 'https://www.facebook.com/viaviweb', 'https://twitter.com/viaviwebtech', 'Viavi Webtech', '<p><strong>We are committed to protecting your privacy</strong></p>\r\n\r\n<p>We collect the minimum amount of information about you that is commensurate with providing you with a satisfactory service. This policy indicates the type of processes that may result in data being collected about you. Your use of this website gives us the right to collect that information.&nbsp;</p>\r\n\r\n<p><strong>Information Collected</strong></p>\r\n\r\n<p>We may collect any or all of the information that you give us depending on the type of transaction you enter into, including your name, address, telephone number, and email address, together with data about your use of the website. Other information that may be needed from time to time to process a request may also be collected as indicated on the website.</p>\r\n\r\n<p><strong>Information Use</strong></p>\r\n\r\n<p>We use the information collected primarily to process the task for which you visited the website. Data collected in the UK is held in accordance with the Data Protection Act. All reasonable precautions are taken to prevent unauthorised access to this information. This safeguard may require you to provide additional forms of identity should you wish to obtain information about your account details.</p>\r\n\r\n<p><strong>Cookies</strong></p>\r\n\r\n<p>Your Internet browser has the in-built facility for storing small files - &quot;cookies&quot; - that hold information which allows a website to recognise your account. Our website takes advantage of this facility to enhance your experience. You have the ability to prevent your computer from accepting cookies but, if you do, certain functionality on the website may be impaired.</p>\r\n\r\n<p><strong>Disclosing Information</strong></p>\r\n\r\n<p>We do not disclose any personal information obtained about you from this website to third parties unless you permit us to do so by ticking the relevant boxes in registration or competition forms. We may also use the information to keep in contact with you and inform you of developments associated with us. You will be given the opportunity to remove yourself from any mailing list or similar device. If at any time in the future we should wish to disclose information collected on this website to any third party, it would only be with your knowledge and consent.&nbsp;</p>\r\n\r\n<p>We may from time to time provide information of a general nature to third parties - for example, the number of individuals visiting our website or completing a registration form, but we will not use any information that could identify those individuals.&nbsp;</p>\r\n\r\n<p>In addition Dummy may work with third parties for the purpose of delivering targeted behavioural advertising to the Dummy website. Through the use of cookies, anonymous information about your use of our websites and other websites will be used to provide more relevant adverts about goods and services of interest to you. For more information on online behavioural advertising and about how to turn this feature off, please visit youronlinechoices.com/opt-out.</p>\r\n\r\n<p><strong>Changes to this Policy</strong></p>\r\n\r\n<p>Any changes to our Privacy Policy will be placed here and will supersede this version of our policy. We will take reasonable steps to draw your attention to any changes in our policy. However, to be on the safe side, we suggest that you read this document each time you use the website to ensure that it still meets with your approval.</p>\r\n\r\n<p><strong>Contacting Us</strong></p>\r\n\r\n<p>If you have any questions about our Privacy Policy, or if you want to know what information we have collected about you, please email us at hd@dummy.com. You can also correct any factual errors in that information or require us to remove your details form any list under our control.</p>\r\n', 10, 'city_name', 'DESC', 'language_name', 'pub-5474962547551047', 'true', 'ca-app-pub-3940256099942544/1033173712', '5', 'true', 'ca-app-pub-3940256099942544/6300978111', 'admob', '', 'admob', '', 'false', 'admob', '', '', 5, 'false', 1, 'Kindle Update you application', 'https://play.google.com/store/apps/developer?id=Viaan+Parmar', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_smtp_settings`
--

CREATE TABLE `tbl_smtp_settings` (
  `id` int(5) NOT NULL,
  `smtp_type` varchar(20) NOT NULL DEFAULT 'server',
  `smtp_host` varchar(150) NOT NULL,
  `smtp_email` varchar(150) NOT NULL,
  `smtp_password` text NOT NULL,
  `smtp_secure` varchar(20) NOT NULL,
  `port_no` varchar(10) NOT NULL,
  `smtp_ghost` varchar(150) NOT NULL,
  `smtp_gemail` varchar(150) NOT NULL,
  `smtp_gpassword` text NOT NULL,
  `smtp_gsecure` varchar(20) NOT NULL,
  `gport_no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_smtp_settings`
--

INSERT INTO `tbl_smtp_settings` (`id`, `smtp_type`, `smtp_host`, `smtp_email`, `smtp_password`, `smtp_secure`, `port_no`, `smtp_ghost`, `smtp_gemail`, `smtp_gpassword`, `smtp_gsecure`, `gport_no`) VALUES
(1, 'server', '', '', '', 'ssl', '465', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_theme`
--

CREATE TABLE `tbl_theme` (
  `id` int(11) NOT NULL,
  `theme_name` varchar(255) NOT NULL,
  `gradient_color1` varchar(255) NOT NULL,
  `gradient_color2` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_theme`
--

INSERT INTO `tbl_theme` (`id`, `theme_name`, `gradient_color1`, `gradient_color2`) VALUES
(1, 'Green', '#37c704', '#156e07'),
(2, 'Red', '#d12601', '#eb680a'),
(3, 'Theme 3', '#185a9d', '#43cea2'),
(4, 'Theme 4', '#96fbc4', '#f9f586'),
(5, 'Theme 5', '#ff512f', '#dd2476'),
(6, 'Theme 6', '#aa076b', '#61045f');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(10) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'Normal',
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `auth_id` varchar(255) NOT NULL DEFAULT '0',
  `registered_on` varchar(200) NOT NULL DEFAULT '0',
  `password` text NOT NULL,
  `confirm_code` varchar(100) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `user_type`, `name`, `email`, `phone`, `auth_id`, `registered_on`, `password`, `confirm_code`, `status`) VALUES
(1, 'Normal', 'User', 'user.viaviweb@gmail.com', '+91 1234569874', '0', '1603531493', '202cb962ac59075b964b07152d234b70', '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_suggest`
--

CREATE TABLE `tbl_user_suggest` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` varchar(150) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_active_log`
--
ALTER TABLE `tbl_active_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `tbl_favorite`
--
ALTER TABLE `tbl_favorite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_language`
--
ALTER TABLE `tbl_language`
  ADD PRIMARY KEY (`lid`);

--
-- Indexes for table `tbl_mp3`
--
ALTER TABLE `tbl_mp3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_radio`
--
ALTER TABLE `tbl_radio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_smtp_settings`
--
ALTER TABLE `tbl_smtp_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_theme`
--
ALTER TABLE `tbl_theme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_suggest`
--
ALTER TABLE `tbl_user_suggest`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_active_log`
--
ALTER TABLE `tbl_active_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_favorite`
--
ALTER TABLE `tbl_favorite`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_language`
--
ALTER TABLE `tbl_language`
  MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_mp3`
--
ALTER TABLE `tbl_mp3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_radio`
--
ALTER TABLE `tbl_radio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_smtp_settings`
--
ALTER TABLE `tbl_smtp_settings`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_theme`
--
ALTER TABLE `tbl_theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_user_suggest`
--
ALTER TABLE `tbl_user_suggest`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
