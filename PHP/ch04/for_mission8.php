<?php
  $star = rand(2, 10);
  print "star : $star <br>";
  for($i = 1; $i <= $star; $i++)
  {
    for($j = 1; $j <= $star; $j++)
    {
      print "*";
    }
      print "<br>";
  }

?>