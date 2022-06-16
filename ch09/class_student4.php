<?php
  class Student{
    private $studentId;
    private $studentName;

    //getters
    public function getStudentId(){
      return $this->studentId;
    }
    public function getStudentName(){
      return $this->studentName;
    }

    //setters
    public function setStudentId($studentId){
      $this->studentId = $studentId;
      return $this;
    }
    public function setStudentName($studentName){
      $this->studentName = $studentName;
      return $this;
    }

    public function printStudent()
    {
      print "ID : {$this->studentId}<br>";
      print "Name : {$this->studentName}<br>";
    }
  }

  $obj = new Student;
  $obj->setStudentId(111);
  $obj->setStudentName("홍길동");
  $obj->printStudent();