<?php

use easymvc\base\Controller;

class TestController extends Controller {
  function getPage($page) {
    echo $page;
  }
}