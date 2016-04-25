<?php
use Bluebanner\Core\Purchase\PurchaseServiceInterface;

use Bluebanner\Core\Model\PurchaseCostParams;

class APICostparamsController extends \BaseController {

	public function __construct(PurchaseServiceInterface $service, PurchaseCostParams $modelPurchaseCostParams)
	{
		$this->service = $service;

    $this->modelPurchaseCostParams = $modelPurchaseCostParams;
	}


  public function getCostParams($itemId) {
    return $this->modelPurchaseCostParams->where('item_id', (int)$itemId)->first(array('air_cost', 'sea_cost'));
  }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//取整个列表
		$attr=array();
		if(Input::get('warehouse_id')) $attr['warehouse_id']=Input::get('warehouse_id');
		if(Input::get('item_id')) $attr['item_id']=Input::get('item_id');
		return $this->service->CostParamsList($attr)->get();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
    {
      $attr = array(
        'warehouse_id' => Input::get('warehouse.id'),
        'air_cost' => Input::get('air_cost'),
        'sea_cost' => Input::get('sea_cost'),
        'item_id' => Input::get('item.id', 0),
      );
      $model = $this->service->addCostParams($attr);

      $model->warehouse = Input::get('warehouse');
      $model->item = Input::get('item');

      return $model; 

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{	    
	    $model=$this->service->getCostParams($id);	   
		return $model;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
	    $attr=array();
        $inputData=Input::get();
        
        if(!isset($inputData['warehouse_id']))
        {
            throw new Exception("仓库为必要");
        }
        
        $attr['warehouse_id']=$inputData['warehouse_id'];
        
        if(isset($inputData['air_cost']))
        {
             $attr['air_cost']=$inputData['air_cost'];
        }
        
        if(isset($inputData['sea_cost']))
        {
            $attr['sea_cost']=$inputData['sea_cost'];
        }
        
        if(isset($inputData['item'])&&isset($inputData['item']['id']))
        {
            $attr['item_id']=$inputData['item']['id'];
        }
        
        $this->service->updateCostParams($id,$attr);
        $model=$this->service->getCostParams($id);
        return $model;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$cp = $this->service->getCostParams($id);
		if(!empty($cp))
		    $cp->delete();
		
	}
	
	
	/**
	 * 上传 创建或者更新
	 */
	public function upload()
	{
	    $file = Input::file('file');	   
	    $content=file_get_contents($file->getRealPath());	  
	    $lines=explode("\n", $content);
	    
	    $skus = Illuminate\Support\Facades\DB::table('core_item_master')->lists('sku','id');
	    $warehouses = Illuminate\Support\Facades\DB::table('core_storage_warehouse')->lists('name','id');	    
	    
	    $errMsg="";	 
	    $attrs=array();
	    if(trim($lines[0])!="海运系数,空运系数,仓库,特定SKU(没有则不填)")
	    {
	        throw new Exception("文件格式不正确!");
	    }
	    else
	    {
	        $lines=array_slice($lines, 1);
	        foreach ($lines as $line)
	        {
	            $useline=trim($line,",");
	            $useline=trim($useline);
	            $cols=explode(',',trim($useline));
	            $item_id=$warehouse_id=$sea_fee=$air_fee=0;	           
	            $n=count($cols);
	            if($n>3)
	            {
	                $item_id=array_search(trim($cols[3]),$skus);
	            }
	            else if($n<3)
	            {
	                $errMsg.="format error: '".$line."' !\n";
	                continue;	                
	            } 

	            $warehouse_id=array_search(trim($cols[2]), $warehouses);
	            
	            $sea_fee=floatval(trim($cols[0]));
	            $air_fee=floatval(trim($cols[1]));
	            
	            if($warehouse_id===false || $item_id===false)
	            {
	                $errMsg.="warehouse or sku is not exist! int line ': ".$line." '!\n";
	                continue;
	            }
	            
	            $attr=array();
	            $attr['warehouse_id']=$warehouse_id;
	            $attr['air_cost']=$air_fee;
	            $attr['sea_cost']=$sea_fee;
	            if($item_id!=0)
	            {
	                $attr['item_id']=$item_id;
	            }
	            $attrs[]=$attr;
	        }
	    }
	    $this->service->updateAllCostParams($attrs);
	    echo $errMsg;
	}
	
	public function getAll()
	{
	    return $this->service->GetAllWarehouseItemFee();
	}
	
	
	/**
	 * 下载模板
	 */
	
	public function down()
	{
        //文件的类型
        header('Content-type: application/csv');
        //下载显示的名字
        header('Content-Disposition: attachment; filename="costparams_upload.csv"');
        echo "海运系数,空运系数,仓库,特定SKU(没有则不填)\n";
        echo "12.58,22.65,CN-FUTIAN,\n";
        exit(); 
	}
}
