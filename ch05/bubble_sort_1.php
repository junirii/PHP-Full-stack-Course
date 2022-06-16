<?php
  $arr = [10, 33, 12, 8, 1, 89, 3, 50];
  $arr_len = count($arr) - 1;

  for($i=0; $i<$arr_len; $i++)
  {
    for($j=0; $j<$arr_len - $i; $j++)
    {
      if($arr[$j] > $arr[$j+1])
      {
        $temp = $arr[$j];
        $arr[$j] = $arr[$j+1];
        $arr[$j+1] = $temp;
      }
    }
  }

  print_r($arr);
?>