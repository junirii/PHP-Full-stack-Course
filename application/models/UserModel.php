<?php

namespace application\models;

use PDO;

class UserModel extends Model
{
  public function insUser(&$param)
  {
    $sql =
      " INSERT INTO t_user
      (email, pw, nm, nick, gender, age, tel, profile_img, cmt)
      VALUES
      (:email, :pw, :nm, :nick, :gender, :age, :tel, :profile_img, :cmt)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":email", $param["email"]);
    $stmt->bindValue(":pw", $param["pw"]);
    $stmt->bindValue(":nm", $param["nm"]);
    $stmt->bindValue(":nick", $param["nick"]);
    $stmt->bindValue(":gender", $param["gender"]);
    $stmt->bindValue(":age", $param["age"]);
    $stmt->bindValue(":tel", $param["tel"]);
    $stmt->bindValue(":profile_img", $param["profile_img"]);
    $stmt->bindValue(":cmt", $param["cmt"]);
    $stmt->execute();
    return $stmt->rowCount();
  }

  public function selUser(&$param)
  {
    $sql =
      " SELECT * FROM t_user
      WHERE email = :email
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":email", $param["email"]);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }

  /* mypage 시작 */
  public function myPagehost(&$param)
  // mypage 호스팅한 여행 (title 뿌리기)
  {
    $sql =
      " SELECT *
      FROM t_user A
      INNER JOIN t_board B
      ON A.iuser = B.iuser
      WHERE A.iuser = :iuser
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":iuser", $param["iuser"]);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function myPageTrip(&$param)
  { // mypage 참여한 여행 (title 뿌리기)
    $sql =
      " SELECT *
      FROM t_trip A
      INNER JOIN t_board B
      ON A.iboard = B.iboard
      WHERE A.iuser = :iuser
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":iuser", $param["iuser"]);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function myPageCmt(&$param)
  { // mypage 호스트 리뷰 (list 뿌리기)
    $sql =
      " SELECT *
      FROM t_cmt D
      WHERE host_iuser = :iuser
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":iuser", $param["iuser"]);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function myPageBoardFav(&$param)
  { // mypage 찜한 여행 (title 뿌리기)
    $sql =
      "SELECT A.iboard, A.iuser, A.reg_dt,
      B.title, B.reg_dt, B.mod_dt, B.area, B.location, B.main_img, B.s_date, B.e_date, B.f_people, B.f_price, B.f_gender, B.f_age
      FROM t_board_fav A
      INNER JOIN t_board B
      ON A.iboard = B.iboard
      WHERE A.iuser = :iuser;
      ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":iuser", $param["iuser"]);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
  /* mypage 끝 */
}
