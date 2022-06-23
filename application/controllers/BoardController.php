<?php
  namespace application\controllers;
  use application\models\BoardModel;

  class BoardController extends Controller{
    public function list(){
      if(!isset($_SESSION[_LOGINUSER])){
        print 
        " <script>
          alert('로그인 해주세요.');
          location.href='/user/login';
          </script>
        ";
        return;
      }
      $model = new BoardModel();
      // $this->list = $model->selBoardList(); //아랫줄이랑 같음
      $this->addAttribute("list", $model->selBoardList());
      $this->addAttribute(_JS, ["board/list"]);
      $this->addAttribute(_TITLE, "리스트");
      $this->addAttribute(_HEADER, $this->getView("template/header.php"));
      $this->addAttribute(_MAIN, $this->getView("board/list.php"));
      $this->addAttribute(_FOOTER, $this->getView("template/footer.php"));
      return "template/t1.php";
    }

    public function detail(){
      $i_board = $_GET["i_board"];
      $param = ["i_board" => $i_board];
      $model = new BoardModel();
      $this->addAttribute("data", $model->selBoard($param));
      $this->addAttribute(_JS, ["board/detail"]);
      $this->addAttribute(_TITLE, "글내용");
      $this->addAttribute(_HEADER, $this->getView("template/header.php"));
      $this->addAttribute(_MAIN, $this->getView("board/detail.php"));
      $this->addAttribute(_FOOTER, $this->getView("template/footer.php"));
      return "template/t1.php";
    }

    public function del(){
      $i_board = $_GET["i_board"];
      $param = ["i_board" => $i_board];
      $model = new BoardModel();
      $model->delBoard($param);
      return "redirect:/board/list";
    }

    public function mod(){
      $i_board = $_GET["i_board"];
      $param = ["i_board" => $i_board];
      $model = new BoardModel();
      $this->addAttribute("data", $model->selBoard($param));
      $this->addAttribute(_TITLE, "글수정");
      $this->addAttribute(_HEADER, $this->getView("template/header.php"));
      $this->addAttribute(_MAIN, $this->getView("board/mod.php"));
      $this->addAttribute(_FOOTER, $this->getView("template/footer.php"));
      return "template/t1.php";
    }

    public function modProc(){
      $i_board = $_POST["i_board"];
      $title = $_POST["title"];
      $ctnt = $_POST["ctnt"];
      $param = [
        "i_board" => $i_board,
        "title" => $title,
        "ctnt" => $ctnt
      ];
      $model = new BoardModel();
      $model->updBoard($param);
      return "redirect:/board/detail?i_board=$i_board";
    }

    public function write(){
      $this->addAttribute(_TITLE, "글쓰기");
      $this->addAttribute(_HEADER, $this->getView("template/header.php"));
      $this->addAttribute(_MAIN, $this->getView("board/write.php"));
      $this->addAttribute(_FOOTER, $this->getView("template/footer.php"));
      return "template/t1.php";
    }

    public function writeProc(){
      $param = [
        "title" => $_POST["title"],
        "ctnt" => $_POST["ctnt"],
        "i_user" => $_SESSION[_LOGINUSER]->i_user
      ];
      $model = new BoardModel();
      $model->insBoard($param);
      return "redirect:/board/list";
    }
  }