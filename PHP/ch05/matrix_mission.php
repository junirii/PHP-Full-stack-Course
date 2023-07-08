<?php
  $scores = array(
    array(100, 100, 100),
    array(90, 80, 70),
    array(55, 65, 75)
  );

  $names = array("영수", "순자", "영철");
  $each_scores = array(0, 0, 0);

  for($i=0; $i<count($scores); $i++)
  {
    for($j=0; $j<count($scores[$i]); $j++)
    {
      $each_scores[$i] += $scores[$i][$j];
    }
  }

  for($i=0; $i<count($names); $i++)
  {
    print $names[$i] . " : " . $each_scores[$i] . "<br>";
  }
?>