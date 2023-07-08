<?php
  $arr_age = array(
    "Peter" => 35,
    "Ben" => 37,
    "Joe" => 43,
    "John" => 24
  );

  print "origin : ";
  print_r($arr_age);
  print "<br>";

  $copy_arr_1 = $arr_age;
  print "copy : ";
  print_r($copy_arr_1);
  print "<br>";

  sort($copy_arr_1);
  print "copy-sort : ";
  print_r($copy_arr_1);
  print "<br>";
  
  print "origin : ";
  print_r($arr_age);

  print "<br>---------------------<br>";

  $copy_arr_2 = $arr_age;
  print "copy2 : ";
  print_r($copy_arr_2);
  print "<br>";

  ksort($copy_arr_2);
  print "copy2-ksort : ";
  print_r($copy_arr_2);
  print "<br>";
?>