<?php
  include_once "db.php";

  $i_board = $_GET['i_board'];
  $board_num = $_GET['board_num'];
  $hot = $_GET['hot'];

  $t_board = $board_num == 1? "t_board" : "t_board2";

  $sql = "SELECT title, ctnt, writer, passwd FROM $t_board WHERE i_board = $i_board";

  $conn = get_conn();
  $result = mysqli_query($conn, $sql);
  mysqli_close($conn);

  if($row = mysqli_fetch_assoc($result))
  {
    $title = $row["title"];
    $ctnt = $row["ctnt"];
    $writer = $row['writer'];
    $passwd = $row["password"];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>글수정</title>
</head>
<body>
  <h1>글수정</h1>
  <a href="detail.php?i_board=<?=$i_board?>&board_num=<?=$board_num?>&hot=<?=$hot?>"><button>글내용</button></a>
  <form action="mod_proc.php" method="post">
    <div><input type="hidden" name="i_board" value="<?=$i_board?>"></div>
    <div><input type="hidden" name="board_num" value="<?=$board_num?>"></div>
    <div><input type="hidden" name="hot" value="<?=$hot?>"></div>
    <div>글쓴이: <?=$writer?></div>
    <div>암호: <input type="password" name="passwd"></div>
    <div>제목: <input type="text" name="title" value="<?=$title?>" required></div>
    <div>내용: <textarea cols="50" rows="8" name="ctnt" required><?=$ctnt?></textarea></div>
    <div><input type="file" name="img"></div>
    <input type="submit" value="수정">
    <input type="reset" value="초기화">
  </form>
</body>
</html>