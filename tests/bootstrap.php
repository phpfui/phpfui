<?php

error_reporting(E_ALL);

function classNameExists(string $className) : string
  {
  $path = ".\\src\\$className.php";
  if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')
    {
    $path = str_replace("\\", '/', $path);
    }
  return file_exists($path) ? $path : '';
  }

function autoload($className)
  {
  $path = classNameExists($className);
  if ($path)
    {
    /** @noinspection PhpIncludeInspection */
    include $path;
    }
  }
spl_autoload_register('autoload');

$vendorDir = __DIR__ . '/../../..';

if (file_exists($file = $vendorDir . '/autoload.php')) {
    require_once $file;
} else if (file_exists($file = './vendor/autoload.php')) {
    require_once $file;
} else {
		throw new \RuntimeException("Composer autoload file not found");
}