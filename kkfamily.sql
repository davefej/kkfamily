-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2017. Feb 11. 12:52
-- Kiszolgáló verziója: 10.1.13-MariaDB
-- PHP verzió: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `kkfamily`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `alert`
--

CREATE TABLE `alert` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `param` varchar(100) NOT NULL,
  `param2` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `alert`
--

INSERT INTO `alert` (`id`, `type`, `param`, `param2`, `time`, `user_id`, `seen`, `deleted`) VALUES
(2, 'output', '13', '62', '2017-02-11 09:58:09', 2, 1, 0),
(3, 'output', '14', '62', '2017-02-11 10:05:18', 2, 1, 0),
(4, 'output', '15', '19', '2017-02-11 10:24:55', 2, 1, 0),
(5, 'trash', '9', '11', '2017-02-11 10:40:47', 2, 1, 0),
(6, 'output', '16', '55', '2017-02-11 11:44:55', 2, 1, 0),
(7, 'output', '17', '55', '2017-02-11 11:46:25', 2, 0, 0),
(8, 'output', '18', '55', '2017-02-11 11:46:37', 2, 0, 0),
(9, 'output', '19', '55', '2017-02-11 11:49:39', 2, 0, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `category`
--

INSERT INTO `category` (`id`, `name`, `deleted`) VALUES
(1, 'Gyümölcs', 0),
(2, 'Öntet', 0),
(3, 'Zöldség', 0),
(4, 'Egyéb ', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `output`
--

CREATE TABLE `output` (
  `id` int(11) NOT NULL,
  `pallet_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `output`
--

INSERT INTO `output` (`id`, `pallet_id`, `amount`, `time`, `user_id`, `deleted`) VALUES
(2, 57, 30, '2017-01-30 09:46:51', 2, 0),
(3, 57, 20, '2017-01-30 09:48:49', 3, 0),
(4, 21, 65, '2017-01-31 08:04:29', 3, 0),
(5, 1, 650, '2017-01-31 08:29:38', 3, 0),
(6, 58, 9999999, '2017-01-31 10:37:11', 4, 0),
(7, 60, 1, '2017-01-31 10:37:21', 4, 0),
(8, 2, 2, '2017-02-01 10:49:43', 2, 0),
(9, 11, 56, '2017-02-01 10:54:55', 2, 0),
(10, 61, 6663, '2017-02-01 10:55:58', 2, 0),
(11, 18, 239, '2017-02-01 11:12:14', 3, 0),
(12, 43, 5, '2017-02-01 12:14:58', 1, 0),
(13, 62, 100, '2017-02-11 09:57:49', 2, 0),
(14, 62, 101, '2017-02-11 10:05:18', 2, 0),
(15, 19, 100, '2017-02-11 10:24:55', 2, 0),
(16, 55, 1000, '2017-02-11 11:44:55', 2, 0),
(17, 55, 100, '2017-02-11 11:46:25', 2, 0),
(18, 55, 100, '2017-02-11 11:46:37', 2, 0),
(19, 55, 100, '2017-02-11 11:49:39', 2, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `pallet`
--

CREATE TABLE `pallet` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `pallet`
--

INSERT INTO `pallet` (`id`, `product_id`, `supplier_id`, `time`, `amount`, `user_id`, `deleted`) VALUES
(1, 41, 18, '2017-01-30 08:34:41', 10500, 3, 0),
(2, 51, 1, '2017-01-30 08:37:21', 392, 1, 0),
(3, 9, 4, '2017-01-30 08:37:56', 390, 1, 0),
(4, 12, 3, '2017-01-30 08:42:52', 269, 1, 0),
(5, 38, 1, '2017-01-30 08:43:53', 900, 1, 0),
(6, 16, 5, '2017-01-30 08:44:55', 260, 1, 0),
(7, 34, 3, '2017-01-30 08:46:09', 129, 1, 0),
(8, 28, 3, '2017-01-30 08:46:48', 85, 1, 0),
(9, 42, 18, '2017-01-30 08:48:11', 350, 1, 0),
(10, 26, 1, '2017-01-30 08:48:51', 165, 1, 0),
(11, 27, 1, '2017-01-30 08:49:40', 85, 1, 0),
(12, 27, 1, '2017-01-30 08:50:41', 25, 1, 0),
(13, 40, 18, '2017-01-30 08:52:25', 450, 1, 0),
(14, 36, 20, '2017-01-30 08:53:10', 600, 1, 0),
(15, 6, 9, '2017-01-30 08:53:35', 200, 1, 0),
(16, 8, 15, '2017-01-30 08:55:12', 262, 1, 0),
(17, 4, 4, '2017-01-30 08:55:36', 265, 1, 0),
(18, 4, 3, '2017-01-30 08:56:14', 239, 1, 0),
(19, 4, 3, '2017-01-30 08:56:14', 239, 1, 0),
(20, 4, 3, '2017-01-30 08:56:30', 195, 1, 0),
(21, 30, 3, '2017-01-30 08:57:08', 195, 1, 0),
(22, 28, 3, '2017-01-30 08:57:34', 40, 1, 0),
(23, 37, 3, '2017-01-30 08:58:38', 350, 1, 0),
(24, 5, 2, '2017-01-30 08:58:55', 252, 1, 0),
(25, 32, 1, '2017-01-30 08:59:15', 720, 1, 0),
(26, 20, 2, '2017-01-30 08:59:56', 5, 1, 0),
(27, 43, 2, '2017-01-30 09:00:17', 1, 1, 0),
(28, 31, 2, '2017-01-30 09:00:47', 18, 1, 0),
(29, 7, 2, '2017-01-30 09:01:43', 35, 1, 0),
(30, 25, 2, '2017-01-30 09:02:14', 24, 1, 0),
(31, 45, 3, '2017-01-30 09:02:56', 30, 1, 0),
(32, 47, 1, '2017-01-30 09:03:49', 180, 1, 0),
(33, 47, 1, '2017-01-30 09:04:16', 720, 1, 0),
(34, 49, 16, '2017-01-30 09:04:39', 9, 1, 0),
(35, 31, 2, '2017-01-30 09:05:14', 40, 1, 0),
(36, 35, 5, '2017-01-30 09:07:32', 200, 1, 0),
(37, 25, 2, '2017-01-30 09:08:05', 12, 1, 0),
(38, 20, 2, '2017-01-30 09:08:33', 5, 1, 0),
(39, 44, 2, '2017-01-30 09:09:06', 53, 1, 0),
(40, 11, 9, '2017-01-30 09:09:46', 520, 1, 0),
(41, 11, 9, '2017-01-30 09:10:08', 519, 1, 0),
(42, 13, 10, '2017-01-30 09:11:24', 120, 1, 0),
(43, 10, 8, '2017-01-30 09:11:42', 40, 1, 0),
(44, 29, 2, '2017-01-30 09:12:16', 1, 1, 0),
(45, 29, 2, '2017-01-30 09:13:31', 1, 1, 0),
(46, 25, 2, '2017-01-30 09:13:58', 6, 1, 0),
(47, 50, 15, '2017-01-30 09:14:44', 63, 1, 0),
(48, 46, 15, '2017-01-30 09:15:09', 32, 1, 0),
(49, 22, 1, '2017-01-30 09:16:02', 380, 1, 0),
(50, 14, 6, '2017-01-30 09:17:43', 120, 1, 0),
(51, 24, 5, '2017-01-30 09:18:22', 200, 1, 0),
(52, 42, 18, '2017-01-30 09:19:22', 365, 1, 0),
(53, 21, 1, '2017-01-30 09:19:49', 2000, 1, 0),
(54, 11, 9, '2017-01-30 09:21:10', 543, 1, 0),
(55, 11, 9, '2017-01-30 09:27:00', 3000, 1, 0),
(56, 6, 9, '2017-01-30 09:27:32', 800, 1, 0),
(57, 13, 10, '2017-01-30 09:38:33', 120, 3, 0),
(58, 39, 15, '2017-01-31 08:09:13', 9999999, 3, 0),
(60, 1, 19, '2017-01-31 10:35:08', 1, 4, 0),
(61, 1, 19, '2017-02-01 10:54:20', 6663, 2, 0),
(62, 51, 21, '2017-02-01 11:13:02', 552, 4, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `category_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `product`
--

INSERT INTO `product` (`id`, `name`, `category_id`, `type`, `deleted`) VALUES
(1, 'Alma', 1, 0, 0),
(2, 'Banán', 1, 0, 0),
(3, 'Bazsalikom', 3, 0, 0),
(4, 'Bébi spenót', 3, 0, 0),
(5, 'Burgonya', 3, 0, 0),
(6, 'Cékla', 3, 0, 0),
(7, 'Citrom', 1, 0, 0),
(8, 'Csemegekukorica 2650ml/db', 4, 0, 0),
(9, 'Endívia saláta', 3, 0, 0),
(10, 'Édes kömény', 3, 0, 0),
(11, 'Fejeskáposzta', 3, 0, 0),
(12, 'Frisée saláta', 3, 0, 0),
(13, 'Gomba', 4, 0, 0),
(14, 'Gyökér', 3, 0, 0),
(15, 'Hegyeser?s paprika', 4, 0, 1),
(16, 'Hegyeserös paprika', 3, 0, 0),
(17, 'Jégsaláta', 3, 0, 0),
(18, 'Kaliforniai paprika Sárga', 3, 0, 1),
(19, 'Kalif. paprika Zöld', 3, 0, 0),
(20, 'Kalif. paprika Sárga', 3, 0, 0),
(21, 'Kínai kel', 3, 0, 0),
(22, 'Koktélparadicsom', 3, 0, 0),
(23, 'Lilahagyma', 3, 0, 0),
(24, 'Lilakáposzta', 3, 0, 0),
(25, 'Lime', 1, 0, 0),
(26, 'Lollo bionda saláta', 3, 0, 0),
(27, 'Lollo rosso saláta', 3, 0, 0),
(28, 'Madársaláta', 3, 0, 0),
(29, 'Menta', 3, 0, 0),
(30, 'Misticanza saláta', 3, 0, 0),
(31, 'Narancs', 1, 0, 0),
(32, 'Paradicsom', 3, 0, 0),
(33, 'Piros retek', 3, 0, 0),
(34, 'Petrezselyem', 3, 0, 0),
(35, 'Póréhagyma', 3, 0, 0),
(36, 'Radicchio saláta', 3, 0, 0),
(37, 'Ruccola saláta', 3, 0, 0),
(38, 'Római saláta', 3, 0, 0),
(39, 'Salátaszív', 3, 0, 0),
(40, 'Sárgarépa egész', 3, 0, 0),
(41, 'Sárgarépa vágott', 3, 0, 0),
(42, 'Sárga sárgarépa vágott', 3, 0, 0),
(43, 'Snidling', 3, 0, 0),
(44, 'Cukkini', 3, 0, 0),
(45, 'Tatsoi', 3, 0, 0),
(46, 'Tonhal db', 4, 0, 0),
(47, 'Uborka', 3, 0, 0),
(48, 'Vöröshagyma', 3, 0, 0),
(49, 'Retekcsíra', 3, 0, 0),
(50, 'Oliva konzerv db', 4, 0, 0),
(51, 'Batavia', 3, 0, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `address` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `address`, `deleted`) VALUES
(1, 'Casa Cliente Gmbh', 'Ausztria', 0),
(2, 'Fruit Lord Kft.', 'Bp.', 0),
(3, 'Altamura', 'Olaszo.', 0),
(4, 'Alphacom', 'Németo.', 0),
(5, 'Zölden Friss Kft.', 'Nyársapát', 0),
(6, 'Dusnoki Zsoltné', 'Harta', 0),
(7, 'Bonduelle', 'Nagykőrös', 0),
(8, 'Békési Kft.', 'Bp.', 0),
(9, 'Karibi Bt.', 'Bugyi', 0),
(10, 'G-Globál Growing Kft.', 'Bp.', 0),
(11, 'Pusztai Zsoltné', 'Mo.', 0),
(12, 'Frugary Jamans', 'Mo.', 0),
(13, 'Ördögh Imre', 'Szeged', 0),
(14, 'Kiss', 'Mo.', 0),
(15, 'Hellas-Invest Kft.', 'Diósd', 0),
(16, 'Öko vital', 'Bp.', 0),
(17, 'Rago', '', 0),
(18, 'Matókné', 'Mo.', 0),
(19, 'Ábrahám', 'Mo.', 0),
(20, 'Garbin', '', 0),
(21, 'Univer', 'Kecskemét', 0),
(22, 'Prospero', 'Szeged', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `trash`
--

CREATE TABLE `trash` (
  `id` int(11) NOT NULL,
  `pallet_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `trash`
--

INSERT INTO `trash` (`id`, `pallet_id`, `amount`, `time`, `user_id`, `deleted`) VALUES
(1, 58, 9999999, '2017-01-31 08:16:09', 3, 0),
(2, 58, 9999999, '2017-01-31 08:18:29', 3, 0),
(3, 58, 9999998, '2017-01-31 08:19:22', 3, 0),
(4, 1, 1000, '2017-01-31 08:32:13', 3, 0),
(5, 60, 1, '2017-01-31 10:35:32', 4, 0),
(6, 60, 1, '2017-01-31 10:36:41', 4, 0),
(7, 58, 9999999, '2017-01-31 10:36:46', 4, 0),
(8, 1, 50, '2017-02-01 10:50:02', 2, 0),
(9, 11, 10, '2017-02-11 10:40:47', 2, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `type`, `deleted`) VALUES
(1, 'admin', 'kkpass', 0, 0),
(2, 'raktar', 'kkpass', 1, 0),
(3, 'Varga', '1111', 1, 0),
(4, 'Petrics', '0000', 1, 0);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `alert`
--
ALTER TABLE `alert`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `output`
--
ALTER TABLE `output`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `pallet`
--
ALTER TABLE `pallet`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `trash`
--
ALTER TABLE `trash`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `alert`
--
ALTER TABLE `alert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT a táblához `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT a táblához `output`
--
ALTER TABLE `output`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT a táblához `pallet`
--
ALTER TABLE `pallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT a táblához `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT a táblához `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT a táblához `trash`
--
ALTER TABLE `trash`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT a táblához `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
