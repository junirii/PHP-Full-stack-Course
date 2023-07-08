<?php
  $arr = [10, 33, 12, 8, 1, 89, 11, 50, 3, 100];
  $arr_len = count($arr) - 1;

  for($i=0; $i<$arr_len; $i++)
  {
    for($j=$i; $j<$arr_len; $j++)
    {
      if($arr[$i] > $arr[$j+1])
      {
        $temp = $arr[$i];
        $arr[$i] = $arr[$j+1];
        $arr[$j+1] = $temp;
      }

    }
  }
  print_r($arr);
?>