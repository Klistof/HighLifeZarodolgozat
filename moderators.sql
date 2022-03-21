-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2022. Már 21. 10:35
-- Kiszolgáló verziója: 10.5.12-MariaDB-0+deb11u1
-- PHP verzió: 7.2.34-28+0~20211119.67+debian11~1.gbpf24e81

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `moderators`
--
CREATE DATABASE IF NOT EXISTS `moderators` DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE `moderators`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `dutytime`
--

CREATE TABLE `dutytime` (
  `ID` int(11) NOT NULL,
  `uID` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `min` int(11) DEFAULT 1,
  `activetime` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `generatetable`
--

CREATE TABLE `generatetable` (
  `uID` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `key` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `log`
--

CREATE TABLE `log` (
  `ID` int(11) NOT NULL,
  `uID` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `joined` text COLLATE utf8_hungarian_ci NOT NULL,
  `leaved` text COLLATE utf8_hungarian_ci NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `members`
--

CREATE TABLE `members` (
  `ID` int(11) NOT NULL,
  `name` text COLLATE utf8_hungarian_ci NOT NULL,
  `uID` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `rank` text COLLATE utf8_hungarian_ci NOT NULL,
  `lastSeen` date DEFAULT current_timestamp(),
  `connection` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `members`
--

INSERT INTO `members` (`ID`, `name`, `uID`, `rank`, `lastSeen`, `connection`) VALUES
(1, 'admin', 'admin', 'Operátor', '2022-03-17', 0),
(2, 'user', 'user', 'Moderátor 1', '2022-03-17', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `upload`
--

CREATE TABLE `upload` (
  `ID` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `date` date NOT NULL,
  `identity` text COLLATE utf8_hungarian_ci NOT NULL,
  `aproved` tinyint(1) NOT NULL,
  `photoURL` text COLLATE utf8_hungarian_ci NOT NULL,
  `UCP` text COLLATE utf8_hungarian_ci NOT NULL,
  `aprovedBy` text COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `username` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `password` text COLLATE utf8_hungarian_ci NOT NULL,
  `email` text COLLATE utf8_hungarian_ci NOT NULL,
  `level` int(11) NOT NULL,
  `uID` varchar(100) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`username`, `password`, `email`, `level`, `uID`) VALUES
('admin', '$2y$10$.WYwCmrzZ8GlxnIsCl8SDupm.N.Wa9ed/HVwMNFS0yMWkHyFZTKJ.', 'admin@admin.hu', 2, 'admin'),
('user', '$2y$10$uVCYD.UTsyM4ly9F00DU3uOrwNieqVhsfFfHPIkdNb8vEG.5pmfvW', 'user@user.hu', 0, 'user');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `warns`
--

CREATE TABLE `warns` (
  `ID` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `reason` text COLLATE utf8_hungarian_ci NOT NULL,
  `date` text COLLATE utf8_hungarian_ci NOT NULL,
  `admin` text COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `dutytime`
--
ALTER TABLE `dutytime`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `uID` (`uID`);

--
-- A tábla indexei `generatetable`
--
ALTER TABLE `generatetable`
  ADD PRIMARY KEY (`uID`);

--
-- A tábla indexei `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `uID` (`uID`);

--
-- A tábla indexei `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`ID`) USING BTREE;

--
-- A tábla indexei `upload`
--
ALTER TABLE `upload`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `username` (`username`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `uID` (`uID`) USING BTREE;

--
-- A tábla indexei `warns`
--
ALTER TABLE `warns`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `username` (`username`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `dutytime`
--
ALTER TABLE `dutytime`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT a táblához `log`
--
ALTER TABLE `log`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT a táblához `members`
--
ALTER TABLE `members`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `upload`
--
ALTER TABLE `upload`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT a táblához `warns`
--
ALTER TABLE `warns`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `dutytime`
--
ALTER TABLE `dutytime`
  ADD CONSTRAINT `dutytime_ibfk_1` FOREIGN KEY (`uID`) REFERENCES `users` (`uID`);

--
-- Megkötések a táblához `generatetable`
--
ALTER TABLE `generatetable`
  ADD CONSTRAINT `generatetable_ibfk_1` FOREIGN KEY (`uID`) REFERENCES `users` (`uID`);

--
-- Megkötések a táblához `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`uID`) REFERENCES `users` (`uID`);

--
-- Megkötések a táblához `upload`
--
ALTER TABLE `upload`
  ADD CONSTRAINT `upload_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Megkötések a táblához `warns`
--
ALTER TABLE `warns`
  ADD CONSTRAINT `warns_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
