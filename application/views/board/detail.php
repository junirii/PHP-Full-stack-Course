<!DOCTYPE html>
<html lang="en">
<?php include_once "application/views/template/head.php";?>
<body>
  <h1>디테일</h1>
  <div>
    <?php
    if($_SESSION[_LOGINUSER]->i_user === $this->data->i_user){
    ?>
    <a href="mod?i_board=<?=$this->data->i_board?>"><button>글수정</button></a>
    <button id="btnDel" data-i_board="<?=$this->data->i_board?>" data-i_user="<?=$this->data->i_user?>">글삭제</button>
    <?php } ?>
  </div>
  <div>글번호: <?=$this->data->i_board?></div>
  <div>제목: <?=$this->data->title?></div>
  <div>글쓴이 이름: <?=$this->data->nm?></div>
  <div>작성일: <?=$this->data->created_at?></div>
  <div>수정일: <?=$this->data->updated_at?></div>
  <div>내용: <?=$this->data->ctnt?></div>
</body>
</html>