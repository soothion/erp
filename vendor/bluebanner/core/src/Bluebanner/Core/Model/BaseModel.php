<?php namespace Bluebanner\Core\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

abstract class BaseModel extends Eloquent
{
	
	protected static function boot()
	{
		parent::boot();
		
		static::saving(function($model) {
			return $model->validate();
		});
	}

	
	abstract public function validate();

	// helpers
	public function scopeSearching($query, array $condition)
	{
		foreach ($condition as $field => $value) {
			if (is_array($value)) {
				if (is_a(head($value), 'DateTime')) {
					$query->whereBetween($field, $value);
				} else {
					$query->whereIn($field, $value);
				}
			} else {
				if (is_string($value)) {
					$query->where($field, 'like', '%' . $value . '%');
				} else {
					$query->where($field, '=', $value);
				}
			}
		}
		return $query;
	}

  public function findByKey($id) {
    return self::find($id);
  }

  /**
   * @param $field
   * @param $value
   * @param $symbol Database logical operator || Linux shell logical operator
   * @return object
   */
  public function scopeSingle($query, $field, $value, $symbol = null) {
    $validSymbols = array('lt' => '<', 'le' => '<=', 'gt' => '>', 'ge' => '>=', 'ne' => '<>', 'eq' => '=');

    if (in_array($symbol, $validSymbols)) {
      return $query->where($field, $symbol, $value);      
    }

    if (array_key_exists($symbol, $validSymbols)) {
      return $query->where($field, $validSymbols[$symbol], $value);
    }

    if ($symbol == 'like') {
      return $query->where($field, 'like', '%' . $value . '%');
    }

    return $query->where($field, $value);
  }

  /**
   * multi conditions filter
   * @depend on function $this->scopeSingle
   * @param $conds
   * @return object
   */
  public function scopeConds($query, $conds) {
    foreach ($conds as $op => $cond) {
      if ($op == 'in') {
        foreach ($cond as $field => $value) {
          $query = $query->whereIn($field, $value);
        }

      } else {
        foreach ($cond as $field => $value) {
          $query = $query->single($field, $value, $op);
        }

      }
    }

    return $query;
  }

  public function scopeCondsEq($query, array $array) {
    foreach ($array as $field => $value) {
      $query = $query->where($field, $value);
    }
    return $query;
  }

  /**
   * Fetch all fields
   * @depend on function $this->scopeConds
   *
   * @param array $conds
   * @return object
   */
  public function findByConds($conds, $pg = 1, $offset = 15, $skip = 0) {
    return $this->conds($conds)->take(max(1, $offset))->skip(max(0, (max(1, $pg) - 1) * $offset - $skip));
  }


  /**
   * Fetch the special fields (including relation table) we need
   * @depend on function $this->findByConds
   *
   * @param array $fields ['fkTbls'] like: $fkTbls = array('warehouse' => array('id' => 'warehouseId'));
   * 'warehouse' is a relation table, 'id' will be replaced by 'warehouseId'
   * @param array $conds
   * @param array $pg
   * @param array $offset
   * @return object
   */
  public function findFieldsByConds(array $fields, $conds, $pg = 1, $offset = 15) {
    if (isset($fields['fkTbls'])) {
      $fkTbls = $fields['fkTbls'];
      unset($fields['fkTbls']);
    } else {
      $fkTbls = array();
    }

    if (isset($fields['rmFields'])) {
      $rmFields = $fields['rmFields'];
      unset($fields['rmFields']);
    } else {
      $rmFields = array();
    }

    $result = $this->findByConds($conds, $pg, $offset, 1)->get($fields);

    foreach ($result as $row) {
      foreach ($fkTbls as $fkTblName => $fkTbl) {
        foreach ($fkTbl as $fkField => $fkFieldRename) {
          $row->$fkFieldRename = $row->$fkTblName->$fkField;
        }

        unset($row->$fkTblName);
      }

      foreach ($rmFields as $rmField) {
        if (isset($row->$rmField)) {
          unset($row->$rmField);
        }
      }
    }

    return $result;
  }


  public static function findByAttributes($attributes)
  {
    $query = static::query();

    foreach ($attributes as $key => $value)
    {
      $query->where($key, $value);
    }

    return $query;
  }



  /**
   * @param array $array
   * $array ex: array("id" => array("fields1" => "value1")
   *                                "fields2" => "value2");
   */
  public function updateByIdOneTime(array $array) {
    DB::beginTransaction();

    try {
      foreach ($array as $key => $value) {
        $this->where('id', $key)->update($value);
      }

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception('update failed');
    }
  }

  /**
   * @return string
   */
  public static function getTbl() {
    return with(new static)->getTable();
  }

  /**
   * @return int
   */
  public function createGetId(array $value) {
    return DB::table($this->getTable())->insertGetId($value);
  }

}