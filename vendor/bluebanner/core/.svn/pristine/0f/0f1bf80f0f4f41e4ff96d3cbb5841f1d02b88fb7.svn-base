# Installation

- [修改配置文件](#configuration)
- [初始化数据库](#databases)
- [Assets输出](#assets)

<a name="configuration"></a>
## 修改配置文件

**add to providers in app.php**

	'Bluebanner\Core\CoreServiceProvider',
	'Bluebanner\Ui\UiServiceProvider',
	'Cartalyst\Sentry\SentryServiceProvider',

**add to aliases in app.php**

	'Core'				=>	'Bluebanner\Core\Facades\Core',
	'Inventory'			=>	'Bluebanner\Core\Facades\Inventory',
	'Item'				=>	'Bluebanner\Core\Facades\Item',
	'Storage'			=>	'Bluebanner\Core\Facades\Storage',
	'Sentry'			=>	'Cartalyst\Sentry\Facades\Laravel\Sentry',
	
**输出配置文件**

	php artisan config:publish cartalyst/sentry
	php artisan config:publish bluebanner/core

<a name="databases"></a>
## 初始化数据库

**建立数据库，请注意顺序**

	php artisan migrate --package cartalyst/sentry
	php artisan migrate --package bluebanner/core

**导入初始数据**

	php artisan db:seed --class="Bluebanner\Core\DatabaseSeeder"

<a name="assets"></a>
## assets输出

	php artisan asset:publish