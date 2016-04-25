<?php namespace Bluebanner\Core\Model;

use Bluebanner\Core\StockIOException;

class StockIODetail extends BaseModel
{
	
	protected $table = 'core_storage_io_detail';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
		
	public $rules = array(
		'io_id' => 'required|integer',
		'item_id' => 'required|integer',
	);
	public function validate() 
	{
		if ( ! $io_id = $this->io_id)
			throw new StockIOException('A StockIO is required for a Stock detail, none given.');

		if ( ! $stockio = StockIOMaster::find($io_id))
			throw new StockIOException("A StockIO is required for a StockIO detail, the given [$io_id] can not found.given.");

		return true;
	}
	
	public function item()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item','item_id');
	}

	public function io()
	{
		return $this->belongsTo('Bluebanner\Core\Model\StockIOMaster');
	}

	public function relation()
	{

		//重写里面的morphTo
		$type = $this->io->type;

		switch ($type){
			case '1':
				$class ='Bluebanner\Core\Model\StockPurchaseDetail';
				break;
			case '2':
				$class ='Bluebanner\Core\Model\CountingMaster';
				break;
			case '4':
				$class ='Bluebanner\Core\Model\ShipMaster';
				break;
			case '6':
				$class ='Bluebanner\Core\Model\OtherIOMaster';
				break;
			case '9':
				$class ='Bluebanner\Core\Model\RMAMaster';
				break;
			case '-1':
				$class ='Bluebanner\Core\Model\PurchaseReturn';
				break;
			case '-2':
				$class ='Bluebanner\Core\Model\CountingMaster';
				break;
			case '-4':
				$class ='Bluebanner\Core\Model\ShipMaster';
			case '-6':
				$class ='Bluebanner\Core\Model\OtherIOMaster';
				break;
		}

		return $this->belongsTo($class, 'relation_did');
	}

}
