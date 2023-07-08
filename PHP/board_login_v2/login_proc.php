<?php
  include_once 'db/db_user.php';
  
  $uid = $_POST['uid'];
  $upw = $_POST['upw'];

  $param = [
    "uid" => $uid
  ];

  $result = sel_user($param);

  if(empty($result))
  {
    echo "<script>alert('해당하는 아이디 없음');
    history.back();</script>";
    exit;
  }

  if($upw === $result['upw'])
  {
    session_start();
    $_SESSION["login_user"] = $result;
    header("Location: list.php");
  }
  else
  {
    echo "<script>alert('비밀번호 다름');
    history.back();</script>";
    exit;
  }