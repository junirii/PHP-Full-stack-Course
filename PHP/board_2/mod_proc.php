<?php
  include_once "db.php";

  $i_board = $_POST['i_board'];
  $board_num = $_POST['board_num'];
  $title = $_POST['title'];
  $ctnt = $_POST['ctnt'];
  $img = $_POST['img'];
  $passwd = $_POST['passwd'];
  $hot = $_POST['hot'];

  $t_board = $board_num == 1 ? "t_board" : "t_board2";

  $sql = "UPDATE $t_board SET title = '$title', ctnt = '$ctnt', mod_at = now(), img = '$img' WHERE i_board = $i_board";
  $sql2 = "SELECT passwd FROM $t_board WHERE i_board = $i_board";

  $conn = get_conn();
  $result = mysqli_query($conn, $sql2);
  if($row = mysqli_fetch_assoc($result))
  {
    $passwd_real = $row['passwd'];
    if($passwd == $passwd_real)
    {
      mysqli_query($conn, $sql);
      mysqli_close($conn);
      header("Location: detail.php?i_board=$i_board&board_num=$board_num&hot=$hot");
    }
    else
    {
      print "
      <script>
      alert('암호가 올바르지 않습니다.');
      history.back();
      </script>";
    }
  }
?>