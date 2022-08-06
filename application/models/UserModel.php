<?php

namespace application\models;

use PDO;

class UserModel extends Model
{
  public function insUser(&$param)
  {
    $sql =
      " INSERT INTO t_user
      (email, pw, nm, nick, gender, birth, tel, profile_img, cmt)
      VALUES
      (:email, :pw, :nm, :nick, :gender, :birth, :tel, :profile_img, :cmt)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":email", $param["email"]);
    $stmt->bindValue(":pw", $param["pw"]);
    $stmt->bindValue(":nm", $param["nm"]);
    $stmt->bindValue(":nick", $param["nick"]);
    $stmt->bindValue(":gender", $param["gender"]);
    $stmt->bindValue(":birth", $param["birth"]);
    $stmt->bindValue(":tel", $param["tel"]);
    $stmt->bindValue(":profile_img", $param["profile_img"]);
    $stmt->bindValue(":cmt", $param["cmt"]);
    $stmt->execute();
    return $stmt->rowCount();
  }

  public function selUser(&$param) // mypage 프로필 띄우기, myaccount 프로필 띄우기
  {
    $sql = "SELECT * FROM t_user WHERE";
    if(array_key_exists("email", $param)){
      $email = $param["email"];
      $sql .= " email = '{$email}'";
    } else if (array_key_exists("iuser", $param)) {
      $sql .= " iuser = " . $param["iuser"];
    }

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }

  /* mypage 시작 */
  public function myPageTravelFav(&$param)
  { // mypage 찜한 여행 (title 뿌리기)
    $sql ="SELECT A.itravel, A.iuser, A.reg_dt,
                  B.title, B.reg_dt, B.mod_dt, B.area, B.location, B.main_img,
                  B.s_date, B.e_date, B.f_people, B.f_price, B.f_gender, B.f_age
           FROM t_travel_fav A
           INNER JOIN t_travel B
           ON A.itravel = B.itravel
           WHERE A.iuser = :iuser";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":iuser", $param["iuser"]);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function myPageHost(&$param)
  // mypage 호스팅한 여행 (title 뿌리기)
  {
    $sql = "SELECT * FROM t_user A
            INNER JOIN t_travel B
            ON A.iuser = B.iuser
            WHERE A.iuser = :iuser";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":iuser", $param["iuser"]);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function myPageTravelState(&$param)
  { // mypage 참여한 여행 (title 뿌리기)
    $sql = "SELECT * FROM t_travel_state A
            INNER JOIN t_travel B
            ON A.itravel = B.itravel
            WHERE A.iuser = :iuser";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":iuser", $param["iuser"]);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function myPageCmt(&$param)
  { // mypage 호스트 리뷰 (list 뿌리기)
    $sql =
      " SELECT A.*, B.itravel, B.title, C.nick, C.profile_img  FROM t_mypage_cmt A
        INNER JOIN t_travel B
        ON A.itravel = B.itravel
        INNER JOIN t_user C
        ON A.guest_iuser = C.iuser
        WHERE B.iuser = :iuser
      ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":iuser", $param["iuser"]);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function selGuestTravel(&$param){
    $sql =
    "SELECT A.*, B.iuser, B.title 
    FROM t_travel_state A
    INNER JOIN t_travel B
    ON A.itravel = B.itravel
    WHERE A.iuser = :loginIuser AND B.iuser = :iuser AND A.isconfirm = 1";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":loginIuser", $param["loginIuser"]);
    $stmt->bindValue(":iuser", $param["iuser"]);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function insMypageCmt(&$param)
  { // mypage cmt (호스트 유저에게 댓글 달기)
    $sql =
      "INSERT INTO t_mypage_cmt
       (itravel, guest_iuser, cmt)
       VALUES
       (:itravel, :guest_iuser, :cmt)
      ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":itravel", $param["itravel"]);
    $stmt->bindValue(":guest_iuser", $param["guest_iuser"]);
    $stmt->bindValue(":cmt", $param["cmt"]);
    $stmt->execute();
    return $stmt->rowCount();
  }
  /* mypage 끝 */

  // myaccountmod
  public function MyAccountMod(&$param)
  {
   $sql =
    "UPDATE t_user
      SET profile_img = :profile_img,
          email = :email,
          nm = :nm,
          nick = :nick,
          gender = :gender,
          birth = :birth,
          tel = :tel,
          cmt = :cmt
      WHERE iuser = :iuser
    ";
  $stmt = $this->pdo->prepare($sql);
  $stmt->bindValue(":profile_img", $param["profile_img"]);
  $stmt->bindValue(":email", $param["email"]);
  $stmt->bindValue(":nm", $param["nm"]);
  $stmt->bindValue(":nick", $param["nick"]);
  $stmt->bindValue(":gender", $param["gender"]);
  $stmt->bindValue(":birth", $param["birth"]);
  $stmt->bindValue(":tel", $param["tel"]);
  $stmt->bindValue(":cmt", $param["cmt"]);
  $stmt->bindValue(":iuser", $param["iuser"]);
  $stmt->execute();
  return $stmt->rowCount();
  }

  // ----------------- MyPage Fav ---------------
  public function selUserFav(&$param){
    $sql = "SELECT count(liked_iuser) AS FAV
    FROM t_user_fav WHERE liked_iuser = :liked_iuser";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":liked_iuser", $param["iuser"]);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function userFavgood(&$param) {
    $sql="INSERT INTO t_user_fav
    (liking_iuser,liked_iuser)
    VALUES
    (:liking_iuser,:liked_iuser)
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":liking_iuser", $param["liking_iuser"]);
    $stmt->bindValue(":liked_iuser", $param["liked_iuser"]);
    $stmt->execute();
    return $stmt->rowCount();
  }

  public function userFavDelete(&$param) {
    $sql="DELETE FROM t_user_fav
    WHERE liking_iuser = :liking_iuser
    AND liked_iuser = :liked_iuser";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":liking_iuser", $param["liking_iuser"]);
    $stmt->bindValue(":liked_iuser", $param["liked_iuser"]);
    $stmt->execute();
    return $stmt->rowCount();
  }

}
