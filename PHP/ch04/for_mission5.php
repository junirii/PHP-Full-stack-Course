<?php
  for($i=2; $i<=9; $i++)
  {
    for($j=1; $j<=9; $j++)
    {
      print "$i x $j = " . $i * $j . "<br>";
    }
    if($i < 9)
    {
    print "----------------<br>";
    }
  }
?>