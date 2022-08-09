<?php
namespace application\controllers;
use application\libs\application;
use Exception;

class ChatController extends Controller{
  public function insChatRoom(){
    switch (getMethod()) {
      case _POST:
        $urlPaths = getUrlPaths();
        $itravel = $urlPaths[2];
        $iuser = $urlPaths[3];
        $param = [
          "itravel" => $itravel,
          "iuser" => $iuser
        ];
        return [_RESULT => $this->model->insChatRoom($param)];
    }
  }
}