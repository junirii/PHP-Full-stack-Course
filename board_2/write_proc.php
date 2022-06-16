<?php
  include_once "db.php";

  /*
  function getExt($file)
  {
    $needle = strrpos($file, ".") + 1;
    $slice = substr($file, $needle);
    $ext = strtolower($slice);
    return $ext;
  }

  $tmpName = $_FILES['img']['tmp_name'];
  $fileName = $_FILES['img']['name'];
  
  $file_exe_arr = explode(".", $fileName);
  $file_name = $file_exe_arr[0];
  $ext = getExt($fileName);
  $ext = strtolower($ext);
  $src = "$tmpName./$file_name.$ext";
  print $src;
  */

  $title = $_POST["title"];
  $ctnt = $_POST["ctnt"];
  $img = $_POST['img'];
  $writer = $_POST['writer'];
  $passwd = $_POST['passwd'];
  $board = $_POST['board'];

  $sql = "INSERT INTO $board (title, ctnt, img, writer, passwd) VALUES ('$title', '$ctnt', '$img', '$writer', '$passwd')";

  $conn = get_conn();
  mysqli_query($conn, $sql);
  mysqli_close($conn);

  if($board == "t_board")
  {
    $list = "list";
  }
  else
  {
    $list = "list2";
  }

  header("Location: $list.php");
?>