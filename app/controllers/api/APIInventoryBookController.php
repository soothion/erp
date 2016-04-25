<?php

use Bluebanner\Core\Inventory\InventoryBookService;

use Bluebanner\Core\Model\InventoryBook;

class APIInventoryBookController  extends \BaseController
{
  public function __construct(InventoryBookService $bookService, InventoryBook $modelInventoryBook, InventoryForm $formInventory)
    {
        $this->service=$bookService;

        $this->inventoryBookService = $this->service;
        $this->modelInventoryBook = $modelInventoryBook;
        $this->formInventory = $formInventory;
    }

    public function book() {
      $pg = Input::get('pg', 1);
      $getData = Input::get();

      $formData = $this->formInventory->filterBookOpt($getData);
      $books = $this->modelInventoryBook->getInventoryByConds($formData);

      return $books;
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
            if(!empty($invoice))
            {
                $ids=$this->service->getRelationIdByInvoice($invoice);
    
                if(!empty($ids) && $ids!==array() && count($ids)!==0)
                {
                    $condition[$i]['field'] ="relation_id";
                    $condition[$i]['opera']='in';
                    $condition[$i]['value']=$ids;
                    $i++;
                }
                else
                {
                    $condition[$i]['field'] ='relation_id';
                    $condition[$i]['opera']='=';
                    $condition[$i]['value']=0;
                    $i++;
                }
            }
        }
    
        if(($status=Input::get("status",false))!==false)
        {
    
            if(!empty($status) && $status!="undifined")
            {
                $condition[$i]['field'] ="status";
                $condition[$i]['opera']='in';
                $condition[$i]['value']=explode(',',$status);
                $i++;
            }
        }
        
        if(($type=Input::get("type",false))!==false)
        {
        
            if(!empty($type) && $type!="undifined")
            {
                $condition[$i]['field'] ="type";
                $condition[$i]['opera']='in';
                $condition[$i]['value']=explode(',',$type);
                $i++;
            }
        }
    
        if(($timeFrom=Input::get("timeFrom",false))!==false)
        {
            if(!empty($timeFrom) && $timeFrom!="undefined")
            {
    
                $condition[$i]['field'] ="created_at";
                $condition[$i]['opera']='>=';
                $condition[$i]['value']=date("Y-m-d H:i:s",strtotime($timeFrom));
                $i++;
            }
        }
    
        if(($timeTo=Input::get("timeTo",false))!==false)
        {
            if(!empty($timeTo) && $timeTo!="undefined")
            {
                $condition[$i]['field'] ="created_at";
                $condition[$i]['opera']='<=';
                $condition[$i]['value']=date("Y-m-d H:i:s",strtotime($timeTo));
                $i++;
            }
        }
    
    
        $list=array();
        $list=$this->service->findBookByCondition($condition)->get();
        foreach($list as $k=>$stock)
        {
            $stock->inventory;
            $stock->relation;
            if($stock->type=="io" && !empty($stock->IODetailRelations))
            {
                $list[$k]['relationDetail_item_id']=isset($stock->IODetailRelations->item_id)?$stock->IODetailRelations->item_id:"";
                $list[$k]['relationDetail_qty']=isset($stock->IODetailRelations->qty)?$stock->IODetailRelations->qty:"";
            }
            else if(!empty($stock->OrderRelations))
            {
               // $stock->relationMaster=$stock->OrderRelations;
               // $stock->relationDetail=$stock->OrderDetailRelations;
            }
           // $stock->agent;$stock->fromWarehouse;$stock->user;$stock->toWarehouse;*/
        }
        return $list;
    }
}
