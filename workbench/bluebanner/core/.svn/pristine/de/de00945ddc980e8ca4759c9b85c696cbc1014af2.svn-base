<?php
namespace Bluebanner\Core\Purchase;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\Model\PurchaseRequest;
use Bluebanner\Core\Model\Account;
use Bluebanner\Core\Model\PurchaseRequestDetail;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\Platform;
use Bluebanner\Core\Model\Warehouse;
use Bluebanner\Core\Model\PurchaseCostParams;
use Bluebanner\Core\Model\VendorQuotation;
use Bluebanner\Core\Model\PurchaseSkuDefault;

class RequestService implements RequestServiceInterface {

	public function __construct(
	        PurchaseRequest $model = null,
	        PurchaseRequestDetail $detailModel=null,
	        Item $item=null,
	        PurchaseSkuDefault $skuDefault=null,
	        Platform $platform=null,
	        Warehouse $warehouse=null,
	        PurchaseCostParams $costParams=null,
	        VendorQuotation $VendorQuotation=null)
	{
		$this->model = $model;
		$this->detailModel=$detailModel;
		$this->warehouseModel=$warehouse;
		$this->costParams=$costParams;
		$this->vendorQuotation=$VendorQuotation;
		$this->item=$item;
		$this->platform=$platform;
		$this->skuDefault=$skuDefault;
	}

	public function confirm($request_id, $agent)
	{
		$pr = $this->model->find($request_id);
		if ($pr->status != PurchaseRequest::STATUS_OF_PENDING) {
			throw new \Exception('only confirm from pending.');
		}

		if ($pr->agent != $agent) {
			throw new \Exception('only confirm self PR');
		}

		$pr->update(array('status' => PurchaseRequest::STATUS_OF_CONFIRMED));
	}
	

	/**
	 * 取消确认
	 * @param int $pr_id
	 * @param int $agent
	 * @throws \Exception
	 */
	public function unconfirm($pr_id,$agent)
	{
	    $pr = $this->model->find($pr_id);
	    if ($pr->status != PurchaseRequest::STATUS_OF_CONFIRMED) {
	        throw new \Exception('the PR status not allow to unconfirm !');
	    }
	
	    if ($pr->agent != $agent) {
	        throw new \Exception('only unconfirm self PR');
	    }
	
	    $pr->update(array('status' => PurchaseRequest::STATUS_OF_PENDING));
	}
	

	public function confirmplus($request_id, $agent)
	{
		$pr = PurchaseRequest::find($request_id);
		if ($pr->status != PurchaseRequest::STATUS_OF_PENDING) {
			throw new \Exception('only confirm from pending.');
		}

		if ($pr->agent != $agent) {
			throw new \Exception('only confirm self PR');
		}

		$pr->update(array('status' => PurchaseRequest::STATUS_OF_CONFIRMED));
    $this->dtm();
    
	}

  public static function stm() {
    
  }

  public function dtm() {
    
  }
    
	/**
	 * 获取申购单主表的数据
	 * $page_size = -1时，返回所有(用于导出)
	 * @param array $filter in [invoice, item_id, relation_id, warehouse_id, status, type]
	 * @param array $fields in [id, agent, agent_name, warehouse_id, warehouse_name, invoice, status,  type, note, verified_note]
	 * @param number $page_no
	 * @param number $page_size
	 */
	public function lists($filter,$fields,$page_no=1,$page_size=15)
	{
	    $allowFilterFields=array('id','invoice', 'item_id', 'relation_id', 'warehouse_id', 'status', 'type');
	   
	    self::filterArrayByKeys($filter, $allowFilterFields);
	    
	    $page_no=intval($page_no);
	    $page_size=intval($page_size);
	    
	    if($page_size==-1)
	    {
	        $offset=-1;
	    }
	    else
	    {
	        $offset=($page_no-1)*$page_size;
	    }
	    
      $listModelData=$this->findAllByCondition($filter,$offset,$page_size);
        
	    $return =array();
	    
	    foreach($listModelData->get() as $k=> $model)
	    {
	        $return[$k]=$model->toArray();
	        $return[$k]['warehouse']=$model->warehouse->toArray();
	        //$return['details']=$model->details->toArray();
	        $return[$k]['user']=$model->user->toArray();
	    }
	    $return=$this->listsModelDataFilter($return,$fields);
	    return $return;
	}
	
	/**
	 * 返回筛选后的结果
	 * @param array $source
	 * @param array $fields
	 * @return array 
	 */
	protected function listsModelDataFilter($source,$fields)
	{
	    $allowFields=array('id', 'agent', 'agent_name', 'warehouse_id', 'warehouse_name', 'invoice', 'check_note','status',  'type', 'note','relation_id', 'verified_note','created_at','updated_at','expired_at');
	    $tmp=array();
	    foreach($source as $k=>$se)
	    {
    	    foreach($allowFields as $field)
    	    {
    	        if(array_search($field,$fields)!==false)
    	        {
    	            if(isset($se[$field])) $tmp[$k][$field]=$se[$field];
    	            else
    	            {
    	                if($field=="agent_name")
    	                {
    	                    if(isset($se['user']['email']))
    	                    $tmp[$k][$field]=$se['user']['email'];
    	                }
    	                
    	                if($field=="warehouse_name")
    	                {
    	                    if(isset($se['warehouse']['name']))
    	                        $tmp[$k][$field]=$se['warehouse']['name'];
    	                }    
    	            }
    	                
    	        }
    	    }
	    }
	    return $tmp;
	}



    /**
     * 通用的查找方法
     * @param array $filter
     * @param number $offset
     * @param number $limit
     */
    public function findAllByCondition($filter,$offset=0,$limit=30)
    {
        $temp = PurchaseRequest::with('warehouse', 'details', 'user');
        if(!is_array($filter))
        {
            throw new \Exception('filter must be a array');
        }
        else 
        {
            if($offset==-1)
            {
                return $temp->all();
            }
            foreach($filter as $field => $value)
            {
                if(is_string($value)||is_int($value))
                {
                    $temp -> where($field, "=", $value);
                }
                else if(is_array($value))
                {
                    if(isset($value[0]))
                    {
                        $opera=strtolower($value[0]);
                        if($opera=="in")
                        {
                            if(isset($value[1])&&is_array($value[1]))
                            {
                                $temp ->whereIn($field,$value[1]);
                            }
                        }
                        else if($opera=="between")
                        {
                            if(isset($value[1])&&is_int($value[1]))
                            {
                                $temp ->where($field,">",intval($value[1]));
                            }
                            
                            if(isset($value[2])&&is_int($value[2]))
                            {
                                $temp ->where($field,"<",intval($value[2]));
                            }
                        }
                        else if($opera=="like")
                        {
                            if(isset($value[1])&&is_string($value[1]))
                            {
                                $temp ->where($field,"like",$value[1]);
                            }
                        }
                    }
                }
                else 
                {
                    throw new \Exception("filter's format is error !");
                }  
            }
        }
        return $temp;
         
    }
    
    
    public static  function filterArrayByKeys(&$source,$allowKey)
    {
        $tmp=array();
        foreach($source as $k=>$v)
        {
            if(array_search($k, $allowKey)!==false)
            {
                $tmp[$k]=$v;
            }
        }
       $source= $tmp;
    }
    
    /**
     * @desc 		获取最新的invoice
	 * @return 		string
     */
    public function GenerateInvoice()
    {
        return PurchaseRequest::GenerateInvoice();
    }
    
    /**
     * 返回所有申购单类别
     * @return array
     */
    public function typeList()
    {
        return PurchaseRequest::getTypeList();
    }
    
    /**
     * 获取所有状态类型
     * @return multitype:string
     */
    public function getStatusList()
    {
        return PurchaseRequest::getStatusList();
    }
    
    /**
     * 获取运输方式类型
     * @return multitype:string
     */
    public function getTransportationList()
    {
        return PurchaseRequestDetail::getTransportationList();
    }
    
    /**
     * 返回warehouse的 id=>name 对
     * @return array();
     */
    public function warehouseList($is_json=false)
    {
        $list=$this->warehouseModel->lists('name','id');
        if($is_json)
        {
            $json=array();$i=0;
            foreach($list as $id=>$name)
            {
                $json[$i]['id']=$id;
                $json[$i]['name']=$name;
                $i++;
            }
            return $json;
        }
        else return $list;
    }
    
    /**
     * 新建申购单主表
     * 新建之后的默认审核人为自己
     * @param array $pr purchase request master attr
     */
    public function createMaster(array $pr)
    {
        $attrs=array();
        
        if(isset($pr['invoice'])) $attrs['invoice']=$pr['invoice'];
        else $attrs['invoice']=$this->GenerateInvoice();
        
        if(isset($pr['agent'])) 
        {
            $attrs['agent']=$pr['agent'];
            $attrs['verified_agent']=$pr['agent'];
        }
        else
        {
            throw new \Exception("must pass the agent who create the Request!");
        }
        
        if(isset($pr['type'])) 
        {
            $attrs['type']=$pr['type'];
            $allTypes=$this->getTypeList();
            if(array_search($attrs['type'], $allTypes)===false)
            {
                throw new \Exception("not support request type. type:'".$attrs['type']."' !");
            }
        }
        else
        {
            throw new \Exception("make give the type of Request!");
        }
        
        if(isset($pr['warehouse_id'])) $attrs['warehouse_id']=intval($pr['warehouse_id']);
        else
        {
            throw new \Exception("we need to know the Request's warehouse!");
        }
        
        if(isset($pr['relation_id'])) $attrs['relation_id']=intval($pr['relation_id']);
        else $attrs['relation_id']=0;
        
        if(isset($pr['expired_at'])) $attrs['expired_at']=$pr['expired_at'];
        else
        {
            throw new \Exception("you must tell what time the Request been expired!");
        }
        
        if(is_string($attrs['expired_at'])) $attrs['expired_at']=strtotime($attrs['expired_at']);
        
        if(!$attrs['expired_at'])
        {
            throw new \Exception("you passed time format error!");
        }
        
        if(intval($attrs['expired_at'])<=time())
        {
            throw new \Exception("you passed time is already expired!");
        }
        
        $attrs['expired_at']=date("Y-m-d H:i:s",intval($attrs['expired_at']));
        
        if(isset($pr['note'])) $attrs['note']=$pr['note'];
        
        $attrs['status']=PurchaseRequest::STATUS_OF_PENDING;
        
        return $this->model->create($attrs);
    }
    
    /**
     * @param int $pr_id
     */
    public function getDetails($pr_id)
    {
        $request=$this->model->findOrFail($pr_id);
        $request -> warehouse;
        $request -> user;
        
        //如果订单是被拒绝状态 临时改为pending,修改后才允许真正改为pending 以及后续操作
        if($request->status=="rejected")
        {
            $request->status="pending";
        }
        
        foreach ($request->details as $detail) {
            $detail -> item -> spq;
            $detail->platform;
            $detail -> channel;
            $detail['item']['fee']=PurchaseCostParams::getFeeByItemAndWarehose($detail -> item ->id, $request -> warehouse->id);
        }
        return $request;
    }

    /**
     * 审核通过
     * @param int $pr_id
     * @param int $agent
     * @param string $note
     * @throws \Exception
     */
    public function approve($pr_id,$agent,$note)
    {
        $pr = $this->model->find($pr_id);
        if ($pr->status != PurchaseRequest::STATUS_OF_CONFIRMED && $pr->status != PurchaseRequest::STATUS_OF_REJECT) {
            throw new \Exception('only audit CONFIRMED PR');
        }
        
        $pr->update(array('status' => PurchaseRequest::STATUS_OF_ACCEPT,'verified_agent'=>$agent,'verified_note'=>$note,'verified_at'=>date('Y-m-d H:i:s',time())));
    }
    
    /**
     * 审核拒绝
     * @param int $pr_id
     * @param int $agent
     * @param string $note
     * @throws \Exception
     */
    public function reject($pr_id,$agent,$note)
    {
        $pr = $this->model->find($pr_id);
        if ($pr->status != PurchaseRequest::STATUS_OF_CONFIRMED && $pr->status != PurchaseRequest::STATUS_OF_ACCEPT) {
            throw new \Exception('only audit CONFIRMED PR');
        }
        
        $pr->update(array('status' => PurchaseRequest::STATUS_OF_REJECT,'verified_agent'=>$agent,'verified_note'=>$note,'verified_at'=>date('Y-m-d H:i:s',time())));
    }
    
    /**
     * 获取所有Item默认供应商的L/T
     */
    public function getLeadTimeList()
    {
        return $this->vendorQuotation->lists('lead_time','item_id');
    }
    

    /**
     * 根据供应商很产品信息获取供应商信息
     * @param 供应商id $vendor_id
     * @param 产品id $item_id
     */
    public function getVendorQuotationByVendorAndItem($vendor_id,$item_id)
    {
        return $this->vendorQuotation->where('vendor_id',intval($vendor_id))->where('item_id',intval($item_id))->first();
    }
    
    /**
     * 
     * 获取某个Item默认供应商的L/T
     */
    public function getLeadTime($item_id)
    {
        $skuDefault=$this->skuDefault->where('item_id',$item_id)->first();
        
        if(empty($skuDefault))
        {
            throw new \Exception("当前产品没有配置默认供应商信息!");
        }
        else 
        {
            $vendorId=$skuDefault->vendor->id;
            $vendorQuotation=$this->getVendorQuotationByVendorAndItem($vendorId, $item_id);
            if(empty($vendorQuotation))
            {
                throw new \Exception("当前产品默认供应商的信息未给出!");
            }
            else 
            {
                return intval($vendorQuotation->lead_time);
            }
        }
        
    }
    
    /**
     * 获取所有仓库,所有item的运费
     *
     */
    public function getAllWarehouseFeeList()
    {
        return PurchaseCostParams::GetAllWarehouseItemFee();
    }
    
    /**
     * 获取某个仓库下某个item的运费
     */
    public function getWarehouseFeeList($warehouse_id,$item_id)
    {
        return PurchaseCostParams::getFeeByItemAndWarehose($item_id, $warehouse_id);
    }
    
    public function updateMaster($pr_id,$attr)
    {
        $master=$this->model->findOrFail($pr_id);
        if(isset($attr['warehouse_id'])) $master->warehouse_id=intval($attr['warehouse_id']);
        if(isset($attr['invoice'])) $master->invoice=$attr['invoice'];
        if(is_string($attr['expired_at'])) $attr['expired_at']=strtotime($attr['expired_at']);
        if(isset($attr['expired_at'])) $master->expired_at=date("Y-m-d H:i:s",$attr['expired_at']);
        if(isset($attr['note'])) $master->note=$attr['note'];
        if(isset($attr['type'])) $master->type=$attr['type'];
        $master->save();
    }
    
    public function deleteMaster($pr_id)
    {
        $pr = $this->model->find($pr_id);
        if($pr==null)
        {
            throw new \Exception("您要删除的PR已经不存在!");
        }
        $pr->delete();
    } 
    
    public function addDetail($pr_id, $pd)
    {
        if(! isset($pd['platform_id']) ||! isset($pd['item_id']) ||! isset($pd['qty']) ||! isset($pd['end_date']))
        {
            throw new \Exception("添加的明细中缺少必要信息!");
        }
        
        if(! $this->checkDetailsEta($pd['item_id'],$pd['end_date']))
        {
            throw new \Exception("添加的明细中ETA 时间内不可能送达!");
        }
        
        if(!isset($pd['transportation'])) $pd['transportation']=$this->detailModel->getTransportationByETAAndLeadtime(strtotime($pd['end_date']), $this->getLeadTime($pd['item_id']));
        $attr=array();
        $attr['item_id']=intval($pd['item_id']);
        $attr['platform_id']=intval($pd['platform_id']);
        $attr['qty']=intval($pd['qty']);
        $attr['end_date']=date("Y-m-d H:i:s",strtotime($pd['end_date']));
        if(isset($pd['note'])) $attr['note']=$pd['note'];
        $attr['request_id']=intval($pr_id);
      $attr['transportation'] = $pd['transportation'];

      $this->detailModel->create($attr);
    }
    
    /**
     * 更新明细
     * @param int $pr_id
     * @param array $pd
     */
    public function updateDetail($pd_id,$pd)
    {
        $attr=array();
        if(isset($pd['item_id'])&&isset($pd['end_date'])&&!$this->checkDetailsEta($pd['item_id'],$pd['end_date']))
        {
            throw new \Exception("修改的明细中ETA 时间内不可能送达!");
        }
        if(isset($pd['item_id'])) $attr['item_id']=intval($pd['item_id']);
        if(isset($pd['platform_id'])) $attr['platform_id']=intval($pd['platform_id']);
        if(isset($pd['qty'])) $attr['qty']=intval($pd['qty']);
        if(isset($pd['end_date']))  $attr['end_date']=date("Y-m-d H:i:s",strtotime($pd['end_date']));
        if(isset($pd['note']))  $attr['note']=$pd['note'];

        $this->detailModel->findOrFail($pd_id)->update($attr);
    }
    
    /**
     * 删除 明细  硬删除
     * @param unknown $pd_id
     */
    public function deleteDetail($pd_id)
    {
        $this->detailModel->withTrashed()->findOrFail($pd_id)->withTrashed()->delete();
    }
    
    /**
     * 相当于更新整单 提交的信息 数据库中不存在则添加  存在修改 数据库中存在 提交的不存在  则删除数据库中的数据
     * 
     * @param int $pr_id
     * @param array $pr_attr
     * @param array(array) $pd_attrs
     */
    public function updateMasterAndDetail($pr_id,$pr_attr,$pd_attrs)
    {
		$self=$this;
        DB::transaction(function() use ($self,$pr_id, $pr_attr, $pd_attrs)
        {
            $alreadyExistIdList=$self->detailModel->where("request_id","=",$pr_id)->lists("id");
            $submitIdList=array();
            $self->updateMaster($pr_id, $pr_attr);
            foreach($pd_attrs as $pd_attr)
            {
                if(isset($pd_attr['id']))
                {
                    $submitIdList[]=$pd_attr['id'];
                    $self->updateDetail($pd_attr['id'], $pd_attr);
                }
                else
                {
                  $self->addDetail($pr_id, $pd_attr);
                }
            }
            $deleteIdList=array_diff($alreadyExistIdList,$submitIdList);
            if(count($deleteIdList)>0)
            {
                $self->detailModel->whereIn('id',$deleteIdList)->withTrashed()->delete();
            }
            
        });
       
        
    }
    
    /**
     * 检查新的明细的属性是否符合规则
     * @param array $attr
     */
    protected  function checkDetailsEta($item_id,$eta)
    {
        $lead_day=$this->getLeadTime($item_id);       
        return PurchaseRequestDetail::TRANS_NOT_IMPOSS!==$this->detailModel->getTransportationByETAAndLeadtime($eta, $lead_day);
    }
    
    /**
     * 根据excel解析出来的row 导入申购明细到数据库
     * @param array $rows
     * @param int $request_id
     * @param string $err_msg
     * @param int $successCount
     * @param int $errorCount
     * @return void
     */
    public function importRequestDetailByExcelRows($rows,$request_id,&$err_msg,&$successCount,&$errorCount)
    {
       
        //SKU列表
        $itemModelList=$this->item->lists('sku','id');
         
        //platform 列表
        $platformModelList=$this->platform->lists('name','id');
    
        // 默认item的最小发货时间
        $itemLeadTimelList=$this->vendorQuotation->lists('lead_time','item_id');
    
        $rightModelAttrs=array();
        $err_msg="";
        $successCount=$errorCount=0;
        foreach ($rows as $k => $row) {
            $tmpAttr=array();
            if($row[0][0]==""){
                $err_msg="excel 文件内容为空!";
                $successCount=0;
                $errorCount=count($rows);
                return;
            }  //排除excel清除内容后，还保存格式的表格
    
            $inputSKU=trim($row[0][0]);
            $inputQty=trim($row[0][1]);
            $inputPlatform=trim($row[0][2]);
            $inputETA=trim($row[0][3]);
    
            if(($item_id=array_search($inputSKU,$itemModelList))!==false)
            {
                $tmpAttr['item_id']=$item_id;
            }
            else
            {
                $err_msg.="第[".($k+1)."]条记录: sku:'".$inputSKU."'不存在\n";
                $errorCount++;
                continue;
            }
    
            if(($platform_id=array_search($inputPlatform,$platformModelList))!==false)
            {
                $tmpAttr['platform_id']=$platform_id;
            }
            else
            {
                $err_msg.="第[".($k+1)."]条记录: platform:'".$inputPlatform."'不存在\n";
                $errorCount++;
                continue;
            }
    
            if(is_numeric($inputQty))
            {
                $tmpAttr['qty']=abs(intval($inputQty));
            }
            else
            {
                $err_msg.="第[".($k+1)."]条记录: qty:'".$inputQty."' 值 必须为正整数\n";
                $errorCount++;
                continue;
            }
    
            if(preg_match("/^[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}$/",$inputETA)||preg_match("/^[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}\s[0-9]{1,2}\:[0-9]{1,2}\:[0-9]{1,2}$/",$inputETA))
            {
                $ETime=strtotime($inputETA);
                //不存在时 默认为两天
                $lead_day=isset($itemLeadTimelList[$item_id])?intval($itemLeadTimelList[$item_id]):2;
    
                //根据ETA判断运输方式
                $transportation=$this->detailModel->getTransportationByETAAndLeadtime($ETime, $lead_day);
                if($transportation==$this->detailModel->TRANS_NOT_IMPOSS)
                {
                    $err_msg.="第[".($k+1)."]条记录: 您的ETA时间段:'".$inputETA."'内,不可能送达 \n ".$inputSKU."的 最小备货时间为['".$lead_day."']天\n";
                    $errorCount++;
                    continue;
                }
                else
                {
                    $tmpAttr['end_date']=date("Y-m-d H:i:s",$ETime);
                    $tmpAttr['transportation']=$transportation;
                }
            }
            else
            {
                $err_msg.="第[".($k+1)."]条记录: 时间 :'".$inputETA."' 格式不正确 必须为 'YYYY-mm-dd' 或者 'YYYY-mm-dd HH:ii:ss'形式 \n";
                $errorCount++;
                continue;
            }
            $tmpAttr['request_id']=$request_id;
            $rightModelAttrs[$successCount]=$tmpAttr;
            $successCount++;
        }
         
        $self = $this;
        DB::transaction(function() use ($rightModelAttrs, $self) {
    
            foreach($rightModelAttrs as $attr)
            {
                $self->detailModel->create($attr);
            }
        });
    }
    
    









	// ==============================	华丽的分割线  下面是原来的代码	====================================
	/**
	 * Create Purchase Request
	 *
	 * @param array $array
	 * @param array $details
	 * @return Bluebanner\Core\Model\PurchaseRequest
	 */
	public function requestCreate(array $request, array $details) {
		DB::transaction(function() use (&$request, $details) {
			$request = PurchaseRequest::create($request);

			foreach ($details as $detail) {
				$detail['request_id'] = $r -> id;
				PurchaseRequestDetail::create($detail);
			}
		});
		return $request;
	}

// 	public function CreateMaster(array $request) {
// 		$r = PurchaseRequest::create($request);
// 		return $r;
// 	}

	public function requestDetailCreate(array $detail) {
		return PurchaseRequestDetail::create($detail);
	}

	/**
	 * Create Purchase Request Detail
	 *
	 * @return Bluebanner\Core\Model\PurchaseRequest
	 */
	public function requestList() {
		return PurchaseRequest::with('user', 'warehouse');
	}

	/**
	 * find
	 */
	public function requestFind($id) {
		if (!$request = PurchaseRequest::find($id))
			throw new PurchaseRequestNotFoundException("The PR [$id] can not found.");

		return $request;
	}

	/**
	 * remove
	 * @param integer $id
	 */
	public function requestRemove($id) {
		PurchaseRequest::destroy($id);
	}

	/**
	 *
	 * @param int $master_id
	 * @param array $detailInfoList
	 */
	public function addRequestDetail($master_id, array $detailInfoList) {
		foreach ($detailInfoList as $detail) {
			$detail['request_id'] = $master_id;
			PurchaseRequestDetail::create($detail);
		}
	}

	/**
	 * @param int $master_id
	 * @param array $detailIdList
	 * @return boolean
	 */
	public function removeRequestDetail($master_id, array $detailIdList) {
		if (count($detailIdList) < 1)
			return true;
		return PurchaseRequestDetail::where('request_id', $master_id) -> whereIn('id', $detailIdList) -> delete();
	}

	/**
	 * @param array $search_condition
	 * @return AmbigousList
	 */
	public function findByCondition(array $search_condition) {
		$temp = PurchaseRequest::with('warehouse', 'details', 'user');
		foreach ($search_condition as $condition) {
			if ($condition['opera'] == "in") {
				$temp -> whereIn($condition['field'], $condition['value']);
			} else {
				$temp -> where($condition['field'], $condition['opera'], $condition['value']);
			}
		}
		return $temp;
	}

	/**
	 * 查找所有item_id为@item_id的列的request_id(主表主键)
	 * @param interge  $item_id
	 *
	 * @return array count_id的集合
	 *
	 */

	public function getMasterIdFromDetailByItemId($item_id) {
		if (!is_array($item_id)) {
			$item_id = array(intval($item_id));
		}
		$ids = array();
		$requestDetail = new PurchaseRequestDetail();
		$ids = DB::table($requestDetail -> getTable()) -> whereIn('item_id', $item_id) -> lists('request_id');
		if (!is_array($ids))
			$ids = array();
		return $ids;
	}

	/**
	 * 查找所有item_id为@sku的列的request_id(主表主键)
	 * @param string  $sku
	 *
	 * @return array request_id的集合
	 *
	 */

	public function getMasterIdFromDetailByItemSku($sku) {
		$ids = array();
		$itemModel = new Item();

		$item_ids = DB::table($itemModel -> getTable()) -> where('sku', 'like', '%' . $sku . '%') -> lists('id');

		if (count($item_ids) > 0) {
			$requestDetail = new PurchaseRequestDetail();
			$ids = DB::table($requestDetail -> getTable()) -> whereIn('item_id', $item_ids) -> lists('request_id');
		}
		return $ids;
	}



	/**
	 *
	 */
	public static function getTypeList() {
		return PurchaseRequest::getTypeList();
	}

	/**
	 * 获取新建单的自动Invoice
	 * @return string
	 */
	public static function getNextInvoice() {
		return PurchaseRequest::GenerateInvoice();
	}

	public static function accountFindByName($name) {
		if ( ! $account = Account::where('name', '=', $name)->first()){
			 return 0;
		}else{
			 return  Account::where('name', '=', $name)->first()->id;
		}
	}

}
