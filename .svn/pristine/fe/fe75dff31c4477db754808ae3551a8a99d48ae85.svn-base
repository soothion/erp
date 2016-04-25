<?php

use Illuminate\Support\Facades\Input;
use Bluebanner\Core\Item\ItemServiceInterface;

class APIItemCustomsController extends \BaseController {

	public function __construct(ItemServiceInterface $service)
	{
		$this->service = $service;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	    $condition=array();
	    $i=0;
	    
	    if(($invoice=Input::get("invoice",false))!==false)
	    {
	        if(!empty($invoice) && $invoice!="undifined")
	        {
	            $condition[$i]['field'] ="customs_code";
	            $condition[$i]['opera']='like';
	            $condition[$i]['value']='%'.$invoice.'%';
	            $i++;
	        }
	    }
	    
	    if(($sku=Input::get("sku",false))!==false)
	    {
	        if(!empty($sku) && is_numeric($sku))
	        {
	            $condition[$i]['field'] ='item_id';
	            $condition[$i]['opera']='=';
	            $condition[$i]['value']=$sku;
	            $i++;
	           
	        }
	    }
	    
	    if(($skuLike=Input::get("skuLike",false))!==false)
	    {
	        if(!empty($skuLike) && $skuLike!="undifined")
	        {
	            $ids=$this->service->findItemIdBySKULike($skuLike);
	           
	            if(!empty($ids) && $ids!==array() && count($ids)!==0)
	            {
	               
	                $condition[$i]['field'] ="item_id";
	                $condition[$i]['opera']='in';
	                $condition[$i]['value']=array_values($ids);
	                $i++;
	            }
	        }
	    }
	    
	   
	    
	    if(($towarehouse=Input::get("country",false))!==false)
	    {
	        if(!empty($towarehouse) && $skuLike!="undifined")
	        {
	            $condition[$i]['field'] ="country";
	            $condition[$i]['opera']='=';
	            $condition[$i]['value']=$towarehouse;
	            $i++;
	        }
	    }
	    
	  
	    $list=array();
	   
	    $list=$this->service->findCustomsByCondition($condition)->get();
	    foreach($list as $stock)
	    {
	       $stock->warehouse;$stock->user;$stock->item;
	    }
	    return $list;
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
	    $attrs=array();
	    $item=Input::get('item');
	    if(!isset($item['id'])) throw new Exception("must have item!");
	    $attrs['item_id']=$item['id'];
	    $attrs['country']=Input::get('country');
	    $attrs['customs_code']=Input::get('customs_code');
	    
	    $attrs['tariff_rate']=floatval(Input::get('tariff_rate'));
	    $attrs['refund_tax_rate']=floatval(Input::get('refund_tax_rate'));
	    
	    $attrs['agent']	=Sentry::getUser()->id;
		return $this->service->createCustoms($attrs);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if($id=="new")
		{
		    return array();
		}
		else
		{
		    return $this->service->findCustomByPk(intval($id));
		}
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
	    $attrs=array();
	    $item=Input::get('item');
	    
	    if(isset($item['id']))
	    {
	        $attrs['item_id']=$item['id'];
	    }
	    
	    if(Input::get('country'))
	    {
	        $attrs['country']=Input::get('country');
	    }
	    
	    if(Input::get('customs_code'))
	    {
	        $attrs['customs_code']=Input::get('customs_code');
	    }
	     
	    if(Input::get('tariff_rate'))
	    {
	        $attrs['tariff_rate']=floatval(Input::get('tariff_rate'));
	    }
	    
	    if(Input::get('refund_tax_rate'))
	    {
	        $attrs['refund_tax_rate']=floatval(Input::get('refund_tax_rate'));
	    }
	     
	    $attrs['agent']	=Sentry::getUser()->id;
	    return $this->service->updateCustoms(intval($id),$attrs);
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	    $this->service->DeleteCustoms(intval($id));
	}

}