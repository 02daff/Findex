-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2020 at 05:43 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `findex`
--

-- --------------------------------------------------------

--
-- Table structure for table `cash`
--

CREATE TABLE `cash` (
  `cash_in` int(11) NOT NULL,
  `cash_out` int(11) NOT NULL,
  `net` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cash`
--

INSERT INTO `cash` (`cash_in`, `cash_out`, `net`) VALUES
(0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `id_material` varchar(11) NOT NULL,
  `material_name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`id_material`, `material_name`, `price`, `stock`) VALUES
('mat-01', 'Sliding Board', 30000, 0),
('mat-02', 'Duplex Board', 4200, 0),
('mat-03', 'Paper Clip', 280, 0),
('mat-04', 'Alarm Module', 1500, 0),
('mat-05', 'Controller Module', 3000, 0),
('mat-06', 'Rivet', 5500, 0),
('mat-07', 'Cover - Black', 12000, 0),
('mat-08', 'Cover - Blue', 12000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orderdata`
--

CREATE TABLE `orderdata` (
  `id_order` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_product` varchar(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `payment_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `proddata`
--

CREATE TABLE `proddata` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `prod1` int(5) NOT NULL,
  `prod2` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prodplan`
--

CREATE TABLE `prodplan` (
  `year` int(4) NOT NULL,
  `volume` int(11) NOT NULL,
  `status` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prodplan`
--

INSERT INTO `prodplan` (`year`, `volume`, `status`) VALUES
(2021, 5843, 'Active'),
(2022, 6173, ''),
(2023, 6277, ''),
(2024, 6589, ''),
(2025, 6749, ''),
(2026, 7331, '');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id_product` varchar(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id_product`, `product_name`, `price`, `stock`) VALUES
('fin-01', 'Black Finder', 325000, 0),
('fin-02', 'Blue Finder', 325000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `recipe1`
--

CREATE TABLE `recipe1` (
  `id` varchar(11) NOT NULL,
  `needs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recipe1`
--

INSERT INTO `recipe1` (`id`, `needs`) VALUES
('mat-01', 1),
('mat-02', 1),
('mat-03', 1),
('mat-04', 1),
('mat-05', 1),
('mat-06', 2),
('mat-07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `recipe2`
--

CREATE TABLE `recipe2` (
  `id` varchar(11) NOT NULL,
  `needs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recipe2`
--

INSERT INTO `recipe2` (`id`, `needs`) VALUES
('mat-01', 1),
('mat-02', 1),
('mat-03', 1),
('mat-04', 1),
('mat-05', 1),
('mat-06', 2),
('mat-08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `pack1` int(5) NOT NULL,
  `pack2` int(5) NOT NULL,
  `price_total` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `name`, `phone`, `address`, `username`, `password`, `role`) VALUES
(1, 'Daffa Irfan', '081313080906', 'Ciganitri Indah Residence A-42, Bandung', 'admin', '1122', 'Admin'),
(2, 'Production', '00', 'Bandung', 'prod', 'usr1', 'Production'),
(3, 'Inventory', '00', 'Bandung', 'inve', 'usr2', 'Inventory'),
(4, 'Customer', '081234567890', 'Telkom University, Bandung', 'cust', 'usr3', 'Customer'),
(5, 'Procurement', '00', 'Bandung', 'proc', 'usr4', 'Procurement'),
(6, 'Finance', '00', 'Bandung', 'fina', 'usr5', 'Finance');

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `id_user` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id_user`, `role`, `date`) VALUES
(1, 'Admin', '2020-05-04 16:42:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id_material`);

--
-- Indexes for table `orderdata`
--
ALTER TABLE `orderdata`
  ADD PRIMARY KEY (`id_order`);

--
-- Indexes for table `proddata`
--
ALTER TABLE `proddata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`);

--
-- Indexes for table `recipe1`
--
ALTER TABLE `recipe1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipe2`
--
ALTER TABLE `recipe2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orderdata`
--
ALTER TABLE `orderdata`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proddata`
--
ALTER TABLE `proddata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
