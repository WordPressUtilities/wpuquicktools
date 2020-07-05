# WPU Quick Tools

WPU Quick Tools is a quick library to retrieve some WordPress datas without loading it.

## How to Install :

- Just unzip it in a protected subdirectory of your WordPress install. It should never be loaded as a plugin.

## Example script :

- Create a file named `my-posts.php` at WordPress root and edit the included wpuquicktools.php file path.

```php
<?php
include dirname( __FILE__ ) . '/shell/wpuquicktools/wpuquicktools.php';

wpuquicktools_query_to_json("
    SELECT SQL_CACHE id, post_title
    FROM " . $table_prefix . "posts
    LIMIT 0,10;
");

```
