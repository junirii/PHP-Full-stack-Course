<?php
  $n1 = 9;
  $n2 = 5;

  print_sum($n1, $n2);
  print_minus($n1, $n2);
  print_multi($n1, $n2);
  print_div($n1, $n2);
  print_mod($n1, $n2);

  function print_sum($num1, $num2)
  { print "$num1 + $num2 = " . $num1 + $num2 . "<br>"; }

  function print_minus($num1, $num2)
  { print "$num1 - $num2 = " . $num1 - $num2 . "<br>"; }

  function print_multi($num1, $num2)
  { print "$num1 * $num2 = " . $num1 * $num2 . "<br>"; }

  function print_div($num1, $num2)
  { print "$num1 / $num2 = " . $num1 / $num2 . "<br>"; }

  function print_mod($num1, $num2)
  { print "$num1 % $num2 = " . $num1 % $num2 . "<br>"; }
?>