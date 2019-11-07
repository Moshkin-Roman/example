-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Ноя 07 2019 г., 15:04
-- Версия сервера: 5.5.60-MariaDB
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `dl`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comm_id` int(5) NOT NULL,
  `comm_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comm_name` varchar(50) NOT NULL,
  `comm_email` varchar(50) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `comments`
--

TRUNCATE TABLE `comments`;
--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`comm_id`, `comm_date`, `comm_name`, `comm_email`, `comment`) VALUES
(1, '2019-11-07 10:47:20', 'Роман', 'odggbo@gmail.com', 'Отличная работа!'),
(2, '2019-11-07 10:47:20', 'Иванов', 'iv@ya.ru', 'Согласен, очень хорошо.');

-- --------------------------------------------------------

--
-- Структура таблицы `picters`
--

CREATE TABLE IF NOT EXISTS `picters` (
  `pic_id` int(11) NOT NULL,
  `comm_id` int(5) NOT NULL,
  `pic_url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `picters`
--

TRUNCATE TABLE `picters`;
--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comm_id`);

--
-- Индексы таблицы `picters`
--
ALTER TABLE `picters`
  ADD PRIMARY KEY (`pic_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `comm_id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `picters`
--
ALTER TABLE `picters`
  MODIFY `pic_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
