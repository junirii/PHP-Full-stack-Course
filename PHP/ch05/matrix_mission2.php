<?php
  $scores = array(
    array(100, 100, 100, 100),
    array(90, 80, 70, 80),
    array(55, 65, 75, 90),
    array(90, 88, 55, 60)
  );
  $subs = array("국어", "영어", "수학", "과학");
  $each_sum = array();
  $each_avg = array();

  for($i=0; $i<count($subs); $i++)
  {
    for($j=0; $j<count($scores); $j++)
    {
      $each_sum[$i] += $scores[$j][$i];
    }
  }

  for($i=0; $i<count($subs); $i++)
  {
    $each_avg[$i] = $each_sum[$i] / count($subs);
    print $subs[$i] . "<br>";
    print "합계 : " . $each_sum[$i] . ", 평균 : " . $each_avg[$i] . "<br>";
  }
?>