# PHP_Laravel12_One_Time_Operations

## Project Description

PHP_Laravel12_One_Time_Operations is a Laravel 12 project that demonstrates how to perform one-time operations in a Laravel application.
It allows developers to define operations like database seeding, data cleanup, or any custom task, which will run only once and never repeat automatically.
This is useful for setup tasks, initial data seeding, or maintenance scripts that must not run multiple times.


## Features

1. One-Time Operations: Define tasks that execute only once.

2. Easy Operation Creation: Generate operations with Artisan command operations:make.

3. Operations Tracking: Processed operations are tracked in the database, preventing duplicates.

4. Sync and Async Execution: Operations can run synchronously or via queue.

5. Tagging Support: Run operations selectively using tags.

6. Customizable Directory & Table: You can configure the operations folder and database table.



## Benefits

- Avoid repeated execution of critical setup tasks.

- Automate initial database seeding or cleanup scripts.

- Integrate easily into CI/CD pipelines to ensure tasks run only once per deployment.

- Keep code organized and maintainable by separating one-time operations from migrations or controllers.



## Technologies Used

- PHP 8.1+

- Laravel 12

- MySQL / MariaDB

- Composer for dependency management

- TimoKoerber Laravel One-Time Operations Package for one-time tasks

- Spatie Laravel Permission Package (optional, for roles example)


## Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL or MariaDB
- Laravel 12



---



## Installation Steps


---


## STEP 1: Create Laravel 12 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel12_One_Time_Operations "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_One_Time_Operations

```

#### Explanation:

Installs a fresh Laravel 12 project and navigates into the project folder for setup.





## STEP 2: Database Setup 

### Update database details:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_one_time_operations
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel12_one_time_operations

```

### Run migrations:

```
php artisan migrate

```


#### Explanation:

Connects Laravel to MySQL and creates the required tables for your application.





## STEP 3: Install One-Time Operations Package

### Run:

```
composer require timokoerber/laravel-one-time-operations

```


#### Explanation:

Installs the package that allows you to define operations that run only once.




## STEP 4: Create Example Operation

### Let’s create a first operation file:

```
php artisan operations:make AddAwesomeUser

```

### This will generate a file like:

```
operations/2026_03_02_000000_add_awesome_user.php

```

### Edit it as follows:

```
<?php

use App\Models\User;
use TimoKoerber\LaravelOneTimeOperations\OneTimeOperation;

return new class extends OneTimeOperation
{
    // This runs synchronously
    protected bool $async = false;

    public function process(): void
    {
        User::create([
            'name' => 'Awesome User',
            'email' => 'awesome@example.com',
            'password' => bcrypt('password123'),
        ]);
    }
};

```

#### Explanation:

This defines an operation that creates a new user. It will run once when executed.





## STEP 5: Run Operations

### Run:

```
php artisan operations:process

```

### Expected Output:

```
Processing operation: AddAwesomeUser

 Successfully executed AddAwesomeUser

```


<img width="1448" height="207" alt="Screenshot 2026-03-02 162143" src="https://github.com/user-attachments/assets/f94bb3b6-3359-4038-baa3-0b1e6b6971e2" />




### Now if you run it again:

```
php artisan operations:process

```

### You will see:

```
No pending operations to execute.

```


<img width="1450" height="123" alt="Screenshot 2026-03-02 162215" src="https://github.com/user-attachments/assets/47bff5de-046a-4c3c-a414-2ad56945d4aa" />



#### Explanation:

The first run executes the operation; subsequent runs skip it automatically.




## STEP 6: Add More Operations

### Example 1: Seed Roles

```
php artisan operations:make SeedRoles

```

### Edit:

```
<?php

use Spatie\Permission\Models\Role;
use TimoKoerber\LaravelOneTimeOperations\OneTimeOperation;

return new class extends OneTimeOperation
{
    public function process(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'editor']);
    }
};

```

#### Explanation:

This operation seeds default roles into your database once.




### Example 2: Clean Old Users

```
php artisan operations:make CleanupOldUsers

```

### Edit:

```
<?php

use App\Models\User;
use TimoKoerber\LaravelOneTimeOperations\OneTimeOperation;

return new class extends OneTimeOperation
{
    public function process(): void
    {
        User::where('created_at', '<', now()->subYear())->delete();
    }
};

```

#### Explanation:

This operation deletes users older than a year and runs only once.


<img width="1411" height="256" alt="Screenshot 2026-03-02 162511" src="https://github.com/user-attachments/assets/b1e296af-782a-4504-97b1-d88326b81252" />


### Run:

```
php artisan operations:process

```

### Console Output (like reference repo):

```
Processing operation: SeedRoles
✓ Successfully executed SeedRoles
Processing operation: CleanupOldUsers
✓ Successfully executed CleanupOldUsers

```


<img width="1463" height="225" alt="Screenshot 2026-03-02 162329" src="https://github.com/user-attachments/assets/1d520d3f-25a7-4eea-85ee-8eacf17ff23e" />




--- 

# Project Folder Structure:

```
PHP_Laravel12_One_Time_Operations/
├─ app/
│  ├─ Models/
│  │  └─ User.php
├─ operations/
│  ├─ 2026_03_02_000000_add_awesome_user.php
│  ├─ 2026_03_02_000001_seed_roles.php
│  └─ 2026_03_02_000002_cleanup_old_users.php
├─ database/
│  └─ migrations/
├─ config/
│  └─ one-time-operations.php
└─ artisan

```



