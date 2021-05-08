# How can we use this repo?


# Install
```sh
composer install
```
Next you can clone the `.env.example` file into the `.env` file. This means that you have to create the same file in the `root` directory under a different name e.g. `.env` and copy paste the same credentials like `.env.example` file.

Laravel has a built-in CLI tool called `artisan`. Your application must generate a unique base 64 key that Laravel uses behind the scenes to bootstrap this project.

**Command:**

```sh
php artisan key:generate
```

It will automatically find your `.env` file and place the base 64 value in the file.

**Output inside the file:**
```
APP_KEY=base64:T0huMR5Wx9EoDmjTxniKTofHD/7cOiDeVVD9eTKuCa0=
```

## Additional Note:
As you can see it is necessary to create the `.env` file in your local to bootstrap the project. But `Laravel` contains 2 methods to connect to the database server.

- Use of the `.env` variables *(I prefer this one)*
- Use of the file located at the `config/database.php`



## Use of the `.env` variables:

When you create this file with copy paste credentials you can see default; the database variables are written something like this:
 ```
DB_CONNECTION=mysql  
DB_HOST=127.0.0.1  
DB_PORT=3306  
DB_DATABASE=test_app  
DB_USERNAME=root  
DB_PASSWORD=
```

You can edit values according to your own database personal preference. I am using Postgres in this case.

##  Use of the file located at the `config/database.php`

**Note:** When Laravel bootstraps the project it gives priority to the `.env` file as compared to `config/**` files. You can see `config/database.php` file contains an associated array with default database settings like this.

```
return [
    
    'default' => env('DB_CONNECTION', 'mysql'),
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
    ]
    ]
```

You can only use these settings if variables from the `.env` file will be deleted. Otherwise, Laravel gives priority to `.env` variables.

Delete the variables from the `.env`:


~~DB_CONNECTION=mysql~~  
~~DB_HOST=127.0.0.1~~  
~~DB_PORT=3306~~  
~~DB_DATABASE=test_app~~  
~~DB_USERNAME=root~~  
~~DB_PASSWORD=~~

Lastly, Update the `config/database.php` with your database server settings:

```
'default' => env('DB_CONNECTION', 'pgsql')
'database' => env('DB_DATABASE', 'ui_multiauth'),
'username' => env('DB_USERNAME', 'postgres'),
'password' => env('DB_PASSWORD', 'a')
```

# Database
I am using  **Postgres** and inside `.env` file my database server credentials are:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1  
DB_PORT=5432
DB_DATABASE=invoicer_test
DB_USERNAME=postgres
DB_PASSWORD=a
```

However, your main server and database server get started.

# Migration (Transform into real database tables)
At the last make sure after updating your database settings. Please use `artisan` CLI to migrate the database tables.
```sh
php artisan migrate
```


# Deployment
[Heroku](https://www.heroku.com)
