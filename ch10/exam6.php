<?php
  $exam6 = file("./exam6.txt");
  $capital = fopen("./exam6_capital.txt", "a+");
  foreach($exam6 as $line){
    fputs($capital, strtoupper($line));
  }
  fclose($capital);