<?php
  $array = array(
    "Hong" => 182.2,
    "Hwang" => 180.4,
    "Kim" => 176.3,
    "Park" => 174.1
  );

  print "<table border = 1 style = 'border-collapse: collapse; text-align: center;'>
         <tr><td>이름</td><td>키</td></tr>";
  foreach($array as $key => $val)
  {
    print "<tr><td>" . $key . "</td><td>" . $val . "</td></tr>";
  }
  print "</table>";
?>