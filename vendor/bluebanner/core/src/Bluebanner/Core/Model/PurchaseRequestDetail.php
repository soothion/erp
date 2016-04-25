<?php namespace Bluebanner\Core\Model;

use Bluebanner\Core\PurchaseRequestDetailRequestRequiredException;
use Bluebanner\Core\PurchaseRequestNotFoundException;

class PurchaseRequestDetail extends BaseModel
{
	const TRANS_NOT_IMPOSS="N/A";
	const TRANS_AIR='air';
	const TRANS_SEA='sea';
	const TRANS_SURFACE='surface';
	protected $touches = array('request');
	
	protected $table = 'core_purchase_request_detail';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'request_id' => 'required|integer',
		'item_id' => 'required|integer',
	);

	protected static function boot()
	{
		parent::boot();

		static::updating(function($model) {
			return $model->WriteRequestBom();
		});

		static::creating(function($model) {
			return $model->WriteRequestBom();
		});
	}
	
	public function validate() {
		if ( ! $rid = $this->request_id)
			throw new PurchaseRequestDetailRequestRequiredException('A PR is required for a PR detail, none given.');

		if ( ! $request = PurchaseRequest::find($rid))
			throw new PurchaseRequestNotFoundException("A PR is required for a PR detail, the given [$rid] can not found.given.");

		return true;
	}
	
	public function account()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Account');
	}
	
	public function platform()
	{
	    return $this->belongsTo('Bluebanner\Core\Model\Platform');
	}
	
	public function request()
	{
		return $this->belongsTo('Bluebanner\Core\Model\PurchaseRequest');
	}
	
	public function item()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item');
	}

	
	public function plan()
	{
		return $this->belongsTo('Bluebanner\Core\Model\PurchasePlan');
	}

	public function plandetail()
	{
		return $this->hasOne('Bluebanner\Core\Model\PurchaseRequestPlanLog', 'request_detail_id');
	}

	/*
	* return array
	*/
	public function childs()
	{
		$r = PurchaseRequestDetail::find($this->id);
		$childs = array();

		if($r->request_bom){
			$bom = explode(",", $r->request_bom);
			foreach ($bom as $k => $v) {
				$c = explode("|", $v);
				$childs[$c[0]] = $c[1];//后期计算 * qty
			}
		}

		return $childs;
	}

	/*public function subsets()
	{
		return $this->hasMany('Bluebanner\Core\Model\PurchaseRequestDetail', 'parent_id');
	}*/

	/*public static function withRequest(array $conditions = null)
	{
		//表连接，id字段重复，只要明细表的id,具体字段提出来是为了区别有重复的
		$query = static::leftJoin('core_purchase_request', 'core_purchase_request.id', '=', 'core_purchase_request_detail.request_id');
		$query = $query->select(
			'core_purchase_request.invoice',
			'core_purchase_request.agent',
			'core_purchase_request.created_at',
			'core_purchase_request.updated_at',
			'core_purchase_request.relation_id',
			'core_purchase_request.status',
			'core_purchase_request.type',
			'core_purchase_request.note as remark',
			'core_purchase_request.id as request_id',
			'core_purchase_request_detail.*'
			);
		if ($conditions) {
			foreach($conditions as $c)
			{
				if($c['v'] == '') continue;

				switch ($c['o']) {
					case 'between':
						$query->whereBetween('core_purchase_request.'.$c['f'],$c['v']);
						break;
					case 'in':
						$query->whereIn('core_purchase_request.'.$c['f'],$c['v']);
						break;
					case 'like':
						$query->where('core_purchase_request.'.$c['f'],'like','%'.$c['v'].'%');
						break;
					default:
						$query->where('core_purchase_request.'.$c['f'],$c['o'],$c['v']);
						break;
				}
			}
		}

		return $query;
	}*/

	/*
	* 两个一起写排除重复的
	*/
	public static function withJoin(array $request_condition = null, array $detail_condition = null)
	{
		//表连接，id字段重复，只要明细表的id,具体字段提出来是为了区别有重复的
		$query = static::leftJoin('core_purchase_request', 'core_purchase_request.id', '=', 'core_purchase_request_detail.request_id');
		$query = $query->select(
			'core_purchase_request.invoice',
			'core_purchase_request.agent',
			'core_purchase_request.created_at',
			'core_purchase_request.updated_at',
			'core_purchase_request.relation_id',
			'core_purchase_request.status',
			'core_purchase_request.warehouse_id',//需求仓库
			'core_purchase_request.relation_id',//需求的订单
			'core_purchase_request.type',
			'core_purchase_request.note as remark',
			'core_purchase_request.id as request_id',
			'core_purchase_request_detail.*'
			)->whereRaw('lv4_core_purchase_request.deleted_at is null');
		if ($request_condition) {
			foreach($request_condition as $c)
			{
				if(($c['v'] == '') || ($c['v'] == 'null')) continue;

				switch ($c['o']) {
					case 'between':
						$query->whereBetween('core_purchase_request.'.$c['f'],$c['v']);
						break;
					case 'in':
						$query->whereIn('core_purchase_request.'.$c['f'],$c['v']);
						break;
					case 'like':
						$query->where('core_purchase_request.'.$c['f'],'like','%'.$c['v'].'%');
						break;
					default:
						$query->where('core_purchase_request.'.$c['f'],$c['o'],$c['v']);
						break;
				}
			}
		}

		if ($detail_condition) {
			foreach($detail_condition as $c)
			{
				if(($c['v'] == '') && ($c['f'] !='plan_id') && ($c['f'] !='plan_detail_id')) continue;

				if(($c['v'] == 'null') && ($c['f'] !='plan_id') && ($c['f'] !='plan_detail_id')) continue;

				switch ($c['o']) {
					case 'between':
						$query->whereBetween('core_purchase_request_detail.'.$c['f'],$c['v']);
						break;
					case 'in':
						$query->whereIn('core_purchase_request_detail.'.$c['f'],$c['v']);
						break;
					case 'like':
						$query->where('core_purchase_request_detail.'.$c['f'],'like','%'.$c['v'].'%');
						break;
					default:
						$query->where('core_purchase_request_detail.'.$c['f'],$c['o'],$c['v']);
						break;
				}
			}
		}

		return $query;
	}


	/**/ 
	public static function getParentStr($plan_id = 0)
	{
		$query  = static::leftJoin('core_purchase_request', 'core_purchase_request.id', '=', 'core_purchase_request_detail.request_id');
		$query->select('core_purchase_request_detail.*')
			->where('core_purchase_request.status','=','confirmed')
			->where('core_purchase_request_detail.parent_id','>',0);

		if($plan_id > 0)// 计划id大于0采取搜索计划／／如果没有计划则出来的所有的／／还没有添加计划时，需要找出明细对应的parent，按照申购父sku加入sku
			$query->where('core_purchase_request_detail.plan_id','=',$plan_id);

		return $query;
	}

	/**
	 * 
	 * 如果SKU是组合SKU，自动按照拆分规则增加记录
	 * 
	 */
	public function childAutoSave()
	{
		if ( ($item = $this->item) && ($boms = $item->bom) ) {

			foreach ($boms as $bom) {
				$row = $this->attributes;
				$row['item_id'] = $bom->child_id;
				$row['parent_id'] = $this->id;
				$row['qty'] = $this->qty * $bom->qty;
				static::create($row);
			}
			
			$this->save();
		}
		return true;
	}
	
	
	///////////现在已经去除了bom字段//////////
	///////////zhunian//////////

	/**
	 * 
	 * 如果SKU是组合SKU，自动将规则插入到request_bom表
	 * 
	 */
	public function WriteRequestBom()
	{
	    //change by zhunian 现在已经去除了bom字段
// 		$bomArr = array();
// 		$str = '';

// 		if ( ($item = $this->item) && ($boms = $item->bom) ) {
// 			foreach ($boms as $bom) 
// 			{
// 				$bomArr[] = $bom->child_id."|".$bom->qty;
// 			}
// 			if(count($bomArr) >0){
// 				$str = implode(",",$bomArr);
// 			}
// 		}

// 		$this->request_bom = $str;
// 		return true;
        //change end		
	}


	//找bom的时候有一个级联关系。。。在bom表一层一层找

	/*public function childAutoDelete()
	{
		if ($children = $this->subsets) {
			foreach ($children as $child) {
				$child->delete();
			}
		}
		return true;
	}*/
	
	/**
	 * 根据预计到货时间判断运输方式
	 * @param timestamp $eta
	 * @param int $leadDays
	 * @return string transportation
	 */
	public static function getTransportationByETAAndLeadtime($eta,$leadDays)
	{
	    //空运最快时间
	    $maxAirDays=3;
	    //海运最快时间
	    $maxSeaDays=21;
	    
	    $nowTime=time();
	    
	    if(is_string($eta)) $eta=strtotime($eta);
	    
	    if($eta<=$nowTime+86400*$leadDays)
	    {
	        // 不可能的时间
	        return  self::TRANS_NOT_IMPOSS;
	    }
	    
	    //空运区间
	    if($eta>time()+86400*$leadDays && $eta<=time()+86400*($leadDays+$maxAirDays))
	    {
	        // 空运
	       return  self::TRANS_AIR;
	    }
	    //海运运区间
	    elseif($eta>time()+86400*($leadDays+$maxAirDays) && $eta<=time()+86400*($leadDays+$maxSeaDays))
	    {
	        return self::TRANS_SEA;
	    }
	    else
	        //都可以
	       return self::TRANS_SURFACE;
	    
	}
	
	
	public static function getTransportationList()
	{
	    return array(
	            "N/A"    =>self::TRANS_NOT_IMPOSS,
	            'air'    =>self::TRANS_AIR,
	            'sea'    =>self::TRANS_SEA,
	            'surface'=>self::TRANS_SURFACE,
	    );
	}

}