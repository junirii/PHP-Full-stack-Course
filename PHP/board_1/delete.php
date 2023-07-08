<?php
  include_once "db.php";
  $i_board = $_GET['i_board'];
  $sql = "DELETE FROM t_board WHERE i_board = $i_board";

  $conn = conn_db();
  mysqli_query($conn, $sql);
  mysqli_close($conn);

  header("Location: list.php");
?>