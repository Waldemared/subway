-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 09 2019 г., 08:54
-- Версия сервера: 8.0.15
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `subway`
--

-- --------------------------------------------------------

--
-- Структура таблицы `line`
--

CREATE TABLE `line` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `path` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `line`
--

INSERT INTO `line` (`id`, `name`, `path`) VALUES
(1, 'Кировско-Выборгская', 'kirovsko-vyborgskaya'),
(2, 'Московско-Петроградская', 'moskovsko-petrogradskaya'),
(3, 'Невско-Василеостровская', 'nevsko-vasileostrovskaya'),
(4, 'Правобережная', 'pravoberezhnaya'),
(5, 'Фрунзенско-Приморская', 'frunzensko-primorskaya');

-- --------------------------------------------------------

--
-- Структура таблицы `station`
--

CREATE TABLE `station` (
  `path` varchar(40) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `foundation_year` int(11) DEFAULT NULL,
  `line_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `station`
--

INSERT INTO `station` (`path`, `name`, `position`, `foundation_year`, `line_id`) VALUES
('admiralteyskaya', 'Адмиралтейская', 6, 2011, 5),
('akademicheskaya', 'Академическая', 3, 1975, 1),
('avtovo', 'Автово', 17, 1955, 1),
('baltiyskaya', 'Балтийская', 14, 1955, 1),
('buharestskaya', 'Бухарестская', 11, 2012, 5),
('chernyshevskaya', 'Чернышевская', 9, 1958, 1),
('chiornaya-rechka', 'Чёрная речка', 6, 1982, 2),
('chkalovskaya', 'Чкаловская', 4, 1997, 5),
('deviatkino', 'Девяткино', 1, 1978, 1),
('dostoyevskaya', 'Достоевская', 2, 1991, 4),
('elektrosila', 'Электросила', 14, 1961, 2),
('frunzenskaya', 'Фрунзенская', 12, 1961, 2),
('gorkovskaya', 'Горьковская', 8, 1963, 2),
('gostiny-dvor', 'Гостиный Двор', 3, 1967, 3),
('grazhdanskiy-pr', 'Гражданский проспект', 2, 1978, 1),
('kirovskiy-zavod', 'Кировский завод', 16, 1955, 1),
('komendantskiy-pr', 'Комендантский проспект', 1, 2005, 5),
('krestovskiy-ostrov', 'Крестовский остров', 3, 1999, 5),
('kupchino', 'Купчино', 18, 1972, 2),
('ladozhskaya', 'Ладожская', 6, 1985, 4),
('leninskiy-pr', 'Ленинский проспект', 18, 1977, 1),
('lesnaya', 'Лесная', 6, 1975, 1),
('ligovskiy-pr', 'Лиговский проспект', 3, 1991, 4),
('lomonosovskaya', 'Ломоносовская', 7, 1970, 3),
('mayakovskaya', 'Маяковская', 4, 1967, 3),
('mezhdunarodnaya', 'Международная', 12, 2012, 5),
('moskovskaya', 'Московская', 16, 1969, 2),
('moskovskiye-vorota', 'Московские ворота', 13, 1961, 2),
('narvskaya', 'Нарвская', 15, 1955, 1),
('nevskiy-prospekt', 'Невский проспект', 9, 1963, 2),
('novocherkasskaya', 'Новочеркасская', 5, 1985, 4),
('obuhovo', 'Обухово', 9, 1981, 3),
('obvodny-kanal', 'Обводный канал', 9, 2010, 5),
('ozerki', 'Озерки', 3, 1988, 2),
('park-pobedy', 'Парк Победы', 15, 1961, 2),
('parnas', 'Парнас', 1, 2006, 2),
('petrogradskaya', 'Петроградская', 7, 1963, 2),
('pionerskaya', 'Пионерская', 5, 1982, 2),
('pl-aleksandra-nevskogo', 'Площадь Александра Невского', 5, 1967, 3),
('pl-aleksandra-nevskogo2', 'Площадь Александра Невского 2', 4, 1985, 4),
('pl-lenina', 'Площадь Ленина', 8, 1958, 1),
('pl-muzhestva', 'Площадь Мужества', 5, 1975, 1),
('pl-vosstaniya', 'Площадь Восстания', 10, 1955, 1),
('politehnicheskaya', 'Политехническая', 4, 1975, 1),
('pr-bolshevikov', 'Проспект Большевиков', 7, 1985, 4),
('pr-prosvescheniya', 'Проспект Просвещения', 2, 1988, 2),
('pr-veteranov', 'Проспект Ветеранов', 19, 1977, 1),
('primorskaya', 'Приморская', 1, 1979, 3),
('proletarskaya', 'Пролетарская', 8, 1981, 3),
('pushkinskaya', 'Пушкинская', 12, 1956, 1),
('rybatskoye', 'Рыбацкое', 10, 1984, 3),
('sadovaya', 'Садовая', 7, 1991, 5),
('sennaya-pl', 'Сенная площадь', 10, 1963, 2),
('spasskaya', 'Спасская', 1, 2009, 4),
('sportivnaya', 'Спортивная', 5, 1997, 5),
('staraya-derevnia', 'Старая Деревня', 2, 1999, 5),
('tehnologicheskiy-institut', 'Технологический институт', 13, 1955, 1),
('tehnologicheskiy-institut2', 'Технологический институт 2', 11, 1955, 2),
('udelnaya', 'Удельная', 4, 1982, 2),
('ul-dybenko', 'Улица Дыбенко', 8, 1987, 4),
('vasileostrovskaya', 'Василеостровская', 2, 1967, 3),
('vladimirskaya', 'Владимирская', 11, 1955, 1),
('volkovskaya', 'Волковская', 10, 2008, 5),
('vyborgskaya', 'Выборгская', 7, 1975, 1),
('yelizarovskaya', 'Елизаровская', 6, 1970, 3),
('zvenigorodskaya', 'Звенигородская', 8, 2008, 5),
('zviozdnaya', 'Звёздная', 17, 1972, 2);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `line`
--
ALTER TABLE `line`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `station`
--
ALTER TABLE `station`
  ADD PRIMARY KEY (`path`),
  ADD KEY `line_id` (`line_id`);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `station`
--
ALTER TABLE `station`
  ADD CONSTRAINT `station_ibfk_1` FOREIGN KEY (`line_id`) REFERENCES `line` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
