# How can we use this repo?

- [Installation](#install)
- [Multi Authentication](#multi-authentication)

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
DB_DATABASE=ui_multiauth   
DB_USERNAME=root    
DB_PASSWORD=  
```  

You can edit values according to your own database personal preference. I am using Postgres in this case.

## Use of the file located at the `config/database.php`

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

# Multi-Authentication
This information is not about the authentication of APIs, but rather about the authentication we see in the creation of web applications.

In general, there are 3 types of authentications when we create web applications. If you know any other please tell me.


- [Simple authentication](#simple-authentication)
- [Multi authentication](#multi-authentication)
- [Role-based authentication](#role-based-authentication)

###  Simple authentication
It only uses one type of `people` and `1 table`.  The website owner manually edits the database from the database server and conditionally renders the content.

###  Multi authentication

We store records in more than one table. So we authenticate them based on their credentials which will be stored in the database.

### Example:
**School management**:

We create authentication for different type of people for example: `Admins`, `Teachers`, `Moderators`, `Parents` & `Students`.

In this, we have to create multiple authentications for these types of people and each people represents a separate database table inside the database.

*What if we depend upon only a single table named `users` for all these people authentication?*

The table will be bloated and many records will reside on the same table and difficult to differentiate the user. So it is best practice to create separate table for each type of people.

- admins
- moderators
- students
- parents
- teachers

In a multi-authentication system, we can log in to different types of people at the same time. for example, `admin` and `student` can log in at the same time, and if you log out (destroy the session) from the admin account then it will not affect the `student` login session.

### Example 2:

At e-commerce website, we deal with 3 kinds of people.
`users`, `sellers` & `admins`.

###  Role based Authentication

We usually see this kind of authentication on blogging websites. As there is only one owner of the website who creates different users and assigns them a role to manipulate the content of the website.

In this method we will create 2 tables that has parent child relationship.
`roles` & `users` (In this table we create a column called `role_id` which is a foreign key and refers to the `roles` table column.)

In role-based authentication, the administrator has to create permissions to separate different permissions by role.

**Note:**

This repo is using a package named [laravel-ui](https://github.com/laravel/ui) and using a second authentication method and creating 2 tables `admins` & `users`.

The security of Laravel authentication depends on 2 things; `Guards`(Protectors) and `Providers`.

**Guard:**

The Guard explains how the user is authentic to each request. By default Laravel ships with `session` guard.

**What is session?**

*Whenever clients visit our website, our PHP server will generate a cookie with `session_ID` and some content inside the client browser and most importantly a `session` file will also be created in our server. It contains the same `session_ID` and content.*

*Now when the user goes back to the website, the server will check and match, Does the server's `session-ID` match the browser cookie? If so, the user is authentic.*

**Provider:**

What kind of permanent storage mechanism do you want to use to retrieve users? Do you want to use `eloquent` or `query builder`?

# Deployment
[Heroku](https://www.heroku.com)
