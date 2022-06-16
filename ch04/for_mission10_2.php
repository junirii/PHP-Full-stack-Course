<?php
  $val = rand(3, 10);
  print "val : $val <br>";
  $num = 1;
  
  print "<table border = 1 style = 'border-collapse: collapse;'>";
  for($i = 1; $i <= $val; $i++)
  {
    print "<tr>";
    for($j = 1; $j <= $val; $j++)
    {
      print "<td>". $num++ . "</td>";
    }
    print "</tr>";
  }
  print "</table>";
?>