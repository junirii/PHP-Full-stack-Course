<?php
  $star = rand(3, 10);
  print "star : $star <br>";
  for($i = 1; $i <= $star; $i++)
  {
    for($j = $star; $j <= $star + $i - 1; $j++)
    {
      print "*";
    }
      print "<br>";
  }

?>