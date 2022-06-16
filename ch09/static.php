<?php
  class Calc{
    function sum($n1, $n2){
      return $n1 + $n2;
    }
  }

  $c = new Calc();
  echo $c->sum(10, 15) . "<br>";
  
  class StaticCalc{
    static function sum($n1, $n2){
      return $n1 + $n2;
    }
  }

  echo StaticCalc::sum(10, 15);