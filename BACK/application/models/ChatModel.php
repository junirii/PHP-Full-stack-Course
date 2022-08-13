<?php

namespace application\models;

use PDO;

class ChatModel extends Model
{
  public function insChatRoom(&$param){
    $sql = 
    " INSERT INTO t_chat_room
      SET itravel = :itravel
        , iuser = :iuser
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":itravel", $param["itravel"]);
    $stmt->bindValue(":iuser", $param["iuser"]);
    $stmt->execute();
    return $stmt->rowCount();
  }

  public function insChatMsg(&$param){
    $sql = 
    " INSERT INTO t_chat_msg
      ( itravel, seq, iuser, msg )
      SELECT ?, (IFNULL(MAX(seq), 0) + 1), ?, ?
      FROM t_chat_msg
      WHERE itravel = ?
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(1, $param["itravel"]);
    $stmt->bindValue(2, $param["iuser"]);
    $stmt->bindValue(3, $param["msg"]);
    $stmt->bindValue(4, $param["itravel"]);
    $stmt->execute();
    return $stmt->rowCount();
  }

  public function selChatList(&$param){
    $sql = 
    " SELECT A.*, B.nick as name FROM t_chat_msg A
      INNER JOIN t_user B
      ON A.iuser = B.iuser
      WHERE itravel = :itravel
      ORDER BY seq
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":itravel", $param["itravel"]);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function selChatUser(&$param){
    $sql = 
    " SELECT A.*, B.nick FROM t_chat_room A
      INNER JOIN t_user B
      ON A.iuser = B.iuser
      WHERE itravel = :itravel
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":itravel", $param["itravel"]);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function selChatRooms(&$param){
    $sql = 
    " SELECT E.*, F.lastMsg FROM
		  (SELECT A.*, B.title FROM t_chat_room A
      INNER JOIN t_travel B
      ON A.itravel = B.itravel
      WHERE A.iuser = :iuser) E
      LEFT JOIN (SELECT C.*, D.msg AS lastMsg FROM (SELECT itravel, MAX(seq) AS maxseq FROM t_chat_msg GROUP BY itravel) C
      INNER JOIN t_chat_msg D
      ON C.maxseq = D.seq
      AND C.itravel = D.itravel) F
      ON E.itravel = F.itravel
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":iuser", $param["iuser"]);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function exitChatRoom(&$param){
    $sql = 
    " DELETE FROM t_chat_room
      WHERE itravel = :itravel
      AND iuser = :loginIuser
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":itravel", $param["itravel"]);
    $stmt->bindValue(":loginIuser", $param["loginIuser"]);
    $stmt->execute();
    return $stmt->rowCount();
  }
}