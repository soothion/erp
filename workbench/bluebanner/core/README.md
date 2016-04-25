core
============

==修改配置文件app.php

===add to providers array

  'Bluebanner\Core\CoreServiceProvider',
  'Bluebanner\Ui\UiServiceProvider',
  'Cartalyst\Sentry\SentryServiceProvider',

===add to aliases array

  'Core'							=>	'Bluebanner\Core\Facades\Core',
  'Inventory'					=>	'Bluebanner\Core\Facades\Inventory',
  'Item'							=>	'Bluebanner\Core\Facades\Item',
  'Storage'						=>	'Bluebanner\Core\Facades\Storage',
  'Sentry'						=>	'Cartalyst\Sentry\Facades\Laravel\Sentry',

==修改配置文件auth.php(可能不再需要了)

  'model' => 'Bluebanner\Core\Model\User',

==建立数据库，请注意顺序

  php artisan migrate --package cartalyst/sentry
  php artisan migrate --package bluebanner/core

==导入初始数据

  php artisan db:seed --class="Bluebanner\Core\DatabaseSeeder"

==输出配置文件

  php artisan config:publish cartalyst/sentry
  php artisan config:publish bluebanner/core

==assets输出

  php artisan asset:publish
