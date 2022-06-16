<?php
  $freshman = array(
    "David" => "Computer",
    "Alice" => "Math",
    "Elsa"  => "Physics",
    "Bob"   => "Music",
    "Chris" => "Elelctronics"
  );

  print_r($freshman);
  print "<br><br>";
  print $freshman["David"] . "<br>";
  print $freshman["Alice"] . "<br>";
  print $freshman["Elsa"] . "<br>";
  print $freshman["Bob"] . "<br>";
  print $freshman["Chris"] . "<br><br>";

  $freshman["Bob"] = "Dance";
  print $freshman["Bob"] . "<br>";

  $freshman["Frank"] = "History";
  print $freshman["Frank"] . "<br><br>";

  $freshman[0] = "안녕";
  print_r($freshman);
?>