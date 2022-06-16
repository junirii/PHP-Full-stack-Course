<?php
  $board_num = $_GET['board_num'];

  $select0 = ""; $select1 = ""; $select2 = "";
  $board_num == 1? $select1 = "selected" : ($board_num == 2? $select2 = "selected" : $select0 = "selected");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>글쓰기</title>
</head>
<body>
  <h1>글쓰기</h1>
  <?php
    switch($board_num)
    {
      case 1:
        print "<a href='list.php'><button>뒤로</button></a>";
        break;
      case 2:
        print "<a href='list2.php'><button>뒤로</button></a>";
        break;
      case 3:
        print "<a href='list_hot.php'><button>뒤로</button></a>";
        break;
      default:
        print "<a href='list.php'><button>게시판1</button></a>
               <a href='list2.php'><button>게시판2</button></a>
               <a href='list_hot.php'><button>HOT게시판</button></a>";
        break;
    }
  ?>
  <form action="write_proc.php" method="post">
    게시판 : 
    <select name="board" required>
      <option value="" disabled <?=$select0?>>선택</option>
      <option value="t_board" <?=$select1?>>게시판1</option>
      <option value="t_board2" <?=$select2?>>게시판2</option>
    </select>
    <div>글쓴이 : <input type="text" name="writer" required></div>
    <div>암호 : <input type="password" name="passwd" required></div>
    <div>제목 : <input type="text" name="title" required></div>
    <div>내용 : <textarea cols="50" rows="8" name="ctnt" required></textarea></div>
    <div><input type="file" name="img"></div>
    <input type="submit" value="등록">
    <input type="reset" value="초기화">
  </form>
</body>
</html>