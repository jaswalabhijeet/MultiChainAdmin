<?php

if (!file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
  $array = explode('?', $_SERVER['REQUEST_URI']);

  $_GET['_url'] = $array[0];
  $querys = isset($array[1]) ? $array[1] : null;
  if ($querys) {
    $params = explode('&', $querys);
    foreach ($params as $param) {
      list($key, $value) = explode('=', $param);
      $_GET[$key] = $value;
    }
  }
}

return false;
