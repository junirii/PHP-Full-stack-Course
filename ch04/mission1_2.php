<?php
  $score = rand(-10, 120);
  print "점수 : $score <br>";
  
  if($score > 100 || $score < 0)
  {
    print "잘못된 값";
  }
  else
  {
    $grade = "F";
    $semi_grade = "";
    $ten_val = intval($score / 10);
    $one_val = $score % 10;

    switch($ten_val)
    {
      case 9: case 10:
        {
          $grade = "A";
          break;
        }
      case 8:
        {
          $grade = "B";
          break;
        }
      case 7:
        {
          $grade = "C";
          break;
        }
      case 6:
        {
          $grade = "D";
          break;
        }
    }

    if($score >= 60)
    {
      if($score == 100 || $one_val >= 7)
      {
        $semi_grade = "+";
      }
      else if($one_val <= 3)
      {
        $semi_grade = "-";
      }
    }
    print $grade . $semi_grade;
  }

?>