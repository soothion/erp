<?php
/**
 * Short description for MasterModel.php
 * Created on 2014-05-06
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @subpackage MasterModel
 * @package MasterModel
 * @category
 * @version 0.1
 */

namespace Bluebanner\Core\Model;
use Illuminate\Support\Facades\DB;

abstract class MasterModel extends BaseModel {
  
    /**
   * @todo incomplete, add exception in the future
   *
   * @depend on function childQueryBuilder & createGetId
   * @param array $master
   * @param array $childs ['main'] => child table and ['log'] => log table
   * @parem array $relation array_key = array('masterId', 'childId');
   */
  public function createMasterAndChilds(array $master, array $childs, array $relation) {
    $masterTbl = $this;

    DB::transaction(function () use ($master, $childs, $masterTbl, $relation) {
        $childTbl = $masterTbl->childQueryBuilder();
        $logTbl = $masterTbl->logQueryBuilder();

        $masterId = $masterTbl->createGetId($master);
        $childIds = array();

        foreach ($childs['main'] as $key => $child) {
          $child[$relation['masterId']] = $masterId;

          $childIds[$key] = $childTbl->insertGetId($child);
        }

        if (isset($childs['logs'])) {
          foreach ($childs['logs'] as $logKey => $logVal) {
            $logVal[$relation['masterId']] = $masterId;
            $logVal[$relation['childId']] = $childIds[$logKey];

            $logTbl->insert($logVal);
          }
        }
      });

    return $masterTbl;
  }

  /**
   * @todo exception
   *
   * @depend on function childQueryBuilder
   * @param int id
   * @param array $master
   * @param array $childs
   */
  public function updateMasterAndChilds($id, array $master, array $childs) {
    DB::beginTransaction();

    try {
      $this->where('id', $id)->update($master);

      foreach ($childs as $key => $child) {
        $childTbl = $this->childQueryBuilder();

        $childTbl->where('id', $key)->update($child);
      }

      DB::commit();

    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception('My exception');
    }
  }

  public function mergeMasterAndChilds($master, $orgMasters, $relation) {
    $rand = '[Cache]' . md5(time() . rand(1, 100));
    $master['invoice'] = $rand;
    $nowDate = date('Y-m-d H:i:s');

    DB::beginTransaction();

    try {
      $childTbl = $this->childQueryBuilder();
      $logTbl = $this->logQueryBuilder();

      $masterId = $this->createGetId($master);
      $this->whereIn('id', $orgMasters)->delete();

      $childTbl->whereIn($relation['masterId'], $orgMasters)->update(array($relation['masterId'] => $masterId, 'updated_at' => $nowDate));
      $logTbl->whereIn($relation['masterId'], $orgMasters)->update(array($relation['masterId'] => $masterId, 'updated_at' => $nowDate));

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception('Hello Exception');
    }

    return $masterId;
  }

}
?>