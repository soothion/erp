<?php

/**
 * Created by EMACS
 * Created at 2014-11-07
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @package api
 * @copyright 2014
 */

use Bluebanner\Core\Repo\StockIo as RepoStockIo;

use Bluebanner\Core\Form\Stock\Io as FormIo;
use Bluebanner\Core\Form\Inventory\Inventory as FormInventory;

class APIStockIoController extends \BaseController {
  public function __construct(RepoStockIo $repoStockIo, FormIo $formIo, FormInventory $formInventory) {
    $this->repoStockIo = $repoStockIo;

    $this->formIo = $formIo;
    $this->formInventory = $formInventory;
  }

  public function index() {
    $inputGet = Input::get();

    $inputGen = $this->formIo->filterIndex($inputGet);
    $page = $this->formIo->page($inputGet);
    $size = $this->formIo->size($inputGet);

    return $this->repoStockIo->master()->findByConds($inputGen, $page, $size)->get();
  }

  public function show($id) {
    return $this->repoStockIo->master()->where('id', (int)$id)->first();
  }

  public function showDetails($id) {
    return $this->repoStockIo->detail()->where('io_id', (int)$id)->get()->toArray();
  }

}
