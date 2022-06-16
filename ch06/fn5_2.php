<?php
  $snum = 1;
  $enum = 10;

  print_num_from_to($snum, $enum);

  function print_num_from_to($n1, $n2)
  {
    print "[";
    if($n1 <= $n2)
    {
      for($i=$n1; $i<=$n2; $i++)
      {
        if($i > $n1)
        {
          print ", ";
        }
        print "$i";
      }
    }
    else
    {
      for($i=$n1; $i>=$n2; $i--)
      {
        if($i < $n1)
        {
          print ", ";
        }
        print "$i";
      }
    }
    print "]";
  }
?>