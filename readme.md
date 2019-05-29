# Laravel Seeder (with data) Generator

This is a laravel package which adds a generator command (make) to your artisan commands that will generate a database seeder class for you. It is similar to the included seeder class generator except that this generator allows you to pass data to it to include in the seeder class.

This can come in handy in situations where you might have database entries you want to be included with your deployment (such as roles and permissions, etc.)

`make:seeder-with-data`

## Install

```
composer require amestsantim/laravel-seeder-with-data-generator
```

## Usage

```make:seeder-with-data [options] [--] <tableName> [<data>]```
<pre>Arguments:
     tableName             The name of the DB table
     data                  The data, as a serialized array of named index arrays [default: "[]"]
Options:
      --path[=PATH]         Path where the seeder file should be saved
      --timestamps          If present, this switch will enable the automatic insertion of timestamps</pre>

### Examples

```php
php artisan make:seeder-with-data permissions "[['guard_name' => 'web', 'name' => 'Make Seeders'], ['guard_name' => 'web', 'name' => 'Run Seeders']]"
```

Notice the format that we use, the data argument is passed in as is. Remember to put it in double quotation marks.

...this will give you:

```php
<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class GenericModel extends Model
{
    public $timestamps = false;
}

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

```php
php artisan make:seeder-with-data permissions "[['guard_name' => 'web', 'name' => 'Make Seeders'], ['guard_name' => 'web', 'name' => 'Run Seeders']]" --path="/storage/app/seeders"
```

It will create the directories in the path if they do not already exist.

If you omit the data argument, the default, which is an empty array will be used so that the seeder will still run without any errors but will effectively do nothing.

Specifying the --timeStamps switch will change the value of the $timestamps property on the model to true. This will enable the automatic addition of the created_at and updated_at fields in the inserted data. The command would like like this:
```php
php artisan make:seeder-with-data permissions "[['guard_name' => 'web', 'name' => 'Make Seeders'], ['guard_name' => 'web', 'name' => 'Run Seeders']]" --timestamps
```