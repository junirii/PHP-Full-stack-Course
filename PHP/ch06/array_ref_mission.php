<?php
  function add_array(&$array, $num)
  {
    /* for문
    for($i=0; $i<count($array); $i++)
    {
      $array[$i] += $num;
    } */

    foreach($array as &$val)
    {
      $val += $num;
    }
  }


  $arr = [10, 20, 30, 40, 50];

  add_array($arr, 15);

  print_r($arr);
?>