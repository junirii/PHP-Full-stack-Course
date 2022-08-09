<?php
namespace application\controllers;
use application\libs\application;
use Exception;

class ChatController extends Controller{
  public function insChatRoom(){
    switch (getMethod()) {
      case _POST:
        $json = getJson();
        $param = [
          "itravel" => $json["itravel"],
          "iuser" => $json["iuser"]
        ];
        return [_RESULT => $this->model->insChatRoom($param)];
    }
  }

  public function insChatMsg(){
    switch (getMethod()) {
      case _POST:
        $json = getJson();
        $param = [
          "itravel" => $json["itravel"],
          "iuser" => $json["iuser"],
          "msg" => $json["msg"],
        ];
        return [_RESULT => $this->model->insChatMsg($param)];
    }
  }

  public function selChatList(){
    switch (getMethod()) {
      case _GET:
        $urlPaths = getUrlPaths();
        $itravel = $urlPaths[2];
        $param = [
          "itravel" => $itravel
        ];
        $chatList = $this->model->selChatList($param);
        $chatUser = $this->model->selChatUser($param);
        $data = [
          "chatList" => $chatList,
          "chatUser" => $chatUser
        ];
        return [_RESULT => $data];
    }
  }

  public function selChatRooms(){
    switch (getMethod()) {
      case _GET:
        $iuser = getIuser();
        $param = [
          "iuser" => $iuser
        ];
        return [_RESULT => $this->model->selChatRooms($param)];
    }
  }
}