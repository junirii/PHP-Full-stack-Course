<?php
  include_once "db.php";

  $i_board = $_GET['i_board'];
  $board_num = $_GET['board_num'];
  $hot = $_GET['hot'];

  $t_board = $board_num == 1? "t_board" : "t_board2";

  $sql = "SELECT writer, title, passwd FROM $t_board WHERE i_board = $i_board";

  $conn = get_conn();
  $result = mysqli_query($conn, $sql);

  if($row = mysqli_fetch_assoc($result))
  {
    $writer = $row['writer'];
    $title = $row['title'];
    $passwd = $row['passwd'];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>글삭제</title>
</head>
<body>
  <h1>글삭제</h1>
  <a href="detail.php?i_board=<?=$i_board?>&board_num=<?=$board_num?>&hot=<?=$hot?>"><button>글내용</button></a>
  <div>글쓴이 : <?=$writer?></div>
  <div>제목 : <?=$title?></div>
  <form action="del_proc.php" method="POST">
    <input type="hidden" name="i_board" value=<?=$i_board?>>
    <input type="hidden" name="board_num" value=<?=$board_num?>>
    <input type="hidden" name="hot" value=<?=$hot?>>
    <div>암호 : <input type="password" name="passwd"></div>
    <input type="submit" value="삭제">
  </form>
</body>
</html>