<?php
  $r_val = rand(1, 10);

  print "시작<br>";

  while($r_val != 10)
  {
    print "r_val : $r_val<br>";
    $r_val = rand(1, 10);
  }

  print "끝";
?>