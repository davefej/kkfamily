-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2017. Jan 25. 15:01
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
(1, 'zöldség', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `output`
--

INSERT INTO `output` (`id`, `pallet_id`, `amount`, `time`, `user_id`, `deleted`) VALUES
(1, 2, 31, '2017-01-24 18:52:34', 2, 0),
(2, 1, 101, '2017-01-25 10:47:24', 1, 0);

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
(1, 2, 1, '2017-01-24 17:48:39', 101, 2, 0),
(2, 3, 6, '2017-01-25 10:26:31', 213, 0, 0),
(3, 3, 3, '2017-01-25 12:56:04', 321, 1, 0);

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
(1, 'Fehér Répa', 2, 1, 0),
(2, 'Sárga Répa', 1, 0, 0),
(3, 'Zeller', 1, 0, 0);

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
(1, 'TESZT Beszállító 1.', 'Budapest Fő utca 23', 0),
(2, 'Teszt Beszállító 2', 'Budapest Alkotás utca 1', 0),
(3, 'Beszállí Tóni', 'Budapest xxx utca 2.', 0),
(4, 'Beszállító 3.', 'Budakeszi fő utca 2.', 0),
(5, 'XYZ KFT.', 'Tök, Jókai utca 2.', 0),
(6, 'TESZT Beszállító', 'Budakeszi', 0),
(11, 'Beszálllító 5', 'Teszt utca', 0),
(12, 'TESZT Beszállító 1.', 'Budapest Fő utca 23', 0),
(13, 'Beszallito 6', 'Teszt cím', 0);

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
(1, 2, 11, '2017-01-24 16:44:55', 2, 0);

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
(1, 'Kis Pisti', 'alma', 0, 0),
(2, 'admin', 'kkpass', 0, 0),
(3, 'raktar', 'kkpass', 1, 0);

--
-- Indexek a kiírt táblákhoz
--

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
-- AUTO_INCREMENT a táblához `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT a táblához `output`
--
ALTER TABLE `output`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT a táblához `pallet`
--
ALTER TABLE `pallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT a táblához `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT a táblához `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT a táblához `trash`
--
ALTER TABLE `trash`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT a táblához `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
