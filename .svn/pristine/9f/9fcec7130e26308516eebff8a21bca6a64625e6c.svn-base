<?php
/**
 * Short description for BaseForm.php
 * Created on 2014-04-22
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @subpackage BaseForm
 * @package BaseForm
 * @category
 * @version 0.1
 */

//namespace Bluebanner\Core\Form;

class BaseForm {
  const SET_CANNOT_NULL = 1411;
  const SET_CAN_NULL = 1412;
  const SET_NUM_CANNOT_NULL = 1413;
  const SET_NUM_CAN_NULL = 1414;

  public function isNumeric($key, $value) {
    if (isset($value[$key]) && is_numeric($value[$key])) {
      return true;
    }
    return false;
  }

  public function isNumericOrNull($key, &$value) {
    if (isset($value[$key])) {
      if (!$value[$key]) {
        $value[$key] = '';
        return true;
      }

      if (is_numeric($value[$key])) {
        return true;
      }
    }
    return false;
  }

  public function isNumericOrUnset($key, $value) {
    if (isset($value[$key])) {
      return is_numeric($value[$key]);
    }
    return true;
  }

  public function isNotNull($key, $value) {
    if (isset($value[$key]) && $value[$key]) {
      return true;
    }
    return false;
  }

  public function isSetOrNull($key, &$value) {
    if (isset($value[$key])) {
      if (!$value[$key]) {
        $value[$key] = '';
      }
      return true;
    }
    return false;
  }

  /**
   * @depend on function isNotNull & isSetOrNull & isNumeric & isNumericOrNull
   */
  public function filterInput(array $keyLists, array $value, $opt = null) {
    $result = array();

    switch ($opt) {
      case self::SET_NUM_CANNOT_NULL:
        foreach ($keyLists as $key) {
          if (!$this->isNumeric($key, $value)) {
            return array();
          }
          $result[$key] = $value[$key];
        }
        break;

      case self::SET_NUM_CAN_NULL:
        foreach ($keyLists as $key) {
          if (!$this->isNumericOrNull($key, $value)) {
            return array();
          }
          $result[$key] = $value[$key];
        }
        break;

      case self::SET_CAN_NULL:
        foreach ($keyLists as $key) {
          if (!$this->isSetOrNull($key, $value)) {
            return array();
          }
          $result[$key] = $value[$key];
        }
        break;

      case self::SET_CANNOT_NULL:
      default:
        foreach ($keyLists as $key) {
          if (!$this->isNotNull($key, $value)) {
            return array();
          }
          $result[$key] = $value[$key];
        }
    }

    return $result;
  }

}
?>