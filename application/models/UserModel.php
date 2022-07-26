<?php
namespace application\models;
use PDO;

class UserModel extends Model {
  public function insUser(&$param){
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

  public function selUser(&$param){
    $sql = 
    " SELECT * FROM t_user
      WHERE email = :email
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":email", $param["email"]);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }

  public function myUser(&$param)
  {
    $sql =
      "     SELECT *
    FROM t_user A
    INNER JOIN t_board B
    ON A.iuser = B.iuser
    INNER JOIN t_trip C
    ON A.iuser = C.iuser
    INNER JOIN t_cmt D
    ON A.iuser = D.host_iuser
    INNER JOIN t_board_fav E
    ON A.iuser = E.iuser
    WHERE A.iuser = 1;
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":iuser", $param["iuser"]);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }

}