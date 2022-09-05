Steps to do

### 1. Create a new Laravel App

- Refer to: [Laravel Installation](https://laravel.com/docs/9.x/installation)


### 2. Install Laravel Socialite
- Refer to: [Laravel Socialite](https://laravel.com/docs/9.x/socialite)
- Command
```sh
composer require laravel/socialite
```

### 3. Add social fields to users table
- Command
```sh
php artisan make:migration add_social_fields_to_users_table
```
- Update migration script
```php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('provider')->nullable(); // Provider name. E.g. twitter, google
        $table->string('provider_id')->nullable(); // Provider ID
    });
}
```
- Update DB
```sh
php artisan migrate
```


### 4. Add routes for social login
- Update routes/web.php 
```php
Route::get('/auth/{provider}', 'SocialAuthController@redirectToProvider');
Route::get('/auth/{provide}/callback', 'SocialAuthController@handleProviderCallback');
```

### 5. Add controller to process social login
- Add new controller SocialAuthController
```sh
php artisan make:controller SocialAuthController
```


### 6. Laravel - Twitter API
- Install package 
```sh
composer require atymic/twitter
```