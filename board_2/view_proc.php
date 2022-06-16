<?php
  include_once "db.php";

  $i_board = $_GET["i_board"];
  $board_num = $_GET["board_num"];
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
  
  $t_board = $board_num == 1? "t_board" : "t_board2";

  $sql = "UPDATE $t_board SET views = views + 1 WHERE i_board = $i_board";

  $conn = get_conn();
  mysqli_query($conn, $sql);
  mysqli_close($conn);

  header("Location: detail.php?i_board=$i_board&board_num=$board_num&hot=$hot&listing=$listing&list_num=${list_num}${search_link}");
?>