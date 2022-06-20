<?php
  namespace application\controllers;
  use application\models\BoardModel;

  class BoardController extends Controller{
    public function list(){
      $model = new BoardModel();
      // $this->addAttribute("list", $model->selBoardList());
      $this->list = $model->selBoardList(); //윗줄이랑 같음
      return "board/list.php"; //view 파일명!!
    }
  }