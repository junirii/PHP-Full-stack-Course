<?php
  include_once "db.php";

  $cate = $_POST['cate'];
  $search_w = $_POST['search_w'];
  $board_numm = $_POST['board_num'];

  $board = "";
  if($board_numm == 1)
  {
    $board = "t_board";
  }
  else if($board_numm == 2)
  {
    $board = "t_board2";
  }

  switch($cate)
  {
    case "title":
      $cate2 = "제목";
      break;
    case "writer":
      $cate2 = "글쓴이";
      break;
    case "ctnt":
      $cate2= "내용";
      break;
  }

  if($board_numm == 3)
  {
    $sql = "SELECT * FROM
    (SELECT i_board, title, create_at, views, img, board_num, writer FROM t_board WHERE views >= 5 AND $cate like '%$search_w%' UNION
    SELECT i_board, title, create_at, views, img, board_num, writer FROM t_board2 WHERE views >= 5 AND $cate like '%$search_w%') AS a ORDER BY create_at";
  }
  else
  {
    $sql = "SELECT i_board, title, create_at, views, board_num, writer, img FROM $board WHERE $cate like '%$search_w%' ORDER BY create_at";
  }
 
  $conn = get_conn();
  $result = mysqli_query($conn, $sql);
  mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>리스트</title>
  <style>
    a {text-decoration: none; color: black;}
    table, td {border: solid black; border-width: 1px 0px 1px 0px; border-collapse: collapse;}
    th {border: solid black; border-width: 2px 0px 2px 0px;}
  </style>
</head>
<body>
  <h1>리스트</h1>
  <a href="list.php"><button>게시판1</button></a>
  <a href="list2.php"><button>게시판2</button></a>
  <a href="list_hot.php"><button>HOT게시판</button></a>
  <h2><?=$cate2?>(으)로 <?=$search_w?> 검색 결과</h2>
  <a href="write.php?board_num=1"><button>글쓰기</button></a>

  <table style="text-align: center">
    <tr>
      <?php if($board_numm != 3){print "<th>번호</th>";} ?>
      <th>제목</th>
      <th>글쓴이</th>
      <?php if($board_numm == 3){print "<th>게시판</th>";} ?>
      <th>작성일시</th>
      <th>조회수</th>
    </tr>
    <?php
    while($row = mysqli_fetch_assoc($result))
      {
        $i_board = $row['i_board'];
        $title = $row['title'];
        $create_at = date("Y-m-d H:i", strtotime($row['create_at']));
        if(substr($create_at, 0, 4) == getdate()["year"] &&
           substr($create_at, 6, 1) == getdate()["mon"] &&
           substr($create_at, 8, 2) == getdate()["mday"])
        {
          $date = date("H:i", strtotime($row['create_at']));
        }
        else
        {
          $date = date("y-m-d", strtotime($row['create_at']));
        }
        $views = $row['views'];
        $board_num = $row['board_num'];
        $board_name = $board_num == 1 ? "게시판1" : "게시판2";
        $writer = $row['writer'];
        $img = $row['img'];

        print "<tr>";
        if($board_numm != 3){print "<td>$i_board</td>";}
        if($img)
        {
          print "<td><a href='view_proc.php?i_board=$i_board&board_num=$board_num&hot=0'><img src='img.png' style='width: 15px; height: 15px;'>$title</a></td>";
        }
        else
        {
          print "<td><a href='view_proc.php?i_board=$i_board&board_num=$board_num&hot=0'>$title</a></td>";
        }
        print "<td>$writer</td>";
        if($board_numm == 3){print "<td>$board_name</td>";}
        print "<td>$date</td>";
        print "<td>$views</td>";
        print "</tr>";
      }
    ?>
  </table>
  <form action="" method="POST">
    <select name="cate">
      <option value="title">제목</option>
      <option value="writer">글쓴이</option>
      <option value="ctnt">내용</option>
    </select>
    <input type="text" name="search_w" required>
    <input type="hidden" name ="board_num" value=<?=$board_num?>>
    <input type="submit" value="검색">
  </form>
</body>
</html>