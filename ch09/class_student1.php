<?php
  class Student{
    public $studentId;
    public $studentName;
    public function printStudent()
    {
      print "ID : {$this->studentId}<br>";
      print "Name : {$this->studentName}<br>";
    }
  }

  $obj = new Student;
  $obj->studentId = 20171234;
  $obj->studentName = "Alice";

  $obj->printStudent();