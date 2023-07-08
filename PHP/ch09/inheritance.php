<?php
  class People{
    protected $name;
    protected $age;

    function printPeople(){
      print "Name : {$this->name}<br>";
      print "Age : {$this->age}<br>";
    }
  }

  class Student extends People{
    private $studentId;

    function __construct($name, $age, $studentId){
      $this->name = $name;
      $this->age = $age;
      $this->studentId = $studentId;
    }

    function printStudent(){
      print "- Student - <br>";
      // $this->printPeople();
      parent::printPeople();
      print "Id : {$this->studentId}<br>";
    }

    function printPeople(){
      print "Student에 있는 print People<br>";
    }
  }
  $people = new People();
  $stu1 = new Student("홍길동", 21, 1010);
  // $stu1->printPeople();
  // print "---------------<br>";
  // $stu1->printStudent();

  callPrintPeople($people);

  function callPrintPeople($obj){
    $obj->printPeople();
  }