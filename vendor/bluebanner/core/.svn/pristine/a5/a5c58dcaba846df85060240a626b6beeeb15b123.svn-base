<?php namespace Bluebanner\Core\Warehouse;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\Model\User;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\Warehouse;
use Bluebanner\Core\Model\Account;
use Bluebanner\Core\Model\Storage;

class WarehouseService implements WarehouseServiceInterface
{
  
	public function warehouseList()
	{
		 return Warehouse::where('id', '>', 0);
	}

	public function warehouseFind($id)
	{  
		return Warehouse::find($id);
	}
	
	public function warehouseCreate($warehouseNew)
	{
		return Warehouse::create($warehouseNew);
	}

	public function containerListByWarehouseId($warehouse_id)
	{
		return Storage::where('warehouse_id', '=', $warehouse_id);
	}

	public function containerCreate($container)
	{
		return Storage::create($container);
	}

	public function containerFind($id)
	{
		if ( ! $container = Storage::find($id))
			throw new \Exception('Container not find.');

		return $container;
			
	}
	
}	
