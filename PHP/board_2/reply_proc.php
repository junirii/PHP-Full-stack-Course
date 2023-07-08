<?php
  include_once "db.php";

  $i_board = $_POST['i_board'];
  $board_num = $_POST['board_num'];
  $hot = $_POST['hot'];
  $listing = $_POST['listing'];
  $list_num = $_POST['list_num'];
  $id = $_POST['id'];
  $passwd = $_POST['passwd'];
  $ctnt = $_POST['ctnt'];
  if(isset($_POST['search_w']))
  {
    $cate = $_POST['cate'];
    $search_w = $_POST['search_w'];
    $search_link = "&cate=$cate&search_w=$search_w";  
  }

  $sql = "INSERT INTO reply (id, passwd, ctnt, i_board, board_num) VALUES ('$id', '$passwd', '$ctnt', $i_board, $board_num)";

  $conn = get_conn();
  mysqli_query($conn, $sql);
  mysqli_close($conn);

  header("Location: detail.php?i_board=$i_board&board_num=$board_num&hot=$hot&listing=$listing&list_num=$list_num$search_link");
  ?>