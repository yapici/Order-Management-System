-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 06, 2016 at 04:59 PM
-- Server version: 5.5.45-cll-lve
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `oms_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE IF NOT EXISTS `audit_trail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `changed_table` varchar(20) NOT NULL,
  `changed_item_id` int(11) NOT NULL,
  `changed_field_name` varchar(100) NOT NULL,
  `old_value` varchar(1000) NOT NULL,
  `new_value` varchar(1000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=421 ;

--
-- Dumping data for table `audit_trail`
--

INSERT INTO `audit_trail` (`id`, `changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `date`, `user_id`) VALUES
(1, 'cost_centers', 6, 'NEW_ITEM', 'NEW_ITEM', 'test', '2016-01-05 14:30:41', 9),
(2, 'orders', 100124, 'NEW_ITEM', 'NEW_ITEM', '1000 uL Filter Tips, Sterile', '2016-01-05 14:31:08', 9),
(3, 'cost_centers', 6, 'name', 'test', 'testdf', '2016-01-05 16:24:10', 9),
(4, 'orders', 100124, 'description', '1000 uL Filter Tips, Sterile', '1000 uL Filter Tips, Steriler', '2016-01-05 16:33:44', 9),
(5, 'orders', 100124, 'quantity', '2', '24', '2016-01-05 16:34:44', 9),
(6, 'orders', 100124, 'description', '1000 uL Filter Tips, Steriler', '1000 uL Filter Tips, Steriler4', '2016-01-05 16:34:53', 9),
(7, 'orders', 100125, 'description', 'Test', 'Test1', '2016-01-05 20:04:21', 9),
(8, 'orders', 100125, 'quantity', '0', '2', '2016-01-05 20:04:21', 9),
(9, 'orders', 100125, 'uom', 'Test', '2Test', '2016-01-05 20:04:21', 9),
(10, 'orders', 100114, 'description', 'SATWIPES NW 4x4 70 IPA', 'SATWIPES NW 4x4 70 IPA1', '2016-01-05 20:18:52', 9),
(11, 'orders', 100114, 'quantity', '1', '11', '2016-01-05 20:18:52', 9),
(12, 'orders', 100114, 'uom', '185/PK', '185/PK1', '2016-01-05 20:18:52', 9),
(13, 'orders', 100114, 'vendor', '2', '4', '2016-01-05 20:18:52', 9),
(14, 'orders', 100114, 'vendor_name', 'Sigma-Aldrich', 'Bio-Rad', '2016-01-05 20:18:52', 9),
(15, 'orders', 100114, 'catalog_no', '19-170-951', '19-170-9511', '2016-01-05 20:18:52', 9),
(16, 'orders', 100114, 'price', '248.47000122070312', '248.4709930419922', '2016-01-05 20:18:52', 9),
(17, 'orders', 100114, 'weblink', 'http://dfd', 'http://dfd1', '2016-01-05 20:18:52', 9),
(18, 'orders', 100114, 'cost_center', '1', '2', '2016-01-05 20:18:52', 9),
(19, 'orders', 100114, 'project', '1', '2', '2016-01-05 20:18:52', 9),
(20, 'orders', 100114, 'comments', 'Backordered. Available on 20 Nov 2015 from RALEIGH, NC.', 'Backordered. Available on 20 Nov 2015 from RALEIGH, NC.1', '2016-01-05 20:18:52', 9),
(21, 'orders', 100114, 'vendor_order_no', '', '1', '2016-01-05 20:18:52', 9),
(22, 'orders', 100114, 'invoice_no', '', '1', '2016-01-05 20:18:52', 9),
(23, 'orders', 100114, 'status', 'Pending', 'Processing', '2016-01-05 20:18:52', 9),
(24, 'vendors', 63, 'NEW_ITEM', 'NEW_ITEM', 'df', '2016-01-05 20:30:52', 9),
(25, 'vendors', 63, 'name', 'df', 'df1', '2016-01-05 20:30:54', 9),
(26, 'vendors', 63, 'phone', 'sdfg', 'sdfg1', '2016-01-05 20:30:55', 9),
(27, 'vendors', 63, 'website', '', '1', '2016-01-05 20:30:56', 9),
(28, 'vendors', 63, 'address', '', '1', '2016-01-05 20:30:57', 9),
(29, 'vendors', 63, 'contact_person', '', '1', '2016-01-05 20:30:57', 9),
(30, 'vendors', 63, 'approved', '1', '0', '2016-01-05 20:31:02', 9),
(31, 'vendors', 63, 'deleted', '0', '1', '2016-01-05 20:31:03', 9),
(32, 'vendors', 62, 'contact_person', 'test3', 'test31', '2016-01-05 20:31:29', 9),
(33, 'vendors', 62, 'account_number', 'test31', 'test3', '2016-01-05 20:32:26', 9),
(34, 'users', 10, 'phone', '', '1', '2016-01-05 20:32:45', 9),
(35, 'users', 10, 'account_status', '1', '0', '2016-01-05 20:32:46', 9),
(36, 'users', 10, 'account_status', '0', '1', '2016-01-05 20:35:54', 9),
(37, 'users', 10, 'user_type', '0', '2', '2016-01-05 20:35:56', 9),
(38, 'users', 9, 'last_login_date', '2016-01-05 14:04:13', '2016-01-05 14:36:12', '2016-01-05 20:36:13', 9),
(39, 'projects', 3, 'name', 'testdf', 'testdf1', '2016-01-05 20:36:35', 9),
(40, 'projects', 3, 'number', 'test', 'test1', '2016-01-05 20:36:36', 9),
(41, 'projects', 3, 'active', '0', '1', '2016-01-05 20:36:39', 9),
(42, 'projects', 4, 'NEW_ITEM', 'NEW_ITEM', '1', '2016-01-05 20:36:41', 9),
(43, 'cost_centers', 6, 'name', 'testdf', 'testdf1', '2016-01-05 20:37:01', 9),
(44, 'cost_centers', 7, 'NEW_ITEM', 'NEW_ITEM', '1', '2016-01-05 20:37:03', 9),
(45, 'cost_centers', 7, 'active', '0', '1', '2016-01-05 20:38:42', 9),
(46, 'cost_centers', 7, 'name', '1', '12', '2016-01-05 20:38:45', 9),
(47, 'users', 1, 'last_login_date', '2016-01-03 22:29:47', '2016-01-05 14:51:21', '2016-01-05 20:51:21', 1),
(48, 'orders', 1, 'NEW_ITEM', 'NEW_ITEM', 'Test', '2016-01-05 20:52:21', 1),
(49, 'users', 9, 'last_login_date', '2016-01-05 14:36:12', '2016-01-05 14:52:37', '2016-01-05 20:52:37', 9),
(50, 'orders', 100002, 'NEW_ITEM', 'NEW_ITEM', 'Test', '2016-01-05 20:53:11', 9),
(51, 'orders', 100002, 'description', 'Test', '&lt;&gt;&quot;&quot;''''''''&gt;&lt;!@#^$%&amp;*_()($%', '2016-01-06 14:41:28', 9),
(52, 'orders', 100002, 'description', '&lt;&gt;&quot;&quot;''''''''&gt;&lt;!@#^$%&amp;*_()($%', '&lt;&gt;&quot;&quot;''''''''&gt;!@#^$%&amp;*_()($%', '2016-01-06 14:41:51', 9),
(53, 'orders', 100002, 'description', '&lt;&gt;&quot;&quot;''''''''&gt;!@#^$%&amp;*_()($%', 'Test', '2016-01-06 14:42:10', 9),
(54, 'vendors', 64, 'NEW_ITEM', 'NEW_ITEM', 'tes', '2016-01-06 16:28:17', 9),
(55, 'vendors', 65, 'NEW_ITEM', 'NEW_ITEM', 'ere', '2016-01-06 16:28:36', 9),
(56, 'vendors', 1, 'NEW_ITEM', 'NEW_ITEM', 'Fisher Scientific', '2016-01-06 16:29:19', 0),
(57, 'vendors', 2, 'NEW_ITEM', 'NEW_ITEM', 'Sigma-Aldrich', '2016-01-06 16:29:19', 0),
(58, 'vendors', 3, 'NEW_ITEM', 'NEW_ITEM', 'VWR', '2016-01-06 16:29:19', 0),
(59, 'vendors', 4, 'NEW_ITEM', 'NEW_ITEM', 'Bio-Rad', '2016-01-06 16:29:19', 1),
(60, 'vendors', 5, 'NEW_ITEM', 'NEW_ITEM', 'CisBio', '2016-01-06 16:29:19', 1),
(61, 'vendors', 6, 'NEW_ITEM', 'NEW_ITEM', 'tes', '2016-01-06 16:29:19', 9),
(62, 'vendors', 7, 'NEW_ITEM', 'NEW_ITEM', 'dg', '2016-01-06 16:29:28', 9),
(63, 'users', 18, 'NEW_ITEM', 'NEW_ITEM', 'test', '2016-01-06 17:35:00', 18),
(64, 'users', 9, 'last_login_date', '2016-01-05 14:52:37', '2016-01-06 12:53:07', '2016-01-06 18:53:07', 9),
(65, 'vendors', 8, 'NEW_ITEM', 'NEW_ITEM', 'test', '2016-01-06 18:53:26', 9),
(66, 'orders', 100003, 'NEW_ITEM', 'NEW_ITEM', 'Test', '2016-01-06 18:53:26', 9),
(67, 'orders', 100004, 'NEW_ITEM', 'NEW_ITEM', 'Test', '2016-01-06 19:34:29', 9),
(68, 'orders', 100005, 'NEW_ITEM', 'NEW_ITEM', 'Test', '2016-01-06 19:42:53', 9),
(69, 'users', 1, 'last_login_date', '2016-01-05 14:51:21', '2016-01-06 16:04:00', '2016-01-06 22:04:00', 1),
(70, 'users', 1, 'last_login_date', '2016-01-06 16:04:00', '2016-01-06 16:07:49', '2016-01-06 22:07:49', 1),
(71, 'users', 9, 'last_login_date', '2016-01-06 12:53:07', '2016-01-06 16:08:38', '2016-01-06 22:08:38', 9),
(72, 'orders', 100005, 'project', '2', '3', '2016-01-06 22:08:44', 9),
(73, 'orders', 100005, 'cost_center', '2', '6', '2016-01-06 22:08:50', 9),
(74, 'orders', 100005, 'price', '11', '114', '2016-01-06 22:08:56', 9),
(75, 'orders', 100005, 'vendor', '1', '3', '2016-01-06 22:09:01', 9),
(76, 'orders', 100005, 'vendor_name', 'Fisher Scientific', 'VWR', '2016-01-06 22:09:01', 9),
(77, 'orders', 100005, 'description', 'Test', 'Test1', '2016-01-06 22:09:14', 9),
(78, 'orders', 100005, 'quantity', '1', '11', '2016-01-06 22:09:14', 9),
(79, 'orders', 100005, 'uom', 'test', 'test1', '2016-01-06 22:09:14', 9),
(80, 'orders', 100005, 'catalog_no', 'test', 'test1', '2016-01-06 22:09:14', 9),
(81, 'orders', 100005, 'weblink', 'http://test', 'http://test1', '2016-01-06 22:09:14', 9),
(82, 'orders', 100005, 'comments', 'test', 'test1', '2016-01-06 22:09:14', 9),
(83, 'orders', 100005, 'vendor_order_no', '', '1', '2016-01-06 22:09:14', 9),
(84, 'orders', 100005, 'invoice_no', '', '1', '2016-01-06 22:09:14', 9),
(85, 'users', 9, 'last_login_date', '2016-01-06 16:08:38', '2016-01-06 16:12:15', '2016-01-06 22:12:15', 9),
(86, 'orders', 100005, 'cost_center', '6', '1', '2016-01-06 22:12:22', 9),
(87, 'orders', 100005, 'cost_center', '1', '2', '2016-01-06 22:13:24', 9),
(88, 'orders', 100005, 'cost_center', '2', '1', '2016-01-06 22:13:30', 9),
(89, 'orders', 100005, 'cost_center', '1', '6', '2016-01-06 22:13:38', 9),
(90, 'orders', 100005, 'project', '3', '1', '2016-01-06 22:14:42', 9),
(91, 'orders', 100004, 'cost_center', '2', '1', '2016-01-06 22:16:16', 9),
(92, 'orders', 100004, 'project', '2', '1', '2016-01-06 22:16:16', 9),
(93, 'orders', 100004, 'cost_center', '1', '7', '2016-01-06 22:16:24', 9),
(94, 'orders', 100004, 'project', '1', '4', '2016-01-06 22:16:24', 9),
(95, 'orders', 100005, 'cost_center', '6', '1', '2016-01-06 22:17:08', 9),
(96, 'orders', 100005, 'cost_center', '1', '7', '2016-01-06 22:17:16', 9),
(97, 'orders', 100005, 'project', '1', '4', '2016-01-06 22:17:16', 9),
(98, 'orders', 100005, 'cost_center', '7', '1', '2016-01-06 22:17:46', 9),
(99, 'orders', 100005, 'project', '4', '1', '2016-01-06 22:17:46', 9),
(100, 'orders', 100005, 'cost_center', '1', '6', '2016-01-06 22:17:49', 9),
(101, 'orders', 100005, 'description', 'Test1', 'Test1kk', '2016-01-06 22:19:46', 9),
(102, 'orders', 100005, 'quantity', '11', '1', '2016-01-06 22:20:25', 9),
(103, 'orders', 100005, 'price', '114', '3', '2016-01-06 22:20:25', 9),
(104, 'orders', 100005, 'cost_center', '6', '0', '2016-01-06 22:20:48', 9),
(105, 'orders', 100005, 'project', '1', '0', '2016-01-06 22:20:48', 9),
(106, 'orders', 100005, 'cost_center', '0', '1', '2016-01-06 22:21:58', 9),
(107, 'orders', 100005, 'project', '0', '1', '2016-01-06 22:21:58', 9),
(108, 'orders', 100005, 'cost_center', '1', '2', '2016-01-06 22:22:03', 9),
(109, 'orders', 100005, 'project', '1', '3', '2016-01-06 22:22:03', 9),
(110, 'orders', 100005, 'cost_center', '2', '1', '2016-01-06 22:23:29', 9),
(111, 'orders', 100005, 'project', '3', '2', '2016-01-06 22:23:32', 9),
(112, 'users', 1, 'last_login_date', '2016-01-06 16:07:49', '2016-01-08 12:50:06', '2016-01-08 18:50:06', 1),
(113, 'users', 9, 'last_login_date', '2016-01-06 16:12:15', '2016-01-11 08:22:19', '2016-01-11 14:22:19', 9),
(114, 'users', 1, 'user_type', '0', '2', '2016-01-11 14:36:44', 9),
(115, 'orders', 100005, 'status', 'Pending', 'Delivered', '2016-01-11 14:37:34', 9),
(116, 'orders', 100004, 'status', 'Pending', 'Delivered', '2016-01-11 14:39:25', 9),
(117, 'orders', 100001, 'status', 'Pending', 'Delivered', '2016-01-11 14:40:35', 9),
(118, 'orders', 100001, 'status', 'Delivered', 'Ordered', '2016-01-11 14:43:45', 9),
(119, 'orders', 100001, 'status', 'Ordered', 'Delivered', '2016-01-11 14:46:37', 9),
(120, 'orders', 100001, 'status', 'Delivered', 'Ordered', '2016-01-11 14:47:29', 9),
(121, 'orders', 100001, 'status', 'Ordered', 'Delivered', '2016-01-11 14:48:23', 9),
(122, 'orders', 100002, 'status', 'Pending', 'Canceled', '2016-01-11 14:58:35', 9),
(123, 'projects', 4, 'name', '1', 'aaa', '2016-01-11 15:24:38', 9),
(124, 'projects', 4, 'number', '1', 'a', '2016-01-11 15:24:40', 9),
(125, 'projects', 1, 'name', 'Project 12', 'Project1', '2016-01-11 15:31:36', 9),
(126, 'projects', 2, 'name', 'Project 2ckl', 'Project2', '2016-01-11 15:31:44', 9),
(127, 'projects', 1, 'name', 'Project1', 'Project3', '2016-01-11 15:31:58', 9),
(128, 'projects', 4, 'name', 'aaa', 'Project1', '2016-01-11 15:32:17', 9),
(129, 'projects', 3, 'name', 'testdf1', 'Ggggg', '2016-01-11 15:32:46', 9),
(130, 'orders', 100005, 'project', '2', '3', '2016-01-11 15:33:31', 9),
(131, 'orders', 100003, 'project', '2', '4', '2016-01-11 15:33:41', 9),
(132, 'orders', 100005, 'project', '3', '2', '2016-01-11 17:14:29', 9),
(133, 'users', 19, 'NEW_ITEM', 'NEW_ITEM', 's', '2016-01-11 17:54:12', 19),
(134, 'users', 9, 'last_login_date', '2016-01-11 08:22:19', '2016-01-11 11:58:49', '2016-01-11 17:58:49', 9),
(135, 'users', 9, 'last_login_date', '2016-01-11 11:58:49', '2016-01-11 12:45:52', '2016-01-11 18:45:52', 9),
(136, 'orders', 100006, 'NEW_ITEM', 'NEW_ITEM', 'Test', '2016-01-11 18:46:04', 9),
(137, 'users', 9, 'last_login_date', '2016-01-11 12:45:52', '2016-01-11 12:46:57', '2016-01-11 18:46:57', 9),
(138, 'users', 9, 'last_login_date', '2016-01-11 12:46:57', '2016-01-11 12:48:16', '2016-01-11 18:48:16', 9),
(139, 'orders', 100007, 'NEW_ITEM', 'NEW_ITEM', 'Test1', '2016-01-11 18:48:42', 9),
(140, 'users', 9, 'last_login_date', '2016-01-11 12:48:16', '2016-01-11 13:01:59', '2016-01-11 19:02:00', 9),
(141, 'orders', 100008, 'NEW_ITEM', 'NEW_ITEM', 'Test1', '2016-01-11 19:02:26', 9),
(142, 'orders', 100009, 'NEW_ITEM', 'NEW_ITEM', 'Test2', '2016-01-11 19:20:16', 9),
(143, 'users', 1, 'last_login_date', '2016-01-08 12:50:06', '2016-01-11 13:21:10', '2016-01-11 19:21:10', 1),
(144, 'orders', 100010, 'NEW_ITEM', 'NEW_ITEM', 'Test', '2016-01-11 19:21:27', 1),
(145, 'orders', 100011, 'NEW_ITEM', 'NEW_ITEM', 'Test', '2016-01-11 19:22:00', 9),
(146, 'users', 11, 'user_type', '0', '2', '2016-01-11 19:23:16', 1),
(147, 'users', 11, 'user_type', '2', '0', '2016-01-11 19:23:19', 1),
(148, 'users', 17, 'user_type', '1', '0', '2016-01-11 19:23:22', 1),
(149, 'orders', 100011, 'description', 'Test', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', '2016-01-11 19:34:36', 9),
(150, 'orders', 100010, 'description', 'Test', '&lt;script&gt;alert('''');&lt;/script&gt;', '2016-01-11 19:36:34', 9),
(151, 'orders', 100010, 'quantity', '1', '0', '2016-01-11 19:39:23', 9),
(152, 'orders', 100010, 'uom', 'test', '&lt;script&gt;alert('''');&lt;/script&gt;', '2016-01-11 19:39:23', 9),
(153, 'orders', 100010, 'price', '11', '0', '2016-01-11 19:39:23', 9),
(154, 'orders', 100008, 'project', '2', '0', '2016-01-11 19:40:00', 9),
(155, 'orders', 100010, 'uom', '&lt;script&gt;alert('''');&lt;/script&gt;', '', '2016-01-11 19:45:32', 9),
(156, 'orders', 100010, 'catalog_no', 'test', '&lt;script&gt;alert('''');&lt;/script&gt;', '2016-01-11 19:55:55', 9),
(157, 'orders', 100010, 'uom', '', '&lt;script&gt;alert('''');&lt;/script&gt;', '2016-01-11 20:00:20', 9),
(158, 'orders', 100010, 'weblink', 'http://test', 'http://&lt;script&gt;alert('''');&lt;/script&gt;', '2016-01-11 20:00:52', 9),
(159, 'orders', 100010, 'comments', 'test', '&lt;script&gt;alert('''');&lt;/script&gt;', '2016-01-11 20:00:57', 9),
(160, 'orders', 100010, 'weblink', 'http://&lt;script&gt;alert('''');&lt;/script&gt;', 'http://dsfdsf', '2016-01-11 20:01:07', 9),
(161, 'orders', 100010, 'vendor_order_no', '', '&lt;script&gt;alert('''');&lt;/script&gt;', '2016-01-11 20:01:21', 9),
(162, 'orders', 100010, 'invoice_no', '', '&lt;script&gt;alert('''');&lt;/script&gt;', '2016-01-11 20:01:21', 9),
(163, 'orders', 100011, 'quantity', '1', '0', '2016-01-11 20:01:44', 9),
(164, 'orders', 100011, 'uom', 'test', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', '2016-01-11 20:01:44', 9),
(165, 'orders', 100011, 'catalog_no', 'test', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', '2016-01-11 20:01:44', 9),
(166, 'orders', 100011, 'price', '11', '0', '2016-01-11 20:01:44', 9),
(167, 'orders', 100011, 'weblink', 'http://test', 'http://&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', '2016-01-11 20:01:44', 9),
(168, 'orders', 100011, 'comments', 'test', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', '2016-01-11 20:01:44', 9),
(169, 'orders', 100011, 'vendor_order_no', '', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', '2016-01-11 20:01:44', 9),
(170, 'orders', 100011, 'invoice_no', '', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', '2016-01-11 20:01:44', 9),
(171, 'orders', 100011, 'weblink', 'http://&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', 'http://www.amazon.com/dp/B018GTUWPO/ref=dvm_us_aw_cs_sh_ps_mitjggwin?pf_rd_m=ATVPDKIKX0DER&amp;pf_rd_s=desktop-hero-piv&amp;pf_rd_r=0X74PEFPAGK3MSTTFF3G&amp;pf_rd_t=36701&amp;pf_rd_p=2383061222&amp;pf_rd_i=desktop', '2016-01-11 20:04:11', 9),
(172, 'orders', 100012, 'NEW_ITEM', 'NEW_ITEM', '&lt;script&gt;alert('''');&lt;/script&gt;', '2016-01-11 20:15:52', 9),
(173, 'vendors', 6, 'website', '', 'http://www.amazon.com/dp/B018GTUWPO/ref=dvm_us_aw_cs_sh_ps_mitjggwin?pf_rd_m=ATVPDKIKX0DER', '2016-01-11 20:17:14', 9),
(174, 'vendors', 7, 'website', '', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '2016-01-11 20:18:26', 9),
(175, 'vendors', 8, 'phone', 'test', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '2016-01-11 20:18:27', 9),
(176, 'vendors', 8, 'website', '', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '2016-01-11 20:18:28', 9),
(177, 'vendors', 8, 'address', '', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '2016-01-11 20:18:29', 9),
(178, 'vendors', 8, 'contact_person', '', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '2016-01-11 20:18:30', 9),
(179, 'vendors', 8, 'account_number', '', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '2016-01-11 20:18:31', 9),
(180, 'vendors', 8, 'name', 'test', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '2016-01-11 20:18:33', 9),
(181, 'vendors', 8, 'name', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '&lt;script&gt;alert('''');&lt;/script&gt;', '2016-01-11 20:18:54', 9),
(182, 'vendors', 8, 'approved', '0', '1', '2016-01-11 20:18:55', 9),
(183, 'vendors', 9, 'NEW_ITEM', 'NEW_ITEM', '&lt;script&gt;alert('''');&lt;/script&gt;', '2016-01-11 20:19:40', 9),
(184, 'vendors', 10, 'NEW_ITEM', 'NEW_ITEM', '&lt;script&gt;alert('''');&lt;/script&gt;', '2016-01-11 20:23:39', 9),
(185, 'vendors', 11, 'NEW_ITEM', 'NEW_ITEM', '&lt;script&gt;alert('''');&lt;/script&gt;', '2016-01-11 20:26:59', 9),
(186, 'vendors', 12, 'NEW_ITEM', 'NEW_ITEM', '&lt;script&gt;alert('''');&lt;/script&gt;', '2016-01-11 20:27:09', 9),
(187, 'vendors', 13, 'NEW_ITEM', 'NEW_ITEM', 'WDFW', '2016-01-11 20:28:27', 9),
(188, 'users', 1, 'last_login_date', '2016-01-11 13:21:10', '2016-01-13 13:12:57', '2016-01-13 19:12:57', 1),
(189, 'users', 9, 'last_login_date', '2016-01-11 13:01:59', '2016-01-14 08:42:19', '2016-01-14 14:42:19', 9),
(190, 'orders', 100012, 'status', 'Pending', 'Ordered', '2016-01-14 15:10:33', 9),
(191, 'orders', 100012, 'status', 'Ordered', 'Delivered', '2016-01-14 15:11:22', 9),
(192, 'orders', 100011, 'status', 'Pending', 'Ordered', '2016-01-14 15:14:26', 9),
(193, 'orders', 100011, 'status', 'Ordered', 'Delivered', '2016-01-14 15:14:41', 9),
(194, 'orders', 100010, 'status', 'Pending', 'Delivered', '2016-01-14 15:38:57', 9),
(195, 'orders', 100009, 'status', 'Pending', 'Ordered', '2016-01-14 17:38:33', 9),
(196, 'orders', 100009, 'status', 'Ordered', 'Delivered', '2016-01-14 17:38:39', 9),
(197, 'orders', 100009, 'status', 'Delivered', 'Processing', '2016-01-14 18:26:21', 9),
(198, 'orders', 100009, 'status', 'Processing', 'Delivered', '2016-01-14 18:26:31', 9),
(199, 'orders', 100009, 'status', 'Delivered', 'Pending', '2016-01-14 18:32:27', 9),
(200, 'orders', 100009, 'status', 'Pending', 'Delivered', '2016-01-14 18:32:39', 9),
(201, 'orders', 100009, 'status', 'Delivered', 'Ordered', '2016-01-14 18:32:48', 9),
(202, 'orders', 100009, 'status', 'Ordered', 'Delivered', '2016-01-14 18:33:29', 9),
(203, 'orders', 100008, 'project', '0', '1', '2016-01-14 18:34:07', 9),
(204, 'orders', 100008, 'status', 'Pending', 'Ordered', '2016-01-14 18:34:07', 9),
(205, 'orders', 100008, 'status', 'Ordered', 'Delivered', '2016-01-14 18:34:24', 9),
(206, 'orders', 100012, 'description', '&lt;script&gt;alert('''');&lt;/script&gt;', 'Test1', '2016-01-14 20:53:18', 9),
(207, 'orders', 100012, 'uom', '&lt;script&gt;alert('''');&lt;/script&gt;', 'Test1', '2016-01-14 20:53:18', 9),
(208, 'orders', 100012, 'catalog_no', '&lt;script&gt;alert('''');&lt;/script&gt;', 'Test1', '2016-01-14 20:53:18', 9),
(209, 'orders', 100012, 'comments', '&lt;script&gt;alert('''');&lt;/script&gt;', 'Test1', '2016-01-14 20:53:18', 9),
(210, 'orders', 100011, 'description', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', 'Test2', '2016-01-14 20:53:31', 9),
(211, 'orders', 100011, 'uom', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', 'Test2', '2016-01-14 20:53:31', 9),
(212, 'orders', 100011, 'catalog_no', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', 'Test2', '2016-01-14 20:53:31', 9),
(213, 'orders', 100011, 'comments', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', 'Test2', '2016-01-14 20:53:31', 9),
(214, 'vendors', 13, 'website', '', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '2016-01-14 20:53:40', 9),
(215, 'vendors', 14, 'NEW_ITEM', 'NEW_ITEM', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', '2016-01-14 20:53:56', 9),
(216, 'projects', 5, 'NEW_ITEM', 'NEW_ITEM', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '2016-01-14 20:54:13', 9),
(217, 'cost_centers', 8, 'NEW_ITEM', 'NEW_ITEM', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '2016-01-14 20:54:22', 9),
(218, 'users', 19, 'phone', '', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '2016-01-14 20:54:33', 9),
(219, 'users', 19, 'phone', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', 'dsfds/fdfdf//', '2016-01-14 20:54:47', 9),
(220, 'orders', 100012, 'description', 'Test1', '&lt;&gt;&lt;?''[[];l]]]123456790-=@#$%^&amp;*()_(*&amp;^%$#&lt;&gt;?:&quot;{:{+P:L&lt;M&gt;:'''';;&quot;&quot;&quot;&quot;&quot;&quot;''''''', '2016-01-15 00:27:05', 9),
(221, 'orders', 100011, 'description', 'Test2', '&lt;&gt;&lt;?''[[];l]]]123456790-=@#$%^&amp;*()_(*&amp;^%$#&lt;&gt;?:&quot;{:{+P:L&lt;M&gt;:'''';;&quot;&quot;&quot;&quot;&quot;&quot;''''''', '2016-01-15 00:28:35', 9),
(222, 'users', 1, 'last_login_date', '2016-01-13 13:12:57', '2016-01-18 07:15:35', '2016-01-18 13:15:35', 1),
(223, 'orders', 100011, 'description', '&lt;&gt;&lt;?''[[];l]]]123456790-=@#$%^&amp;*()_(*&amp;^%$#&lt;&gt;?:&quot;{:{+P:L&lt;M&gt;:'''';;&quot;&quot;&quot;&quot;&quot;&quot;''''''', '&lt;&gt;&lt;?''[[];l]]]123456790-=@#$%^&amp;*()_(*&amp;^%$#&lt;&gt;?:&quot;{:{+P:L&lt;M&gt;:'''';;&quot;&quot;&quot;&quot;&quot;&quot;''''''dafmsdmfmdsm mdsa fmdmfmdsfmmsd fmmsfms mfmmdsfmdsmf', '2016-01-18 13:15:52', 1),
(224, 'users', 1, 'last_login_date', '2016-01-18 07:15:35', '2016-01-18 07:21:03', '2016-01-18 13:21:03', 1),
(225, 'users', 9, 'last_login_date', '2016-01-14 08:42:19', '2016-01-18 07:23:23', '2016-01-18 13:23:23', 9),
(226, 'users', 1, 'user_type', '2', '0', '2016-01-18 13:23:36', 9),
(227, 'cost_centers', 8, 'name', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '', '2016-01-18 13:42:30', 1),
(228, 'orders', 100012, 'vendor', '1', '2', '2016-01-18 15:05:26', 1),
(229, 'orders', 100012, 'vendor_name', 'Fisher Scientific', 'Sigma-Aldrich', '2016-01-18 15:05:26', 1),
(230, 'orders', 100012, 'description', '&lt;&gt;&lt;?''[[];l]]]123456790-=@#$%^&amp;*()_(*&amp;^%$#&lt;&gt;?:&quot;{:{+P:L&lt;M&gt;:'''';;&quot;&quot;&quot;&quot;&quot;&quot;''''''', 'ergrewg', '2016-01-18 15:05:50', 1),
(231, 'orders', 100012, 'quantity', '0', '1', '2016-01-18 15:05:55', 1),
(232, 'orders', 100012, 'uom', 'Test1', 'Test11', '2016-01-18 15:06:01', 1),
(233, 'orders', 100012, 'catalog_no', 'Test1', 'Test11', '2016-01-18 15:06:04', 1),
(234, 'orders', 100012, 'price', '0', '1', '2016-01-18 15:06:08', 1),
(235, 'orders', 100012, 'weblink', 'http://dsfdsf', 'http://dsfdsf1', '2016-01-18 15:06:08', 1),
(236, 'orders', 100012, 'cost_center', '7', '1', '2016-01-18 15:06:16', 1),
(237, 'orders', 100012, 'project', '4', '5', '2016-01-18 15:06:16', 1),
(238, 'orders', 100012, 'comments', 'Test1', 'Test11', '2016-01-18 15:06:16', 1),
(239, 'orders', 100012, 'price', '1', '0', '2016-01-18 17:40:14', 1),
(240, 'orders', 100012, 'project', '5', '0', '2016-01-18 17:40:14', 1),
(241, 'orders', 100012, 'price', '0', '14', '2016-01-18 17:40:19', 1),
(242, 'users', 1, 'last_login_date', '2016-01-18 07:21:03', '2016-01-18 14:57:52', '2016-01-18 20:57:52', 1),
(243, 'orders', 100013, 'NEW_ITEM', 'NEW_ITEM', 'ergrewg', '2016-01-19 13:11:38', 1),
(244, 'orders', 100014, 'NEW_ITEM', 'NEW_ITEM', 'ergrewg', '2016-01-19 13:14:25', 1),
(245, 'orders', 100015, 'NEW_ITEM', 'NEW_ITEM', 'ergrewg', '2016-01-19 13:24:44', 1),
(246, 'orders', 100016, 'NEW_ITEM', 'NEW_ITEM', 'ergrewg', '2016-01-19 13:37:04', 1),
(247, 'orders', 100017, 'NEW_ITEM', 'NEW_ITEM', 'ergrewg', '2016-01-19 13:56:23', 1),
(248, 'users', 1, 'last_login_date', '2016-01-18 14:57:52', '2016-01-28 20:47:05', '2016-01-29 02:47:05', 1),
(249, 'users', 9, 'last_login_date', '2016-01-18 07:23:23', '2016-01-28 20:47:30', '2016-01-29 02:47:30', 9),
(250, 'orders', 100016, 'status', 'Pending', 'Ordered', '2016-01-29 02:48:45', 9),
(251, 'orders', 100017, 'vendor', '2', '1', '2016-01-29 02:56:48', 9),
(252, 'orders', 100017, 'vendor_name', 'Sigma-Aldrich', 'Fisher Scientific', '2016-01-29 02:56:48', 9),
(253, 'orders', 100017, 'vendor', '1', '2', '2016-01-29 02:59:45', 9),
(254, 'orders', 100017, 'vendor_name', 'Fisher Scientific', 'Sigma-Aldrich', '2016-01-29 02:59:45', 9),
(255, 'orders', 100017, 'price', '14', '144', '2016-01-29 02:59:51', 9),
(256, 'orders', 100017, 'price', '144', '144.11000061035156', '2016-01-29 03:02:05', 9),
(257, 'orders', 100017, 'price', '144.11', '144.00', '2016-01-29 03:03:51', 9),
(258, 'orders', 100017, 'price', '144.00', '144.20', '2016-01-29 03:04:12', 9),
(259, 'orders', 100017, 'price', '144.20', '9999.99', '2016-01-29 03:05:21', 9),
(260, 'orders', 100017, 'price', '9999.99', '99994234342341111.99', '2016-01-29 03:05:58', 9),
(261, 'vendors', 6, 'name', 'tes', 'aaaaa', '2016-01-29 03:07:32', 9),
(262, 'vendors', 7, 'name', 'dg', 'bbbbb', '2016-01-29 03:07:34', 9),
(263, 'vendors', 8, 'name', '&lt;script&gt;alert('''');&lt;/script&gt;', 'ccccc', '2016-01-29 03:07:36', 9),
(264, 'vendors', 9, 'name', '&lt;script&gt;alert('''');&lt;/script&gt;', 'ddddd', '2016-01-29 03:07:38', 9),
(265, 'vendors', 10, 'name', '&lt;script&gt;alert('''');&lt;/script&gt;', 'eeeee', '2016-01-29 03:07:40', 9),
(266, 'vendors', 11, 'name', '&lt;script&gt;alert('''');&lt;/script&gt;', 'ffffff', '2016-01-29 03:07:42', 9),
(267, 'vendors', 12, 'name', '&lt;script&gt;alert('''');&lt;/script&gt;', 'ggggg', '2016-01-29 03:07:45', 9),
(268, 'vendors', 13, 'name', 'WDFW', 'hhhhh', '2016-01-29 03:07:46', 9),
(269, 'vendors', 14, 'name', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', 'jjjjjj', '2016-01-29 03:07:50', 9),
(270, 'orders', 100017, 'vendor', '2', '3', '2016-01-29 03:08:20', 9),
(271, 'orders', 100017, 'vendor_name', 'Sigma-Aldrich', 'VWR', '2016-01-29 03:08:20', 9),
(272, 'orders', 100017, 'price', '99994234342341111.99', '99911.99', '2016-01-29 03:08:26', 9),
(273, 'orders', 100017, 'vendor', '3', '5', '2016-01-29 03:17:46', 9),
(274, 'orders', 100017, 'vendor_name', 'VWR', 'CisBio', '2016-01-29 03:17:46', 9),
(275, 'orders', 100010, 'comments', '&lt;script&gt;alert('''');&lt;/script&gt;', 'test', '2016-01-29 03:20:04', 9),
(276, 'orders', 100010, 'description', '&lt;script&gt;alert('''');&lt;/script&gt;', 'test', '2016-01-29 03:20:16', 9),
(277, 'orders', 100010, 'uom', '&lt;script&gt;alert('''');&lt;/script&gt;', 'test', '2016-01-29 03:20:16', 9),
(278, 'orders', 100010, 'catalog_no', '&lt;script&gt;alert('''');&lt;/script&gt;', 'test', '2016-01-29 03:20:23', 9),
(279, 'projects', 5, 'name', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', 'Office Supplies', '2016-01-29 03:22:51', 9),
(280, 'projects', 5, 'number', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '', '2016-01-29 03:22:53', 9),
(281, 'orders', 100012, 'status', 'Delivered', 'Archived', '2016-01-29 03:27:25', 9),
(282, 'orders', 100011, 'status', 'Delivered', 'In Concur', '2016-01-29 03:27:34', 9),
(283, 'vendors', 6, 'approved', '1', '0', '2016-01-29 03:30:57', 9),
(284, 'vendors', 7, 'approved', '1', '0', '2016-01-29 03:31:00', 9),
(285, 'orders', 100017, 'price', '99911.99', '99912.00', '2016-01-29 03:33:18', 9),
(286, 'users', 1, 'last_login_date', '2016-01-28 20:47:05', '2016-01-28 21:33:44', '2016-01-29 03:33:44', 1),
(287, 'users', 1, 'last_login_date', '2016-01-28 21:33:44', '2016-01-28 21:36:11', '2016-01-29 03:36:11', 1),
(288, 'users', 1, 'last_login_date', '2016-01-28 21:36:11', '2016-01-28 21:36:57', '2016-01-29 03:36:57', 1),
(289, 'users', 1, 'last_login_date', '2016-01-28 21:36:57', '2016-01-28 21:37:32', '2016-01-29 03:37:32', 1),
(290, 'users', 1, 'last_login_date', '2016-01-28 21:37:32', '2016-01-28 21:38:02', '2016-01-29 03:38:02', 1),
(291, 'users', 1, 'last_login_date', '2016-01-28 21:38:02', '2016-01-28 21:38:36', '2016-01-29 03:38:36', 1),
(292, 'users', 1, 'last_login_date', '2016-01-28 21:38:36', '2016-01-28 21:39:19', '2016-01-29 03:39:19', 1),
(293, 'users', 9, 'last_login_date', '2016-01-28 20:47:30', '2016-01-28 21:39:40', '2016-01-29 03:39:40', 9),
(294, 'orders', 100010, 'status', 'Delivered', 'In Concur', '2016-01-29 03:40:33', 9),
(295, 'orders', 100017, 'status', 'Pending', 'Ordered', '2016-01-29 03:40:39', 9),
(296, 'orders', 100017, 'status', 'Ordered', 'Delivered', '2016-01-29 03:41:33', 9),
(297, 'orders', 100017, 'status', 'Delivered', 'In Concur', '2016-01-29 03:41:40', 9),
(298, 'orders', 100017, 'status', 'In Concur', 'Ordered', '2016-01-29 03:46:36', 9),
(299, 'orders', 100017, 'status', 'Ordered', 'Delivered', '2016-01-29 03:46:41', 9),
(300, 'orders', 100017, 'status', 'Delivered', 'In Concur', '2016-01-29 03:46:53', 9),
(301, 'users', 1, 'last_login_date', '2016-01-28 21:39:19', '2016-01-28 21:47:11', '2016-01-29 03:47:11', 1),
(302, 'orders', 100018, 'NEW_ITEM', 'NEW_ITEM', 'Test1', '2016-01-29 03:47:45', 1),
(303, 'users', 9, 'last_login_date', '2016-01-28 21:39:40', '2016-01-28 21:51:46', '2016-01-29 03:51:46', 9),
(304, 'users', 1, 'last_login_date', '2016-01-28 21:47:11', '2016-01-28 22:11:00', '2016-01-29 04:11:00', 1),
(305, 'users', 20, 'NEW_ITEM', 'NEW_ITEM', 'sdgf', '2016-02-05 17:22:32', 20),
(306, 'users', 21, 'NEW_ITEM', 'NEW_ITEM', 'ghyvjghj', '2016-02-05 17:50:47', 21),
(307, 'users', 1, 'last_login_date', '2016-01-28 22:11:00', '2016-02-07 20:55:15', '2016-02-08 02:55:15', 1),
(308, 'users', 9, 'last_login_date', '2016-01-28 21:51:46', '2016-02-07 21:02:33', '2016-02-08 03:02:33', 9),
(309, 'orders', 100011, 'description', '&lt;&gt;&lt;?''[[];l]]]123456790-=@#$%^&amp;*()_(*&amp;^%$#&lt;&gt;?:&quot;{:{+P:L&lt;M&gt;:'''';;&quot;&quot;&quot;&quot;&quot;&quot;''''''dafmsdmfmdsm mdsa fmdmfmdsfmmsd fmmsfms mfmmdsfmdsmf', '&lt;&gt;&lt;?''[[];l]]]123456790-=@#$%^&amp;*()_(*&amp;^%$#&lt;&gt;?:&quot;{:{+P:L&lt;M&gt;:'''';;', '2016-02-08 03:03:16', 9),
(310, 'orders', 100011, 'description', '&lt;&gt;&lt;?''[[];l]]]123456790-=@#$%^&amp;*()_(*&amp;^%$#&lt;&gt;?:&quot;{:{+P:L&lt;M&gt;:'''';;', '&lt;&gt;&lt;?''[[];l]]]123456790-=@#$%', '2016-02-08 03:03:27', 9),
(311, 'orders', 100014, 'quantity', '1', '2', '2016-02-08 03:07:12', 9),
(312, 'orders', 100018, 'quantity', '1', '2', '2016-02-08 03:07:19', 9),
(313, 'orders', 100018, 'price', '11.00', '11.45', '2016-02-08 03:07:44', 9),
(314, 'orders', 100018, 'price', '11.45', '11.43', '2016-02-08 03:10:47', 9),
(315, 'orders', 100018, 'price', '11.43', '78.00', '2016-02-08 03:10:53', 9),
(316, 'users', 1, 'last_login_date', '2016-02-07 20:55:15', '2016-02-07 21:24:17', '2016-02-08 03:24:17', 1),
(317, 'vendors', 6, 'approved', '0', '2', '2016-02-08 03:25:52', 9),
(318, 'vendors', 15, 'NEW_ITEM', 'NEW_ITEM', 'test1', '2016-02-08 03:33:53', 1),
(319, 'orders', 100019, 'NEW_ITEM', 'NEW_ITEM', 'Test1', '2016-02-08 03:33:55', 1),
(320, 'vendors', 16, 'NEW_ITEM', 'NEW_ITEM', 'test1', '2016-02-08 03:35:03', 1),
(321, 'orders', 100020, 'NEW_ITEM', 'NEW_ITEM', 'Test1', '2016-02-08 03:35:05', 1),
(322, 'vendors', 17, 'NEW_ITEM', 'NEW_ITEM', 'test2', '2016-02-08 03:38:35', 1),
(323, 'orders', 100021, 'NEW_ITEM', 'NEW_ITEM', 'Test1', '2016-02-08 03:38:37', 1),
(324, 'vendors', 18, 'NEW_ITEM', 'NEW_ITEM', 'test3', '2016-02-08 03:39:59', 1),
(325, 'orders', 100022, 'NEW_ITEM', 'NEW_ITEM', 'Test1', '2016-02-08 03:40:01', 1),
(326, 'vendors', 19, 'NEW_ITEM', 'NEW_ITEM', 'test4', '2016-02-08 03:41:02', 1),
(327, 'orders', 100023, 'NEW_ITEM', 'NEW_ITEM', 'Test1', '2016-02-08 03:41:04', 1),
(328, 'vendors', 20, 'NEW_ITEM', 'NEW_ITEM', 'test5', '2016-02-08 03:41:45', 1),
(329, 'orders', 100024, 'NEW_ITEM', 'NEW_ITEM', 'Test1', '2016-02-08 03:41:47', 1),
(330, 'vendors', 21, 'NEW_ITEM', 'NEW_ITEM', 'test6', '2016-02-08 03:43:44', 1),
(331, 'orders', 100025, 'NEW_ITEM', 'NEW_ITEM', 'Test1', '2016-02-08 03:43:46', 1),
(332, 'vendors', 15, 'approved', '2', '0', '2016-02-08 03:52:45', 9),
(333, 'vendors', 16, 'approved', '2', '1', '2016-02-08 03:52:47', 9),
(334, 'vendors', 17, 'approved', '2', '1', '2016-02-08 03:52:56', 9),
(335, 'vendors', 19, 'approved', '2', '1', '2016-02-08 03:53:05', 9),
(336, 'vendors', 18, 'approved', '2', '1', '2016-02-08 03:53:07', 9),
(337, 'orders', 100025, 'status', 'Pending', 'Processing', '2016-02-08 04:06:10', 9),
(338, 'orders', 100025, 'status', 'Processing', 'Ordered', '2016-02-08 04:06:14', 9),
(339, 'orders', 100025, 'status', 'Ordered', 'Delivered', '2016-02-08 04:06:21', 9),
(340, 'orders', 100025, 'status', 'Delivered', 'Processing', '2016-02-08 04:06:30', 9),
(341, 'orders', 100008, 'status', 'Delivered', 'Archived', '2016-02-08 04:07:15', 9),
(342, 'orders', 100009, 'status', 'Delivered', 'In Concur', '2016-02-08 04:09:33', 9),
(343, 'orders', 100009, 'status', 'In Concur', 'Archived', '2016-02-08 04:09:43', 9),
(344, 'orders', 100015, 'status', 'Pending', 'Delivered', '2016-02-08 04:09:58', 9),
(345, 'orders', 100015, 'status', 'Delivered', 'Ordered', '2016-02-08 04:10:05', 9),
(346, 'orders', 100024, 'status', 'Pending', 'Ordered', '2016-02-08 04:12:30', 9),
(347, 'orders', 100024, 'status', 'Ordered', 'Delivered', '2016-02-08 04:12:36', 9),
(348, 'orders', 100024, 'status', 'Delivered', 'Processing', '2016-02-08 04:12:43', 9),
(349, 'orders', 100024, 'status', 'Processing', 'Ordered', '2016-02-08 04:12:46', 9),
(350, 'orders', 100024, 'status', 'Ordered', 'Delivered', '2016-02-08 04:12:52', 9),
(351, 'orders', 100024, 'status', 'Delivered', 'Ordered', '2016-02-08 04:12:58', 9),
(352, 'orders', 100024, 'status', 'Ordered', 'In Concur', '2016-02-08 04:13:07', 9),
(353, 'orders', 100024, 'status', 'In Concur', 'Canceled', '2016-02-08 04:13:13', 9),
(354, 'users', 1, 'last_login_date', '2016-02-07 21:24:17', '2016-02-15 08:27:00', '2016-02-15 14:27:00', 1),
(355, 'users', 9, 'last_login_date', '2016-02-07 21:02:33', '2016-02-15 08:27:30', '2016-02-15 14:27:30', 9),
(356, 'users', 9, 'last_login_date', '2016-02-15 08:27:30', '2016-02-15 09:29:06', '2016-02-15 15:29:06', 9),
(357, 'users', 16, 'password_reset', '0', '1', '2016-02-15 23:14:13', 16),
(358, 'users', 16, 'last_login_date', '2015-12-31 15:19:42', '2016-02-15 17:17:15', '2016-02-15 23:17:15', 16),
(359, 'users', 9, 'last_login_date', '2016-02-15 09:29:06', '2016-02-15 17:30:08', '2016-02-15 23:30:08', 9),
(360, 'users', 16, 'password_reset', '1', '0', '2016-02-15 23:50:27', 16),
(361, 'users', 16, 'last_login_date', '2016-02-15 17:17:15', '2016-02-15 17:50:33', '2016-02-15 23:50:33', 16),
(362, 'users', 9, 'last_login_date', '2016-02-15 17:30:08', '2016-02-15 17:51:21', '2016-02-15 23:51:21', 9),
(363, 'vendors', 7, 'account_number', '', 'd', '2016-02-16 00:06:14', 9),
(364, 'vendors', 7, 'approved', '0', '1', '2016-02-16 00:10:53', 9),
(365, 'vendors', 7, 'approved', '1', '0', '2016-02-16 00:11:00', 9),
(366, 'vendors', 21, 'approved', '2', '0', '2016-02-16 00:11:04', 9),
(367, 'users', 1, 'last_login_date', '2016-02-15 08:27:00', '2016-02-20 12:46:54', '2016-02-20 18:46:55', 1),
(368, 'users', 9, 'last_login_date', '2016-02-15 17:51:21', '2016-02-20 12:49:04', '2016-02-20 18:49:04', 9),
(369, 'users', 9, 'last_login_date', '2016-02-20 12:49:04', '2016-02-20 13:00:21', '2016-02-20 19:00:22', 9),
(370, 'vendors', 7, 'account_number', 'd', 'dfff', '2016-02-20 19:01:43', 9),
(371, 'vendors', 7, 'account_number', 'dfff', 'dfffcc', '2016-02-20 19:01:45', 9),
(372, 'vendors', 21, 'account_number', '', 'cc', '2016-02-20 19:01:47', 9),
(373, 'vendors', 22, 'NEW_ITEM', 'NEW_ITEM', 'svs', '2016-02-20 19:01:50', 9),
(374, 'vendors', 3, 'deleted', '0', '1', '2016-02-20 19:01:55', 9),
(375, 'users', 9, 'last_login_date', '2016-02-20 13:00:21', '2016-02-29 06:12:20', '2016-02-29 12:12:20', 9),
(376, 'users', 1, 'last_login_date', '2016-02-20 12:46:54', '2016-02-29 06:19:13', '2016-02-29 12:19:13', 1),
(377, 'users', 1, 'last_login_date', '2016-02-29 06:19:13', '2016-03-06 15:56:16', '2016-03-06 21:56:16', 1),
(378, 'users', 1, 'last_login_date', '2016-03-06 15:56:16', '2016-03-06 16:05:17', '2016-03-06 22:05:17', 1),
(379, 'orders', 100023, 'price', '78.00', '79.00', '2016-03-06 22:29:43', 1),
(380, 'orders', 100023, 'status', 'Pending', '', '2016-03-06 22:29:43', 1),
(381, 'orders', 100022, 'price', '78.00', '79.00', '2016-03-06 22:35:25', 1),
(382, 'users', 9, 'last_login_date', '2016-02-29 06:12:20', '2016-03-06 16:35:47', '2016-03-06 22:35:47', 9),
(383, 'orders', 100023, 'price', '79.00', '78.00', '2016-03-06 22:36:26', 9),
(384, 'orders', 100023, 'vendor_order_no', '', 'aaa', '2016-03-06 22:36:59', 9),
(385, 'orders', 100023, 'invoice_no', '', 'aaa', '2016-03-06 22:36:59', 9),
(386, 'orders', 100023, 'status', '', 'Delivered', '2016-03-06 22:36:59', 9),
(387, 'orders', 100023, 'vendor_order_no', 'aaa', 'aaaaaaa', '2016-03-06 22:37:14', 9),
(388, 'orders', 100023, 'status', 'Delivered', 'Pending', '2016-03-06 22:37:25', 9),
(389, 'orders', 100023, 'price', '78.00', '79.00', '2016-03-06 22:37:34', 1),
(390, 'orders', 100023, 'description', 'Test1', 'Test2', '2016-03-06 22:39:53', 1),
(391, 'orders', 100023, 'quantity', '2', '3', '2016-03-06 22:39:53', 1),
(392, 'orders', 100023, 'uom', 'test', 'test2', '2016-03-06 22:39:53', 1),
(393, 'orders', 100023, 'vendor', '19', '17', '2016-03-06 22:39:53', 1),
(394, 'orders', 100023, 'vendor_name', 'test4', 'test2', '2016-03-06 22:39:53', 1),
(395, 'orders', 100023, 'catalog_no', 'test', 'test2', '2016-03-06 22:39:53', 1),
(396, 'orders', 100023, 'weblink', 'http://test', 'http://test2', '2016-03-06 22:39:53', 1),
(397, 'orders', 100023, 'cost_center', '6', '1', '2016-03-06 22:39:53', 1),
(398, 'orders', 100023, 'project', '5', '2', '2016-03-06 22:39:53', 1),
(399, 'orders', 100023, 'comments', 'test', 'test2', '2016-03-06 22:39:53', 1),
(400, 'orders', 100023, 'quantity', '3', '2', '2016-03-06 22:40:10', 1),
(401, 'orders', 100023, 'status', 'Pending', 'Processing', '2016-03-06 22:40:25', 9),
(402, 'orders', 100023, 'status', 'Processing', 'Pending', '2016-03-06 22:48:47', 9),
(403, 'orders', 100023, 'status', 'Pending', 'Processing', '2016-03-06 22:48:55', 9),
(404, 'orders', 100023, 'status', 'Processing', 'Pending', '2016-03-06 22:50:17', 9),
(405, 'orders', 100023, 'status', 'Pending', 'Processing', '2016-03-06 22:50:26', 9),
(406, 'orders', 100023, 'status', 'Processing', 'Pending', '2016-03-06 22:51:31', 9),
(407, 'orders', 100023, 'catalog_no', 'test2', 'test3', '2016-03-06 22:51:41', 1),
(408, 'orders', 100023, 'catalog_no', 'test3', 'test2', '2016-03-06 22:51:47', 9),
(409, 'orders', 100023, 'status', 'Pending', 'Processing', '2016-03-06 22:51:47', 9),
(410, 'orders', 100022, 'catalog_no', 'test', 'test3', '2016-03-06 22:52:15', 1),
(411, 'orders', 100022, 'catalog_no', 'test3', 'test4', '2016-03-06 22:52:48', 1),
(412, 'users', 22, 'NEW_ITEM', 'NEW_ITEM', 'tetstt.ssng', '2016-03-06 22:58:12', 22),
(413, 'orders', 100026, 'NEW_ITEM', 'NEW_ITEM', 'Test1', '2016-03-06 23:02:37', 9),
(414, 'orders', 100027, 'NEW_ITEM', 'NEW_ITEM', 'Test1', '2016-03-06 23:04:17', 9),
(415, 'orders', 100028, 'NEW_ITEM', 'NEW_ITEM', 'Test1%5C%5C%5C%2F%2F%2F%2FDFD!%40%24%23%25%5E%26*()_%2B', '2016-03-06 23:06:40', 9),
(416, 'orders', 100029, 'NEW_ITEM', 'NEW_ITEM', 'Test1\\\\\\???////!@#@$%^&amp;*()_', '2016-03-06 23:07:52', 9),
(417, 'orders', 100030, 'NEW_ITEM', 'NEW_ITEM', 'Test1\\???////!@#@$%^&amp;*()_', '2016-03-06 23:15:23', 9),
(418, 'orders', 100031, 'NEW_ITEM', 'NEW_ITEM', 'Test1???////!@#@$%^&amp;*()_', '2016-03-06 23:35:54', 9),
(419, 'orders', 100032, 'NEW_ITEM', 'NEW_ITEM', 'Test1???////!@#@$%^&amp;*()_', '2016-03-06 23:38:17', 9),
(420, 'users', 1, 'last_login_date', '2016-03-06 16:05:17', '2016-03-06 17:44:22', '2016-03-06 23:44:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cost_centers`
--

CREATE TABLE IF NOT EXISTS `cost_centers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `date_added` datetime NOT NULL,
  `added_by_user_id` int(11) NOT NULL,
  `added_by_username` varchar(100) NOT NULL,
  `last_updated_date` datetime NULL DEFAULT NULL,
  `last_updated_by_user_id` int(11) NULL DEFAULT NULL,
  `last_updated_by_username` varchar(100) NULL DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `cost_centers`
--

INSERT INTO `cost_centers` (`id`, `name`, `date_added`, `added_by_user_id`, `added_by_username`, `last_updated_date`, `last_updated_by_user_id`, `last_updated_by_username`, `active`) VALUES
(1, '1234ZYZ', '0000-00-00 00:00:00', 0, '', '2015-12-29 17:19:43', 9, 'john.doe', 1),
(2, '9876ABCDs', '0000-00-00 00:00:00', 0, '', '2015-12-29 16:57:04', 9, 'john.doe', 1),
(3, 'et', '2015-12-29 17:15:55', 9, 'john.doe', '2015-12-29 19:27:45', 9, 'john.doe', 0),
(4, 'dddf', '2015-12-29 17:16:33', 9, 'john.doe', '2015-12-30 12:36:44', 9, 'john.doe', 0),
(5, 'dsfd', '2015-12-30 12:36:51', 9, 'john.doe', '2015-12-30 12:36:51', 9, 'john.doe', 0),
(6, 'testdf1', '2016-01-05 08:30:41', 9, 'john.doe', '2016-01-05 14:37:02', 9, 'john.doe', 1),
(7, '12', '2016-01-05 14:37:03', 9, 'john.doe', '2016-01-05 14:38:45', 9, 'john.doe', 1),
(8, '', '2016-01-14 14:54:22', 9, 'john.doe', '2016-01-18 07:42:30', 1, 'engin.yapici', 0);

--
-- Triggers `cost_centers`
--
DROP TRIGGER IF EXISTS `after_insert_cost_centers`;
DELIMITER //
CREATE TRIGGER `after_insert_cost_centers` AFTER INSERT ON `cost_centers`
 FOR EACH ROW INSERT INTO audit_trail 
            (`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
        VALUES 
            ("cost_centers", NEW.id, "NEW_ITEM", "NEW_ITEM", NEW.name, NEW.added_by_user_id)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `after_update_cost_centers`;
DELIMITER //
CREATE TRIGGER `after_update_cost_centers` AFTER UPDATE ON `cost_centers`
 FOR EACH ROW begin
IF OLD.name != NEW.name THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES 
        ('cost_centers', OLD.id, 'name', OLD.name, NEW.name, NEW.last_updated_by_user_id);
END IF;

IF OLD.active != NEW.active THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES 
        ('cost_centers', OLD.id, 'active', OLD.active, NEW.active, NEW.last_updated_by_user_id);
END IF;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(300) NOT NULL,
  `quantity` int(100) NOT NULL,
  `uom` varchar(100) NOT NULL,
  `vendor` varchar(100) NOT NULL,
  `vendor_name` varchar(200) NOT NULL,
  `catalog_no` varchar(200) NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `weblink` text NULL DEFAULT NULL,
  `cost_center` int(11) NOT NULL DEFAULT '0',
  `project` int(11) NOT NULL DEFAULT '0',
  `account_id` int(11) NULL DEFAULT NULL,
  `comments` varchar(1000) NULL DEFAULT NULL,
  `sds` varchar(3) NOT NULL,
  `vendor_order_no` varchar(100) NULL DEFAULT NULL,
  `invoice_no` varchar(100) NULL DEFAULT NULL,
  `requested_by_id` int(100) NOT NULL,
  `requested_by_username` varchar(100) NOT NULL,
  `requested_datetime` datetime NULL DEFAULT NULL,
  `item_needed_by_date` date NOT NULL,
  `last_updated_by_id` int(100) NOT NULL,
  `last_updated_by_username` varchar(100) NOT NULL,
  `last_updated_datetime` datetime NULL DEFAULT NULL,
  `status` varchar(100) NULL DEFAULT NULL,
  `status_updated_date` datetime NULL DEFAULT NULL,
  `status_updated_by_user_id` int(11) NULL DEFAULT NULL,
  `status_updated_by_username` varchar(100) NULL DEFAULT NULL,
  `ordered` int(1) NOT NULL DEFAULT '0',
  `ordered_date` datetime NULL DEFAULT NULL,
  `ordered_by_user_id` int(11) NULL DEFAULT NULL,
  `ordered_by_username` varchar(100) NULL DEFAULT NULL,
  `delivered` int(11) NULL DEFAULT NULL,
  `delivered_date` datetime NULL DEFAULT NULL,
  `delivered_by_user_id` int(11) NULL DEFAULT NULL,
  `delivered_by_username` varchar(100) NULL DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100033 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `description`, `quantity`, `uom`, `vendor`, `vendor_name`, `catalog_no`, `price`, `weblink`, `cost_center`, `project`, `account_id`, `comments`, `sds`, `vendor_order_no`, `invoice_no`, `requested_by_id`, `requested_by_username`, `requested_datetime`, `item_needed_by_date`, `last_updated_by_id`, `last_updated_by_username`, `last_updated_datetime`, `status`, `status_updated_date`, `status_updated_by_user_id`, `status_updated_by_username`, `ordered`, `ordered_date`, `ordered_by_user_id`, `ordered_by_username`, `delivered`, `delivered_date`, `delivered_by_user_id`, `delivered_by_username`, `deleted`) VALUES
(100001, 'Test', 1, 'test', '1', 'Fisher Scientific', 'test', '11.00', 'http://test', 2, 2, 0, 'test', '', '', '', 1, 'engin.yapici', '2016-01-05 14:52:21', '2016-06-01', 9, 'john.doe', '2016-01-11 08:48:23', 'Delivered', '2016-01-05 14:52:21', 1, 'engin.yapici', 0, '2016-01-11 08:47:29', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0),
(100002, 'Test', 1, 'test', '1', 'Fisher Scientific', 'test', '11.00', 'http://test', 2, 2, 0, 'test', '', '', '', 9, 'john.doe', '2016-01-05 14:53:11', '2016-01-13', 9, 'john.doe', '2016-01-11 08:58:35', 'Canceled', '2016-01-05 14:53:11', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100003, 'Test', 1, 'test', '8', 'test', 'test', '11.00', 'http://test', 2, 4, 0, 'test', '', '', '', 9, 'john.doe', '2016-01-06 12:53:26', '2016-01-27', 9, 'john.doe', '2016-01-11 09:33:41', 'Pending', '2016-01-06 12:53:26', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100004, 'Test', 1, 'test', '1', 'Fisher Scientific', 'test', '11.00', 'http://test', 7, 4, 0, 'test', '', '', '', 9, 'john.doe', '2016-01-06 13:34:29', '2016-08-02', 9, 'john.doe', '2016-01-11 08:39:25', 'Delivered', '2016-01-06 13:34:29', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100005, 'Test1kk', 1, 'test1', '3', 'VWR', 'test1', '3.00', 'http://test1', 1, 2, 0, 'test1', '', '1', '1', 9, 'john.doe', '2016-01-06 13:42:53', '2016-01-12', 9, 'john.doe', '2016-01-11 11:14:29', 'Delivered', '2016-01-06 13:42:53', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100006, 'Test', 1, 'test', '1', 'Fisher Scientific', 'test', '11.00', 'http://test', 2, 2, 0, 'test', '', '', '', 9, 'john.doe', '2016-01-11 12:46:04', '2016-01-12', 9, 'john.doe', '2016-01-11 12:46:04', 'Pending', '2016-01-11 12:46:04', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100007, 'Test1', 1, 'test', '2', 'Sigma-Aldrich', 'test', '11.00', 'http://test', 6, 1, 0, 'test', '', '', '', 9, 'john.doe', '2016-01-11 12:48:42', '2016-01-20', 9, 'john.doe', '2016-01-11 12:48:42', 'Pending', '2016-01-11 12:48:42', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100008, 'Test1', 1, 'test', '4', 'Bio-Rad', 'test', '11.00', 'http://test', 6, 1, 0, 'test', '', '', '', 9, 'john.doe', '2016-01-11 13:02:26', '2016-01-22', 9, 'john.doe', '2016-02-07 22:07:15', 'Archived', '2016-02-07 22:07:15', 9, 'john.doe', 0, '2016-01-14 12:34:07', 9, 'john.doe', 0, '2016-01-14 12:34:24', 9, 'john.doe', 0),
(100009, 'Test2', 1, 'test', '5', 'CisBio', 'test', '11.00', 'http://test', 2, 2, 0, 'test', '', '', '', 9, 'john.doe', '2016-01-11 13:20:16', '2016-01-14', 9, 'john.doe', '2016-02-07 22:09:43', 'Archived', '2016-02-07 22:09:43', 9, 'john.doe', 1, '2016-01-14 12:32:48', 9, 'john.doe', 1, '2016-01-14 12:33:29', 9, 'john.doe', 0),
(100010, 'test', 0, 'test', '1', 'Fisher Scientific', 'test', '0.00', 'http://dsfdsf', 7, 4, 0, 'test', '', '&lt;script&gt;alert('''');&lt;/script&gt;', '&lt;script&gt;alert('''');&lt;/script&gt;', 1, 'engin.yapici', '2016-01-11 13:21:27', '2016-01-13', 9, 'john.doe', '2016-01-28 21:40:33', 'In Concur', '2016-01-28 21:40:33', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0, '2016-01-14 09:38:57', 9, 'john.doe', 0),
(100018, 'Test1', 2, 'test', '10', 'eeeee', 'test', '78.00', 'http://test', 6, 5, 0, 'test', '', '', '', 1, 'engin.yapici', '2016-01-28 21:47:45', '2016-01-05', 9, 'john.doe', '2016-02-07 21:10:53', 'Pending', '2016-01-28 21:47:45', 1, 'engin.yapici', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100011, '&lt;&gt;&lt;?''[[];l]]]123456790-=@#$%', 0, 'Test2', '3', 'VWR', 'Test2', '0.00', 'http://www.amazon.com/dp/B018GTUWPO/ref=dvm_us_aw_cs_sh_ps_mitjggwin?pf_rd_m=ATVPDKIKX0DER&amp;pf_rd_s=desktop-hero-piv&amp;pf_rd_r=0X74PEFPAGK3MSTTFF3G&amp;pf_rd_t=36701&amp;pf_rd_p=2383061222&amp;pf_rd_i=desktop', 7, 4, 0, 'Test2', '', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', 9, 'john.doe', '2016-01-11 13:22:00', '2016-01-14', 9, 'john.doe', '2016-02-07 21:03:27', 'In Concur', '2016-01-28 21:27:34', 9, 'john.doe', 0, '2016-01-14 09:14:26', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0),
(100019, 'Test1', 2, 'test', '15', 'test1', 'test', '78.00', 'http://test', 6, 5, 0, 'test', '', '', '', 1, 'engin.yapici', '2016-02-07 21:33:53', '2016-02-24', 1, 'engin.yapici', '2016-02-07 21:33:53', 'Pending', '2016-02-07 21:33:53', 1, 'engin.yapici', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100012, 'ergrewg', 1, 'Test11', '2', 'Sigma-Aldrich', 'Test11', '14.00', 'http://dsfdsf1', 1, 0, 0, 'Test11', '', '', '', 9, 'john.doe', '2016-01-11 14:15:52', '2016-01-05', 9, 'john.doe', '2016-01-28 21:27:25', 'Archived', '2016-01-28 21:27:25', 9, 'john.doe', 0, '2016-01-14 09:10:33', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0),
(100013, 'ergrewg', 1, 'Test11', '2', 'Sigma-Aldrich', 'Test11', '14.00', 'http://dsfdsf1', 1, 1, 0, 'Test11', '', '', '', 1, 'engin.yapici', '2016-01-19 07:11:38', '2016-01-26', 1, 'engin.yapici', '2016-01-19 07:11:38', 'Pending', '2016-01-19 07:11:38', 1, 'engin.yapici', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100014, 'ergrewg', 2, 'Test11', '2', 'Sigma-Aldrich', 'Test11', '14.00', 'http://dsfdsf1', 1, 1, 0, 'Test11', '', '', '', 1, 'engin.yapici', '2016-01-19 07:14:25', '2016-01-13', 9, 'john.doe', '2016-02-07 21:09:30', 'Pending', '2016-01-19 07:14:25', 1, 'engin.yapici', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100015, 'ergrewg', 1, 'Test11', '2', 'Sigma-Aldrich', 'Test11', '14.00', 'http://dsfdsf1', 1, 1, 0, 'Test11', '', '', '', 1, 'engin.yapici', '2016-01-19 07:24:44', '2016-01-12', 9, 'john.doe', '2016-02-07 22:10:05', 'Ordered', '2016-02-07 22:10:05', 9, 'john.doe', 1, '2016-02-07 22:10:05', 9, 'john.doe', 0, '2016-02-07 22:09:58', 9, 'john.doe', 0),
(100016, 'ergrewg', 1, 'Test11', '2', 'Sigma-Aldrich', 'Test11', '14.00', 'http://dsfdsf1', 1, 1, 0, 'Test11', '', '', '', 1, 'engin.yapici', '2016-01-19 07:37:04', '2016-01-13', 9, 'john.doe', '2016-01-28 20:48:45', 'Ordered', '2016-01-28 20:48:45', 9, 'john.doe', 1, '2016-01-28 20:48:45', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0),
(100017, 'ergrewg', 1, 'Test11', '5', 'CisBio', 'Test11', '99912.00', 'http://dsfdsf1', 1, 1, 0, 'Test11', '', '', '', 1, 'engin.yapici', '2016-01-19 07:56:23', '2016-01-20', 9, 'john.doe', '2016-01-28 21:46:53', 'In Concur', '2016-01-28 21:46:53', 9, 'john.doe', 1, '2016-01-28 21:46:36', 9, 'john.doe', 1, '2016-01-28 21:46:41', 9, 'john.doe', 0),
(100020, 'Test1', 2, 'test', '16', 'test1', 'test', '78.00', 'http://test', 6, 5, 0, 'test', '', '', '', 1, 'engin.yapici', '2016-02-07 21:35:03', '2016-02-24', 1, 'engin.yapici', '2016-02-07 21:35:03', 'Pending', '2016-02-07 21:35:03', 1, 'engin.yapici', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100021, 'Test1', 2, 'test', '17', 'test2', 'test', '78.00', 'http://test', 6, 5, 0, 'test', '', '', '', 1, 'engin.yapici', '2016-02-07 21:38:35', '2016-02-02', 1, 'engin.yapici', '2016-02-07 21:38:35', 'Pending', '2016-02-07 21:38:35', 1, 'engin.yapici', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100022, 'Test1', 2, 'test', '18', 'test3', 'test4', '79.00', 'http://test', 6, 5, 0, 'test', 'Yes', '', '', 1, 'engin.yapici', '2016-02-07 21:39:59', '2016-02-23', 1, 'engin.yapici', '2016-03-06 17:45:39', 'Pending', '2016-02-07 21:39:59', 1, 'engin.yapici', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100023, 'Test2', 2, 'test2', '17', 'test2', 'test2', '79.00', 'http://test2', 1, 2, 0, 'test2', '', 'aaaaaaa', 'aaa', 1, 'engin.yapici', '2016-02-07 21:41:02', '2016-02-09', 9, 'john.doe', '2016-03-06 16:51:47', 'Processing', '2016-03-06 16:51:47', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0, '2016-03-06 16:36:59', 9, 'john.doe', 0),
(100024, 'Test1', 2, 'test', '20', 'test5', 'test', '78.00', 'http://test', 6, 5, 0, 'test', '', '', '', 1, 'engin.yapici', '2016-02-07 21:41:45', '2016-02-29', 9, 'john.doe', '2016-02-07 22:13:13', 'Canceled', '2016-02-07 22:13:13', 9, 'john.doe', 0, '2016-02-07 22:12:58', 9, 'john.doe', 0, '2016-02-07 22:12:52', 9, 'john.doe', 0),
(100025, 'Test1', 2, 'test', '21', 'test6', 'test', '78.00', 'http://test', 6, 5, 0, 'test', '', '', '', 1, 'engin.yapici', '2016-02-07 21:43:44', '2016-02-10', 9, 'john.doe', '2016-02-07 22:06:30', 'Processing', '2016-02-07 22:06:30', 9, 'john.doe', 0, '2016-02-07 22:06:14', 9, 'john.doe', 0, '2016-02-07 22:06:21', 9, 'john.doe', 0),
(100026, 'Test1', 2, 'test', '20', 'test5', 'test', '78.00', 'http://http%3A%2F%2Ftest', 6, 5, 0, 'test', '', '', '', 9, 'john.doe', '2016-03-06 17:02:37', '2016-03-01', 9, 'john.doe', '2016-03-06 17:02:37', 'Pending', '2016-03-06 17:02:37', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100027, 'Test1', 2, 'test', '20', 'test5', 'test', '78.00', 'http://http%3A%2F%2Fwww.amazon.com%2Fgp%2Fproduct%2F1455554790%2Fref%3Ds9_simh_gw_g14_i5_r%3Fie%3DUTF8%26fpl%3Dfresh%26pf_rd_m%3DATVPDKIKX0DER%26pf_rd_s%3Ddesktop-1%26pf_rd_r%3D0VEM7FS71K03XTPBGPYR%26pf_rd_t%3D36701%26pf_rd_p%3D2079475242%26pf_rd_i%3Ddesktop', 6, 5, 0, 'test', '', '', '', 9, 'john.doe', '2016-03-06 17:04:17', '2016-03-23', 9, 'john.doe', '2016-03-06 17:04:17', 'Pending', '2016-03-06 17:04:17', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100028, 'Test1%5C%5C%5C%2F%2F%2F%2FDFD!%40%24%23%25%5E%26*()_%2B', 2, 'test', '20', 'test5', 'test', '78.00', 'http://http%3A%2F%2Fwww.amazon.com%2Fgp%2Fproduct%2F1455554790%2Fref%3Ds9_simh_gw_g14_i5_r%3Fie%3DUTF8%26fpl%3Dfresh%26pf_rd_m%3DATVPDKIKX0DER%26pf_rd_s%3Ddesktop-1%26pf_rd_r%3D0VEM7FS71K03XTPBGPYR%26pf_rd_t%3D36701%26pf_rd_p%3D2079475242%26pf_rd_i%3Ddesktop', 6, 5, 0, 'test', '', '', '', 9, 'john.doe', '2016-03-06 17:06:40', '2016-03-17', 9, 'john.doe', '2016-03-06 17:06:40', 'Pending', '2016-03-06 17:06:40', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100029, 'Test1\\\\\\???////!@#@$%^&amp;*()_', 2, 'test', '20', 'test5', 'test', '78.00', 'http://www.amazon.com/gp/product/1455554790/ref=s9_simh_gw_g14_i5_r?ie=UTF8&amp;fpl=fresh&amp;pf_rd_m=ATVPDKIKX0DER&amp;pf_rd_s=desktop-1&amp;pf_rd_r=0VEM7FS71K03XTPBGPYR&amp;pf_rd_t=36701&amp;pf_rd_p=2079475242&amp;pf_rd_i=desktop', 6, 5, 0, 'test', '', '', '', 9, 'john.doe', '2016-03-06 17:07:52', '2016-03-17', 9, 'john.doe', '2016-03-06 17:07:52', 'Pending', '2016-03-06 17:07:52', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100030, 'Test1\\???////!@#@$%^&amp;*()_', 2, 'test', '20', 'test5', 'test', '78.00', 'http://www.amazon.com/gp/product/1455554790/ref=s9_simh_gw_g14_i5_r?ie=UTF8&amp;fpl=fresh&amp;pf_rd_m=ATVPDKIKX0DER&amp;pf_rd_s=desktop-1&amp;pf_rd_r=0VEM7FS71K03XTPBGPYR&amp;pf_rd_t=36701&amp;pf_rd_p=2079475242&amp;pf_rd_i=desktop', 6, 5, 0, 'test', '', '', '', 9, 'john.doe', '2016-03-06 17:15:23', '2016-03-10', 9, 'john.doe', '2016-03-06 17:15:23', 'Pending', '2016-03-06 17:15:23', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100031, 'Test1???////!@#@$%^&amp;*()_', 2, 'test', '20', 'test5', 'test', '78.00', 'http://www.amazon.com/gp/product/1455554790/ref=s9_simh_gw_g14_i5_r?ie=UTF8&amp;fpl=fresh&amp;pf_rd_m=ATVPDKIKX0DER&amp;pf_rd_s=desktop-1&amp;pf_rd_r=0VEM7FS71K03XTPBGPYR&amp;pf_rd_t=36701&amp;pf_rd_p=2079475242&amp;pf_rd_i=desktop', 6, 5, 0, 'test', 'Yes', '', '', 9, 'john.doe', '2016-03-06 17:35:54', '2016-03-16', 9, 'john.doe', '2016-03-06 17:40:19', 'Pending', '2016-03-06 17:35:54', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0),
(100032, 'Test1???////!@#@$%^&amp;*()_', 2, 'test', '20', 'test5', 'test', '78.00', 'http://www.amazon.com/gp/product/1455554790/ref=s9_simh_gw_g14_i5_r?ie=UTF8&amp;fpl=fresh&amp;pf_rd_m=ATVPDKIKX0DER&amp;pf_rd_s=desktop-1&amp;pf_rd_r=0VEM7FS71K03XTPBGPYR&amp;pf_rd_t=36701&amp;pf_rd_p=2079475242&amp;pf_rd_i=desktop', 6, 5, 0, 'test', 'N/A', '', '', 9, 'john.doe', '2016-03-06 17:38:17', '2016-03-08', 9, 'john.doe', '2016-03-06 17:44:11', 'Pending', '2016-03-06 17:38:17', 9, 'john.doe', 0, '0000-00-00 00:00:00', 0, '', 0, '0000-00-00 00:00:00', 0, '', 0);

--
-- Triggers `orders`
--
DROP TRIGGER IF EXISTS `after_insert_orders`;
DELIMITER //
CREATE TRIGGER `after_insert_orders` AFTER INSERT ON `orders`
 FOR EACH ROW INSERT INTO audit_trail 
            (`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
        VALUES 
            ("orders", NEW.id, "NEW_ITEM", "NEW_ITEM", NEW.description, NEW.requested_by_id)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `after_update_orders`;
DELIMITER //
CREATE TRIGGER `after_update_orders` AFTER UPDATE ON `orders`
 FOR EACH ROW begin
IF OLD.description != NEW.description THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("orders", OLD.id, "description", OLD.description, NEW.description, NEW.last_updated_by_id);
END IF;

IF OLD.quantity != NEW.quantity THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("orders", OLD.id, "quantity", OLD.quantity, NEW.quantity, NEW.last_updated_by_id);
END IF;

IF OLD.uom != NEW.uom THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("orders", OLD.id, "uom", OLD.uom, NEW.uom, NEW.last_updated_by_id);
END IF;

IF OLD.vendor != NEW.vendor THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("orders", OLD.id, "vendor", OLD.vendor, NEW.vendor, NEW.last_updated_by_id);
END IF;

IF OLD.vendor_name != NEW.vendor_name THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("orders", OLD.id, "vendor_name", OLD.vendor_name, NEW.vendor_name, NEW.last_updated_by_id);
END IF;

IF OLD.catalog_no != NEW.catalog_no THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("orders", OLD.id, "catalog_no", OLD.catalog_no, NEW.catalog_no, NEW.last_updated_by_id);
END IF;

IF OLD.price != NEW.price THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("orders", OLD.id, "price", OLD.price, NEW.price, NEW.last_updated_by_id);
END IF;

IF OLD.weblink != NEW.weblink THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("orders", OLD.id, "weblink", OLD.weblink, NEW.weblink, NEW.last_updated_by_id);
END IF;

IF OLD.cost_center != NEW.cost_center THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("orders", OLD.id, "cost_center", OLD.cost_center, NEW.cost_center, NEW.last_updated_by_id);
END IF;

IF OLD.project != NEW.project THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("orders", OLD.id, "project", OLD.project, NEW.project, NEW.last_updated_by_id);
END IF;

IF OLD.comments != NEW.comments THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("orders", OLD.id, "comments", OLD.comments, NEW.comments, NEW.last_updated_by_id);
END IF;

IF OLD.vendor_order_no != NEW.vendor_order_no THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("orders", OLD.id, "vendor_order_no", OLD.vendor_order_no, NEW.vendor_order_no, NEW.last_updated_by_id);
END IF;

IF OLD.invoice_no != NEW.invoice_no THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("orders", OLD.id, "invoice_no", OLD.invoice_no, NEW.invoice_no, NEW.last_updated_by_id);
END IF;

IF OLD.status != NEW.status THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("orders", OLD.id, "status", OLD.status, NEW.status, NEW.last_updated_by_id);
END IF;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `number` varchar(200) NOT NULL,
  `date_added` datetime NOT NULL,
  `added_by_user_id` int(11) NOT NULL,
  `added_by_username` varchar(100) NOT NULL,
  `last_updated_date` datetime NOT NULL,
  `last_updated_by_user_id` int(11) NOT NULL,
  `last_updated_by_username` varchar(100) NOT NULL,
  `active` int(11) NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `number`, `date_added`, `added_by_user_id`, `added_by_username`, `last_updated_date`, `last_updated_by_user_id`, `last_updated_by_username`, `active`) VALUES
(1, 'Project3', '12345ZXCVB1', '0000-00-00 00:00:00', 1, 'engin.yapici', '2015-12-28 07:31:23', 9, 'john.doe', 1),
(2, 'Project2', '98765ABVCXf', '0000-00-00 00:00:00', 2, 'john.doe', '2015-12-28 08:02:02', 9, 'john.doe', 1),
(3, 'Ggggg', 'test1', '2015-12-28 08:12:31', 9, 'john.doe', '2016-01-05 14:36:39', 9, 'john.doe', 1),
(4, 'Project1', 'a', '2016-01-05 14:36:41', 9, 'john.doe', '2016-01-05 14:36:41', 9, 'john.doe', 1),
(5, 'Office Supplies', '', '2016-01-14 14:54:13', 9, 'john.doe', '2016-01-28 21:22:53', 9, 'john.doe', 1);

--
-- Triggers `projects`
--
DROP TRIGGER IF EXISTS `after_insert_projects`;
DELIMITER //
CREATE TRIGGER `after_insert_projects` AFTER INSERT ON `projects`
 FOR EACH ROW INSERT INTO audit_trail 
            (`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
        VALUES 
            ("projects", NEW.id, "NEW_ITEM", "NEW_ITEM", NEW.name, NEW.added_by_user_id)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `after_update_projects`;
DELIMITER //
CREATE TRIGGER `after_update_projects` AFTER UPDATE ON `projects`
 FOR EACH ROW begin
IF OLD.name != NEW.name THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("projects", OLD.id, "name", OLD.name, NEW.name, NEW.last_updated_by_user_id);
END IF;

IF OLD.number != NEW.number THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("projects", OLD.id, "number", OLD.number, NEW.number, NEW.last_updated_by_user_id);
END IF;

IF OLD.active != NEW.active THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("projects", OLD.id, "active", OLD.active, NEW.active, NEW.last_updated_by_user_id);
END IF;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NULL DEFAULT NULL,
  `last_name` varchar(100) NULL DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NULL DEFAULT NULL,
  `password` varchar(300) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activation` varchar(100) NULL DEFAULT NULL,
  `last_login_date` datetime NULL DEFAULT NULL,
  `account_status` int(11) NOT NULL DEFAULT '0',
  `user_type` int(1) NOT NULL DEFAULT '0',
  `forgot_password` varchar(100) NOT NULL DEFAULT '0',
  `password_reset` int(11) NOT NULL DEFAULT '0',
  `last_updated_date` datetime NULL DEFAULT NULL,
  `last_updated_by_user_id` int(11) NULL DEFAULT NULL,
  `last_updated_by_username` varchar(200) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `phone`, `password`, `registration_date`, `activation`, `last_login_date`, `account_status`, `user_type`, `forgot_password`, `password_reset`, `last_updated_date`, `last_updated_by_user_id`, `last_updated_by_username`) VALUES
(1, 'Engin', 'Yapici', 'engin.yapici', 'engin.yapici@example.com', '1-555-555-555', '$2y$10$Oy1V/pmNd96MdqWvjdPyMuwYyMW3FF6QvVLPcJ1TemaaTX.YFodUG', '2014-11-04 16:45:16', '', '2016-03-06 17:44:22', 1, 0, '1G2z8IZcmNVvASrDiOjRp5U64oXeLBFbqhy7HPWaEQ903TdfwYxklnMJsuCg', 0, '2016-01-18 07:23:36', 9, 'john.doe'),
(9, 'John', 'Doe', 'john.doe', 'john.doe@example.com', '1-111-111-1111', '$2y$10$2TdVIQym8TUWkk1xhtBI5OOA9Z6xftytSAhrM.kcs64If4b5AjG3e', '2015-10-23 20:27:20', '', '2016-03-06 16:35:47', 1, 1, '0', 0, '2015-12-30 22:04:45', 9, 'john.doe'),
(10, '', '', 'dd', 'engin.yapici@gmail.com', '1', '$2y$10$I/aR3Nuel3wMqpPvPf.vJuagFfegGEULPFC9YaPHrAClIL9ictIF2', '2015-12-31 18:47:44', '', '2015-12-31 12:47:44', 1, 2, '0', 0, '2016-01-05 14:35:56', 9, 'john.doe'),
(11, '', '', 'd', 'd@example.com', '', '$2y$10$6wBJIejEnJGz1L2cz8m04OhcLXk36V5hpUG9hzV0fNKgifkqIMmb6', '2015-12-31 18:50:00', '', '2015-12-31 12:50:00', 1, 0, '0', 0, '2016-01-11 13:23:19', 1, 'engin.yapici'),
(12, '', '', 'engin.yapici', 'engin.yapic1i-dfdfdfdfdfdfdwfrewr@example.com', '', '$2y$10$xxrdZKmxMuzUbbZC9jCIlOzYJ/qADQpf85cbO8aRJv7Cwr3c/I6Ea', '2015-12-31 18:52:19', '', '2015-12-31 12:52:19', 1, 0, '0', 0, '2016-01-03 16:43:32', 9, 'john.doe'),
(13, '', '', 'engin.yapici', 'engin.yapicei@example.com', '', '$2y$10$cho5xb/3avY/uWb//YgmpeUv8CJcQFFtaL3FONdCEwENo2iZhDHYi', '2015-12-31 19:15:47', 'xrLBHnQfeZS3jW0zpGimqKAY7DckJbyguIR2O1C8MsdTVNw9h6FaPv4ltXUE', '2015-12-31 13:15:46', 1, 0, '0', 0, '2016-01-03 16:40:58', 9, 'john.doe'),
(14, '', '', 'engin.yapici', 'engin.yapdici@etc.com', '', '$2y$10$kfi8PnkXOcNoTgaort8OfeFwKnp/t7y/q36oFBw4poVEWb0liD0DO', '2015-12-31 20:43:44', 'cn2isP5XAOUqG0dIpDfxN4Er7W1a9B6zYJwLCvlSZhytKo3ubMVkeQ8TmgjH', '2015-12-31 14:43:44', 1, 0, '0', 0, '0000-00-00 00:00:00', 0, ''),
(15, '', '', 'engin.yapici', 'd', '', '$2y$10$mzACYRb4Rg9/BJT.Uwep4eQi5FCFylbk.eCEcd4nrtYifnv2Zj0oC', '2015-12-31 21:16:02', 'Mz3CSph9m7iEGNuAQjaVOKB84oITrHqknyF5c06fJUdvsYb2ZwXxelWLgDt1', '2015-12-31 15:16:02', 1, 0, '0', 0, '0000-00-00 00:00:00', 0, ''),
(16, '', '', 'engin.yapici', 'g@example.com', '', '$2y$10$.GyPlt1DxsQJhlpLc4wI/eR1lNqoGeB.23Y/TiUO3bKw0TrALa12m', '2015-12-31 21:19:42', 'dr0bRBSHWMLXxZlQin7cD1PsjGu5K2E9hpNFVAUzt6vmeIT8fJq4C3aYywko', '2016-02-15 17:50:33', 1, 0, '0', 0, '0000-00-00 00:00:00', 0, ''),
(17, '', '', 'engin.yapici', 'engin.yapici@etc.com', '', '$2y$10$LKYBNq4jmLiG8gCL52l5D.exRtZyAuofHN/k/f.34Vd10LL2RzlAS', '2015-12-31 21:24:32', '5QAZyT3SkcJKsWBqNOGadV0gIL2vf8uX7z9ploimnw4D1MHbeRYxhPEUjCrF', '2015-12-31 15:24:32', 1, 0, '0', 0, '2016-01-11 13:23:22', 1, 'engin.yapici'),
(18, '', '', 'test', 'test@example.com', '', '$2y$10$LhWQ6sU4sZnUn6EW7YLKjeCN7.bCNJq0nSzDaD/ehnZqHDGlBBoCi', '2016-01-06 17:35:00', '1LuTtWBrR2w5I8koZDAeV0GcKJX9YsxmfpNFiqHUE7nO4hMjzPbSQvg6dyal', '2016-01-06 11:35:00', 0, 0, '0', 0, '0000-00-00 00:00:00', 0, ''),
(19, '', '', 's', 's@example.com', 'dsfds/fdfdf//', '$2y$10$hp73TyPp6lpcrUJFalz6KepZaLdxwILVPUxwBZ/O9pwJl.hwjl23C', '2016-01-11 17:54:12', 'uHT83vjlKXr1sgWhC0VUJYGIpORmxb5dFNZaDQkSiAczMP24ew67Bnoy9qLE', '2016-01-11 11:54:12', 0, 0, '0', 0, '2016-01-14 14:54:47', 9, 'john.doe'),
(20, '', '', 'sdgf', 'sdgf@example.com', '', '$2y$10$TjeVS1sPWAmJGFup.PhfwOmtw8aPtQ0HhCg6CdJlVM/j1r9GV0mne', '2016-02-05 17:22:32', '9E0CqGwRJ5FyLHXi81ZjaDuBofcMkhPVr6gbm3TdvpslWKn2zANtUeSQIY47', '2016-02-05 11:22:32', 0, 0, '0', 0, '0000-00-00 00:00:00', 0, ''),
(21, '', '', 'ghyvjghj', 'ghyvjghj@example.com', '', '$2y$10$KrQ6ZlKVPQV2AxU.o06V3.Pj6YpPriw2d8eCJG692bPFAaglOMue6', '2016-02-05 17:50:47', 'P5ZvDfh1jF4GHneQBO239JrNgLAUpEb0qiSYWts7oClXku6aRmzw8IdKTyxM', '2016-02-05 11:50:47', 0, 0, '0', 0, '0000-00-00 00:00:00', 0, ''),
(22, '', '', 'tetstt.ssng', 'tetstt.ssng@example.com', '', '$2y$10$5fKCfmIBg8.g3GaB55DaY.3pM6QDBg9mUM35bS9U0IpYQgXLGmWaC', '2016-03-06 22:58:12', '0hBV3PJLNAutnKmOxGS7zg68bsMv5fkFWT1c2jEYDURCi4rawlHIoyqepQXZ', '2016-03-06 16:58:11', 0, 0, '0', 0, '0000-00-00 00:00:00', 0, '');

--
-- Triggers `users`
--
DROP TRIGGER IF EXISTS `after_insert_users`;
DELIMITER //
CREATE TRIGGER `after_insert_users` AFTER INSERT ON `users`
 FOR EACH ROW INSERT INTO audit_trail 
            (`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
        VALUES 
            ("users", NEW.id, "NEW_ITEM", "NEW_ITEM", NEW.username, NEW.id)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `after_update_users`;
DELIMITER //
CREATE TRIGGER `after_update_users` AFTER UPDATE ON `users`
 FOR EACH ROW begin
IF OLD.phone != NEW.phone THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("users", OLD.id, "phone", OLD.phone, NEW.phone, NEW.last_updated_by_user_id);
END IF;

IF OLD.account_status != NEW.account_status THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("users", OLD.id, "account_status", OLD.account_status, NEW.account_status, NEW.last_updated_by_user_id);
END IF;

IF OLD.user_type != NEW.user_type THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("users", OLD.id, "user_type", OLD.user_type, NEW.user_type, NEW.last_updated_by_user_id);
END IF;

IF OLD.last_login_date != NEW.last_login_date THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("users", OLD.id, "last_login_date", OLD.last_login_date, NEW.last_login_date, NEW.id);
END IF;

IF OLD.password_reset != NEW.password_reset THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("users", OLD.id, "password_reset", OLD.password_reset, NEW.password_reset, NEW.id);
END IF;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE IF NOT EXISTS `vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `phone` varchar(100) NULL DEFAULT NULL,
  `address` varchar(100) NULL DEFAULT NULL,
  `website` varchar(100) NULL DEFAULT NULL,
  `contact_person` varchar(200) NULL DEFAULT NULL,
  `account_number` varchar(200) NULL DEFAULT NULL,
  `approved` int(1) NOT NULL DEFAULT '2',
  `date_added` datetime NOT NULL,
  `added_by_user_id` int(11) NOT NULL,
  `added_by_username` varchar(100) NOT NULL,
  `last_updated_by_user_id` int(11) NULL DEFAULT NULL,
  `last_updated_by_username` varchar(100) NULL DEFAULT NULL,
  `last_updated_date` datetime NULL DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `deleted_date` datetime NULL DEFAULT NULL,
  `deleted_by_user_id` int(11) NULL DEFAULT NULL,
  `deleted_by_username` varchar(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `phone`, `address`, `website`, `contact_person`, `account_number`, `approved`, `date_added`, `added_by_user_id`, `added_by_username`, `last_updated_by_user_id`, `last_updated_by_username`, `last_updated_date`, `deleted`, `deleted_date`, `deleted_by_user_id`, `deleted_by_username`) VALUES
(1, 'Fisher Scientific', '1-800-766-7000', '4500 Turnberry Dr, Hanover Park, IL 60133', 'https://www.fishersci.com/', 'Jane Doe', 'F123456789', 1, '0000-00-00 00:00:00', 0, '', 9, 'john.doe', '2015-12-24 12:25:04', 0, '2015-12-27 19:54:25', 9, 'john.doe'),
(2, 'Sigma-Aldrich', '1-800-325-3010', '6000 N Teutonia Ave, Milwaukee, WI 53209', 'http://www.sigmaaldrich.com/', '', 'S987654321', 1, '0000-00-00 00:00:00', 0, '', 9, 'john.doe', '2015-12-19 21:51:28', 0, '2015-12-27 19:54:25', 9, 'john.doe'),
(3, 'VWR', '1-800-932-5000', '800 East Fabyan Parkway, Batavia, IL 60510', 'https://us.vwr.com/', '', 'V1234567890', 1, '0000-00-00 00:00:00', 0, '', 9, 'john.doe', '2015-12-19 21:51:28', 1, '2016-02-20 13:01:55', 9, 'john.doe'),
(4, 'Bio-Rad', '1-510-741-1000', '2000 Alfred Nobel Drive Hercules, California 94547 USA', 'http://www.bio-rad.com', '', 'B9876543210', 1, '2015-12-17 07:44:53', 1, 'engin.yapici', 9, 'john.doe', '2015-12-24 12:24:52', 0, '0000-00-00 00:00:00', 0, ''),
(5, 'CisBio', '1-888-963-4567', '135 South Road Bedford, MA 01730, USA', 'http://www.cisbio.com/', '', 'C1234567890', 1, '2015-12-17 07:46:45', 1, 'engin.yapici', 9, 'john.doe', '2015-12-31 16:58:29', 0, '0000-00-00 00:00:00', 0, ''),
(6, 'aaaaa', 'test', '', 'http://www.amazon.com/dp/B018GTUWPO/ref=dvm_us_aw_cs_sh_ps_mitjggwin?pf_rd_m=ATVPDKIKX0DER', '', '', 2, '2016-01-06 10:28:17', 9, 'john.doe', 9, 'john.doe', '2016-01-28 21:30:57', 0, '0000-00-00 00:00:00', 0, ''),
(7, 'bbbbb', 'fgf', '', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '', 'dfffcc', 0, '2016-01-06 10:29:28', 9, 'john.doe', 9, 'john.doe', '2016-02-20 13:01:45', 0, '0000-00-00 00:00:00', 0, ''),
(8, 'ccccc', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', 1, '2016-01-06 12:53:26', 9, 'john.doe', 9, 'john.doe', '2016-01-28 21:07:36', 0, '0000-00-00 00:00:00', 0, ''),
(9, 'ddddd', '&lt;script&gt;alert('''');&lt;/script&gt;', '&lt;script&gt;alert('''');&lt;/script&gt;', 'http://&lt;script&gt;alert('''');&lt;/script&gt;', '&lt;script&gt;alert('''');&lt;/script&gt;', '&lt;script&gt;alert('''');&lt;/script&gt;', 1, '2016-01-11 14:19:40', 9, 'john.doe', 9, 'john.doe', '2016-01-28 21:07:38', 0, '0000-00-00 00:00:00', 0, ''),
(10, 'eeeee', '&lt;script&gt;alert('''');&lt;/script&gt;', '&lt;script&gt;alert('''');&lt;/script&gt;', 'http://&lt;script&gt;alert('''');&lt;/script&gt;', '&lt;script&gt;alert('''');&lt;/script&gt;', '&lt;script&gt;alert('''');&lt;/script&gt;', 1, '2016-01-11 14:23:39', 9, 'john.doe', 9, 'john.doe', '2016-01-28 21:07:40', 0, '0000-00-00 00:00:00', 0, ''),
(11, 'ffffff', '&lt;script&gt;alert('''');&lt;/script&gt;', '&lt;script&gt;alert('''');&lt;/script&gt;', 'http://&lt;script&gt;alert('''');&lt;/script&gt;', '&lt;script&gt;alert('''');&lt;/script&gt;', '&lt;script&gt;alert('''');&lt;/script&gt;', 1, '2016-01-11 14:26:59', 9, 'john.doe', 9, 'john.doe', '2016-01-28 21:07:42', 0, '0000-00-00 00:00:00', 0, ''),
(12, 'ggggg', '&lt;script&gt;alert('''');&lt;/script&gt;', '&lt;script&gt;alert('''');&lt;/script&gt;', 'http://&lt;script&gt;alert('''');&lt;/script&gt;', '&lt;script&gt;alert('''');&lt;/script&gt;', '&lt;script&gt;alert('''');&lt;/script&gt;', 1, '2016-01-11 14:27:09', 9, 'john.doe', 9, 'john.doe', '2016-01-28 21:07:45', 0, '0000-00-00 00:00:00', 0, ''),
(13, 'hhhhh', 'SFDGY&amp;RGEFH', '', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^', '', '', 1, '2016-01-11 14:28:27', 9, 'john.doe', 9, 'john.doe', '2016-01-28 21:07:46', 0, '0000-00-00 00:00:00', 0, ''),
(14, 'jjjjjj', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', 'http://&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', '&lt;&gt;&quot;'''''''';;''''p]],;''/!@#$%^&amp;*()_+_)(*&amp;^%$#@', 1, '2016-01-14 14:53:56', 9, 'john.doe', 9, 'john.doe', '2016-01-28 21:07:50', 0, '0000-00-00 00:00:00', 0, ''),
(15, 'test1', 'test1', '', '', '', '', 0, '2016-02-07 21:33:53', 1, 'engin.yapici', 9, 'john.doe', '2016-02-07 21:52:45', 0, '0000-00-00 00:00:00', 0, ''),
(16, 'test1', 'test1', '', '', '', '', 1, '2016-02-07 21:35:03', 1, 'engin.yapici', 9, 'john.doe', '2016-02-07 21:52:47', 0, '0000-00-00 00:00:00', 0, ''),
(17, 'test2', 'test2', '', '', '', '', 1, '2016-02-07 21:38:35', 1, 'engin.yapici', 9, 'john.doe', '2016-02-07 21:52:56', 0, '0000-00-00 00:00:00', 0, ''),
(18, 'test3', 'test3', '', '', '', '', 1, '2016-02-07 21:39:59', 1, 'engin.yapici', 9, 'john.doe', '2016-02-07 21:53:07', 0, '0000-00-00 00:00:00', 0, ''),
(19, 'test4', 'test4', '', '', '', '', 1, '2016-02-07 21:41:02', 1, 'engin.yapici', 9, 'john.doe', '2016-02-07 21:53:05', 0, '0000-00-00 00:00:00', 0, ''),
(20, 'test5', 'test5', '', '', '', '', 2, '2016-02-07 21:41:45', 1, 'engin.yapici', 1, 'engin.yapici', '2016-02-07 21:41:45', 0, '0000-00-00 00:00:00', 0, ''),
(21, 'test6', 'test6', '', '', '', 'cc', 0, '2016-02-07 21:43:44', 1, 'engin.yapici', 9, 'john.doe', '2016-02-20 13:01:47', 0, '0000-00-00 00:00:00', 0, ''),
(22, 'svs', 'vbscb', 'df', 'http://vfscb', 'fdb', 'df', 1, '2016-02-20 13:01:50', 9, 'john.doe', 9, 'john.doe', '2016-02-20 13:01:50', 0, '0000-00-00 00:00:00', 0, '');

--
-- Triggers `vendors`
--
DROP TRIGGER IF EXISTS `after_insert_vendors`;
DELIMITER //
CREATE TRIGGER `after_insert_vendors` AFTER INSERT ON `vendors`
 FOR EACH ROW INSERT INTO audit_trail 
            (`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
        VALUES 
            ("vendors", NEW.id, "NEW_ITEM", "NEW_ITEM", NEW.name, NEW.added_by_user_id)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `after_update_vendors`;
DELIMITER //
CREATE TRIGGER `after_update_vendors` AFTER UPDATE ON `vendors`
 FOR EACH ROW begin
IF OLD.name != NEW.name THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("vendors", OLD.id, "name", OLD.name, NEW.name, NEW.last_updated_by_user_id);
END IF;

IF OLD.phone != NEW.phone THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("vendors", OLD.id, "phone", OLD.phone, NEW.phone, NEW.last_updated_by_user_id);
END IF;

IF OLD.address != NEW.address THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("vendors", OLD.id, "address", OLD.address, NEW.address, NEW.last_updated_by_user_id);
END IF;

IF OLD.website != NEW.website THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("vendors", OLD.id, "website", OLD.website, NEW.website, NEW.last_updated_by_user_id);
END IF;

IF OLD.contact_person != NEW.contact_person THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("vendors", OLD.id, "contact_person", OLD.contact_person, NEW.contact_person, NEW.last_updated_by_user_id);
END IF;

IF OLD.account_number != NEW.account_number THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("vendors", OLD.id, "account_number", OLD.account_number, NEW.account_number, NEW.last_updated_by_user_id);
END IF;

IF OLD.approved != NEW.approved THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("vendors", OLD.id, "approved", OLD.approved, NEW.approved, NEW.last_updated_by_user_id);
END IF;

IF OLD.deleted != NEW.deleted THEN
  INSERT INTO audit_trail 
  		(`changed_table`, `changed_item_id`, `changed_field_name`, `old_value`, `new_value`, `user_id`) 
  VALUES
        ("vendors", OLD.id, "deleted", OLD.deleted, NEW.deleted, NEW.deleted_by_user_id);
END IF;
end
//
DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
