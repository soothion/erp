<?php

class ADC_Autoloader {

  public static function autoload($className) {
    if ($className == 'RequestType') {
      include_once dirname(__file__) . '/MarketplaceWebService/RequestType.php';
      return;
    }
    $filePath = str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    $includePaths = explode(PATH_SEPARATOR, get_include_path());
    array_unshift($includePaths, dirname(__file__));
    foreach($includePaths as $includePath){
      if(file_exists($includePath . DIRECTORY_SEPARATOR . $filePath)){
        include_once $filePath;
        return;
      }
    }
  }
}
