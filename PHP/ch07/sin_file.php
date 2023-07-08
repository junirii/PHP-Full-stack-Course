<?php
  print __FILE__ . "<br>";
  print __LINE__ . "<br>";
  print "PHP VERSION : " . PHP_VERSION . "<br>";
  print "OS : "  . PHP_OS . "<br>";

  $foo = 11;
  $poo = 50;

  print "-- 글로벌 상수 --<br>";
  foreach($GLOBALS as $key => $val)
  {
    print $key . " : ";
    print_r($val);
    print "<br>";
  }
/*
  while(list($ket, $var) = each($_GLOBALS))
  {

  }*/
?>