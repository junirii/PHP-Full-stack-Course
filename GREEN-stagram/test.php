<?php
require_once "application/utils/FileUtils.php";

$result = getRandomFileNm("asdasd.asdagfadgdsa.asf.jpeg");
print "result : " . $result . "<br>";

$email = "ga243@naver.com";
$emailArr = explode("@", $email);
print $emailArr[0];