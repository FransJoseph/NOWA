-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 26, 2025 at 10:45 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cmentarz`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `groby`
--

CREATE TABLE `groby` (
  `id` int(5) NOT NULL,
  `lokalizacja` text NOT NULL,
  `rodzaj` varchar(20) NOT NULL,
  `oplata` varchar(20) NOT NULL,
  `notka` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `groby`
--

INSERT INTO `groby` (`id`, `lokalizacja`, `rodzaj`, `oplata`, `notka`) VALUES
(1, 'Północna', 'grób rodzinny', 'TAK', 'Do pogrzebania Poland2k50 Sz Grobowni'),
(8, 'Plac Cyrwony', 'pomnik', 'NIE', 'Nie musi płacić - to państwowe (co jak przyjdą czerwoni???)');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(50) NOT NULL,
  `adres` varchar(100) NOT NULL,
  `opis` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `klienci`
--

INSERT INTO `klienci` (`id`, `nazwa`, `adres`, `opis`) VALUES
(1, 'Żabka', 'ul. Las 1, 32-600 Tychy', NULL),
(4, 'ABC Oświęcim', 'ABC Oświęcim', 'fajna firma, dawać rabaty.   \r\n        ');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `operatorzy`
--

CREATE TABLE `operatorzy` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `haslo` varchar(300) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `operatorzy`
--

INSERT INTO `operatorzy` (`id`, `login`, `haslo`, `imie`, `nazwisko`, `email`, `status`) VALUES
(1, 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Adam', 'Administracyjny', 'admin@serwer.pl', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pochowki`
--

CREATE TABLE `pochowki` (
  `id` int(5) NOT NULL,
  `id_osoby` int(5) NOT NULL,
  `id_grobu` int(5) NOT NULL,
  `data_pochowku` date DEFAULT NULL,
  `rodzaj_pochowku` varchar(20) DEFAULT NULL,
  `notka_pochowku` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `towary`
--

CREATE TABLE `towary` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(50) NOT NULL,
  `ilosc` int(11) NOT NULL,
  `jm` varchar(5) NOT NULL,
  `cena` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `towary`
--

INSERT INTO `towary` (`id`, `nazwa`, `ilosc`, `jm`, `cena`) VALUES
(1, 'Rezystor', 10, 'szt.', 123),
(2, 'Rezystor', 100, 'szt.', 12.05),
(3, 'towar1', 0, 'm', 0),
(4, 'test123', 0, 'cm', 0),
(5, 'aaaaaaaaaaa', 0, 'cm', 0),
(6, 'aaaa', 0, 'm', 0),
(7, 'aaaa', 0, 'm', 0),
(8, 'aaaa', 0, 'm', 0),
(9, 'aaaa', 0, 'm', 0),
(10, 'aaaa', 0, 'm', 0),
(11, 'aaaa', 0, 'm', 0),
(12, 'sssssssss', 1111, 'm', 1.11),
(13, '', 0, '', 0),
(14, '', 0, '', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zmarli`
--

CREATE TABLE `zmarli` (
  `id` int(5) NOT NULL,
  `imie` varchar(50) DEFAULT NULL,
  `nazwisko` varchar(50) DEFAULT NULL,
  `data_urodzenia` date DEFAULT NULL,
  `data_smierci` date DEFAULT NULL,
  `notka` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `zmarli`
--

INSERT INTO `zmarli` (`id`, `imie`, `nazwisko`, `data_urodzenia`, `data_smierci`, `notka`) VALUES
(1, 'Adolf', 'Hitler', '2025-05-06', '2025-05-16', 'Akta tajne'),
(12, 'Józef', 'Dżugaszfili-Stalin', '1111-11-11', '1111-11-11', 'Przeniesiony');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `groby`
--
ALTER TABLE `groby`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `operatorzy`
--
ALTER TABLE `operatorzy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `pochowki`
--
ALTER TABLE `pochowki`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id osoby` (`id_osoby`,`id_grobu`),
  ADD KEY `id grobu` (`id_grobu`);

--
-- Indeksy dla tabeli `towary`
--
ALTER TABLE `towary`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zmarli`
--
ALTER TABLE `zmarli`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groby`
--
ALTER TABLE `groby`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `klienci`
--
ALTER TABLE `klienci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `operatorzy`
--
ALTER TABLE `operatorzy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pochowki`
--
ALTER TABLE `pochowki`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `towary`
--
ALTER TABLE `towary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `zmarli`
--
ALTER TABLE `zmarli`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pochowki`
--
ALTER TABLE `pochowki`
  ADD CONSTRAINT `pochowki_ibfk_1` FOREIGN KEY (`id_osoby`) REFERENCES `zmarli` (`id`),
  ADD CONSTRAINT `pochowki_ibfk_2` FOREIGN KEY (`id_grobu`) REFERENCES `groby` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
