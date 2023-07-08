<?php
  include_once "db.php";

  //검색
  if(isset($_GET['search_w']))
  {
    $cate = $_GET['cate'];
    $search_w = $_GET['search_w'];
    $search_link = "&cate=$cate&search_w=$search_w";  
  }
  //

  //페이징 변수
  $list_num = isset($_GET['list_num']) ? $_GET['list_num'] : 5;
  $select_list1 = ""; $select_list2 = ""; $select_list3 = "";
  switch($list_num)
  {
    case 3:
      $select_list1 = "selected";
      break;
    case 10:
      $select_list2 = "selected";
    case 5: default:
      $select_list3 = "selected";
  }
  $block_page_num = 5;
  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $start = ($page - 1) * $list_num;
  //

  //정렬
  $listing = isset($_GET['listing']) ? $_GET['listing'] : "listing_time2";

  if(isset($_GET['search_w']))
  {
    $sql = "SELECT * FROM
    (SELECT i_board, title, create_at, views, img, board_num, writer FROM t_board WHERE views >= 5 UNION
    SELECT i_board, title, create_at, views, img, board_num, writer FROM t_board2 WHERE views >= 5) AS a
    WHERE $cate like '%$search_w%'";
  }
  else
  {
    $sql = "SELECT * FROM
    (SELECT i_board, title, create_at, views, img, board_num, writer FROM t_board WHERE views >= 5 UNION
    SELECT i_board, title, create_at, views, img, board_num, writer FROM t_board2 WHERE views >= 5) AS a";
  }
  $sql_total = "SELECT i_board FROM
  (SELECT i_board, title, create_at, views, img, board_num, writer FROM t_board WHERE views >= 5 UNION
  SELECT i_board, title, create_at, views, img, board_num, writer FROM t_board2 WHERE views >= 5) AS a";

  $sql2 = "LIMIT $start, $list_num";

  $sql_title_ = "$sql ORDER BY title";
  $sql_title = "$sql ORDER BY title $sql2";
  $sql_title2 = "$sql ORDER BY title DESC $sql2";
  $sql_time = "$sq ORDER BY create_at $sql2";
  $sql_time2 = "$sql ORDER BY create_at DESC $sql2";
  $sql_view = "$sql ORDER BY views $sql2";
  $sql_view2 = "$sql ORDER BY views DESC $sql2";

  $select1 = ""; $select2 = ""; $select3 = ""; $select4 = ""; $select5 = ""; $select6 = "";
  
  $conn = get_conn();
  switch($listing)
  {
    case "listing_title":
      $result = mysqli_query($conn, $sql_title);
      $select3 = "selected";
      break;
    case "listing_title2":
      $result = mysqli_query($conn, $sql_title2);
      $select4 = "selected";
      break;
    case "listing_time":
      $result = mysqli_query($conn, $sql_time);
      $select2 = "selected";
      break;
    case "listing_view":
      $result = mysqli_query($conn, $sql_view);
      $select5 = "selected";
      break;
    case "listing_view2":
      $result = mysqli_query($conn, $sql_view2);
      $select6 = "selected";
      break;
    case "listing_time2": default:
      $result = mysqli_query($conn, $sql_time2);
      $select1 = "selected";
      break;
  }
  //데이터 수 구하기
  if(isset($_GET['search_w']))
  {
    $result_paging = mysqli_query($conn, "$sql_total WHERE $cate like '%$search_w%'");
  }
  else
  {
    $result_paging = mysqli_query($conn, $sql_total);
  }
  mysqli_close($conn);
  //

  //페이징 변수2
  $num = 0;
  while($row = mysqli_fetch_assoc($result_paging)){$num++;}

  $total_page = ceil($num/$list_num);
  $total_block = ceil($total_page / $block_page_num);
  $now_block = ceil($page / $block_page_num);
  $s_pageNum = ($now_block - 1) * $block_page_num + 1;
  if($s_pageNum <= 0)
  {
    $s_pageNum = 1;
  }

  $e_pageNum = $now_block * $block_page_num;
  if($e_pageNum > $total_page)
  {
    $e_pageNum = $total_page;
  }
  //
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
  <?php
    switch($cate)
    {
      case "title":
        $cate_k = "제목";
        break;
      case "writer":
        $cate_k = "글쓴이";
        break;
      case "ctnt":
        $cate_k = "내용";
        break;
    }
    $board_name = isset($_GET['search_w']) ? "$cate_k(으)로 $search_w 검색 결과" : "HOT게시판";
  ?>
  <h2><?=$board_name?></h2>
  <a href="write.php?board_num=3"><button>글쓰기</button></a>
  <form action="" method="GET">
    정렬방법: 
    <select name="listing">
      <option value="listing_time2" <?=$select1?>>최신순(기본)</option>
      <option value="listing_time" <?=$select2?>>오래된 순</option>
      <option value="listing_title" <?=$select3?>>제목 오름차순</option>
      <option value="listing_title2" <?=$select4?>>제목 내림차순</option>
      <option value="listing_view" <?=$select5?>>조회수 낮은 순</option>
      <option value="listing_view2" <?=$select6?>>조회수 높은 순</option>
    </select>
    <select name="list_num">
      <option value="3" <?=$select_list1?>>3개</option>
      <option value="5" <?=$select_list3?>>5개</option>
      <option value="10" <?=$select_list2?>>10개</option>
    </select>
    <input type="submit" value="정렬">
  </form>
  <table style="text-align: center">
    <tr>
      <th>제목</th>
      <th>글쓴이</th>
      <th>게시판</th>
      <th>작성일시</th>
      <th>조회수</th>
    </tr>
    <?php
      while($row = mysqli_fetch_assoc($result))
        { 
          $i_board =$row['i_board'];
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
          $writer = $row['writer'];
          $img = $row['img'];
          $board_num = $row['board_num'];
          $board_name = $board_num == 1 ? "게시판1" : "게시판2";

          print "<tr>";
          if($img)
          {
            print "<td><a href='view_proc.php?i_board=$i_board&board_num=$board_num&hot=1&listing=$listing&list_num=$list_num${search_link}'><img src='img.png' style='width: 15px; height: 15px;'>$title</a></td>";
          }
          else
          {
            print "<td><a href='view_proc.php?i_board=$i_board&board_num=$board_num&hot=1&listing=$listing&list_num=$list_num${search_link}'>$title</a></td>";
          }
          print "<td>$writer</td>";
          print "<td>$board_name</td>";
          print "<td>$date</td>";
          print "<td>$views</td>";
          print "</tr>";
        }
    ?>
    <div>전체글: <?=$num?></div>
  </table>

  <form action="" method="GET">
    <select name="cate">
      <option value="title">제목</option>
      <option value="writer">글쓴이</option>
      <option value="ctnt">내용</option>
    </select>
    <input type="text" name="search_w" required>
    <input type="submit" value="검색">
  </form>

  <?php
    //페이저 만들기
    if($now_block >= 1)
    {$page1 = 1;}

    if($now_block <= 1)
    {$page2 = 1;}
    else
    {$page2 = $now_block * $block_page_num - 5;}

    if($page <= 1)
    {$page3 = 1;}
    else
    {$page3 = $page - 1;}

    $search_page = isset($_GET['search_w']) ? "&cate=$cate&search_w=$search_w" : "";

    print "<a href='list_hot.php?page=$page1&listing=$listing&list_num=$list_num$search_page'><button><<<</button></a>";
    print "<a href='list_hot.php?page=$page2&listing=$listing&list_num=$list_num$search_page'><button><<</button></a>";
    print "<a href='list_hot.php?page=$page3&listing=$listing&list_num=$list_num$search_page'><button><</button></a>";

    for($i = $s_pageNum; $i <= $e_pageNum; $i++)
    {
      if($i == $page)
      {
        print "<a href='list_hot.php?page=$i&listing=$listing&list_num=$list_num$search_page'><b>$i </b></a>";
      }
      else
      {
        print "<a href='list_hot.php?page=$i&listing=$listing&list_num=$list_num$search_page'>$i </a>";
      }

    }

    if($page >= $total_page)
    {$page4=$total_page;}
    else
    {$page4 = $page + 1;}

    if($now_block >= $total_block)
    {$page5 = $total_page;}
    else
    {$page5 = $now_block * $block_page_num + 1;}

    if($now_block < $total_block)
    {$page6 =  $total_block * $block_page_num - 2;}
    else
    {$page6 = $total_page;}

    print "<a href='list_hot.php?page=$page4&listing=$listing&list_num=$list_num$search_page'><button>></button></a>";
    print "<a href='list_hot.php?page=$page5&listing=$listing&list_num=$list_num$search_page'><button>>></button></a>";
    print "<a href='list_hot.php?page=$page6&listing=$listing&list_num=$list_num$search_page'><button>>>></button></a>";
    //
  ?>
</body>
</html>