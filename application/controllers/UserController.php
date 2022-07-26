<?php
namespace application\controllers;
use application\libs\Application;

class UserController extends Controller{
  public function join(){
    switch (getMethod()) {
      case _POST:
        $json = getJson();
        //아이디 중복 체크
        if($this->model->selUser($json)){
          return [_RESULT => 2];
        }else{
          $json["pw"] = password_hash($json["pw"], PASSWORD_BCRYPT);
          return [_RESULT => $this->model->insUser($json)];
        }
        return [_RESULT => 0];
    }
  }

  public function login(){
    switch (getMethod()) {
      case _POST:
        $json = getJson();
        $dbUser = $this->model->selUser($json);
        if(!$dbUser || !password_verify($json["pw"], $dbUser->pw)){
          return [_RESULT => 0];
        }else{
          $dbUser->pw = null;
          $dbUser->regdt = null;
          $this->flash(_LOGINUSER, $dbUser);
          return [_RESULT => 1];
        }
    }
  }
}