<?php
  class Computer{
    public static $brand = "1";
    public $price;

    function __construct(){
      self::$brand = "2";
    }

    static function setBrand($brand){
      self::$brand = $brand;
    }
    function myPrint(){
      print "컴퓨터 브랜드는 " . self::$brand . ", 가격은 {$this->price}입니다.<br>";
    }

    static function myStaticPrint($price){
      print "컴퓨터 브랜드는 " . self::$brand . ", 가격은 {$price}입니다.<br>";
    }
  }
  // print Computer::$brand;
  // Computer::$brand = "LG";
  // print Computer::$brand;
  $c = new Computer;
  $c->price = 10000;
  
  $c2 = new Computer;
  $c2->price = 20000;

  $c->myPrint();
  $c2->myPrint();
  
  Computer::setBrand("SS");
  
  $c->myPrint();
  $c2->myPrint();
  $c->myStaticPrint(30000);