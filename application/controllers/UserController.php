<?php
  namespace application\controllers;
  use application\models\UserModel;
  // require_once "/application/models/UserModel.php";

  class UserController extends Controller{
    public function join(){
      $this->addAttribute(_TITLE, "회원가입");
      return "user/join.php";
    }

    public function joinProc(){
      $param = [
        "uid" => $_POST["uid"],
        "upw" => $_POST["upw"],
        "nm" => $_POST["nm"],
        "gender" => $_POST["gender"]
      ];
      $param["upw"] = password_hash($param["upw"], PASSWORD_BCRYPT);
      $model = new UserModel();
      $model->insUser($param);
      return "redirect:login";
    }

    public function login(){
      $this->addAttribute(_TITLE, "로그인");
      return "user/login.php";
    }

    public function loginProc(){
      $param = [
        "uid" => $_POST["uid"], 
        "upw" => $_POST["upw"]
      ];
      $model = new UserModel();
      $dbUser = $model->selUser($param);
      
      if($dbUser === false){
        print "<script>alert('아이디 없음')</script>";
        return $this->login();
      }else if(!password_verify($param["upw"], $dbUser->upw)){
        print "<script>alert('비밀번호 다름')</script>";
        return $this->login();
      }
      flash(_LOGINUSER, $dbUser);
      return "redirect:/board/list";
    }

    public function logout(){
      flash(_LOGINUSER);
      return "redirect:/user/login";
    }
  }