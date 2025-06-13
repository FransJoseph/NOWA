-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 12, 2025 at 08:34 PM
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
CREATE DATABASE IF NOT EXISTS `cmentarz` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci;
USE `cmentarz`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `groby`
--

CREATE TABLE `groby` (
  `id` int(5) NOT NULL,
  `lokalizacja` text NOT NULL,
  `rodzaj` varchar(20) DEFAULT NULL,
  `oplata` varchar(20) NOT NULL,
  `notka` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `groby`
--

INSERT INTO `groby` (`id`, `lokalizacja`, `rodzaj`, `oplata`, `notka`) VALUES
(14, 'Północ', '', 'NIE', 'W trakcie likwidacji'),
(15, 'Wawer', 'grobowiec', 'TAK', 'Grzegorz (id 3) jest pochowany gdzie indziej'),
(16, 'Wawel', 'kolumbarium', 'TAK', ''),
(17, 'Północ', 'inny', 'NIE', 'Plakietka likwidacyjna'),
(18, 'Wawer', 'pomnik', 'TAK', 'Pomnik - w czysto lokalnej definicji'),
(19, 'Babel', 'ziemny', 'TAK', ''),
(20, 'Południe', 'ziemny', 'NIE', 'Opuszczony grób - brak tabliczki');

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
(1, 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Tomasz', 'Organista', 'admin@serwer.pl', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pochowki`
--

CREATE TABLE `pochowki` (
  `id` int(5) NOT NULL,
  `id_zmarly` int(5) NOT NULL,
  `id_grob` int(5) NOT NULL,
  `data_pochowku` date DEFAULT NULL,
  `rodzaj_pochowku` varchar(20) DEFAULT NULL,
  `notka_pochowku` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `pochowki`
--

INSERT INTO `pochowki` (`id`, `id_zmarly`, `id_grob`, `data_pochowku`, `rodzaj_pochowku`, `notka_pochowku`) VALUES
(31, 28, 15, '2008-04-23', 'trumna', ''),
(32, 29, 15, '1995-10-14', 'trumna', ''),
(33, 27, 16, '2003-12-19', 'urna', 'Pierwszy pochówek w kolumbarium'),
(34, 25, 14, NULL, '', 'Pochówek najpóźniej z lat 60\''),
(36, 22, 17, '1957-10-07', 'trumna', ''),
(37, 23, 18, '1997-06-18', 'trumna', ''),
(38, 26, 14, '1994-06-17', 'trumna', 'Tak naprawdę nie dożył 60tki - stąd brak daty urodzin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zmarli`
--

CREATE TABLE `zmarli` (
  `id` int(5) NOT NULL,
  `imie` varchar(50) DEFAULT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `data_urodzenia` date DEFAULT NULL,
  `data_smierci` date DEFAULT NULL,
  `notka` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `zmarli`
--

INSERT INTO `zmarli` (`id`, `imie`, `nazwisko`, `data_urodzenia`, `data_smierci`, `notka`) VALUES
(22, 'Anastazja', 'Bąk', '1865-06-14', '1957-10-04', ''),
(23, 'Tomisław', 'Gąsienica', '1969-07-22', '1997-06-18', ''),
(24, 'Grzegorz', 'Brzęczyszczykiewicz', '1890-04-02', '1949-11-10', 'Pochowany na cmentarzu w Chrząszczy-Grzeborzycach, wpisany na jednym z grobów rodzinnych'),
(25, '', 'Bednarz', NULL, NULL, 'Imię nieczytelne'),
(26, 'Józef', 'Barykadowicz', NULL, '1994-06-14', 'Żył kopę lat'),
(27, 'Marzena', 'Warzała', '1949-04-10', '2003-12-16', 'Czytaj \"War-zała\"'),
(28, 'Ula', 'Lenartowicz', '1949-03-01', '2008-04-19', ''),
(29, 'Łużyn', 'Lenartowicz', '1940-09-02', '1995-10-11', '');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `groby`
--
ALTER TABLE `groby`
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
  ADD KEY `id osoby` (`id_zmarly`,`id_grob`),
  ADD KEY `id_grob` (`id_grob`);

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
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `operatorzy`
--
ALTER TABLE `operatorzy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pochowki`
--
ALTER TABLE `pochowki`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `zmarli`
--
ALTER TABLE `zmarli`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pochowki`
--
ALTER TABLE `pochowki`
  ADD CONSTRAINT `pochowki_ibfk_1` FOREIGN KEY (`id_zmarly`) REFERENCES `zmarli` (`id`),
  ADD CONSTRAINT `pochowki_ibfk_2` FOREIGN KEY (`id_grob`) REFERENCES `groby` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
