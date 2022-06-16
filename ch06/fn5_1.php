<?php
  $snum = 3;
  $enum = 10;

  print_num_from_to($snum, $enum);

  function print_num_from_to($n1, $n2)
  {
    if($n1>$n2)
    {
      print "종료값이 더 작을 수 없습니다.";
      return;
    }

    print "[";
    for($i=$n1; $i<=$n2; $i++)
    {
      if($i>$n1)
      {
        print ", ";
      }
      print $i;
    }
    print "]";
  }
?>