-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Авг 16 2018 г., 14:13
-- Версия сервера: 5.7.22-0ubuntu18.04.1
-- Версия PHP: 7.2.5-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `guestbook`
--

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `message_id` int(10) UNSIGNED NOT NULL,
  `theme` varchar(128) DEFAULT NULL,
  `text` text,
  `pictures` varchar(128) DEFAULT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip` varchar(128) DEFAULT NULL,
  `browser` varchar(128) DEFAULT NULL,
  `id_user` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`message_id`, `theme`, `text`, `pictures`, `filepath`, `date`, `ip`, `browser`, `id_user`) VALUES
(133, 'ÐŸÑ€Ð¾ Ð±Ð¾Ð±Ñ€Ð°', '<i>Ð‘Ð¾Ð±ÐµÑ€</i> â€” Ð´Ð¾Ð²Ð¾Ð»ÑŒÐ½Ð¾ ÐºÑ€ÑƒÐ¿Ð½Ñ‹Ð¹ Ð³Ñ€Ñ‹Ð·ÑƒÐ½, Ð¶Ð¸Ð²ÑƒÑ‰Ð¸Ð¹ Ð²Ð´Ð¾Ð»ÑŒ Ð±ÐµÑ€ÐµÐ³Ð¾Ð² Ñ€ÐµÐº. ÐžÐ½ Ð¸Ð·Ð²ÐµÑÑ‚ÐµÐ½ ÐºÐ°Ðº Ñ…Ð¾Ñ€Ð¾ÑˆÐ¸Ð¹ Ð¿Ð»Ð¾Ð²ÐµÑ† Ð¸ ÑÐ¾Ð·Ð´Ð°Ñ‚ÐµÐ»ÑŒ Ð¿Ð»Ð¾Ñ‚Ð¸Ð½. Ð Ð°ÑÐ¿Ñ€Ð¾ÑÑ‚Ñ€Ð°Ð½ÐµÐ½ Ð² Ð¡ÐµÐ²ÐµÑ€Ð½Ð¾Ð¹ ÐÐ¼ÐµÑ€Ð¸ÐºÐµ Ð¸ Ð•Ð²Ñ€Ð°Ð·Ð¸Ð¸. Ð•Ð³Ð¾ Ñ†ÐµÐ½ÑÑ‚ Ð·Ð° Ñ€Ð¾ÑÐºÐ¾ÑˆÐ½Ñ‹Ð¹ Ð¼ÐµÑ… Ð¸ Ð±Ð¾Ð±Ñ€Ð¾Ð²ÑƒÑŽ ÑÑ‚Ñ€ÑƒÑŽ, ÐºÐ¾Ñ‚Ð¾Ñ€Ð°Ñ Ð¸ÑÐ¿Ð¾Ð»ÑŒÐ·ÑƒÐµÑ‚ÑÑ Ð² Ð¿Ð°Ñ€Ñ„ÑŽÐ¼ÐµÑ€Ð¸Ð¸, Ð¿Ð¾ÑÑ‚Ð¾Ð¼Ñƒ Ð»ÑŽÐ´Ð¸ Ð¸Ð·Ð´Ð°Ð²Ð½Ð° Ð½Ð° Ð½ÐµÐ³Ð¾ Ð¾Ñ…Ð¾Ñ‚ÑÑ‚ÑÑ.', 'bober.jpg', 'upload/txt/beaver.txt', '2018-08-16 13:38:20', '192.168.10.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 49),
(134, 'ÐŸÑ€Ð¾ Ð¶ÑƒÐºÐ¾Ð²', '<i>Ð–ÑƒÐº</i> â€“ ÑÑ‚Ð¾ Ð½Ð°ÑÐµÐºÐ¾Ð¼Ð¾Ðµ, ÐºÐ¾Ñ‚Ð¾Ñ€Ð¾Ðµ Ð¾Ñ‚Ð½Ð¾ÑÐ¸Ñ‚ÑÑ Ðº Ñ†Ð°Ñ€ÑÑ‚Ð²Ñƒ Ð¶Ð¸Ð²Ð¾Ñ‚Ð½Ñ‹Ðµ, Ñ‚Ð¸Ð¿Ñƒ Ñ‡Ð»ÐµÐ½Ð¸ÑÑ‚Ð¾Ð½Ð¾Ð³Ð¸Ðµ, ÐºÐ»Ð°ÑÑÑƒ Ð½Ð°ÑÐµÐºÐ¾Ð¼Ñ‹Ðµ, Ð¾Ñ‚Ñ€ÑÐ´Ñƒ Ð¶ÐµÑÑ‚ÐºÐ¾ÐºÑ€Ñ‹Ð»Ñ‹Ðµ, Ð¸Ð»Ð¸ Ð¶ÑƒÐºÐ¸ (Ð»Ð°Ñ‚. Coleoptera).', 'Ð–ÑƒÐº.jpg', 'upload/txt/beetle.txt', '2018-08-16 13:41:54', '192.168.10.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 50),
(135, 'Ðž ÑÐ»Ð¾Ð½Ð°Ñ…', '<strong>Ð¡Ð»Ð¾Ð½Ñ‹ </strong>Ð¾Ð±Ð¸Ñ‚Ð°ÑŽÑ‚ Ð² ÐÑ„Ñ€Ð¸ÐºÐµ Ð¸ Ð² Ð˜Ð½Ð´Ð¸Ð¸. Ð’ ÑÑ‚Ð¸Ñ… Ð¼ÐµÑÑ‚Ð°Ñ… Ð¼Ð½Ð¾Ð³Ð¾ Ñ‚Ñ€Ð¾Ð¿Ð¸Ñ‡ÐµÑÐºÐ¸Ñ… Ð»ÐµÑÐ¾Ð², Ð³Ð´Ðµ Ð¾Ð½Ð¸ Ð¸ Ð¶Ð¸Ð²ÑƒÑ‚.', 'slon.jpg', 'upload/txt/elephant.txt', '2018-08-16 13:44:49', '192.168.10.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 49),
(136, 'ÐÐ¼ÑƒÑ€ÑÐºÐ¸Ð¹ Ñ‚Ð¸Ð³Ñ€ - Ð¾Ð½ Ð¶Ðµ ÑƒÑÑÑƒÑ€Ð¸Ð¹ÑÐºÐ¸Ð¹', 'Ð–Ð¸Ð²ÑƒÑ‚ ÑÑ‚Ð¸ Ð·Ð²ÐµÑ€Ð¸ Ð½Ð° Ð”Ð°Ð»ÑŒÐ½ÐµÐ¼ Ð’Ð¾ÑÑ‚Ð¾ÐºÐµ, Ñ€ÑÐ´Ð¾Ð¼ Ñ Ñ€ÐµÐºÐ°Ð¼Ð¸ <strong>ÐÐ¼ÑƒÑ€ </strong>Ð¸ <strong>Ð£ÑÑÑƒÑ€Ð°</strong>, Ð¿Ð¾ÑÑ‚Ð¾Ð¼Ñƒ Ð¸ Ð½Ð°Ð·Ñ‹Ð²Ð°ÐµÑ‚ÑÑ Ð°Ð¼ÑƒÑ€ÑÐºÐ¸Ð¼ Ð¸Ð»Ð¸ ÑƒÑÑÑƒÑ€Ð¸Ð¹ÑÐºÐ¸Ð¼ Ñ‚Ð¸Ð³Ñ€Ð¾Ð¼, Ñ‡Ñ‚Ð¾ Ð¾Ð´Ð½Ð¾ Ð¸ Ñ‚Ð¾Ð¶Ðµ.', 'ussuriiskii.jpg', 'upload/txt/tiger.txt', '2018-08-16 13:47:09', '192.168.10.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 51),
(137, 'Ð Ñ‹Ð¶Ð°Ñ Ð»Ð¸ÑÐ°', '<i>Ð›Ð¸ÑÐ¸Ñ†Ð°</i> â€” ÑÑ‚Ð¾ Ñ…Ð¸Ñ‰Ð½Ð¾Ðµ Ð¶Ð¸Ð²Ð¾Ñ‚Ð½Ð¾Ðµ, Ð¾Ñ‚Ð½Ð¾ÑÐ¸Ñ‚ÑÑ Ðº ÑÐµÐ¼ÐµÐ¹ÑÑ‚Ð²Ñƒ Ð¿ÑÐ¾Ð²Ñ‹Ñ…. Ð’Ð½ÐµÑˆÐ½Ðµ Ð¿Ð¾Ñ…Ð¾Ð¶Ð° Ð½Ð° ÑÑ€ÐµÐ´Ð½Ð¸Ñ… Ñ€Ð°Ð·Ð¼ÐµÑ€Ð¾Ð² ÑÐ¾Ð±Ð°ÐºÑƒ, Ð½Ð¾ Ð¿Ð¾Ð²Ð°Ð´ÐºÐ¸ Ñƒ Ð½ÐµÑ‘ Ð±Ð¾Ð»ÑŒÑˆÐµ ÐºÐ¾ÑˆÐ°Ñ‡ÑŒÐ¸. ÐÐ° ÐµÑ‘ Ð³Ð¸Ð±ÐºÐ¾Ð¼ Ñ‚ÐµÐ»Ðµ Ñ€Ð°ÑÐ¿Ð¾Ð»Ð¾Ð¶ÐµÐ½Ð° Ð°ÐºÐºÑƒÑ€Ð°Ñ‚Ð½Ð°Ñ Ð³Ð¾Ð»Ð¾Ð²Ð° Ñ Ð¾ÑÑ‚Ñ€Ð¾Ð¹ Ð¼Ð¾Ñ€Ð´Ð¾Ñ‡ÐºÐ¾Ð¹ Ð¸ Ð¿Ð¾Ð´Ð²Ð¸Ð¶Ð½Ñ‹Ð¼Ð¸, Ð²ÑÐµÐ³Ð´Ð° Ð½Ð°ÑÑ‚Ð¾Ñ€Ð¾Ð¶ÐµÐ½Ð½Ñ‹Ð¼Ð¸, ÐºÑ€ÑƒÐ¿Ð½Ñ‹Ð¼Ð¸ Ñ‚Ñ‘Ð¼Ð½Ñ‹Ð¼Ð¸ ÑƒÑˆÐ°Ð¼Ð¸, Ð½Ð¾Ð³Ð¸ Ð½ÐµÐ´Ð»Ð¸Ð½Ð½Ñ‹Ðµ, Ñ‚Ð¾Ð½ÐºÐ¸Ðµ, Ð½Ð¾ ÐºÑ€ÐµÐ¿ÐºÐ¸Ðµ.', 'lisa.jpg', 'upload/txt/fox.txt', '2018-08-16 13:52:43', '192.168.10.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 49),
(138, 'ÐŸÑ€Ð¾ Ð±ÑƒÑ€Ð¾Ð³Ð¾ Ð¼ÐµÐ´Ð²ÐµÐ´Ñ', '<i>Ð‘ÑƒÑ€Ñ‹Ð¹ Ð¼ÐµÐ´Ð²ÐµÐ´ÑŒ</i> â€” ÐºÑ€ÑƒÐ¿Ð½ÐµÐ¹ÑˆÐ¸Ð¹ Ð»ÐµÑÐ½Ð¾Ð¹ Ð¾Ð±Ð¸Ñ‚Ð°Ñ‚ÐµÐ»ÑŒ, Ñ…Ð¸Ñ‰Ð½Ð¸Ðº. Ð–Ð¸Ð²ÐµÑ‚ Ð² Ð»ÐµÑÐ½Ñ‹Ñ… Ð¼Ð°ÑÑÐ¸Ð²Ð°Ñ… Ð² Ð¡Ð¸Ð±Ð¸Ñ€Ð¸, Ð½Ð° Ð”Ð°Ð»ÑŒÐ½ÐµÐ¼ Ð’Ð¾ÑÑ‚Ð¾ÐºÐµ, Ð½Ð° ÐšÐ°Ð¼Ñ‡Ð°Ñ‚ÐºÐµ, Ð² Ð³Ð¾Ñ€Ð½Ñ‹Ñ… Ð»ÐµÑÐ°Ñ… ÐšÐ°Ð²ÐºÐ°Ð·Ð°. Ð’ÑÑ‚Ñ€ÐµÑ‡Ð°ÐµÑ‚ÑÑ Ð² Ñ‚Ð°Ð¹Ð³Ðµ, Ñ‚ÑƒÐ½Ð´Ñ€Ðµ.', 'buryi-medved.jpg', 'upload/txt/bear.txt', '2018-08-16 14:04:38', '192.168.10.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 52),
(139, 'ÐŸÑ€Ð¾ Ð±ÐµÐ»Ð¾Ð³Ð¾ Ð¼ÐµÐ´Ð²ÐµÐ´Ñ', '<strong>Ð‘ÐµÐ»Ñ‹Ð¹ Ð¼ÐµÐ´Ð²ÐµÐ´ÑŒ</strong> â€” ÑÑ‚Ð¾ Ð¾Ð´Ð¸Ð½ Ð¸Ð· ÑÐ°Ð¼Ñ‹Ñ… ÐºÑ€ÑƒÐ¿Ð½Ñ‹Ñ… Ñ…Ð¸Ñ‰Ð½Ð¸ÐºÐ¾Ð² Ð½Ð° Ð—ÐµÐ¼Ð»Ðµ. Ð•Ð³Ð¾ Ð²ÐµÑ ÑÐ¾ÑÑ‚Ð°Ð²Ð»ÑÐµÑ‚ Ð¾Ñ‚ 300 Ð´Ð¾ 800 ÐºÐ³, Ð° Ð´Ð»Ð¸Ð½Ð° Ð¼Ð¾Ð¶ÐµÑ‚ Ð´Ð¾Ñ…Ð¾Ð´Ð¸Ñ‚ÑŒ Ð´Ð¾ Ñ‚Ñ€ÐµÑ… Ð¼ÐµÑ‚Ñ€Ð¾Ð². Ð¡Ð²ÐµÑ‚Ð»Ð°Ñ, Ð° Ð¸Ð½Ð¾Ð³Ð´Ð° Ð¸ Ð¶ÐµÐ»Ñ‚Ð¾Ð²Ð°Ñ‚Ð°Ñ ÑˆÐµÑ€ÑÑ‚ÑŒ Ñ…Ñ€Ð°Ð½Ð¸Ñ‚ Ð¿Ð¾Ð´ÐºÐ¾Ð¶Ð½Ñ‹Ð¹ Ð¶Ð¸Ñ€ Ð¸ Ñ…Ð¾Ñ€Ð¾ÑˆÐ¾ Ð·Ð°Ñ‰Ð¸Ñ‰Ð°ÐµÑ‚ Ð¾Ñ‚ Ñ…Ð¾Ð»Ð¾Ð´Ð°, Ð¿Ð¾ÑÑ‚Ð¾Ð¼Ñƒ Ð¶Ð¸Ð²Ð¾Ñ‚Ð½Ñ‹Ðµ Ð½Ðµ Ð¼ÐµÑ€Ð·Ð½ÑƒÑ‚ Ð½Ð¸ Ð½Ð° ÑÑƒÑˆÐµ, Ð½Ð¸ Ð¿Ð¾Ð´ Ð²Ð¾Ð´Ð¾Ð¹. ', 'belyi-medved.jpg', 'upload/txt/polarbear.txt', '2018-08-16 14:09:32', '192.168.10.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 53);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`) VALUES
(49, 'Ivan Ivanov', 'iivanov@gmail.com'),
(50, 'Ivan Gukov', 'igukov@gmail.com'),
(51, 'Petr Petrov', 'ppetrov@gmail.com'),
(52, 'Petr Vasiliev', 'petr@gmail.com'),
(53, 'Vasili Petrov', 'petrov@gmail.com');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `theme` (`theme`),
  ADD KEY `date` (`date`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
