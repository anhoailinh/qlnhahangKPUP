-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 14, 2025 at 01:47 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gs_restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `ban`
--

CREATE TABLE `ban` (
  `id` int NOT NULL,
  `ten_ban` varchar(50) NOT NULL,
  `trang_thai` enum('trong','da_dat') DEFAULT 'trong'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `id` int NOT NULL,
  `tieude` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `mota` text,
  `noidung` text,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `tieude`, `mota`, `noidung`, `img`) VALUES
(1, 'Thịt Bò Mỹ Nhập Khẩu – Ăn Bao Nhiêu Cũng Có!', 'Thực khách mê thịt không thể bỏ lỡ món bò Mỹ lát mỏng, mềm tan trên bếp nướng.\r\n👉 Có mặt trong tất cả các suất buffet từ 199K trở lên!', 'v', 'blog1.jpg'),
(2, 'Ưu Đãi Mỗi Tuần – Buffet Lẩu Nướng Chỉ Từ 149K', 'Giá siêu mềm nhưng vẫn đầy đủ thịt bò, ba chỉ heo, hải sản và rau tươi!\r\n\r\n👉 Áp dụng từ Thứ 2 đến Thứ 5 hàng tuần – đi 4 tính tiền 3!', 'v', 'blog1.jpg'),
(4, 'K-PUB Ưu Đãi Tháng Vàng – Giảm Giá Lên Tới 10% Món Nướng Chuẩn Hàn!', 'K-PUB gửi tặng bạn đại tiệc nướng đậm chất Hàn Quốc với ưu đãi hấp dẫn suốt tháng này!', 'K-PUB – Vua Nướng Đường Phố Hàn Quốc trân trọng giới thiệu chương trình khuyến mãi lớn nhất tháng dành cho các tín đồ ẩm thực!\r\n\r\nTừ ngày 25/5 đến 25/6, khách hàng khi đến thưởng thức tại K-PUB sẽ được trải nghiệm không khí ẩm thực Hàn Quốc sôi động, cùng ưu đãi lên đến 10% cho nhiều combo món nướng và set buffet.\r\n\r\nChi tiết ưu đãi gồm:\r\n\r\nGiảm 10% khi đi theo nhóm từ 3 người trở lên\r\n\r\nGiảm 20% khi đặt bàn trước qua hotline hoặc fanpage\r\n\r\nTặng ngay 1 phần Tokbokki cay phô mai cho hóa đơn từ 499.000đ\r\n\r\nMiễn phí nước ngọt cho học sinh – sinh viên khi mang theo thẻ\r\n\r\nĐắm chìm trong hương vị nướng đặc trưng, thịt tươi ngon, nước sốt đậm đà cùng phong cách phục vụ trẻ trung, năng động – chỉ có tại K-PUB.\r\n\r\n\r\nNhanh tay đặt chỗ – Số lượng ưu đãi có hạn!\r\n\r\n', '6820a2e734922.png'),
(8, 'Khám phá đại tiệc nướng Hàn Quốc với ưu đãi lên đến 30% tại K-PUB', 'Đến K-PUB tháng này để thưởng thức món nướng ngon đúng điệu với mức giá hấp dẫn', 'Tháng này, K-PUB mang đến chương trình khuyến mãi đặc biệt dành riêng cho các tín đồ yêu thích ẩm thực Hàn Quốc. Với thực đơn đa dạng từ thịt bò, ba chỉ heo, đến hải sản nướng, bạn sẽ được trải nghiệm không khí nướng đường phố Hàn Quốc đầy sống động.\r\n\r\nGiảm giá lên đến 30% cho các set buffet nướng khi đi theo nhóm hoặc đặt bàn trước. Ngoài ra, K-PUB còn tặng kèm món ăn kèm đặc biệt cho các hóa đơn trên 499.000đ. Hãy nhanh tay đặt bàn để không bỏ lỡ cơ hội thưởng thức ẩm thực chuẩn Hàn với giá cực kỳ ưu đãi.', '6820a4e41efc5.png');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int NOT NULL,
  `id_mon` bigint NOT NULL,
  `sesid` varchar(255) NOT NULL,
  `name_mon` varchar(300) NOT NULL,
  `gia_mon` double NOT NULL,
  `soluong` int NOT NULL,
  `images` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `id_mon`, `sesid`, `name_mon`, `gia_mon`, `soluong`, `images`) VALUES
(66, 67, 's4d1pceg5dc7r3ag8a2937f8jh', 'Gà ngó sen', 120000, 1, '212b6fe40e.jpg'),
(65, 71, 'smvd78qrsa7k43vll981mni72b', 'Gà gỏi ', 200000, 1, 'ff05be5866.jpg'),
(67, 67, 'khdsif919hu620d1vgcps009p4', 'Gà ngó sen', 120000, 1, '212b6fe40e.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_don_hang`
--

CREATE TABLE `chi_tiet_don_hang` (
  `id` int NOT NULL,
  `don_hang_id` int DEFAULT NULL,
  `mon_an_id` int DEFAULT NULL,
  `so_luong` int DEFAULT NULL,
  `trang_thai_mon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chi_tiet_don_hang`
--

INSERT INTO `chi_tiet_don_hang` (`id`, `don_hang_id`, `mon_an_id`, `so_luong`, `trang_thai_mon`) VALUES
(20, 31, 54, 2, 'Đã đặt'),
(22, 33, 54, 2, 'Đã đặt'),
(23, 34, 8, 3, 'Đã đặt'),
(24, 34, 6, 12, 'Đã đặt'),
(25, 35, 11, 1, 'Đã đặt'),
(26, 36, 11, 1, 'Đã đặt'),
(27, 37, 11, 1, 'Đã đặt'),
(28, 38, 11, 1, 'Đã đặt'),
(29, 39, 11, 1, 'Đã đặt'),
(30, 40, 54, 1, 'Đã đặt'),
(31, 41, 51, 3, 'Đã đặt'),
(32, 42, 50, 2, 'Đã đặt'),
(33, 42, 54, 1, 'Đã đặt'),
(34, 43, 51, 3, 'Đã đặt'),
(35, 44, 71, 4, 'Đã đặt'),
(36, 45, 71, 4, 'Đã đặt'),
(37, 46, 54, 1, 'Đã đặt'),
(38, 47, 71, 4, 'Đã đặt'),
(39, 48, 71, 4, 'Đã đặt'),
(40, 49, 54, 1, 'Đã đặt');

-- --------------------------------------------------------

--
-- Table structure for table `customercontact`
--

CREATE TABLE `customercontact` (
  `id` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `gopy` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `ban_id` int NOT NULL,
  `so_nguoi` int NOT NULL,
  `thoi_gian` datetime NOT NULL,
  `ghi_chu` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `trang_thai` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dat_ban`
--

INSERT INTO `dat_ban` (`id`, `user_id`, `ban_id`, `so_nguoi`, `thoi_gian`, `ghi_chu`, `created_at`, `trang_thai`) VALUES
(1, 25, 2, 4, '2025-04-23 17:09:00', 'ssaasedit', '2025-04-26 10:37:41', 'Đã xác nhận'),
(3, 25, 4, 3, '2025-04-22 15:46:00', 'd', '2025-04-26 10:38:38', 'chờ xác nhận'),
(4, 26, 3, 4, '2025-04-23 22:04:00', 'aaaaaaaaaaaaa', '2025-04-26 10:42:39', 'chờ xác nhận'),
(6, 28, 1, 4, '2025-04-23 21:33:00', 'edit', '2025-04-26 10:38:46', 'da_xac_nhan');

-- --------------------------------------------------------

--
-- Table structure for table `don_hang`
--

CREATE TABLE `don_hang` (
  `id` int NOT NULL,
  `ban_id` int DEFAULT NULL,
  `thoi_gian` datetime DEFAULT CURRENT_TIMESTAMP,
  `trang_thai` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `khuyenmai_id` int DEFAULT NULL,
  `tong` int NOT NULL,
  `tong_tien` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `don_hang`
--

INSERT INTO `don_hang` (`id`, `ban_id`, `thoi_gian`, `trang_thai`, `khuyenmai_id`, `tong`, `tong_tien`, `user_id`) VALUES
(12, 2, '2025-05-09 11:42:35', 'Đã đặt', 3, 600000, 600000, 0),
(13, 4, '2025-05-09 11:43:38', 'Đã đặt', 3, 880000, 880000, 0),
(14, 2, '2025-05-09 11:46:16', 'Đã đặt', 3, 600000, 600000, 0),
(15, 2, '2025-05-09 11:47:39', 'Đã đặt', 3, 200000, 200000, 0),
(17, 4, '2025-05-09 11:50:41', 'Đã đặt', 3, 600000, 600000, 0),
(18, 2, '2025-05-09 11:52:30', 'Đã đặt', 0, 600000, 600000, 0),
(19, 2, '2025-05-09 11:54:14', 'Đã đặt', 0, 880000, 880000, 0),
(20, 2, '2025-05-09 12:01:16', 'Đã đặt', 0, 600000, 600000, 0),
(21, 2, '2025-05-09 12:04:24', 'Đã đặt', 3, 600000, 600000, 0),
(22, 2, '2025-05-09 12:10:13', 'Đã đặt', 0, 800000, 800000, 0),
(23, 2, '2025-05-09 12:12:49', 'Đã đặt', 3, 200000, 200000, 0),
(26, 2, '2025-05-09 12:21:05', 'Đã đặt', 3, 800000, 800000, 0),
(27, 2, '2025-05-09 12:21:14', 'Đã đặt', 3, 200000, 200000, 0),
(28, 2, '2025-05-09 12:28:18', 'Đã đặt', 0, 200000, 200000, 0),
(29, 2, '2025-05-09 12:43:40', 'Đã đặt', 3, 200000, 200000, 0),
(30, 4, '2025-05-09 12:46:22', 'Đã đặt', 3, 800000, 800000, 0),
(31, 4, '2025-05-09 12:52:32', 'Đã đặt', 3, 280000, 280000, 0),
(32, 2, '2025-05-09 13:09:07', 'Đang chuẩn bị', 3, 800000, 800000, 25),
(33, 4, '2025-05-09 14:08:42', 'Hoàn tất', 3, 280000, 280000, 25),
(34, 4, '2025-05-11 14:26:41', 'Hoàn tất', 0, 612000, 612000, 25),
(35, 2, '2025-05-11 14:43:18', 'Đã đặt', 0, 200000, 200000, 25),
(36, 2, '2025-05-11 14:45:30', 'Đã đặt', 0, 200000, 200000, 25),
(37, 2, '2025-05-11 14:46:17', 'Đã đặt', 0, 200000, 200000, 25),
(38, 2, '2025-05-11 14:47:06', 'Đã đặt', 0, 200000, 200000, 25),
(39, 2, '2025-05-11 14:57:31', 'Đã đặt', 0, 200000, 200000, 25),
(40, 4, '2025-05-11 14:57:39', 'Đã đặt', 0, 200000, 200000, 25),
(41, 2, '2025-05-11 15:01:29', 'Đã đặt', 0, 600000, 600000, 25),
(42, 2, '2025-05-11 15:09:29', 'Đã đặt', 3, 480000, 480000, 25),
(43, 2, '2025-05-11 15:11:14', 'Hoàn tất', 3, 600000, 0, 25),
(44, 2, '2025-05-11 15:26:08', 'Hoàn tất', 3, 800000, 800000, 25),
(45, 2, '2025-05-11 15:28:38', 'Đang chuẩn bị', 3, 800000, 800000, 25),
(46, 2, '2025-05-11 15:31:41', 'Hoàn tất', 3, 180000, 200000, 25),
(47, 2, '2025-05-11 15:32:29', 'Hoàn tất', 3, 800000, 720000, 25),
(48, 2, '2025-05-11 15:34:19', 'Hoàn tất', 3, 800000, 720000, 25),
(49, 2, '2025-05-11 17:18:18', 'Đã đặt', 3, 200000, 180000, 25);

-- --------------------------------------------------------

--
-- Table structure for table `giamgia`
--

CREATE TABLE `giamgia` (
  `id` int NOT NULL,
  `ten` varchar(50) NOT NULL,
  `loai` enum('phantram','tienmat') NOT NULL,
  `giatri` int NOT NULL,
  `don_toi_thieu` int DEFAULT '0',
  `so_lan` int DEFAULT '1',
  `ngay_bat_dau` datetime DEFAULT CURRENT_TIMESTAMP,
  `ngay_ket_thuc` datetime DEFAULT NULL,
  `trang_thai` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `giamgia`
--

INSERT INTO `giamgia` (`id`, `ten`, `loai`, `giatri`, `don_toi_thieu`, `so_lan`, `ngay_bat_dau`, `ngay_ket_thuc`, `trang_thai`) VALUES
(2, 'Sale đầu tháng', 'tienmat', 100000, 10000, 1, '2025-04-07 00:21:00', '2025-04-30 00:20:00', 1),
(3, 'Giảm 10%', 'phantram', 10, 100000, 1, '2025-04-16 00:58:00', '2025-08-31 00:58:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `giohang`
--

CREATE TABLE `giohang` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price_at_time` decimal(10,2) NOT NULL,
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `giohang`
--

INSERT INTO `giohang` (`id`, `user_id`, `product_id`, `quantity`, `price_at_time`, `added_at`) VALUES
(6, 25, 48, 12, 1000.00, '2025-04-22 15:45:01'),
(8, 25, 51, 3, 200000.00, '2025-04-22 16:25:37'),
(10, 25, 50, 2, 140000.00, '2025-04-23 09:02:36');

-- --------------------------------------------------------

--
-- Table structure for table `khach_hang`
--

CREATE TABLE `khach_hang` (
  `id` int NOT NULL,
  `ten` varchar(255) NOT NULL,
  `sodienthoai` varchar(15) NOT NULL,
  `gioitinh` int NOT NULL,
  `solandat` int DEFAULT NULL,
  `ghichu` text,
  `passwords` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
(25, 'V Trường ', '0123456789', 0, 0, '0', '$2y$10$fKgIgsQ6QpSo9upj2I1HeuwUjGDDxt2bMZkpUBbbvnrHThEQ5Dlyu'),
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
  `id_loai` int NOT NULL,
  `name_loai` varchar(255) NOT NULL,
  `ghichu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `loai_mon`
--

INSERT INTO `loai_mon` (`id_loai`, `name_loai`, `ghichu`) VALUES
(10, 'Khai vị', ''),
(11, 'Heo', ''),
(12, 'Bò', ''),
(13, 'GÀ', ''),
(14, 'Cơm/Bún/Miến', ''),
(16, 'Tráng miệngg', ''),
(17, 'cơm', ''),
(18, 'kem', 'kem'),
(19, 'hoa quả', ''),
(20, 'salat', '');

-- --------------------------------------------------------

--
-- Table structure for table `monan`
--

CREATE TABLE `monan` (
  `id_mon` bigint NOT NULL,
  `name_mon` varchar(300) NOT NULL,
  `id_loai` int NOT NULL,
  `gia_mon` double NOT NULL,
  `ghichu_mon` text,
  `images` varchar(300) DEFAULT NULL,
  `tinhtrang` int NOT NULL DEFAULT '1',
  `special` int NOT NULL,
  `detail` varchar(555) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `monan`
--

INSERT INTO `monan` (`id_mon`, `name_mon`, `id_loai`, `gia_mon`, `ghichu_mon`, `images`, `tinhtrang`, `special`, `detail`) VALUES
(48, 'Heo nướng', 11, 1000, '', 'f5bf17632c.jpg', 1, 0, 'Heo nướngHeo nướngHeo nướngHeo nướngHeo nướngHeo nướngHeo nướngHeo nướngHeo nướngHeo nướngHeo nướngHeo nướngHeo nướngHeo nướng'),
(49, 'Hủ tiếu áp chảo ', 14, 100000, '    ', '14b5d07e78.jpg', 1, 0, ''),
(50, 'Cơm chiên Lộc Phát', 14, 140000, '', '23901ccf32.jpg', 1, 0, ''),
(51, 'Miến xào cua', 14, 200000, '', '4ce1fb365a.jpg', 1, 0, ''),
(52, 'Cơm xá xíu', 14, 100000, '', 'e8ead109db.jpg', 1, 0, ''),
(54, 'Bò lagu', 12, 200000, '', 'ef171620d1.jpg', 1, 1, ''),
(55, 'Bò nướng Y', 12, 210000, '', '2b6c56a51d.jpg', 1, 0, ''),
(56, 'Bò nướng đá', 12, 300000, '', '48f4ea300c.jpg', 1, 1, ''),
(57, 'Bò hầm', 12, 200000, '', '9b10800509.jpg', 1, 0, ''),
(58, 'Heo lên mẹt', 11, 200000, '', 'c50872ded9.jpg', 1, 0, ''),
(59, 'Gà hầm', 13, 200000, '', '0d3a986b70.jpg', 1, 0, ''),
(60, 'Gà nướng', 13, 200000, '', 'b5c1c9fe66.jpg', 1, 0, ''),
(61, 'Trái cây 1', 16, 50000, '', '9720364c45.jpg', 1, 0, ''),
(62, 'Trái cây 2', 16, 50000, '', 'e8962224b8.jpg', 1, 0, ''),
(63, 'Rau câu 1', 16, 50000, '', 'c16eef151d.jpg', 1, 0, ''),
(64, 'Rau câu 2', 16, 50000, '', '94b370ea47.jpg', 1, 0, ''),
(67, 'Gà ngó sen', 10, 120000, '', '212b6fe40e.jpg', 1, 0, ''),
(68, 'Gà gỏi', 12, 120000, '', 'a9b1758ff7.jpg', 1, 0, ''),
(69, 'Đậu hủ chiên giòn ', 10, 80000, '', '56f31f13dc.jpg', 1, 0, ''),
(70, 'Đậu hủ tứ xuyên', 10, 140000, '', 'c8217c6bc8.jpg', 1, 1, ''),
(71, 'Gà gỏi ', 10, 200000, '', 'ff05be5866.jpg', 1, 1, ''),
(72, 'Khai vị ba món', 10, 200000, '', '7fbb074b00.jpg', 1, 0, ''),
(73, 'Chả giò', 10, 200000, '', '01c15124a7.jpg', 1, 0, ''),
(74, 'Sườn heo ngon', 11, 200000, ' ', 'f73f6b9bdc.jpg', 1, 1, ''),
(75, 'Heo quay', 11, 200000, '', '6fe0bf3207.jpg', 1, 0, ''),
(76, 'cơm tấm', 17, 20000, 'cơm tấm ngon nh', 'e3a440ed44.jpg', 1, 0, ''),
(80, 'hoa quả ', 19, 40000, 'ah gggghhhhhhhhhhhhhhhh                ', 'c8bebae718.jpg', 1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int NOT NULL,
  `Name_admin` varchar(255) NOT NULL,
  `adminuser` varchar(155) NOT NULL,
  `adminpass` varchar(255) NOT NULL,
  `role` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `Name_admin`, `adminuser`, `adminpass`, `role`) VALUES
(1, 'Lý Văn Trường', 'truong', '$2y$10$Hef2QJpz3iU7rGJBTXaUt.iyfI2qsTzWF.zp010bTak9T46UlbYES', 1),
(7, 'linh', 'linh', '$2y$10$h7sHl3T6/kuuaWyw/Xrn7unRryok/gahzdoYQGGsln9rYucpRgNda', 1),
(6, 'trang thuy', 'trang', '$2y$10$aXKnR3hSs26qyFi0FLaSpuBioJZpn99jzmWSoCaZKuiIGR9BdYT0i', 0),
(5, 'lanh', 'lanh', '$2y$10$WqxW93QgdhVgBBAR9UWeXeHBIrdUFL4IxEOZ/8EjLAWH9HbpvJiBG', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vitri`
--

CREATE TABLE `vitri` (
  `id_vitri` int NOT NULL,
  `Name_vitri` varchar(5) NOT NULL,
  `Ghichu` text,
  `image` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `vitri`
--

INSERT INTO `vitri` (`id_vitri`, `Name_vitri`, `Ghichu`, `image`) VALUES
(1, 'Vip', NULL, 'Vip3.JPG'),
(2, 'Sảnh ', NULL, 'silde2.jpg');

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
-- Indexes for table `vitri`
--
ALTER TABLE `vitri`
  ADD PRIMARY KEY (`id_vitri`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ban`
--
ALTER TABLE `ban`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `customercontact`
--
ALTER TABLE `customercontact`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dat_ban`
--
ALTER TABLE `dat_ban`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `don_hang`
--
ALTER TABLE `don_hang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `giamgia`
--
ALTER TABLE `giamgia`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `giohang`
--
ALTER TABLE `giohang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `loai_mon`
--
ALTER TABLE `loai_mon`
  MODIFY `id_loai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `monan`
--
ALTER TABLE `monan`
  MODIFY `id_mon` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vitri`
--
ALTER TABLE `vitri`
  MODIFY `id_vitri` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_1` FOREIGN KEY (`don_hang_id`) REFERENCES `don_hang` (`id`);

--
-- Constraints for table `don_hang`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `don_hang_ibfk_1` FOREIGN KEY (`ban_id`) REFERENCES `ban` (`id`);

--
-- Constraints for table `monan`
--
ALTER TABLE `monan`
  ADD CONSTRAINT `monan_ibfk_1` FOREIGN KEY (`id_loai`) REFERENCES `loai_mon` (`id_loai`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
