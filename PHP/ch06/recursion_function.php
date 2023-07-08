<?php
  function factorial($n)
  {
    $x = 1;
    for($i=$n; $i>0; $i--)
    {
      $x *= $i;
    }
    return $x;
  }

  function factorial_rec($num)
  {
    if($num === 1) {return 1;}
    return $num * factorial_rec($num - 1);
  }
  
  function my_abs($val)
  {
    /* if구문
    if($val < 0)
    {
      return $val * (-1);
    }
    return $val;
    */
    
    //삼항연산자
    return $val < 0 ? -$val : $val;
  }

  $num = my_abs(-5);
  $result = factorial_rec($num);
  print "${num}! = $result<br>";
  
?>