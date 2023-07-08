<?php
  $val = rand(2, 5);
  print "\$val = $val";
  print_table($val);

  function print_table($num)
  {
    $count=1;
    print "<table border = 1 style = 'border-collapse: collapse; text-align: center;'>";
    for($i=0; $i<$num; $i++)
    {
      print "<tr>";
      for($j=0; $j<$num; $j++)
      {
        print "<td>". $count++ . "</td>";
      }
      print "</tr>";
    }
    print "</table>";
  }
?>