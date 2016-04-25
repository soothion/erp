<?php namespace Bluebanner\Core\Model;

use Illuminate\Support\Facades\DB;

use Bluebanner\Core\StockIOException;

class StockIOMaster extends BaseModel
{
	
	protected $table = 'core_storage_io_master';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
		
	public $rules = array(
		'invoice' => 'required|unique:core_storage_io_master',
		'agent' => 'required|integer'
	);

	public function validate() {
		if ( ! $invoice = $this->invoice)
			throw new StockIOException('An invoice is required for a Stock IO, none given.');

		if ( ! $this->relation_invoice)
			throw new StockIOException('An RelationInvoice is required for a Stock IO, none given.');

		if ( ! $this->relation_id)
			throw new StockIOException('An RelationId is required for a Stock IO, none given.');

		//修改的排除
		$persisted = $this->newQuery()->where('invoice', '=', $invoice)->first();
		if ($persisted && ($persisted->getKey() != $this->getKey()) && ($persisted->invoice == $this->invoice))
			throw new StockIOException("A Stock IO already exists with invoice [$invoice].");


		$persisted = $this->newQuery()
					->where('relation_invoice', '=', $this->relation_invoice)
					->where('type','=',$this->type)
					->first();
		if ($persisted && ($persisted->getKey() != $this->getKey()) && ($persisted->relation_invoice == $this->relation_invoice) && (strpos($this->invoice,'-')) ==false)
			throw new StockIOException("A Stock IO already with Relation Invoice [$this->relation_invoice].");

		return true;
	}

	public function warehouse()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Warehouse','warehouse_id');
	}

	public function createUser()
	{
		return $this->belongsTo('Cartalyst\Sentry\Users\Eloquent\User', 'creat_agent');
	}

	public function execUser()
	{
		return $this->belongsTo('Cartalyst\Sentry\Users\Eloquent\User', 'exec_agent');
	}
	
	public function details()
	{
		return $this->hasMany('Bluebanner\Core\Model\StockIODetail', 'io_id');
	}
	

	/**
	* @desc 		获取最新的invoice
	* @param 		(int)type "大于0 － 入库"，“小于0 － 出库”
	* @return 		string
	*/
	public function GenerateInvoice($type)
	{

		$char = ($type > 0) ? 'I' : 'O';
		$prev_invoice  = $char . date('ymd');

		$query = $this->newQuery();
		$invoice = $query->withTrashed()
					->select('invoice')
					->where('invoice','like','%'.$prev_invoice.'%')
					->where('invoice','not like','%-%')
					->orderBy('id', 'desc')
					->first();
		$count = $invoice ? ((int)(substr($invoice->invoice,-2))+1) : '01';
		$count = str_pad($count, 2, "0", STR_PAD_LEFT); 

		return $prev_invoice . $count;
	}


	/**
	* @desc 		获取拆分的invoice
	* @param 		(int)type "大于0 － 入库"，“小于0 － 出库”
	* @return 		string
	*/
	public function generateSplitInvoice($type,$prev_invoice)
	{

		$char = ($type > 0) ? 'I' : 'O';
		$prev_invoice = explode("-",$prev_invoice);

		$query = $this->newQuery();
		$invoice = $query->withTrashed()
					->select('invoice')
					->where('invoice','like','%'.$prev_invoice[0].'%')
					->orderBy('id', 'desc')
					->first();
		$count = (!$invoice || strpos($invoice->invoice,'-') ===false) ? '02' : ((int)(substr($invoice->invoice,-2))+1);
		//$count = $invoice ? ((int)(substr($invoice->invoice,-2))+1) : '01';
		$count = str_pad($count, 2, "0", STR_PAD_LEFT); 

		return $prev_invoice[0] . "-" . $count;
	}

	/**
	* 多态实现仓库其他单跟出入库单的关联[出入库单不是属主]
	* //似乎有问题
	*/
	public function relation()
	{
		//重写里面的morphTo
		list($type, $id) = $this->getMorphs('relation', 'type','relation_id');

		switch ($this->$type){
			case '1':
				$class ='Bluebanner\Core\Model\StockPurchaseMaster';
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

		// $class = $this->$type;

		return $this->belongsTo($class, $id);
	}

	public function books()
	{
		return $this->morphMany('Bluebanner\Core\Model\InventoryBook', 'bookRelations');
	}



  public function detailQueryBuilder() {
    return DB::table(StockIODetail::getTbl());
  }

  public function stockPurchaseMasterQueryBuilder() {
    return DB::table(StockPurchaseMaster::getTbl());
  }

  public function stockPurchaseDetailQueryBuilder() {
    return DB::table(StockPurchaseDetail::getTbl());
  }

  public function poQueryBuilder() {
    return DB::table(PurchaseOrder::getTbl());
  }


  public function getIOLists($conds, $pg = 1, $size = 16) {
    $result = $this->findByConds($conds, $pg, $size, 1)->get();

    foreach ($result as $ioList) {
      $ioList->warehouse;
      $ioList->createUser;
      $ioList->execUser;
    }

    return $result;
  }

  public function getOrdersByOpts($conds, $pg, $size) {
    $result = $this->findByConds($conds, $pg, $size, 0)->get();

    foreach ($result as $order) {
      $order->createUser;
      $order->execUser;
    }

    return $result;
  }

  public function genStockPurchaseLog($in) {
    DB::beginTransaction();

    try {
      foreach ($in['stockDetails'] as $stockDetailId => $stockDetail) {
        $this->stockPurchaseDetailQueryBuilder()->where('id', $stockDetailId)->update($stockDetail);
      }

      if ($this->stockPurchaseDetailQueryBuilder()->where('master_id', $in['ioMaster']['relation_id'])->sum('qty_rest') == 0) {
        $this->stockPurchaseMasterQueryBuilder()->where('id', $in['ioMaster']['relation_id'])->update(array('updated_at' => date('Y-m-d H:i:s'), 'status' => 'done'));
        $this->poQueryBuilder()->where('id', $in['stockMaster']['po_id'])->update(array('updated_at' => date('Y-m-d H:i:s'), 'status' => 'completely received'));
      } else {
        $this->stockPurchaseMasterQueryBuilder()->where('id', $in['ioMaster']['relation_id'])->update(array('updated_at' => date('Y-m-d H:i:s'), 'status' => 'doing'));
        $this->poQueryBuilder()->where('id', $in['stockMaster']['po_id'])->update(array('updated_at' => date('Y-m-d H:i:s'), 'status' => 'partially received'));
      }

      $in['ioMaster']['invoice'] = $this->GenerateInvoice(1);
      $masterId = $this->createGetId($in['ioMaster']);

      foreach ($in['ioDetails'] as $detail) {
        $detail['io_id'] = $masterId;
        $this->detailQueryBuilder()->insert($detail);
      }

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception($e);
    }
  }
}