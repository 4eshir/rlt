# rlt
Репозиторий для демонстенда системы РОСЭЛТОРГ Fun

Система реализована на языке PHP с использованием фреймворка Yii2

Шаблон проектирования - классический MVC

Основные модули системы
- models - модели, являющиеся представлениями таблиц БД в коде приложения, а также реализующие основную бизнес-логику приложения
- views - фронт приложения, непосредственно веб-страницы
- controllers - классы, обеспечивающие взаимодействие между models и views

Точка входа в приложение - web\index.php

Доступ в систему
- Роль администратор
-- Логин: New
-- Пароль: admin

- Роль пользователь
-- Логины: Petr, Ivan
-- Пароль: admin

Сценарии взаимодействия с системой отправлены вместе с сообщением ментору трека, а также находятся в корне данного репозитория (Scenario.txt)
