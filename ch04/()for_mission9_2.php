<?php
  $star = rand(3, 10);
  print "star : $star <br>";
  for($i = 1; $i <= $star; $i++)
  {
    for($j = 1; $j <= $i; $j++)
    {
      print "*";
    }
      print "<br>";
  }

?>