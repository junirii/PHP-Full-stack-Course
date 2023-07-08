<?php
  include_once "db.php";

  $i_board = $_GET['i_board'];
  $board_num = $_GET['board_num'];
  $hot = $_GET['hot'];
  $listing = $_GET['listing'];
  $list_num = $_GET['list_num'];
  
  //검색
  if(isset($_GET['search_w']))
  {
    $cate = $_GET['cate'];
    $search_w = $_GET['search_w'];
    $search_link = "&cate=$cate&search_w=$search_w";  
  }
  //

  if($search == 1)
  {
    $list = "search.php?cate=$cate&search_w=$search_w";
  }
  else if($board_num == 1)
  {
    $t_board = "t_board";
    $list = $hot == 0 ? "list.php" : "list_hot.php";
  }
  else
  {
    $t_board = "t_board2";
    $list = $hot == 0 ? "list2.php" : "list_hot.php";
  }

  $sql = "SELECT title, ctnt, create_at, mod_at, views, img, writer FROM $t_board WHERE i_board = $i_board";
  $sql_re = "SELECT id, ctnt, create_at FROM reply WHERE i_board = $i_board AND board_num = $board_num ORDER BY idx";
  $sql_move = "SELECT i_board FROM $t_board";

  $conn = get_conn();
  $result = mysqli_query($conn, $sql);
  $result_re = mysqli_query($conn, $sql_re);
  $result_move = mysqli_query($conn, $sql_move);
  mysqli_close($conn);

  if($row = mysqli_fetch_assoc($result))
  {
    $title = $row['title'];
    $ctnt = $row['ctnt'];
    $create_at = $row['create_at'];  
    $mod_at = $row['mod_at'];
    $views = $row['views'];
    $img = $row['img'];
    $writer = $row['writer'];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>글내용</title>
</head>
<body>
  <h1>글내용</h1>
  <a href=<?=$list?>?listing=<?=$listing?>&list_num=<?=$list_num?><?=$search_link?>><button>글목록</button></a>
  <a href="mod.php?i_board=<?=$i_board?>&board_num=<?=$board_num?>&hot=<?=$hot?>"><button>글수정</button></a>
  <a href="del.php?i_board=<?=$i_board?>&board_num=<?=$board_num?>&hot=<?=$hot?>"><button>글삭제</button></a>
  <a href="reply.php?i_board=<?=$i_board?>&board_num=<?=$board_num?>&hot=<?=$hot?>"><button>답변</button></a>
  <div>제목 : <?=$title?></div>
  <div>글쓴이 : <?=$writer?></div>
  <div>작성일시 : <?=$create_at?></div>
  <?php
    if($create_at != $mod_at)
    {
      print "<div>수정일시 : $mod_at</div>";
    }

    print "<div>조회수 : $views</div>";
    print "<div>내용 : <br>";

    if($img)
    {
      print "<img src='$img'><br>";
    }
    print "$ctnt</div>";
  ?>

  <?php
    $i_board_arr = [];
    foreach($result_move as $item)
    {
      array_push($i_board_arr, $item['i_board']);
    }

    $key_after = array_search($i_board, $i_board_arr) + 1;
    $key_before = array_search($i_board, $i_board_arr) - 1;
    if($i_board_arr[$key_before])
    {
      $i_board_before = $i_board_arr[$key_before];
      print "<a href='detail.php?i_board=$i_board_before&board_num=$board_num&hot=$hot&listing=$listing&list_num=$list_num'><button><</button></a>";
    }
    if($i_board_arr[$key_after])
    {
      $i_board_after = $i_board_arr[$key_after];
      print "<a href='detail.php?i_board=$i_board_after&board_num=$board_num&hot=$hot&listing=$listing&list_num=$list_num'><button>></button></a>";
    }

  ?>

  <h3>댓글</h3>
  <?php
    while($row = mysqli_fetch_assoc($result_re))
    {
      $id_re = $row['id'];
      $ctnt_re = $row['ctnt'];
      $create_at_re = $row['create_at'];

      print "<div><b>$id_re</b></div>";
      print "<div>$ctnt_re</div>";
      print "<div>$create_at_re</div>";
      print "<a href='mod_re.php?i_board=<?=$i_board?>&board_num=<?=$board_num?>&hot=<?=$hot?>'><button>수정</button></a>";
      print "<a href='del_re.php?i_board=<?=$i_board?>&board_num=<?=$board_num?>&hot=<?=$hot?>'><button>삭제</button></a>";
    }
  ?>
  <hr>
  <form action="reply_proc.php" method="POST">
    <div><input type="hidden" name="i_board" value="<?=$i_board?>"></div>
    <div><input type="hidden" name="board_num" value="<?=$board_num?>"></div>
    <div><input type="hidden" name="hot" value="<?=$hot?>"></div>
    <div><input type="hidden" name="listing" value="<?=$listing?>"></div>
    <div><input type="hidden" name="list_num" value="<?=$list_num?>"></div>
    <div><input type="hidden" name="cate" value="<?=$cate?>"></div>
    <div><input type="hidden" name="search_w" value="<?=$search_w?>"></div>
    <input type="text" name="id" placeholder="아이디" required>
    <input type="password" name="passwd" placeholder="비밀번호" required><br><br>
    <textarea name="ctnt" cols="48" rows="3" placeholder="내용" required></textarea>
    <input type="submit" value="작성">
  </form>
  <div></div>
</body>
</html>