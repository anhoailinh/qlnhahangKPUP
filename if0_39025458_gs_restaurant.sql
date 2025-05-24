-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql311.byetcluster.com
-- Generation Time: May 24, 2025 at 02:24 AM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_39025458_gs_restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `ban`
--

CREATE TABLE `ban` (
  `id` int(11) NOT NULL,
  `ten_ban` varchar(50) NOT NULL,
  `trang_thai` enum('trong','da_dat') DEFAULT 'trong'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ban`
--

INSERT INTO `ban` (`id`, `ten_ban`, `trang_thai`) VALUES
(1, 'A1', 'da_dat'),
(2, 'A2', 'trong'),
(3, 'A3', 'da_dat'),
(4, 'B1', 'trong'),
(5, 'B2', 'trong'),
(6, 'B3', 'trong'),
(7, 'C1', 'trong'),
(8, 'C2', 'trong'),
(9, 'C3', 'trong'),
(11, 'D2', 'trong'),
(12, 'Bàn D3', '');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `tieude` text DEFAULT NULL,
  `mota` text DEFAULT NULL,
  `noidung` text DEFAULT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `tieude`, `mota`, `noidung`, `img`) VALUES
(1, 'Th?t Bò M? Nh?p Kh?u – ?n Bao Nhiêu C?ng Có!', 'Th?c khách mê th?t không th? b? l? món bò M? lát m?ng, m?m tan trên b?p n??ng.\r\n? Có m?t trong t?t c? các su?t buffet t? 199K tr? lên!', 'v', 'blog1.jpg'),
(2, '?u ?ãi M?i Tu?n – Buffet L?u N??ng Ch? T? 149K', 'Giá siêu m?m nh?ng v?n ??y ?? th?t bò, ba ch? heo, h?i s?n và rau t??i!\r\n\r\n? Áp d?ng t? Th? 2 ??n Th? 5 hàng tu?n – ?i 4 tính ti?n 3!', 'v', 'blog1.jpg'),
(4, 'K-PUB ?u ?ãi Tháng Vàng – Gi?m Giá Lên T?i 10% Món N??ng Chu?n Hàn!', 'K-PUB g?i t?ng b?n ??i ti?c n??ng ??m ch?t Hàn Qu?c v?i ?u ?ãi h?p d?n su?t tháng này!', 'K-PUB – Vua N??ng ???ng Ph? Hàn Qu?c trân tr?ng gi?i thi?u ch??ng trình khuy?n mãi l?n nh?t tháng dành cho các tín ?? ?m th?c!\r\n\r\nT? ngày 25/5 ??n 25/6, khách hàng khi ??n th??ng th?c t?i K-PUB s? ???c tr?i nghi?m không khí ?m th?c Hàn Qu?c sôi ??ng, cùng ?u ?ãi lên ??n 10% cho nhi?u combo món n??ng và set buffet.\r\n\r\nChi ti?t ?u ?ãi g?m:\r\n\r\nGi?m 10% khi ?i theo nhóm t? 3 ng??i tr? lên\r\n\r\nGi?m 20% khi ??t bàn tr??c qua hotline ho?c fanpage\r\n\r\nT?ng ngay 1 ph?n Tokbokki cay phô mai cho hóa ??n t? 499.000?\r\n\r\nMi?n phí n??c ng?t cho h?c sinh – sinh viên khi mang theo th?\r\n\r\n??m chìm trong h??ng v? n??ng ??c tr?ng, th?t t??i ngon, n??c s?t ??m ?à cùng phong cách ph?c v? tr? trung, n?ng ??ng – ch? có t?i K-PUB.\r\n\r\n\r\nNhanh tay ??t ch? – S? l??ng ?u ?ãi có h?n!\r\n\r\n', '6820a2e734922.png'),
(8, 'Khám phá ??i ti?c n??ng Hàn Qu?c v?i ?u ?ãi lên ??n 30% t?i K-PUB', '??n K-PUB tháng này ?? th??ng th?c món n??ng ngon ?úng ?i?u v?i m?c giá h?p d?n', 'Tháng này, K-PUB mang ??n ch??ng trình khuy?n mãi ??c bi?t dành riêng cho các tín ?? yêu thích ?m th?c Hàn Qu?c. V?i th?c ??n ?a d?ng t? th?t bò, ba ch? heo, ??n h?i s?n n??ng, b?n s? ???c tr?i nghi?m không khí n??ng ???ng ph? Hàn Qu?c ??y s?ng ??ng.\r\n\r\nGi?m giá lên ??n 30% cho các set buffet n??ng khi ?i theo nhóm ho?c ??t bàn tr??c. Ngoài ra, K-PUB còn t?ng kèm món ?n kèm ??c bi?t cho các hóa ??n trên 499.000?. Hãy nhanh tay ??t bàn ?? không b? l? c? h?i th??ng th?c ?m th?c chu?n Hàn v?i giá c?c k? ?u ?ãi.', '6820a4e41efc5.png');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `id_mon` bigint(20) NOT NULL,
  `sesid` varchar(255) NOT NULL,
  `name_mon` varchar(300) NOT NULL,
  `gia_mon` double NOT NULL,
  `soluong` int(11) NOT NULL,
  `images` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `id_mon`, `sesid`, `name_mon`, `gia_mon`, `soluong`, `images`) VALUES
(66, 67, 's4d1pceg5dc7r3ag8a2937f8jh', 'Gà ngó sen', 120000, 1, '212b6fe40e.jpg'),
(65, 71, 'smvd78qrsa7k43vll981mni72b', 'Gà g?i ', 200000, 1, 'ff05be5866.jpg'),
(67, 67, 'khdsif919hu620d1vgcps009p4', 'Gà ngó sen', 120000, 1, '212b6fe40e.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_don_hang`
--

CREATE TABLE `chi_tiet_don_hang` (
  `id` int(11) NOT NULL,
  `don_hang_id` int(11) DEFAULT NULL,
  `mon_an_id` int(11) DEFAULT NULL,
  `so_luong` int(11) DEFAULT NULL,
  `trang_thai_mon` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `chi_tiet_don_hang`
--

INSERT INTO `chi_tiet_don_hang` (`id`, `don_hang_id`, `mon_an_id`, `so_luong`, `trang_thai_mon`) VALUES
(20, 31, 54, 2, '?ã ??t'),
(22, 33, 54, 2, '?ã ??t'),
(23, 34, 8, 3, '?ã ??t'),
(24, 34, 6, 12, '?ã ??t'),
(25, 35, 11, 1, '?ã ??t'),
(26, 36, 11, 1, '?ã ??t'),
(27, 37, 11, 1, '?ã ??t'),
(28, 38, 11, 1, '?ã ??t'),
(29, 39, 11, 1, '?ã ??t'),
(30, 40, 54, 1, '?ã ??t'),
(31, 41, 51, 3, '?ã ??t'),
(32, 42, 50, 2, '?ã ??t'),
(33, 42, 54, 1, '?ã ??t'),
(34, 43, 51, 3, '?ã ??t'),
(35, 44, 71, 4, '?ã ??t'),
(36, 45, 71, 4, '?ã ??t'),
(37, 46, 54, 1, '?ã ??t'),
(38, 47, 71, 4, '?ã ??t'),
(39, 48, 71, 4, '?ã ??t'),
(40, 49, 54, 1, '?ã ??t'),
(41, 50, 50, 2, '?ã ??t'),
(42, 51, 48, 12, '?ã ??t'),
(43, 52, 56, 1, '?ã ??t');

-- --------------------------------------------------------

--
-- Table structure for table `customercontact`
--

CREATE TABLE `customercontact` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gopy` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customercontact`
--

INSERT INTO `customercontact` (`id`, `email`, `gopy`) VALUES
(1, 'a', 'a'),
(2, 'dtc2154802010355@ictu.edu.vn', 'qqqqqqqqqqqqq');

-- --------------------------------------------------------

--
-- Table structure for table `dat_ban`
--

CREATE TABLE `dat_ban` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ban_id` int(11) NOT NULL,
  `so_nguoi` int(11) NOT NULL,
  `thoi_gian` datetime NOT NULL,
  `ghi_chu` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `trang_thai` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dat_ban`
--

INSERT INTO `dat_ban` (`id`, `user_id`, `ban_id`, `so_nguoi`, `thoi_gian`, `ghi_chu`, `created_at`, `trang_thai`) VALUES
(1, 25, 2, 4, '2025-04-23 17:09:00', 'ssaasedit', '2025-04-26 17:37:41', '?ã xác nh?n'),
(3, 25, 4, 3, '2025-04-22 15:46:00', 'd', '2025-04-26 17:38:38', 'ch? xác nh?n'),
(4, 26, 3, 4, '2025-04-23 22:04:00', 'aaaaaaaaaaaaa', '2025-04-26 17:42:39', 'ch? xác nh?n'),
(6, 28, 1, 4, '2025-04-23 21:33:00', 'edit', '2025-04-26 17:38:46', 'da_xac_nhan'),
(8, 25, 2, 3, '2025-05-14 20:54:00', '', '2025-05-14 20:55:02', 'ch? xác nh?n');

-- --------------------------------------------------------

--
-- Table structure for table `don_hang`
--

CREATE TABLE `don_hang` (
  `id` int(11) NOT NULL,
  `ban_id` int(11) DEFAULT NULL,
  `thoi_gian` datetime DEFAULT current_timestamp(),
  `trang_thai` varchar(100) DEFAULT NULL,
  `khuyenmai_id` int(11) DEFAULT NULL,
  `tong` int(11) NOT NULL,
  `tong_tien` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `don_hang`
--

INSERT INTO `don_hang` (`id`, `ban_id`, `thoi_gian`, `trang_thai`, `khuyenmai_id`, `tong`, `tong_tien`, `user_id`) VALUES
(12, 2, '2025-05-09 11:42:35', '?ã ??t', 3, 600000, 600000, 0),
(13, 4, '2025-05-09 11:43:38', '?ã ??t', 3, 880000, 880000, 0),
(14, 2, '2025-05-09 11:46:16', '?ã ??t', 3, 600000, 600000, 0),
(15, 2, '2025-05-09 11:47:39', '?ã ??t', 3, 200000, 200000, 0),
(17, 4, '2025-05-09 11:50:41', '?ã ??t', 3, 600000, 600000, 0),
(18, 2, '2025-05-09 11:52:30', '?ã ??t', 0, 600000, 600000, 0),
(19, 2, '2025-05-09 11:54:14', '?ã ??t', 0, 880000, 880000, 0),
(20, 2, '2025-05-09 12:01:16', '?ã ??t', 0, 600000, 600000, 0),
(21, 2, '2025-05-09 12:04:24', '?ã ??t', 3, 600000, 600000, 0),
(22, 2, '2025-05-09 12:10:13', '?ã ??t', 0, 800000, 800000, 0),
(23, 2, '2025-05-09 12:12:49', '?ã ??t', 3, 200000, 200000, 0),
(26, 2, '2025-05-09 12:21:05', '?ã ??t', 3, 800000, 800000, 0),
(27, 2, '2025-05-09 12:21:14', '?ã ??t', 3, 200000, 200000, 0),
(28, 2, '2025-05-09 12:28:18', '?ã ??t', 0, 200000, 200000, 0),
(29, 2, '2025-05-09 12:43:40', '?ã ??t', 3, 200000, 200000, 0),
(30, 4, '2025-05-09 12:46:22', '?ã ??t', 3, 800000, 800000, 0),
(31, 4, '2025-05-09 12:52:32', '?ã ??t', 3, 280000, 280000, 0),
(32, 2, '2025-05-09 13:09:07', '?ang chu?n b?', 3, 800000, 800000, 25),
(33, 4, '2025-05-09 14:08:42', 'Hoàn t?t', 3, 280000, 280000, 25),
(34, 4, '2025-05-11 14:26:41', 'Hoàn t?t', 0, 612000, 612000, 25),
(35, 2, '2025-05-11 14:43:18', '?ã ??t', 0, 200000, 200000, 25),
(36, 2, '2025-05-11 14:45:30', '?ã ??t', 0, 200000, 200000, 25),
(37, 2, '2025-05-11 14:46:17', '?ã ??t', 0, 200000, 200000, 25),
(38, 2, '2025-05-11 14:47:06', '?ã ??t', 0, 200000, 200000, 25),
(39, 2, '2025-05-11 14:57:31', '?ã ??t', 0, 200000, 200000, 25),
(40, 4, '2025-05-11 14:57:39', '?ã ??t', 0, 200000, 200000, 25),
(41, 2, '2025-05-11 15:01:29', '?ã ??t', 0, 600000, 600000, 25),
(42, 2, '2025-05-11 15:09:29', '?ã ??t', 3, 480000, 480000, 25),
(43, 2, '2025-05-11 15:11:14', 'Hoàn t?t', 3, 600000, 0, 25),
(44, 2, '2025-05-11 15:26:08', 'Hoàn t?t', 3, 800000, 800000, 25),
(45, 2, '2025-05-11 15:28:38', 'Hoàn t?t', 3, 800000, 800000, 25),
(46, 2, '2025-05-11 15:31:41', 'Hoàn t?t', 3, 180000, 200000, 25),
(47, 2, '2025-05-11 15:32:29', 'Hoàn t?t', 3, 800000, 720000, 25),
(48, 2, '2025-05-11 15:34:19', 'Hoàn t?t', 3, 800000, 720000, 25),
(49, 2, '2025-05-11 17:18:18', 'Hoàn t?t', 3, 200000, 180000, 25),
(50, 2, '2025-05-14 13:55:18', 'Hoàn t?t', 3, 280000, 252000, 25),
(51, 2, '2025-05-18 15:00:56', '?ã ??t', 0, 12000, 12000, 25),
(52, 4, '2025-05-18 15:01:21', '?ã ??t', 3, 300000, 270000, 25);

-- --------------------------------------------------------

--
-- Table structure for table `giamgia`
--

CREATE TABLE `giamgia` (
  `id` int(11) NOT NULL,
  `ten` varchar(50) NOT NULL,
  `loai` enum('phantram','tienmat') NOT NULL,
  `giatri` int(11) NOT NULL,
  `don_toi_thieu` int(11) DEFAULT 0,
  `so_lan` int(11) DEFAULT 1,
  `ngay_bat_dau` datetime DEFAULT current_timestamp(),
  `ngay_ket_thuc` datetime DEFAULT NULL,
  `trang_thai` tinyint(1) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `giamgia`
--

INSERT INTO `giamgia` (`id`, `ten`, `loai`, `giatri`, `don_toi_thieu`, `so_lan`, `ngay_bat_dau`, `ngay_ket_thuc`, `trang_thai`) VALUES
(2, 'Sale ??u tháng', 'tienmat', 100000, 10000, 1, '2025-04-07 00:21:00', '2025-04-30 00:20:00', 1),
(3, 'Gi?m 10%', 'phantram', 10, 100000, 1, '2025-04-16 00:58:00', '2025-08-31 00:58:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `giohang`
--

CREATE TABLE `giohang` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price_at_time` decimal(10,2) NOT NULL,
  `added_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `giohang`
--

INSERT INTO `giohang` (`id`, `user_id`, `product_id`, `quantity`, `price_at_time`, `added_at`) VALUES
(8, 25, 51, 3, '200000.00', '2025-04-22 23:25:37');

-- --------------------------------------------------------

--
-- Table structure for table `khach_hang`
--

CREATE TABLE `khach_hang` (
  `id` int(11) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `sodienthoai` varchar(15) NOT NULL,
  `gioitinh` int(11) NOT NULL,
  `solandat` int(11) DEFAULT NULL,
  `ghichu` text DEFAULT NULL,
  `passwords` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `khach_hang`
--

INSERT INTO `khach_hang` (`id`, `ten`, `sodienthoai`, `gioitinh`, `solandat`, `ghichu`, `passwords`) VALUES
(10, 'Thanh NgÃ¢n', '0999999999', 1, NULL, NULL, 'e10adc3949ba59abbe56e057f20f883e'),
(15, 'An Hoai Linh ANh', '0964135761', 1, 2, '', 'e10adc3949ba59abbe56e057f20f883e'),
(17, 'trang thuy', '0964135761', 0, 0, 'j', '$2y$10$QE4aDJGFo3NI8..zPbMjpuVid0xLZAFwLxojQyUCnuuVquh3qEezi'),
(18, 'lâm', '1234567890', 1, 0, '', '$2y$10$uKL4kOlWiSBN1prM/n7UqerbjC0Y0UltzC0lfkMzuV.sq35sm1Nya'),
(19, 'An Hoai Linh ANh', '0964135761', 1, 0, 'ch1', '$2y$10$g93hOSPKtGALiLtcAQ.z8e7co/QBodd6IcYlYIHbIlSxeA2XAbRqe'),
(20, 'an', '0987265173', 1, NULL, NULL, 'e10adc3949ba59abbe56e057f20f883e'),
(21, 'lam hoang', '0965145761', 1, 0, '', '$2y$10$/w5p.ubjZInUur.1kAplBeRzuDTuE09WxtOxgAS.bhm6B4PiuTZse'),
(22, 'trang thuy nhung', '0198346717', 0, 0, '', '$2y$10$nTP4rBoSDfkNZXeF/jnS/.EDBc.8b1HJc83bKly1.9GzmB52q0SoW'),
(23, '0198346717', '0198346717', 1, 0, '0', '$2y$10$YHcj6tLZKYKBJf3UMLVeRuGWB5F3CePvBerMI8AWN0mHfGEILA3hC'),
(24, 'lam lam lam', '0976156817', 1, 0, '', '$2y$10$pMiS462a916P.sM3P8U7w.sE5nivhbD3n88Lm1y6ehlgsvvC8t2bG'),
(25, 'V Tr??ng ', '0123456789', 0, 0, '0', '$2y$10$fKgIgsQ6QpSo9upj2I1HeuwUjGDDxt2bMZkpUBbbvnrHThEQ5Dlyu'),
(26, 'An Hoai Linh ANh', '0980980980', 1, 0, '', '$2y$10$Qp/F4jTQE1q.tUnHYeG9EesTkgRCpNXcRgJFx7gwFVyRXFuvNgOya'),
(28, 'hoàng lâm', '0338960323', 1, 1, 'qqqqqqqqqqqqq', '$2y$10$v8HMNQcip3Y0Rrfe95w/..5wk0u7Xn6tvccL2/O07tAMeBAYZbUJK'),
(29, 'lanh anh anh', '0964356723', 0, 1, 'aaaaaaaaaaaddddddddddddddddd', '$2y$10$0bSOD72GtOScnCGl75GqBePZ2qHx.3a9xmPf7Rx/O3SB64GHbTWfO'),
(30, 'kim anh', '0952627835', 0, 1, 'qqqqqqqqqqqqqqqqqqq', '$2y$10$3ik3uRxGFI4II9PsGDfp1uqwv.arAjv.ZJw//bS13FbYo.Bcy.7Ha'),
(31, 'nhi', '0976543265', 0, 1, 'aa', '$2y$10$B0zS31xi9NzvSs//SUxEwOsIi/3GoBgl5TjCsHcQaWdhCScqTqdOC'),
(32, 'x', '0987625716', 0, 0, '0', '$2y$10$QZKL9ycc6PCx/dj3zsIlMufv4YzEnAMaH7eW7F9AZ3Qod18XnDInO');

-- --------------------------------------------------------

--
-- Table structure for table `loai_mon`
--

CREATE TABLE `loai_mon` (
  `id_loai` int(11) NOT NULL,
  `name_loai` varchar(255) NOT NULL,
  `ghichu` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `loai_mon`
--

INSERT INTO `loai_mon` (`id_loai`, `name_loai`, `ghichu`) VALUES
(10, 'Khai v?', ''),
(11, 'Heo', ''),
(12, 'Bò', ''),
(13, 'GÀ', ''),
(14, 'C?m/Bún/Mi?n', ''),
(16, 'Tráng mi?ngg', ''),
(17, 'c?m', ''),
(18, 'kem', 'kem'),
(19, 'hoa qu?', ''),
(20, 'salat', '');

-- --------------------------------------------------------

--
-- Table structure for table `monan`
--

CREATE TABLE `monan` (
  `id_mon` bigint(20) NOT NULL,
  `name_mon` varchar(300) NOT NULL,
  `id_loai` int(11) NOT NULL,
  `gia_mon` double NOT NULL,
  `ghichu_mon` text DEFAULT NULL,
  `images` varchar(300) DEFAULT NULL,
  `tinhtrang` int(11) NOT NULL DEFAULT 1,
  `special` int(11) NOT NULL,
  `detail` varchar(555) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `monan`
--

INSERT INTO `monan` (`id_mon`, `name_mon`, `id_loai`, `gia_mon`, `ghichu_mon`, `images`, `tinhtrang`, `special`, `detail`) VALUES
(48, 'Heo n??ng', 11, 1000, '', 'f5bf17632c.jpg', 1, 0, 'Heo n??ngHeo n??ngHeo n??ngHeo n??ngHeo n??ngHeo n??ngHeo n??ngHeo n??ngHeo n??ngHeo n??ngHeo n??ngHeo n??ngHeo n??ngHeo n??ng'),
(49, 'H? ti?u áp ch?o ', 14, 100000, '    ', '14b5d07e78.jpg', 1, 0, ''),
(50, 'C?m chiên L?c Phát', 14, 140000, '', '23901ccf32.jpg', 1, 0, ''),
(51, 'Mi?n xào cua', 14, 200000, '', '4ce1fb365a.jpg', 1, 0, ''),
(52, 'C?m xá xíu', 14, 100000, '', 'e8ead109db.jpg', 1, 0, ''),
(54, 'Bò lagu', 12, 200000, '', 'ef171620d1.jpg', 1, 1, ''),
(55, 'Bò n??ng Y', 12, 210000, '', '2b6c56a51d.jpg', 1, 0, ''),
(56, 'Bò n??ng ?á', 12, 300000, '', '48f4ea300c.jpg', 1, 1, ''),
(57, 'Bò h?m', 12, 200000, '', '9b10800509.jpg', 1, 0, ''),
(58, 'Heo lên m?t', 11, 200000, '', 'c50872ded9.jpg', 1, 0, ''),
(59, 'Gà h?m', 13, 200000, '', '0d3a986b70.jpg', 1, 0, ''),
(60, 'Gà n??ng', 13, 200000, '', 'b5c1c9fe66.jpg', 1, 0, ''),
(61, 'Trái cây 1', 16, 50000, '', '9720364c45.jpg', 1, 0, ''),
(62, 'Trái cây 2', 16, 50000, '', 'e8962224b8.jpg', 1, 0, ''),
(63, 'Rau câu 1', 16, 50000, '', 'c16eef151d.jpg', 1, 0, ''),
(64, 'Rau câu 2', 16, 50000, '', '94b370ea47.jpg', 1, 0, ''),
(67, 'Gà ngó sen', 10, 120000, '', '212b6fe40e.jpg', 1, 0, ''),
(68, 'Gà g?i', 12, 120000, '', 'a9b1758ff7.jpg', 1, 0, ''),
(69, '??u h? chiên giòn ', 10, 80000, '', '56f31f13dc.jpg', 1, 0, ''),
(70, '??u h? t? xuyên', 10, 140000, '', 'c8217c6bc8.jpg', 1, 1, ''),
(71, 'Gà g?i ', 10, 200000, '', 'ff05be5866.jpg', 1, 1, ''),
(72, 'Khai v? ba món', 10, 200000, '', '7fbb074b00.jpg', 1, 0, ''),
(73, 'Ch? giò', 10, 200000, '', '01c15124a7.jpg', 1, 0, ''),
(74, 'S??n heo ngon', 11, 200000, ' ', 'f73f6b9bdc.jpg', 1, 1, ''),
(75, 'Heo quay', 11, 200000, '', '6fe0bf3207.jpg', 1, 0, ''),
(76, 'c?m t?m', 17, 20000, 'c?m t?m ngon nh', 'e3a440ed44.jpg', 1, 0, ''),
(80, 'hoa qu? ', 19, 40000, 'ah gggghhhhhhhhhhhhhhhh                 ', '045f8e10e5.jpg', 1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(11) NOT NULL,
  `Name_admin` varchar(255) NOT NULL,
  `adminuser` varchar(155) NOT NULL,
  `adminpass` varchar(255) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `Name_admin`, `adminuser`, `adminpass`, `role`) VALUES
(1, 'Lý V?n Tr??ng', 'truong', '$2y$10$Hef2QJpz3iU7rGJBTXaUt.iyfI2qsTzWF.zp010bTak9T46UlbYES', 1),
(7, 'linh', 'linh', '$2y$10$h7sHl3T6/kuuaWyw/Xrn7unRryok/gahzdoYQGGsln9rYucpRgNda', 1),
(6, 'trang thuy', 'trang', '$2y$10$aXKnR3hSs26qyFi0FLaSpuBioJZpn99jzmWSoCaZKuiIGR9BdYT0i', 0),
(5, 'lanh', 'lanh', '$2y$10$WqxW93QgdhVgBBAR9UWeXeHBIrdUFL4IxEOZ/8EjLAWH9HbpvJiBG', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ban`
--
ALTER TABLE `ban`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `don_hang_id` (`don_hang_id`);

--
-- Indexes for table `customercontact`
--
ALTER TABLE `customercontact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dat_ban`
--
ALTER TABLE `dat_ban`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `don_hang`
--
ALTER TABLE `don_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ban_id` (`ban_id`),
  ADD KEY `khuyenmai_id` (`khuyenmai_id`);

--
-- Indexes for table `giamgia`
--
ALTER TABLE `giamgia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten` (`ten`);

--
-- Indexes for table `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loai_mon`
--
ALTER TABLE `loai_mon`
  ADD PRIMARY KEY (`id_loai`);

--
-- Indexes for table `monan`
--
ALTER TABLE `monan`
  ADD PRIMARY KEY (`id_mon`),
  ADD KEY `id_loai` (`id_loai`);

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ban`
--
ALTER TABLE `ban`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `customercontact`
--
ALTER TABLE `customercontact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dat_ban`
--
ALTER TABLE `dat_ban`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `don_hang`
--
ALTER TABLE `don_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `giamgia`
--
ALTER TABLE `giamgia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `giohang`
--
ALTER TABLE `giohang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `loai_mon`
--
ALTER TABLE `loai_mon`
  MODIFY `id_loai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `monan`
--
ALTER TABLE `monan`
  MODIFY `id_mon` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
