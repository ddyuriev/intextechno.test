# IntexTechno Test Project (Laravel + Redis)


## Запуск

```bash
docker compose up -d --build
docker compose ps
docker compose exec app bash
composer install
php artisan key:generate
```

## Доступ к приложению:

```bash
http://localhost:8000
```


# API Documentation

## Регистрация пользователя

**Endpoint:** `POST /api/register`

**Описание:** Регистрирует нового пользователя с аватаром.

**Параметры (JSON):**

| Параметр  | Тип    | Обязателен | Описание                              |
|-----------|--------|------------|--------------------------------------|
| nickname  | string | да         | Уникальный никнейм пользователя      |
| avatar    | file   | да         | Аватар изображения (jpg, jpeg, png, webp, max 2 MB) |

**Rate limit:** 5 запросов в минуту (по умолчанию, настраивается через `.env`)

**Пример запроса:**

```bash
curl -X POST http://localhost:8000/api/register \
  -F "nickname=John" \
  -F "avatar=@avatar.jpg"
```


## Получение списка пользователей

**Endpoint:** `GET /users`

**Описание:** Возвращает список всех зарегистрированных пользователей.


# job очистки устаревших данных
```bash
docker compose exec app php artisan queue:work
docker compose exec app php artisan schedule:work
```


# Code-style / Code-quality

```bash
docker compose exec app ./vendor/bin/pint
docker compose exec app ./vendor/bin/phpstan analyse --memory-limit=512M
```

#Тесты
```bash
docker compose exec app php artisan test
```
