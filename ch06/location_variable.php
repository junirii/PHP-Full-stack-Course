<?php
  function make_ten()
  {
    global $i;
    $i = $i + 10;
  }
  $i = 5;
  make_ten();
  print "i : $i<br>";
?>