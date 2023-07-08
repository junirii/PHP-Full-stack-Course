<?php
  function get_conn()
  {
    define("URL", "localhost");
    define("USERNAME", "root");
    define("PASSWORD", "506greendg@");
    define("DBNAME", "board1");

    return mysqli_connect(URL, USERNAME, PASSWORD, DBNAME);
  }
?>