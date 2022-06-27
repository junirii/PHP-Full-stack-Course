<?php
namespace application\controllers;

use PDO;

class FeedController extends Controller{
    public function index(){
        $this->addAttribute(_JS, ["feed/index"]);
        $this->addAttribute(_MAIN, $this->getView("feed/index.php"));
        return "template/t1.php";
    }
}