-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 09 2023 г., 10:33
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `rostorg`
--

-- --------------------------------------------------------

--
-- Структура таблицы `achievment`
--

CREATE TABLE `achievment` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count` int(11) NOT NULL,
  `picture` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `achievment`
--

INSERT INTO `achievment` (`id`, `name`, `description`, `count`, `picture`, `level_id`) VALUES
(1, 'Ученик', 'Пройти любой инвент онбординга', 20, 'https://i.gifer.com/MbWC.gif', NULL),
(2, 'Исследователь', 'Принять участие в одной деловой игре', 20, 'https://i.gifer.com/oY.gif', NULL),
(3, 'Студент', 'Пройти пять ивентов онбординга', 50, 'https://i.gifer.com/U7xe.gif', NULL),
(4, 'Специалист', 'Принять участие в пяти деловых играх', 50, 'https://i.gifer.com/IyLH.gif', NULL),
(5, 'Профессор', 'Пройти десять ивентов онбординга', 100, 'https://i.gifer.com/1cE.gif', NULL),
(6, 'Душа команды', 'Принять участие в десяти деловых играх', 100, 'https://i.gifer.com/7xoM.gif', NULL),
(14, 'Прошёл огонь, воду и медные трубы', 'Собрать все достижения', 100, 'https://i.gifer.com/5Aqf.gif', NULL),
(15, 'Нищий', 'Потратить все валюты до нуля', 0, 'https://i.gifer.com/7Aiy.gif', NULL),
(16, 'Богач', 'Накопить в кошельке больше 1000 любой валюты', 50, 'https://i.gifer.com/18Pe.gif', NULL),
(17, 'Добрый самаритянин', 'Совершить переводов любой валюты на сумму 500 и более', 30, 'https://i.gifer.com/uC4.gif', NULL),
(18, 'Транжира', 'Потратить на маркетплейсе больше 1000, в любой валюте', 25, 'https://i.gifer.com/CQRy.gif', NULL),
(19, 'Отчаянный ход', 'Попытаться купить товар, на который не хвататет средств', 10, 'https://i.gifer.com/7cmx.gif', NULL),
(20, 'Самая быстрая рука', 'Купить последний товар на маркетплейсе', 10, 'https://i.gifer.com/1HHU.gif', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `achievment_user`
--

CREATE TABLE `achievment_user` (
  `id` int(11) NOT NULL,
  `achievment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `achievment_user`
--

INSERT INTO `achievment_user` (`id`, `achievment_id`, `user_id`) VALUES
(1, 1, 12),
(2, 19, 12),
(3, 20, 12),
(4, 14, 12);

-- --------------------------------------------------------

--
-- Структура таблицы `business_game`
--

CREATE TABLE `business_game` (
  `id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `type_participation_id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_participant_id` int(11) NOT NULL,
  `type_participant_id` int(11) NOT NULL,
  `target` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count_participant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `business_game`
--

INSERT INTO `business_game` (`id`, `start_date`, `end_date`, `type_participation_id`, `name`, `description`, `role_participant_id`, `type_participant_id`, `target`, `count_participant`) VALUES
(1, '2023-04-09 09:00:00', '2023-04-10 09:00:00', 1, 'Деловая игра \"Торги на повышение\"', 'Вы выступаете в роли покупателя, приобретающего на торгах какую-либо вещь. Ваша задача получить товар и, по возможности, не переплатить за него', 2, 2, 'Повышение уровня компетентности участников в торгах со стороны покупателя', 2),
(2, '2023-04-09 09:00:00', '2023-04-10 09:00:00', 1, 'Деловая игра \"Торги на понижение\"', 'Вы выступаете в роли поставщика. Ваша задача - выиграть тендер на поставку канцелярских товаров в детский сад и не закрыть торги себе в убыток', 2, 2, 'Повышение уровня компетентности участников тендеров со стороны поставщика', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `user_out_id` int(11) NOT NULL,
  `user_in_id` int(11) NOT NULL,
  `text` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `chat`
--

INSERT INTO `chat` (`id`, `user_out_id`, `user_in_id`, `text`, `datetime`) VALUES
(1, 13, 12, 'Привет', '2022-10-01 23:58:32'),
(2, 14, 13, 'Привет еще раз', '2022-10-02 23:58:32'),
(3, 13, 14, 'упауцкцкикику', '2022-10-08 11:33:33');

-- --------------------------------------------------------

--
-- Структура таблицы `confirm`
--

CREATE TABLE `confirm` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `confirm`
--

INSERT INTO `confirm` (`id`, `name`) VALUES
(1, 'Оплачено'),
(2, 'Получено'),
(3, 'Отменено'),
(4, 'Отклонено');

-- --------------------------------------------------------

--
-- Структура таблицы `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `currency`
--

INSERT INTO `currency` (`id`, `name`) VALUES
(1, 'InGameCur'),
(2, 'Rubles');

-- --------------------------------------------------------

--
-- Структура таблицы `currency_wallet`
--

CREATE TABLE `currency_wallet` (
  `id` int(11) NOT NULL,
  `wallet_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `currency_wallet`
--

INSERT INTO `currency_wallet` (`id`, `wallet_id`, `currency_id`, `count`) VALUES
(39, 22, 1, 0),
(40, 22, 2, 14),
(43, 24, 1, 0),
(44, 24, 2, 0),
(45, 25, 1, 0),
(46, 25, 2, 0),
(47, 26, 1, 0),
(48, 26, 2, 10),
(49, 27, 1, 0),
(50, 27, 2, 0),
(51, 28, 1, 2),
(52, 28, 2, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `experience`
--

CREATE TABLE `experience` (
  `id` int(11) NOT NULL,
  `activity_name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `history_wallet`
--

CREATE TABLE `history_wallet` (
  `id` int(11) NOT NULL,
  `currency_wallet_out_id` int(11) DEFAULT NULL,
  `currency_wallet_in_id` int(11) DEFAULT NULL,
  `operation_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `history_wallet`
--

INSERT INTO `history_wallet` (`id`, `currency_wallet_out_id`, `currency_wallet_in_id`, `operation_id`, `count`, `date_time`, `team_id`, `task_id`) VALUES
(75, NULL, 40, 6, 10, '2022-10-08 09:02:04', NULL, NULL),
(76, NULL, 48, 6, 3, '2022-10-08 09:05:19', NULL, NULL),
(77, 48, 44, 2, 1, '2022-10-08 09:12:09', NULL, NULL),
(78, 48, 44, 2, 1, '2022-10-08 09:15:12', NULL, NULL),
(79, NULL, 48, 6, 5, '2022-10-08 09:16:22', NULL, NULL),
(80, NULL, 48, 6, 5, '2022-10-08 09:17:21', NULL, NULL),
(81, NULL, 51, 6, 2, '2022-10-08 09:25:09', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `experience_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `operation`
--

CREATE TABLE `operation` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `operation`
--

INSERT INTO `operation` (`id`, `name`) VALUES
(1, 'Обмен InGameCur на Rubles'),
(2, 'Перевод InGameCur/Rubles'),
(3, 'Покупка товара на маркетплейсе'),
(4, 'Выплата за командную работу'),
(5, 'Выплата за проект'),
(6, 'Другие операции');

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `user_creator_id` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 1,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `photo`, `currency_id`, `price`, `user_creator_id`, `count`, `status_id`) VALUES
(3, 'ЭЦП директору и предпринимателю', 'Квалифицированная электронная подпись на 15 месяцев от ДУЦ ФНС России для работы на госпорталах и решения других бизнес-задач онлайн', 'Фото1_ЭЦП_директору_и_предпринимателю_3.png ', 2, 1500, 13, 10, 1),
(4, 'Электронная подпись ГИИС ДМДК', 'Квалифицированная электронная подпись для регистрации в ГИИС ДМДК и учета драгоценных металлов, камней и изделий из них', 'Фото1_Электронная_подпись_ГИИС_ДМДК_4.png ', 2, 4500, 13, 8, 1),
(5, 'Электронная подпись для ЭДО', 'Неквалифицированная электронная подпись для внутреннего и внешнего ЭДО', 'Фото1_Электронная_подпись_для_ЭДО_5.png ', 2, 2180, 13, 15, 1),
(6, 'Электронная подпись для ЭДО', 'Неквалифицированная электронная подпись для внутреннего и внешнего ЭДО', 'Фото1_Электронная_подпись_для_ЭДО_6.png ', 1, 2180, 13, 9, 1),
(7, 'Онлайн-курс о контрактной системе', 'Обзор изменений в законодательстве о контрактной системе с 2023 года для заказчиков и участников закупок', 'Фото1_Онлайнкурс_о_контрактной_системе_7.png ', 1, 3500, 13, 15, 1),
(8, 'Интерактивный практикум', 'Интерактивный практикум по участию в электронных процедурах в рамках 44-ФЗ', 'Фото1_Интерактивный_практикум_8.png ', 2, 3500, 13, 30, 1),
(9, 'Повышение квалификации', 'Повышение квалификации для заказчиков «Управление закупками для обеспечения государственных и муниципальных нужд в соответствии с федеральным законом № 44-ФЗ»', 'Фото1_Повышение_квалификации_9.png ', 2, 10000, 13, 10, 1),
(10, 'Практический курс по работе в ЕИС', 'Практический курс для заказчиков по работе в Единой информационной системе и на ЭТП Росэлторг в рамках 44-ФЗ', 'Фото1_Практический_курс_по_работе_в_ЕИС_10.png ', 1, 0, 13, 30, 1),
(11, 'ЭДО «Росинвойс» на 12 месяцев', 'Система электронного документооборота. Вы получите: возможность принимать безлимитное количество входящих документов; возможность отправлять безлимитное количество исходящих документов; хранение документов в архиве. Срок действия: 12 месяцев', 'Фото1_ЭДО_Росинвойс_на_12_месяцев_11.png ', 2, 6240, 13, 40, 1),
(12, '«Коммерческие закупки». Подписка', 'Подписка действительна в течении 30 дней. Доступные секции: корпоративные закупки и закупки субъектов 223-ФЗ; ПАО «Ростелеком»; Группа ВТБ Холдинг «Росгеология»; ПАО «Россети». В стоимость включен НДС 20%', 'Фото1_Коммерческие_закупки._Подписка_12.png ', 2, 29900, 13, 10, 1),
(13, 'Разовое участие в «Росэлторг.Бизнес»', 'Тариф на разовое участие на платформе «Росэлторг.Бизнес». НДС включен в стоимость тарифа', 'Фото1_Разовое_участие_в_Росэлторг.Бизнес_13.png ', 2, 900, 13, 100, 1),
(14, 'Разовое участие в «Росэлторг.Бизнес»', 'Тариф на разовое участие на платформе «Росэлторг.Бизнес»', 'Фото1_Разовое_участие_в_Росэлторг.Бизнес_14.png ', 1, 850, 13, 15, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `product_user`
--

CREATE TABLE `product_user` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `confirm_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'Администратор'),
(2, 'Заказчик'),
(3, 'Продавец'),
(4, 'Сотрудник');

-- --------------------------------------------------------

--
-- Структура таблицы `role_function`
--

CREATE TABLE `role_function` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `role_function`
--

INSERT INTO `role_function` (`id`, `name`) VALUES
(1, 'Просмотр маркетплейса'),
(2, 'Редактирование маркетплейса'),
(3, 'Доступ к пополнению виртуального кошелька'),
(4, 'Доступ к пополнению личного кошелька'),
(5, 'Доступ к обмену InGameCur/Rubles на товары маркетплейса/цифровые рубли Банка России'),
(6, 'Добавление и редактирование достижений/количества очков опыта'),
(7, 'Доступ к переводу InGameCur/Rubles коллеге'),
(8, 'Просмотр начисления/списания своих и коллег своего уровня InGameCur/Rubles'),
(9, 'Просмотр начисления/списания InGameCur/Rubles всех сотрудников'),
(11, 'Выставление своего товара на маркетплейсе'),
(12, 'Создание заявки на обмен InGameCur/Rubles на товары маркетплейса'),
(13, 'Создание и редактирование ивента онбординга'),
(14, 'Подтверждение выполненного ивента онбординга'),
(15, 'Создание и редактирование деловых игр'),
(16, 'Начисление InGameCur/Rubles за деловые игры');

-- --------------------------------------------------------

--
-- Структура таблицы `role_function_role`
--

CREATE TABLE `role_function_role` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `role_function_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `role_function_role`
--

INSERT INTO `role_function_role` (`id`, `role_id`, `role_function_id`) VALUES
(67, 1, 1),
(68, 1, 2),
(69, 1, 3),
(70, 1, 4),
(83, 1, 5),
(84, 1, 6),
(85, 1, 7),
(86, 1, 8),
(87, 1, 9),
(88, 1, 11),
(89, 1, 12),
(90, 1, 13),
(91, 1, 14),
(92, 1, 15),
(93, 1, 16),
(94, 2, 1),
(95, 2, 3),
(96, 2, 4),
(97, 2, 5),
(98, 2, 7),
(99, 2, 8),
(100, 2, 11),
(101, 2, 12),
(102, 3, 1),
(103, 3, 3),
(104, 3, 4),
(105, 3, 5),
(106, 3, 7),
(107, 3, 8),
(108, 3, 11),
(109, 3, 12);

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Активна'),
(2, 'Неактивна');

-- --------------------------------------------------------

--
-- Структура таблицы `status_product`
--

CREATE TABLE `status_product` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `status_product`
--

INSERT INTO `status_product` (`id`, `name`) VALUES
(1, 'Доступен'),
(2, 'Недоступен');

-- --------------------------------------------------------

--
-- Структура таблицы `step`
--

CREATE TABLE `step` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `price_type` int(11) NOT NULL,
  `business_game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `step`
--

INSERT INTO `step` (`id`, `name`, `description`, `price`, `price_type`, `business_game_id`) VALUES
(1, 'Знакомство с лотом', 'Название лота: автомобиль Hyundai Solaris<br>\r\nМакс. мощность: 100 л.с.<br>\r\nРасход топлива: 5.7л./100км.<br>\r\nСтартовая цена: 500.000р<br>', 0, 0, 1),
(2, 'Ставка', 'Вы можете повысить текущую цену или сдаться. Шаг ставки - 100.000р', 10, 1, 1),
(3, 'Ставка', 'Вы можете повысить текущую цену или сдаться. Шаг ставки - 150.000р', 20, 1, 1),
(4, 'Результат торгов', '', 30, 1, 1),
(5, 'Знакомство с тендером', 'Необходимо закупить канцелярские товары в детский сад<br>\r\nКол-во комплектов: 30<br>\r\nСредняя цена по рынку за комплект: 250р<br>\r\nТекущая сумма тендера: 12.000р', 0, 0, 2),
(6, 'Изменение суммы', 'Вы можете понизить текущую цену или сдаться. Шаг -2.000р', 10, 1, 2),
(7, 'Изменение суммы', 'Вы можете понизить текущую цену или сдаться. Шаг -1.000р', 20, 1, 2),
(8, 'Результат тендера', '', 30, 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `step_user`
--

CREATE TABLE `step_user` (
  `id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `log` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_key` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `step_user`
--

INSERT INTO `step_user` (`id`, `step_id`, `user_id`, `log`, `end_key`) VALUES
(11, 1, 12, 'Ознакомился с лотом', 1),
(12, 2, 12, 'Сделал ставку', 1),
(13, 3, 12, 'Сделал ставку', 0),
(14, 4, 12, 'Завершил игру', 0),
(23, 5, 12, 'Ознакомился с тендером', 1),
(24, 6, 12, 'Изменил сумму', 0),
(25, 7, 12, 'Изменил сумму', 0),
(26, 8, 12, 'Завершил игру', 0),
(27, 5, 12, 'Ознакомился с тендером', 1),
(28, 6, 12, 'Изменил сумму', 0),
(29, 7, 12, 'Изменил сумму', 0),
(30, 8, 12, 'Завершил игру', 0),
(31, 5, 12, 'Ознакомился с тендером', 1),
(32, 6, 12, 'Изменил сумму', 1),
(33, 7, 12, 'Изменил сумму', 1),
(34, 8, 12, 'Завершил игру', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `repeat` tinyint(1) NOT NULL,
  `user_creator_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `date_start` datetime NOT NULL,
  `date_finish` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `task`
--

INSERT INTO `task` (`id`, `name`, `currency_id`, `price`, `repeat`, `user_creator_id`, `status_id`, `date_start`, `date_finish`) VALUES
(2, 'Курсы повышения квалификации', 2, 10, 0, 14, 1, '2022-10-01 00:00:00', '2022-10-31 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `task_user`
--

CREATE TABLE `task_user` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `task_user`
--

INSERT INTO `task_user` (`id`, `task_id`, `user_id`, `date`) VALUES
(33, 2, 13, '2022-10-08');

-- --------------------------------------------------------

--
-- Структура таблицы `task_user_confirm`
--

CREATE TABLE `task_user_confirm` (
  `id` int(11) NOT NULL,
  `user_hr_id` int(11) NOT NULL,
  `task_user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `confirm` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `task_user_confirm`
--

INSERT INTO `task_user_confirm` (`id`, `user_hr_id`, `task_user_id`, `date`, `confirm`) VALUES
(42, 14, 33, '2022-10-08', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_creator_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `max_count` int(11) NOT NULL,
  `summary_cost` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `date_start` datetime NOT NULL,
  `date_finish` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `team_user`
--

CREATE TABLE `team_user` (
  `id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cost` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `type_org`
--

CREATE TABLE `type_org` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `type_org`
--

INSERT INTO `type_org` (`id`, `name`) VALUES
(1, 'Физическое лицо'),
(2, 'Юридическое лицо');

-- --------------------------------------------------------

--
-- Структура таблицы `type_wallet`
--

CREATE TABLE `type_wallet` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `type_wallet`
--

INSERT INTO `type_wallet` (`id`, `name`) VALUES
(1, 'Личный'),
(2, 'Виртуальный');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auth_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `firstname` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secondname` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patronymic` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `experience_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `firstname`, `secondname`, `patronymic`, `role_id`, `experience_count`) VALUES
(12, 'New', 'Fn-1o__wOrp0HA1APHcgln77PpLp97IF', '$2y$13$O4yXs43On2PR6C8JmG0u2esAhlTVABtZalc280qOP.f9hikIkYUYK', NULL, NULL, 10, NULL, NULL, 'New', 'New', 'New', 1, 130),
(13, 'Petr', '2lmxpGXxMSEcYvND68mj2RWlPF9oeblO', '$2y$13$O4yXs43On2PR6C8JmG0u2esAhlTVABtZalc280qOP.f9hikIkYUYK', NULL, NULL, 10, NULL, NULL, 'Петр', 'Петров', 'Петрович', 2, 0),
(14, 'Ivan', '8-TVMPJlzz7RGDxD1qkb4e4cgWZNwlun', '$2y$13$O4yXs43On2PR6C8JmG0u2esAhlTVABtZalc280qOP.f9hikIkYUYK', NULL, NULL, 10, NULL, NULL, 'Иван', 'Иванов', 'Иванович', 3, 20),
(15, 'Sidor', 'L9VUTXTDHRF3BQdMtlIlbtxqmb1kopN6', '$2y$13$O4yXs43On2PR6C8JmG0u2esAhlTVABtZalc280qOP.f9hikIkYUYK', NULL, NULL, 10, NULL, NULL, 'Сидор', 'Сидоров', 'Сидорович', 4, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user_salary`
--

CREATE TABLE `user_salary` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `wallet_type_id` int(11) NOT NULL,
  `salary` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_salary`
--

INSERT INTO `user_salary` (`id`, `user_id`, `currency_id`, `wallet_type_id`, `salary`) VALUES
(17, 13, 1, 1, NULL),
(18, 13, 2, 1, NULL),
(19, 13, 1, 2, NULL),
(20, 13, 2, 2, NULL),
(21, 14, 1, 1, NULL),
(22, 14, 2, 1, NULL),
(23, 14, 1, 2, NULL),
(24, 14, 2, 2, NULL),
(25, 15, 1, 1, NULL),
(26, 15, 2, 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `wallet`
--

CREATE TABLE `wallet` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `publicKey` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privateKey` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `wallet`
--

INSERT INTO `wallet` (`id`, `type_id`, `user_id`, `publicKey`, `privateKey`) VALUES
(22, 1, 12, '0x8be07Ca31624a6642d0ab53A1eCAcAd3dee957fB', 'e24760570cd0e28a306c8201766e22633dcd9e19c7fff2f2571aec74982db9b9'),
(24, 1, 13, '0x5Cb7Ba6a980c8794EE04031F24fAdE071B2b175E', '6a3f0a602d3aeb3e561cde2b77d4fe695066b414e541978a489ea1b8954cc02a'),
(25, 2, 13, '0x07200D8CFb1E87CDa701143CFd34905851C68686', '7a6a7c3722a95839616f84066873bb63aa1b17190793cb89c45ece6c99bcf651'),
(26, 1, 14, '0x4029EDD990ec4247f8db11eB5068f0bF6fC8787e', '3bc012016cb5bab1481443a580fba09071ed7155063c3e0e75a414036198947b'),
(27, 2, 14, '0xdC11eFd292A9E2A06467Ba47eea615f40573dcED', '32559004c074ca42190d24f8d4dd4de8a922669984a51ed2662808aa210e7b79'),
(28, 1, 15, '0x3A22E6C5b7654fed6167122FCd84EC3fa48329F5', '9631fe08a6cf01125a6e5a3306344acdd0bbe697f7f2c431f0e9c30aa49a008c');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `achievment`
--
ALTER TABLE `achievment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level_id` (`level_id`);

--
-- Индексы таблицы `achievment_user`
--
ALTER TABLE `achievment_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `achievment_id` (`achievment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `business_game`
--
ALTER TABLE `business_game`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_in_id` (`user_in_id`),
  ADD KEY `user_out_id` (`user_out_id`);

--
-- Индексы таблицы `confirm`
--
ALTER TABLE `confirm`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `currency_wallet`
--
ALTER TABLE `currency_wallet`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `history_wallet`
--
ALTER TABLE `history_wallet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency_wallet_in_id` (`currency_wallet_in_id`),
  ADD KEY `currency_wallet_out_id` (`currency_wallet_out_id`),
  ADD KEY `operation_id` (`operation_id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Индексы таблицы `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `user_creator_id` (`user_creator_id`);

--
-- Индексы таблицы `product_user`
--
ALTER TABLE `product_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `role_function`
--
ALTER TABLE `role_function`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `role_function_role`
--
ALTER TABLE `role_function_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_function_id` (`role_function_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `status_product`
--
ALTER TABLE `status_product`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `step`
--
ALTER TABLE `step`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_game_id` (`business_game_id`);

--
-- Индексы таблицы `step_user`
--
ALTER TABLE `step_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `step_id` (`step_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `user_creator_id` (`user_creator_id`);

--
-- Индексы таблицы `task_user`
--
ALTER TABLE `task_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `task_user_confirm`
--
ALTER TABLE `task_user_confirm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_user_id` (`task_user_id`),
  ADD KEY `user_hr_id` (`user_hr_id`);

--
-- Индексы таблицы `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `user_creator_id` (`user_creator_id`);

--
-- Индексы таблицы `team_user`
--
ALTER TABLE `team_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `type_org`
--
ALTER TABLE `type_org`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `type_wallet`
--
ALTER TABLE `type_wallet`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `username` (`username`),
  ADD KEY `password_reset_token` (`password_reset_token`),
  ADD KEY `email` (`email`);

--
-- Индексы таблицы `user_salary`
--
ALTER TABLE `user_salary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_salary_ibfk_3` (`wallet_type_id`);

--
-- Индексы таблицы `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `achievment`
--
ALTER TABLE `achievment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `achievment_user`
--
ALTER TABLE `achievment_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `business_game`
--
ALTER TABLE `business_game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `confirm`
--
ALTER TABLE `confirm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `currency_wallet`
--
ALTER TABLE `currency_wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT для таблицы `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `history_wallet`
--
ALTER TABLE `history_wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT для таблицы `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `operation`
--
ALTER TABLE `operation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `product_user`
--
ALTER TABLE `product_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `role_function`
--
ALTER TABLE `role_function`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `role_function_role`
--
ALTER TABLE `role_function_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `status_product`
--
ALTER TABLE `status_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `step`
--
ALTER TABLE `step`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `step_user`
--
ALTER TABLE `step_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT для таблицы `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `task_user`
--
ALTER TABLE `task_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `task_user_confirm`
--
ALTER TABLE `task_user_confirm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT для таблицы `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `team_user`
--
ALTER TABLE `team_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `type_org`
--
ALTER TABLE `type_org`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `type_wallet`
--
ALTER TABLE `type_wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `user_salary`
--
ALTER TABLE `user_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `achievment`
--
ALTER TABLE `achievment`
  ADD CONSTRAINT `achievment_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `level` (`id`);

--
-- Ограничения внешнего ключа таблицы `achievment_user`
--
ALTER TABLE `achievment_user`
  ADD CONSTRAINT `achievment_user_ibfk_1` FOREIGN KEY (`achievment_id`) REFERENCES `achievment` (`id`),
  ADD CONSTRAINT `achievment_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`user_in_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`user_out_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `history_wallet`
--
ALTER TABLE `history_wallet`
  ADD CONSTRAINT `history_wallet_ibfk_1` FOREIGN KEY (`currency_wallet_in_id`) REFERENCES `currency_wallet` (`id`),
  ADD CONSTRAINT `history_wallet_ibfk_2` FOREIGN KEY (`currency_wallet_out_id`) REFERENCES `currency_wallet` (`id`),
  ADD CONSTRAINT `history_wallet_ibfk_3` FOREIGN KEY (`operation_id`) REFERENCES `operation` (`id`),
  ADD CONSTRAINT `history_wallet_ibfk_4` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`),
  ADD CONSTRAINT `history_wallet_ibfk_5` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`);

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status_product` (`id`),
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`user_creator_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `product_user`
--
ALTER TABLE `product_user`
  ADD CONSTRAINT `product_user_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `product_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `role_function_role`
--
ALTER TABLE `role_function_role`
  ADD CONSTRAINT `role_function_role_ibfk_1` FOREIGN KEY (`role_function_id`) REFERENCES `role_function` (`id`),
  ADD CONSTRAINT `role_function_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Ограничения внешнего ключа таблицы `step`
--
ALTER TABLE `step`
  ADD CONSTRAINT `step_ibfk_1` FOREIGN KEY (`business_game_id`) REFERENCES `business_game` (`id`);

--
-- Ограничения внешнего ключа таблицы `step_user`
--
ALTER TABLE `step_user`
  ADD CONSTRAINT `step_user_ibfk_1` FOREIGN KEY (`step_id`) REFERENCES `step` (`id`),
  ADD CONSTRAINT `step_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`),
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `task_ibfk_3` FOREIGN KEY (`user_creator_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `task_user`
--
ALTER TABLE `task_user`
  ADD CONSTRAINT `task_user_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`),
  ADD CONSTRAINT `task_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `task_user_confirm`
--
ALTER TABLE `task_user_confirm`
  ADD CONSTRAINT `task_user_confirm_ibfk_1` FOREIGN KEY (`task_user_id`) REFERENCES `task_user` (`id`),
  ADD CONSTRAINT `task_user_confirm_ibfk_2` FOREIGN KEY (`user_hr_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_ibfk_1` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`),
  ADD CONSTRAINT `team_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `team_ibfk_3` FOREIGN KEY (`user_creator_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `team_user`
--
ALTER TABLE `team_user`
  ADD CONSTRAINT `team_user_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`),
  ADD CONSTRAINT `team_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_salary`
--
ALTER TABLE `user_salary`
  ADD CONSTRAINT `user_salary_ibfk_1` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`),
  ADD CONSTRAINT `user_salary_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_salary_ibfk_3` FOREIGN KEY (`wallet_type_id`) REFERENCES `type_wallet` (`id`);

--
-- Ограничения внешнего ключа таблицы `wallet`
--
ALTER TABLE `wallet`
  ADD CONSTRAINT `wallet_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `type_wallet` (`id`),
  ADD CONSTRAINT `wallet_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
