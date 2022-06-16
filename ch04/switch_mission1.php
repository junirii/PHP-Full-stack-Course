<?php
  $mon = rand(1, 15);

  print "${mon}월은 ";
  switch($mon)
  {
    case 3: case 4: case 5:
      print "봄입니다.";
      break;
    
    case 6: case 7: case 8:
      print "여름입니다.";
      break;

    case 9: case 10: case 11:
      print "가을입니다.";
      break;

    case 12: case 1: case 2:
      print "겨울입니다.";
      break;

    default:
      print "없습니다.";
      break;
  }
?>