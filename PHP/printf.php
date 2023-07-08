<?php
  $name = "홍길동";
  $age = 22;
  $height = 177.32;
  $blood_type = 'O';

  $str = sprintf("제 이름은 %s입니다. 나이는 %04d세이고, 키는 %.1fcm입니다. 혈액형은 %s입니다."
          , $name, $age, $height, $blood_type);
          //s, d, f => 문자열, 정수, 실수(자바에서 c => 문자)

  print $str;