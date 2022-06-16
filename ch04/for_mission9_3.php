<?php
  $star = rand(3, 10);
  print "star : $star <br>";

  $sum = "";
  for($i = 1; $i <= $star; $i++)
  {
      $sum = $sum."*";
      print "$sum<br>";
  }

?>