<?php
  $data = file("./name.txt");
  print_r($data);
  foreach($data as $key => $name){
    print "${name}[${key}]<br>";
  }
  $data1 = file("../lorem.txt");
  foreach($data1 as $line){
    print $line . "<br>";
  }