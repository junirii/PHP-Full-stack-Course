<?php
  $snum = 3;
  $enum = 1;

  print_num_from_to($snum, $enum);

  function print_num_from_to($n1, $n2)
  {
    if($n1>$n2)
    {
      print "종료값이 더 작을 수 없습니다.";
      return;
    }
    else
    {
      print "[";
      for($i=$n1; $i<=$n2; $i++)
      {
        if($i == $n2)
        {
          print $i;
        }
        else
        {
        print "$i, ";
        }
      }
      print "]";
    }
  }
?>