<?php
use easymvc\base\Controller;
class IndexController extends Controller {
  function render()
  {
    header("Location: /admin/events.html");
  }
};