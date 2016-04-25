<?php namespace Bluebanner\Core;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
	
	public function boot()
	{
		$this->package('bluebanner/core');
		
		$app = $this->app;
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
    $this->app->singleton('Bluebanner\Core\Storage\StockServiceInterface', 'Bluebanner\Core\Storage\StockService');

		$this->app->singleton('Bluebanner\Core\Item\ItemServiceInterface', 'Bluebanner\Core\Item\ItemService');

		// 申购采购模块绑定
		$this->app->singleton('Bluebanner\Core\Purchase\PlanServiceInterface', 'Bluebanner\Core\Purchase\PlanService');
		$this->app->singleton('Bluebanner\Core\Repository\Purchase\RequestRepositoryInterface', 'Bluebanner\Core\Repository\Purchase\RequestRepository');
		$this->app->singleton('Bluebanner\Core\Repository\Purchase\PlanRepositoryInterface', 'Bluebanner\Core\Repository\Purchase\PlanRepository');

		
		$this->app->singleton('Bluebanner\Core\Purchase\PurchaseServiceInterface', 'Bluebanner\Core\Purchase\PurchaseService');
		$this->app->singleton('Bluebanner\Core\Purchase\RequestServiceInterface', 'Bluebanner\Core\Purchase\RequestService');
		$this->app->singleton('Bluebanner\Core\Purchase\OrderServiceInterface', 'Bluebanner\Core\Purchase\OrderService');
		$this->app->singleton('Bluebanner\Core\Purchase\AuditInterface', 'Bluebanner\Core\Purchase\PRAudit');
		
		$this->app->singleton('Bluebanner\Core\Warehouse\WarehouseServiceInterface', 'Bluebanner\Core\Warehouse\WarehouseService');
		$this->app->singleton('Bluebanner\Core\Warehouse\RMAServiceInterface', 'Bluebanner\Core\Warehouse\RMAService');
		$this->app->singleton('Bluebanner\Core\Inventory\InventoryServiceInterface', 'Bluebanner\Core\Inventory\InventoryService');
		$this->app->singleton('Bluebanner\Core\Warehouse\StockIOServiceInterface', 'Bluebanner\Core\Warehouse\StockIOService');
		$this->app->singleton('Bluebanner\Core\Warehouse\ShipmentServiceInterface', 'Bluebanner\Core\Warehouse\ShipmentService');
		$this->app->singleton('Bluebanner\Core\Warehouse\ShipmentServiceInterface', 'Bluebanner\Core\Warehouse\ShipmentService');


		$this->app['core'] = $this->app->share(function($app) {
			return new CoreService;
		});
		
		$this->app['item'] = $this->app->share(function($app) {
			return new Item\ItemService;
		});
		
		$this->app['inventory'] = $this->app->share(function($app) {
			return new Inventory\InventoryService;
		});
		
		$this->app['storage'] = $this->app->share(function($app) {
			// return new StorageService;
		});
		
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('item', 'inventory', 'storage', 'core');
	}

}