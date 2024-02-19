## To launch:
composer install

php artisan migrate

#### to generate test data: 
php artisan migrate:fresh --seed

php artisan serve

### Make Cron task to schedule weather update
php artisan app:update-weather

### Make Cron task to schedule employee notification
php artisan app:notify-employee

Choose notification method by binding [WeatherEmailNotificationAction.php](app%2FAction%2FWeatherEmailNotificationAction.php) or [WeatherLogNotificationAction.php](app%2FAction%2FWeatherLogNotificationAction.php)
to [WeatherNotificationInterface.php](app%2FServices%2FWeatherNotificationInterface.php) in [AppServiceProvider.php](app%2FProviders%2FAppServiceProvider.php)


## Routes:
get employee list. use 'limit' and 'offset' get params to receive more items, default limit is 500
http://127.0.0.1:8000/api/employee

get employee by id
http://127.0.0.1:8000/api/employee/{id}

post new employee:
http://127.0.0.1:8000/api/employee

put/update employee by Id:
http://127.0.0.1:8000/api/employee/{$id}

delete employee by Id:
http://127.0.0.1:8000/api/employee/{$id}

get list of employees with the highest salaries all or by country name:
http://127.0.0.1:8000/api/employee-top-salary/{country?}

get list of employees by occupation:
http://127.0.0.1:8000/api/employee/position/{position}

generate pdf of employee profile:
http://127.0.0.1:8000/api/employee-pdf/{id}
