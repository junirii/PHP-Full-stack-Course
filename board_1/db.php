<?php
  define("URL", "localhost");
  define("USERNAME", "root");
  define("PASSWORD", "506greendg@");
  define("DBNAME", "board1");

  function conn_db()
  {
    return mysqli_connect(URL, USERNAME, PASSWORD, DBNAME);
  }
?>