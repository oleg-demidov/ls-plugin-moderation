-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 25 2019 г., 10:00
-- Версия сервера: 5.7.24-0ubuntu0.16.04.1
-- Версия PHP: 5.6.38-3+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pdd`
--

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_moderation`
--

CREATE TABLE `prefix_moderation` (
  `id` int(10) UNSIGNED NOT NULL,
  `entity_id` int(10) UNSIGNED NOT NULL,
  `entity` varchar(100) COLLATE utf8_bin NOT NULL,
  `state` smallint(5) UNSIGNED NOT NULL,
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `prefix_moderation`
--
ALTER TABLE `prefix_moderation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `entity_id_2` (`entity_id`,`entity`) USING BTREE,
  ADD KEY `entity_id` (`entity_id`),
  ADD KEY `entity` (`entity`),
  ADD KEY `state` (`state`),
  ADD KEY `date_create` (`date_create`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `prefix_moderation`
--
ALTER TABLE `prefix_moderation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;