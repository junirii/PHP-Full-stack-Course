<?php
  setcookie("country", "한국");
  echo "County : ", $_COOKIE['country'], "<br>";

  $_COOKIE['country'] = "UK";
  echo "County : ", $_COOKIE['country'], "<br>";

  unset($_COOKIE['country']);
  setcookie("country");
  echo "County : ", $_COOKIE['country'], "<br>";
?>