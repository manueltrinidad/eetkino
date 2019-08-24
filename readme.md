# KiNO Movie Reviews

## About

Small application to log the movies you've watched, ratings, etc. Made with Laravel.

## Install

1. Download the code and place it into your server. Install accordingly (public folder is the access, as in every Laravel app).

2. Install Composer dependencies

```console
composer install
```

3. Copy and fill in the .env file. Important: Fill in the admin / only user details.

```console
cp .env.example .env
```

4. Generate an app encryption key.

```console
php artisan key:generate
```

5. Create the database.

6. Migrate and seed the database.

```console
php artisan migrate
php artisan db:seed --force
```

7. Login at < yoursite >/login. Enjoy.