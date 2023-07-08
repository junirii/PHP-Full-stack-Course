<?php
  $star = rand(3, 10);
  print "star : $star <br>";

  for($i = $star; $i > 0; $i--)
  {
    for($j = 1; $j <= $i; $j++)
    {
      print "*";
    }
    print "<br>";
  }

?>