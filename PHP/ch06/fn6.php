<?php
  $star = rand(3, 10);
  print "\$star = $star<br>";
//print_star($star);
//print_star_line($star);
  print_star_triangle($star);

  function print_star($num)
  {
    for($i=0; $i<$num; $i++)
    {
      print "*";
    }
  }

  function print_star_line($num)
  {
    for($i=0; $i<$num; $i++)
    {
      print_star($num);
      print "<br>";
    }
  }

  function print_star_triangle($num)
  {
    for($i=1; $i<=$num; $i++)
    {
      print_star($i);
      print "<br>";
    }
  }
?>