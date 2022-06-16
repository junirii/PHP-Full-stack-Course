<?php
  $start_num = 1;
  $end_num = 11;

  $result = sum_from_to($start_num, $end_num);

  print "$start_num ~ $end_num 을(를) 모두 더한 값은 $result <br>";

  function sum_from_to($n1, $n2)
  {
    $sum = 0;
    for($i=$n1; $i<=$n2; $i++)
    {
      $sum += $i;
    }
    return $sum;
  }
?>