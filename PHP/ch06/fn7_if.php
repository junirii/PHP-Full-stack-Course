<?php
  $mon = rand(0, 15);

  $season = get_season($mon);

  if($season)
  {
  print "${mon}월은 ${season}입니다";
  }
  else
  {
  print "${mon}월은 잘못된 값";
  }


  function get_season($num)
  {
    if($num < 1 || $num > 12){return "";}
    if($num < 3 || $num == 12){return "겨울";}
    if($num < 6){return "봄";}
    if($num < 9){return "여름";}
    return "가을";
  }
?>