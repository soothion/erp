<?php
/**
 * Short description for AspectMockGlobalTestCase.php
 * Created on 2014-04-15
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @subpackage AspectMockGlobalTestCase
 * @package AspectMockGlobalTestCase
 * @category
 * @version
 */

use \AspectMock\Test as m;
/* use \AspectMock\Core\Registry as mReg; */
/* use \AspectMock\Proxy\ClassProxy as mCls; */
/* use \AspectMock\Proxy\InstanceProxy as mIns; */

class AspectMockGlobalTestCase extends TestCase {

  public $service = null;

  public $instances = array();
  public $doubles = array();
  public $models = array();

  public $dir = __DIR__;
  public $class = __CLASS__;

  const MODEL_PATH = 'Bluebanner\Core\Model\\';

  public function tearDown() {
    m::clean();
  }

  public function createModel($model) {
    $class = self::MODEL_PATH . ucfirst($model);
    $double = 'double' . ucfirst($model);
    $model = 'model' . ucfirst($model);

    $this->$model = new $class();
    $this->instances[] = $this->$model;

    $this->$double = m::double($class);
    $this->doubles[] = $this->$double;
  }

  public function setModel($model) {
    $this->models[] = $model;
  }

  public function cleanModels() {
    foreach ($this->instances as $instance) {
      unset($instance);
    }

    foreach ($this->doubles as $double) {
      unset($double);
    }
  }

  public function buildModels() {
    $this->cleanModels();

    foreach ($this->models as $model) {
      $this->createModel($model);
    }
  }

  public function initService() {
    if ($this->service) {
      unset($this->service);
    }

    $path = basename($this->dir);
    $name = substr($this->class, 0, -4);
    $ns = 'Bluebanner\Core\\' . $path . '\\' . $name;
    $args = array();

    foreach ($this->models as $model) {
      $args[] = '$this->model' . ucfirst($model);
    }

    $argv = implode(', ', $args);
    $exec = '$this->service = new ' . $ns . '(' . $argv . ');';
    eval($exec);
  }

}

?>