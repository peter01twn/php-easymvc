<?php
$pattern = 'abc';
$str = 'abc/{12345}/werabcju/:yk68/:456';
$g = strpos($str, $pattern);
$ary = [
  'asd/asd/cxv',
  'dh/rty/vbn/'
];
$ary2 = [311531, 87964];
print_r(array_merge($ary, $ary2));
$num = preg_match('/:(\w*)$/', $str, $urlll);
$bool = preg_match_all('/{(.*?)}/', 'gjhg/dfgd/dfgdf/dfg', $match);
$replace = preg_replace('/{(.*?)}/', '', $str);
$replace = preg_replace('/(.*)/', 'localhost/$1', $ary);
// print_r($num);
// echo $bool;
$pos = strpos('abcjhj', 'd');
// echo $pos;

$uriAry = explode('/', '/true/');
// if ('0') {
//   print_r($uriAry[1]);
// } else {
//   echo 'false';
// }
echo implode('',$ary);