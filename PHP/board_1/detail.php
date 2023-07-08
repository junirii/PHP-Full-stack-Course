<?php
  include_once "db.php";

  $i_board = $_GET['i_board'];
  $sql = "SELECT title, create_at, ctnt FROM t_board WHERE i_board = $i_board";

  $conn = conn_db();
  $result = mysqli_query($conn, $sql);
  mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>글 내용</title>
</head>
<body>
<a href="list.php"><button>글 목록</button></a>
<a href="delete.php?i_board=<?=$i_board?>"><button>글 삭제</button></a>
<a href="mod.php?i_board=<?=$i_board?>"><button>글 수정</button></a>
  <?php
  
    if($row = mysqli_fetch_assoc($result))
    {
      $title = $row['title'];
      $create_at = $row['create_at'];
      $ctnt = $row['ctnt'];
      print "<div>제목: $title</div>";
      print "<div>작성일시: $create_at</div>";
      print "<div>내용: $ctnt</div>";
    }
  ?>
</body>
</html>