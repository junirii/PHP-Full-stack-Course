<?php
  function print_sum(...$vals)
  {
    $sum = 0;
    // for문
    for($i=0; $i<count($vals); $i++)
    {
      $sum += $vals[$i];
    }
    /* foreach문
    foreach($vals as $val)
    {
      $sum += $val;
    }
    */
    print "sum: $sum<br>";
  }

  
  print print_sum(1, 2);
  print print_sum(1, 2, 3);
  print print_sum(1, 2, 3, 4);
?>