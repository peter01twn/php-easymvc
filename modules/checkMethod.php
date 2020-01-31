<?php
function checkMethod($methods) {
  $methods = strtoupper($methods);
  if ($methods === $_SERVER['REQUEST_METHOD']) {
    return true;
  } else {
    return false;
  }
}