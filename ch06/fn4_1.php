<?php

//  $dan = rand(2, 9);
//  print_gugudan($dan);

  print_gugudan_from_to(3, 7);

  function print_gugudan($num)
  {
    for($i=1; $i<=9; $i++)
    {
      print "$num x $i = " . $num * $i . "<br>";
    }
  }

  function print_gugudan_from_to($n1, $n2)
  {
    for($i=$n1; $i<=$n2; $i++)
    {
      print_gugudan($i);
      if($i != $n2)
      {
        print "---------------------<br>";
      }
    }
  }
?>