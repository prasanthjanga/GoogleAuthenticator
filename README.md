

## PHP Laravel GoogleAuthenticator

Steps to configure

- composer create-project laravel/laravel GoogleAuthenticator 5.4 --prefer-dist.
- Update .env with DB connections etc.
- php artisan make:auth
- php artisan migrate
- php artisan make:migration add_googleauth_code_column_to_users --table=users
- php artisan migrate
