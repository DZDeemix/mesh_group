# Руководство по разворачиванию проекта на Laravel с использованием Docker Compose

Это руководство поможет вам развернуть проект на Laravel с использованием Docker Compose. Docker Compose позволяет легко создавать и управлять контейнерами для вашего приложения Laravel, что делает развертывание и управление проектом намного проще.

## Требования

Для успешного разворачивания проекта вам понадобятся следующие инструменты:

- Docker: [Установка Docker](https://docs.docker.com/get-docker/)
- Docker Compose: [Установка Docker Compose](https://docs.docker.com/compose/install/)
- Git: [Установка Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)


Убедитесь, что все эти инструменты установлены и доступны в вашей системе.

## Шаг 1: Клонирование репозитория

Сначала склонируйте репозиторий с вашим проектом Laravel из Git:

<pre>
git clone git@github.com:DZDeemix/mesh_group.git my-laravel-project
</pre>

## Шаг 2: Настройка окружения

Перейдите в каталог вашего проекта::

<pre>
cd my-laravel-project
</pre>

Создайте файл .env на основе .env.example и настройте его согласно вашим требованиям:

<pre>
cp .env.example .env
</pre>

## Шаг 3: Сборка и запуск контейнеров

Выполните следующие команды для сборки и запуска контейнеров:
<pre>
docker-compose build
docker-compose up -d
</pre>

## Шаг 4: Установка зависимостей Laravel

Войдите в контейнер приложения:
<pre>
docker exec -it my-laravel-project-php-cli-1 bash
</pre>
внутри контейнера выполните следующие команды для установки зависимостей Laravel:
<pre>
composer install
</pre>
выполните установку миграций Laravel:
<pre>
php artisan migrate
</pre>
поменяйте права на папку storage:
<pre>
chmod 777 -R storage/
</pre>

## Шаг 5: Завершение установки

Проект Laravel теперь развернут с использованием Docker Compose. Вы можете открыть его в веб-браузере, перейдя по адресу `http://localhost`.
