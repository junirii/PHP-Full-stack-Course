<?php
  function sum($n1, $n2)
  {
    return $n1 + $n2;
  }

  function minus($n1, $n2)
  {
    print "minus : " . ($n1 - $n2) . "<br>";
  }

  $result = sum(10, 11);
  print "썸 : $result<br>";
  print "sum : " . sum(30, 40) . "<br>";
  minus(35, 12);
  minus(10, 2);

?>