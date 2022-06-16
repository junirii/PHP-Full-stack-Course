<?php
  $arr = [10, 33, 12, 8, 1, 89, 11];
  $arr_len = count($arr) - 1;
  $min = array();
  $least = 0;

  for($i=0; $i<$arr_len; $i++)
  {
    $idx = $i;
    for($j=$i; $j<$arr_len; $j++)
    {
      if($arr[$idx] > $arr[$j+1])
      {
        $idx = $j + 1;
      }
    }
    $temp = $arr[$i];
    $arr[$i] = $arr[$idx];
    $arr[$idx] = $temp;
    print_r($arr);
    print "<br>";
  }
  print "<br>";
  print_r($arr);
?>