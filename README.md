# EETKiNO

**A platform for writing film reviews.**

## Work flow

The philosophy behind EETKiNO is to be an API for user, film, and review store / retrieval once the agent accessing the platform has been Authenticated. 

In other words, if you have the API key to EETKiNO, you can manage **all the data**. This is specially useful for a case where you have already Authenticated the user through means where the user can't use explicitly a key, but the backend of their application handles that for them.

In this scenario, I am managing EETKiNO's Authentication as `chat_id` from Telegram, where I intend to write a review system through a Telegram bot.

## Install Instructions

**Requirements**

- Follow the [Laravel Install instructions](https://laravel.com/docs/master#installation) to install Laravel requirements.
- Follow usual Laravel setup:

```bash
composer update
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

In `.env`, write your [TMDb API Key](https://www.themoviedb.org/documentation/api).

## API Endpoints

All API endpoints start with `/api`. 

### User

#### `/register/`

**POST > Register a user.**

| Parameter | Type   | Required | Description                   |
|-----------|--------|----------|-------------------------------|
| username  | string | yes      | Nickname of the user.         |
| chat_id   | string | yes      | Telegram chat_id of the User. |
| api_key   | string | yes      | EETKiNO API Key.              |

### Review

#### `/review/`

**POST > Create a review**

| Parameter | Type   | Required | Description                   |
|-----------|--------|----------|-------------------------------|
| chat_id   | string | yes      | Telegram chat_id of the User. |
| api_key   | string | yes      | EETKiNO API Key.              |
| tmdb_id   | string | yes      | Film ID from Review           |
| score     | int    | yes      | Score 0-100 for the Film      |
| comment   | string | no       | Thoughts on the film.         |