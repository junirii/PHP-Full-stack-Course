<?php
  $star = rand(3, 10);
  print "star : $star <br>";
  for($i = $star; $i > 0; $i--)
  {
    for($j = 1; $j <= $star - $i + 1; $j++)
    {
      print "*";
    }
      print "<br>";
  }

?>