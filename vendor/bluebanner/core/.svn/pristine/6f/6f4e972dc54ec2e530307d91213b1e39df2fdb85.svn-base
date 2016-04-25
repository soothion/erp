<?php

namespace Bluebanner\Core\Form;

abstract class Base {
  public function page(array $input) {
    if (isset($input['page'])) {
      return (int)$input['page'];
    }
    return 1;
  }

  public function size(array $input) {
    if (isset($input['size'])) {
      return (int)$input['size'];
    }
    return 20;
  }
}