# API Song & queue

### Основные файлы проекта

Роуты для API:
<a href="https://github.com/igshein/rest-api-laravel/blob/master/app/routes/api.php">api.php</a>

HTTP контроллер для Song:
<a href="https://github.com/igshein/rest-api-laravel/blob/master/app/app/Http/Controllers/Song/SongController.php">SongController.php</a>

Модуль Song:
<a href="https://github.com/igshein/rest-api-laravel/tree/master/app/app/Modules/Song">Modules/Song</a>

Методы сервиса Song:
<a href="https://github.com/igshein/rest-api-laravel/blob/master/app/app/Modules/Song/Services/SongService.php">SongService.php</a>

Worker очереди:
<a href="https://github.com/igshein/rest-api-laravel/blob/master/app/app/Jobs/SongsQueue.php">SongsQueue.php</a>

Модель Song:
<a href="https://github.com/igshein/rest-api-laravel/blob/master/app/app/Modules/Song/Models/Song.php">Song.php</a>

Миграция Song:
<a href="https://github.com/igshein/rest-api-laravel/blob/master/app/database/migrations/2020_06_20_135014_create_songs_table.php">create_songs_table.php</a>

## Clear all and start application from scratch

This step is needed if you start application before.

Remove all containers:
```bash

docker system prune -a
sudo make clear

```

Than configurate application.

## Configurate application
If you want to import dump of database, please locate it in `.docker/config/postgresql/dump` directory. `.docker/data/postgresql` have to be empty.

```bash

make setup

```

Build containers:

```bash

# development
make build

```

## Start application
```bash

# development
make up

```

## Deploy to production
0/ Git clone or git pull file project
```bash
git clone ...
```

1/ Setup ENV (Only when first deploy)
```bash
make setup
```
Set in .env file: USER_ADMIN_PASSWORD, CUSTOMER_DEFAULT_PASSWORD, DB_PASSWORD

2/ Create build (Only when first deploy or update Dockerfile)
```bash
make build
```

3/ Set environment variables in file "/.env":
```bash
APP_ENV=production
APP_DEBUG=false
APP_LOG_LEVEL=error
APP_URL=https://domain
COOKIE_DOMAIN=.domain
```

4/ Container up
```bash
make up
```

5/ Check that migrations and seeds apply successfully.
In case of errors, try this command:
```bash
docker-compose exec php php artisan migrate --seed
```

## Stop application
```bash

# development
make down

```

## Clear all containers data
```bash

make clear

```

## Clear artisan cache

```bash

clear-cache

```


### Example run artisan commands
```bash
# Clear cache
docker-compose exec php php artisan cache:clear
docker-compose exec php php artisan config:cache
docker-compose exec php php artisan view:clear

# Add new seeder or migration
docker-compose exec php php artisan make:seeder NameSeeder
docker-compose exec php php artisan make:migration create_name_table
docker-compose exec php php artisan make:model Models/NameDir/NameModel

# Migrate + seed
docker-compose exec php php artisan migrate --seed
docker-compose exec php php artisan migrate:rollback --step=1

# Jobs
## for database ## docker-compose exec php php artisan queue:table
docker-compose exec php php artisan make:job Email

# Generate Tests
docker-compose exec php php vendor/bin/codecept generate:cest api  NameDirectory/NameTestCets
docker-compose exec php php vendor/bin/codecept generate:test unit NameDirectory/NameTestTest

# Example run Test
docker-compose exec php php vendor/bin/codecept run -- tests/api/User/nameCest.php

# Disable caching
in .env file set CACHE_DRIVER=none; after # Clear cache (look higher) and make down/up containers.

## Example skip test
# public function saveQuiz(ApiTester $I, $scenario)
# {
#    $scenario->incomplete('testing skipping');
```