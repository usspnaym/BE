# V-SDGs-BE

## Dockerized build
1. Configurations
```shell
cp .env.example .env
```
2. Run docker build
```shell
docker-compose up -d
```

3. Install Dependencies
```shell
docker-compose exec app composer install -o
```

4. (optional) Generate app key
   If APP_KEY in .env doesn't have any value, then run the command.
```shell
docker-compose exec app php artisan key:generate
```

5. Run Artisan Commands
```shell
docker-compose exec app php artisan migrate:refresh --seed
docker-compose exec app php artisan optimize
```

6. 🎉 Success
   Open http://localhost:8000/ to see if it is working correctly.
   

## Native Build
1. Configurations
```shell
cp .env.example .env
```

2. Install Dependencies
```shell
composer install -o
```

3. (optional) Generate app key
   If APP_KEY in .env doesn't have any value, then run the command.
```shell
php artisan key:generate
```

4. Run Artisan Commands
```shell
php artisan migrate:refresh --seed
php artisan optimize
```

6. 🎉 Success
   Open http://localhost:8000/ to see if it is working correctly.
