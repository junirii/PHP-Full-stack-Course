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
}