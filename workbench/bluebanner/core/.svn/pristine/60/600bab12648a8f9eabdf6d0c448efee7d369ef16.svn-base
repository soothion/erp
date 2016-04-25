<?php
/**
 * Short description for MockeryGlobalTestCase.php
 * Created on 2014-04-16
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @subpackage MockeryGlobalTestCase
 * @package MockeryGlobalTestCase
 * @category
 * @version
 */

use Mockery as m;

class MockeryGlobalTestCase extends TestCase {

  public $service = null;

  public $instances = array();
  public $models = array();
  public $repos = array();

  public $dir = __DIR__;
  public $class = __CLASS__;

  const MODEL_PATH = 'Bluebanner\Core\Model\\';
  const REPO_PATH = 'Bluebanner\Core\Repository\\';

  public function tearDown() {
    m::close();
  }

  public function createModel($model) {
    $model = ucfirst($model);
    $class = self::MODEL_PATH . $model;
    $model = 'model' . $model;

    $this->$model = m::mock('Eloquent', $class);
    $this->instances[] = $this->$model;
  }

  public function createRepo($repo) {
    $repo = ucfirst($repo);
    $class = self::REPO_PATH . basename($this->dir) . '\\' . $repo . 'Repository';
    $repo = 'repo' . $repo;

    $this->$repo = m::mock($class);
    $this->instances[] = $this->$repo;
  }

  public function cleanModels() {
    foreach ($this->instances as $instance) {
      unset($instance);
    }
  }

  public function setModel($model) {
    $this->models[] = $model;
  }

  public function setRepo($repo) {
    $this->setModel($repo);
  }

  public function buildModels($op = 'model') {
    $this->cleanModels();
    $op = 'create' . ucfirst($op);

    foreach ($this->models as $model) {
      $this->$op($model);
    }
  }

  public function buildRepos() {
    $this->cleanModels();

    $this->buildModels('repo');
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