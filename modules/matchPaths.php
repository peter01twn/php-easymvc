<?php
function matchPaths($str)
{
  $re = '/<img src="(.+)">/mU';
  preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
  $imgPaths = [];
  foreach ($matches as $match) {
    $imgPaths[] = $match[1];
  }
  return $imgPaths;
}

