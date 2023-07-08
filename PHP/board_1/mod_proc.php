<?php
  include_once "db.php";

  $i_board = $_POST['i_board'];
  $title = $_POST['title'];
  $ctnt = $_POST['ctnt'];
  $sql = "UPDATE t_board SET title = '$title', ctnt = '$ctnt', mod_at = now() WHERE i_board = $i_board";

  $conn = conn_db();
  mysqli_query($conn, $sql);

  header("Location: detail.php?i_board=$i_board");
?>