-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Sep 27, 2016 at 11:32 PM
-- Server version: 5.7.15-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bashsofts_mppt_default_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `advance`
--

CREATE TABLE `advance` (
  `id` int(5) NOT NULL,
  `employee` int(5) NOT NULL,
  `amount` int(20) NOT NULL,
  `duration` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `advance`
--

INSERT INTO `advance` (`id`, `employee`, `amount`, `duration`) VALUES
(2, 2, 10000, 5);

-- --------------------------------------------------------

--
-- Table structure for table `alpha`
--

CREATE TABLE `alpha` (
  `id` int(5) NOT NULL,
  `fname` varchar(24) NOT NULL,
  `lname` varchar(24) NOT NULL,
  `username` varchar(24) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `securityPin` varchar(32) NOT NULL,
  `level` varchar(2) NOT NULL,
  `securityQuestion` varchar(128) NOT NULL,
  `securityAnswer` varchar(64) NOT NULL,
  `phoneNo` varchar(15) NOT NULL,
  `regIP` varchar(15) NOT NULL,
  `lastIP` varchar(15) NOT NULL,
  `lastLogTime` varchar(10) NOT NULL,
  `lastLogDate` varchar(10) NOT NULL,
  `dp` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alpha`
--

INSERT INTO `alpha` (`id`, `fname`, `lname`, `username`, `email`, `password`, `securityPin`, `level`, `securityQuestion`, `securityAnswer`, `phoneNo`, `regIP`, `lastIP`, `lastLogTime`, `lastLogDate`, `dp`) VALUES
(1, 'Shahab', 'Khalid', 'Raftaar456', 'shahabkhalidc@gmail.com', '452bc760acf06fe3504fec964cca20a0', '9a4843fccb863882e4c8e3604216ffee', '1', 'Where do you live? ', 'inHouse', '+923345928078', '127.0.0.1', '127.0.0.1', '07:49:00', '15:08:2016', '../admin/profile_pics/shahab.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `id` int(5) NOT NULL,
  `ref` int(5) NOT NULL,
  `vendor` int(5) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`id`, `ref`, `vendor`, `date`) VALUES
(4, 1, 3, '2016-09-14'),
(5, 2, 1, '2016-09-14');

-- --------------------------------------------------------

--
-- Table structure for table `bill_detail`
--

CREATE TABLE `bill_detail` (
  `id` int(5) NOT NULL,
  `ref` int(5) NOT NULL,
  `ref2` int(5) NOT NULL,
  `biller_id` int(5) NOT NULL,
  `particular` varchar(24) NOT NULL,
  `weices` varchar(24) NOT NULL,
  `rate` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bill_detail`
--

INSERT INTO `bill_detail` (`id`, `ref`, `ref2`, `biller_id`, `particular`, `weices`, `rate`) VALUES
(7, 1, 1, 11, 'Polythene', '1000', 100),
(8, 2, 1, 13, 'Block', '50', 500);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(5) NOT NULL,
  `name` varchar(24) NOT NULL,
  `contact` varchar(12) NOT NULL,
  `address` varchar(64) NOT NULL,
  `opening_balance` int(10) NOT NULL,
  `saleRep` int(5) NOT NULL,
  `rateBy` int(1) NOT NULL,
  `paymentMethod` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `name` varchar(24) NOT NULL,
  `contact` varchar(12) NOT NULL,
  `address` varchar(64) NOT NULL,
  `ldRate` int(5) NOT NULL,
  `hdRate` int(5) NOT NULL,
  `salary` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `name`, `contact`, `address`, `ldRate`, `hdRate`, `salary`) VALUES
(1, 'Noname', '--', '--', 2, 3, 20000),
(2, 'Talha Tahir', '0300-5148792', '-', 2, 3, 20000),
(3, 'Zubair Sheikh', '--', '--', 2, 3, 20000),
(4, 'M. Ali', '--', '--', 2, 3, 20000),
(5, 'Saad Mir', '--', '--', 2, 3, 20000),
(6, 'Hanzala Amin', '--', '--', 2, 3, 20000),
(7, 'Naveed', '--', '--', 3, 6, 20000),
(8, 'Test1231245', '--', '--', 3, 3, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `expAccounts`
--

CREATE TABLE `expAccounts` (
  `id` int(11) NOT NULL,
  `name` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expAccounts`
--

INSERT INTO `expAccounts` (`id`, `name`) VALUES
(1, 'Utility Bills'),
(2, 'TCS/LAPORD');

-- --------------------------------------------------------

--
-- Table structure for table `expences`
--

CREATE TABLE `expences` (
  `id` int(5) NOT NULL,
  `acc_id` int(5) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(128) NOT NULL,
  `amount` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expences`
--

INSERT INTO `expences` (`id`, `acc_id`, `date`, `description`, `amount`) VALUES
(1, -1, '2016-09-19', 'From Zubair', 15000),
(2, 1, '2016-09-19', 'Gas Bill', 5800),
(4, 2, '2016-09-19', 'Test', 500);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `no` int(3) NOT NULL,
  `id` int(5) NOT NULL,
  `customer` int(3) NOT NULL,
  `salerep` int(3) NOT NULL,
  `date` date NOT NULL,
  `rateby` int(1) NOT NULL,
  `paymentTime` int(5) NOT NULL,
  `ldRate` int(5) NOT NULL,
  `hdRate` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_detail`
--

CREATE TABLE `invoice_detail` (
  `id` int(5) NOT NULL,
  `ref` int(3) NOT NULL,
  `size` varchar(24) NOT NULL,
  `material` varchar(5) NOT NULL,
  `exp_name` varchar(64) NOT NULL,
  `charges` int(10) NOT NULL,
  `weices` int(10) NOT NULL,
  `rate` int(10) NOT NULL,
  `bag` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(5) NOT NULL,
  `title` varchar(32) NOT NULL,
  `privileges` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `title`, `privileges`) VALUES
(1, 'Acc Executive', 'all');

-- --------------------------------------------------------

--
-- Table structure for table `login_log`
--

CREATE TABLE `login_log` (
  `id` int(5) NOT NULL,
  `date` date NOT NULL,
  `time` time(6) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userName` varchar(24) NOT NULL,
  `pass` varchar(24) NOT NULL,
  `pin` varchar(24) NOT NULL,
  `fail` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_log`
--

INSERT INTO `login_log` (`id`, `date`, `time`, `ip`, `userName`, `pass`, `pin`, `fail`) VALUES
(1, '2016-09-17', '05:43:09.000000', '127.0.0.1', 'asd', 'asd', 'asd', 1),
(3, '2016-09-17', '06:44:29.000000', '127.0.0.1', 'Raftaar456', '----', '-----', 0),
(4, '2016-09-18', '03:16:45.000000', '127.0.0.1', 'Raftaar456', '----', '-----', 0),
(5, '2016-09-18', '08:58:34.000000', '127.0.0.1', 'Raftaar456', '----', '-----', 0),
(6, '2016-09-19', '12:21:39.000000', '127.0.0.1', 'Raftaar456', '----', '-----', 0),
(7, '2016-09-19', '09:20:06.000000', '127.0.0.1', 'Raftaar456', '----', '-----', 0),
(8, '2016-09-19', '01:11:01.000000', '127.0.0.1', 'Raftaar456', '----', '-----', 0),
(9, '2016-09-26', '10:33:19.000000', '127.0.0.1', 'Raftaar456', '----', '-----', 0),
(10, '2016-09-27', '11:18:58.000000', '127.0.0.1', 'Raftaar456', '----', '-----', 0);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(10) NOT NULL,
  `date` date NOT NULL,
  `time` time(6) NOT NULL,
  `admin` int(5) NOT NULL,
  `log` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `date`, `time`, `admin`, `log`) VALUES
(1, '2016-09-17', '03:39:00.000000', 1, 'Log Database Created!'),
(3, '2016-09-17', '06:36:40.000000', 1, 'New Customer \'Test007\' added!'),
(4, '2016-09-18', '03:24:05.000000', 1, 'New Customer \'Test00\' added!'),
(5, '2016-09-19', '04:46:59.000000', 1, 'New Advance \'\' for employee  \'2\' added!'),
(6, '2016-09-19', '05:04:29.000000', 1, 'New Advance \'10000\' for employee  \'2\' added!');

-- --------------------------------------------------------

--
-- Table structure for table `payments_paid`
--

CREATE TABLE `payments_paid` (
  `id` int(5) NOT NULL,
  `vendor` int(5) NOT NULL,
  `payer` int(5) NOT NULL,
  `bill_no` int(5) NOT NULL,
  `ref_no` int(5) NOT NULL,
  `amount` int(20) NOT NULL,
  `entry_date` date NOT NULL,
  `paid_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments_paid`
--

INSERT INTO `payments_paid` (`id`, `vendor`, `payer`, `bill_no`, `ref_no`, `amount`, `entry_date`, `paid_date`) VALUES
(5, 1, 6, 5, 1, 25000, '2016-09-14', '2016-09-14');

-- --------------------------------------------------------

--
-- Table structure for table `payments_recv`
--

CREATE TABLE `payments_recv` (
  `id` int(5) NOT NULL,
  `customer` int(5) NOT NULL,
  `receiver` int(5) NOT NULL,
  `inv_no` int(5) NOT NULL,
  `ref_no` int(15) NOT NULL,
  `amount` int(10) NOT NULL,
  `entry_date` date NOT NULL,
  `rec_date` date NOT NULL,
  `advance` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` int(3) NOT NULL,
  `size` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `size`) VALUES
(6, '19 x 22'),
(7, '16 x 18'),
(8, '10 x 12');

-- --------------------------------------------------------

--
-- Table structure for table `tmp`
--

CREATE TABLE `tmp` (
  `id` int(5) NOT NULL,
  `ref` int(5) NOT NULL,
  `date` date NOT NULL,
  `amount` int(20) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int(5) NOT NULL,
  `name` varchar(24) NOT NULL,
  `contact` varchar(12) NOT NULL,
  `address` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `name`, `contact`, `address`) VALUES
(1, 'Shah Block', '051-1233210', 'Shop 2 hano plaza johar road Lahore'),
(2, 'PoliMa', '--', '--'),
(3, 'Margalla Packages', '--', 'Aaa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advance`
--
ALTER TABLE `advance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alpha`
--
ALTER TABLE `alpha`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_detail`
--
ALTER TABLE `bill_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saleRep` (`saleRep`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expAccounts`
--
ALTER TABLE `expAccounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expences`
--
ALTER TABLE `expences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`no`),
  ADD KEY `id` (`no`);

--
-- Indexes for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_log`
--
ALTER TABLE `login_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments_paid`
--
ALTER TABLE `payments_paid`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ref` (`ref_no`);

--
-- Indexes for table `payments_recv`
--
ALTER TABLE `payments_recv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advance`
--
ALTER TABLE `advance`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `alpha`
--
ALTER TABLE `alpha`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `bill_detail`
--
ALTER TABLE `bill_detail`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `expAccounts`
--
ALTER TABLE `expAccounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `expences`
--
ALTER TABLE `expences`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `no` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
--
-- AUTO_INCREMENT for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `login_log`
--
ALTER TABLE `login_log`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `payments_paid`
--
ALTER TABLE `payments_paid`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `payments_recv`
--
ALTER TABLE `payments_recv`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=530;
--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
