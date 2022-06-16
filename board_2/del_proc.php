<?php
  include_once "db.php";

  $i_board = $_POST['i_board'];
  $board_num = $_POST['board_num'];
  $hot = $_POST['hot'];
  $passwd = $_POST['passwd'];

  if($board_num == 1)
  {
    $t_board = "t_board";
    $header = $hot == 0 ? "Location: list.php" : "Location: list_hot.php";
  }
  else
  {
    $t_board = "t_board2";
    $header = $hot == 0 ? "Location: list2.php" : "Location: list_hot.php";
  }

  $sql = "DELETE FROM $t_board WHERE i_board = $i_board";
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
      header($header);
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