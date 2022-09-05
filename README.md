## Steps to setup at local

### 1. Install dependencies
```
composer install
```

### 2. Set environment variables
```
copy .env.example .env
```

Open .env file and input the setting values

### 3. Generate Laravel key
```
php artisan key:generate
```

### 4. Migrate DB
```
php artisan schema:migrate
```

### 5. Start with Artisan serve
```
php artisan serve
```

### 6. Or if you love to start with sail/docker
Refer to [Laravel Sail](https://laravel.com/docs/9.x/sail) for more details
Start with sail
```
./vendor/bin/sail up
```


