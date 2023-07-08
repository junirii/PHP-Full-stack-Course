<?php
  include_once "db.php";

  $title = $_POST['title'];
  $ctnt = $_POST['ctnt'];
  $sql = "INSERT INTO t_board (title, ctnt) VALUES ('$title', '$ctnt')";

  $conn = conn_db();
  mysqli_query($conn, $sql);
  mysqli_close($conn);

  header("Location: list.php");
?>