<?php
  function inc()
  {
    static $j = 1;

    print $j . "<br>";

    $j += 1;
  }

  for ($i=0; $i <10 ; $i++) { 
    inc();
    $j = 0;
  }
?>