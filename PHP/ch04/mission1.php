<?php
  $score = rand(-10, 120);
  print "점수 : $score <br>";
  
  if($score > 100 || $score < 0)
  {
    print "잘못된 값";
  }
  else if($score >= 90)
  {
    if($score >= 97)
    {
      print "A+";
    }else if($score > 93)
    {
      print "A";
    }else
    {
      print "A-";
    } 
  }
  else if($score >= 80)
  {
    if($score >= 87)
    {
      print "B+";
    }else if($score > 83)
    {
      print "B";
    }else
    {
      print "B-";
    }
  }
  else if($score >= 70)
  {
    if($score >= 77)
    {
      print "C+";
    }else if($score > 73)
    {
      print "C";
    }else
    {
      print "C-";
    }
  }
  else if($score >= 60)
  {
    if($score >= 67)
    {
      print "D+";
    }else if($score > 63)
    {
      print "D";
    }else
    {
      print "D-";
    }
  }
  else
    {
      print "F";
    }
?>