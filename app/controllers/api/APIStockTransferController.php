<?php

use Bluebanner\Core\Repo\Transfer as RepoTransfer;

use Bluebanner\Core\Form\Stock\Transfer as FormTransfer;

class APIStockTransferController extends \BaseController {
  public function __construct(RepoTransfer $repoTransfer, FormTransfer $formTransfer) {
    $this->repoTransfer = $repoTransfer;

    $this->formTransfer = $formTransfer;
  }

  public function invoice() {
    // @todo
    return 'TR10000';
  }

  public function askIndex() {
    $condsInput = Input::get();

    $condsGen = $this->formTransfer->filterAskIndexConds($condsInput);
    // @todo
    $condsGen['eq']['to_platform_id'] = 1;
    $page = $this->formTransfer->page($condsInput);
    $size = $this->formTransfer->size($condsInput);

    return $this->repoTransfer->ask()->findByConds($condsGen, $page, $size)->get();
  }

  public function askStore() {
    $recordInput = Input::get();

    $recordGen = $this->formTransfer->filterAskStoreRecord($recordInput);

    $this->repoTransfer->validUniquePendingAskRecord($recordGen);

    $this->repoTransfer->ask()->create($recordGen);
  }

  public function askUpdate($id) {
    $recordInput = Input::get('qty');

    if (is_numeric($recordInput) && $recordInput > 0) {
      $this->repoTransfer->ask()->where('id', (int)$id)->where('status', 'pending')->update($recordInput);
    }
  }

  public function askDestroy($id) {
    $this->repoTransfer->ask()->where('id', (int)$id)->whereIn('status', array('pending', 'rejective'))->delete();
  }

  public function askConfirm($id) {
    $now = date('Y-m-d H:i:s');

    $this->repoTransfer->ask()->where('id', (int)$id)->where('status', 'pending')->update(array('updated_at' => $now, 'status' => 'confirmed'));
  }

  public function askRolling($id) {
    $now = date('Y-m-d H:i:s');

    $this->repoTransfer->ask()->where('id', (int)$id)->where('status', 'confirmed')->update(array('updated_at' => $now, 'status' => 'pending'));
  }

  public function index() {
    $condsInput = Input::get();

    $condsGen = $this->formTransfer->filterIndexConds($condsInput);
    $page = $this->formTransfer->page($condsInput);
    $size = $this->formTransfer->size($condsInput);

    return $this->formTransfer->master()->findByConds($condsGen, $page, $size);
  }

  public function reply() {
    $condsInput = Input::get();

    $condsGen = $this->formTransfer->filterReplyConds($condsInput);
    // @todo
    $condsGen['eq']['from_platform_id'] = 1;
    $page = $this->formTransfer->page($condsInput);
    $size = $this->formTransfer->size($condsInput);

    return $this->formTransfer->ask()->findByConds($condsGen, $page, $size);
  }

  public function update($id) {
    $this->formTransfer->transferByAskId($id);
  }

  public function reject($id) {
    $now = date('Y-m-d H:i:s');

    $this->formTransfer->ask()->where('id', (int)$id)->where('status', 'confirmed')->update(array('updated_at' => $now, 'status' => 'rejective'));
  }
}