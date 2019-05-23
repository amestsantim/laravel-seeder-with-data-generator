# Laravel Seeder (with data) Generator

This is a laravel package which adds a generator command to your artisan commands that will generate a seeder class for you. It is similar to the included seeder class generator except that this generator allows you to pass data to it to include in the seeder class.

This can come in handy in situations where you might have database entries you want to be included with your deployment (such as roles and permissions, etc.)

- `make:seeder-with-data`




## Usage

### Step 1: Install Through Composer

```
composer require amestsantim/laravel-seeder-with-data-generator
```

### Step 2: Run the artisan command!

```make:seeder-with-data [options] [--] <tableName> [<data>]```
<pre>Arguments:
     tableName             The name of the DB table
     data                  The data, as a named index array [default: "[]"]
Options:
      --path[=PATH]     Path where the seeder file should be saved</pre>

## Examples

```
php artisan make:seeder-with-data permissions "[['guard_name' => 'web', 'name' => 'Make Seeders'], ['guard_name' => 'web', 'name' => 'Run Seeders']]"
```

Notice the format that we use, the data argument is passed in as is. Remember to put it in double quotation marks.

...this will give you:

```php
<?php

use Illuminate\Database\Seeder;
use AmestSantim\Generators\GenericModel;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $rowArray = [['guard_name' => 'web', 'name' => 'Make Seeders'], ['guard_name' => 'web', 'name' => 'Run Seeders']];
        $model = new GenericModel();
        $model->setTable('permissions');
        foreach ($rowArray as $row) {
            $model->create($row);
        }
    }
}

```

You can also specify where the generated seeder is saved by using the --path option like so,

```php artisan make:seeder-with-data permissions "[['guard_name' => 'web', 'name' => 'Make Seeders'], ['guard_name' => 'web', 'name' => 'Run Seeders']]" --path="/storage/app/seeders```

It will create the directories in the path if they do not already exist.

If you omit the data argument