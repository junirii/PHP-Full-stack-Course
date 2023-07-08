<?php
  $num = rand(1, 10);

  print_odd_even($num);

  function print_odd_even($n)
  {
    if($n % 2 == 0)
    {
      print "숫자 ${n}는(은) 짝수입니다.";
    }else
    {
      print "숫자 ${n}는(은) 홀수입니다.";
    }
  }
?>