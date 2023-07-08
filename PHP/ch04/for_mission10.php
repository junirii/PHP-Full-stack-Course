<?php
  $val = rand(3, 10);
  print "val : $val <br>";

  print "<table border = 1 style = 'border-collapse: collapse;'>";
  for($i = 1; $i <= $val; $i++)
  {
    print "<tr>";
    for($j = 1; $j <= $val; $j++)
    {
      print "<td>". $j + ($val * ($i - 1)) . "</td>";
    }
    print "</tr>";
  }
  print "</table>";
?>