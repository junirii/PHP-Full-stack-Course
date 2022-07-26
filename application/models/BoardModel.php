<?php
namespace application\models;
use PDO;

class BoardModel extends Model {
    // 리스트 
    public function boardList() {
        $sql="SELECT * 
        FROM t_board A
        INNER JOIN t_user B
        ON A.iuser = B.iuser";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // area list
    public function areaList() {
        $sql = "SELECT * FROM t_area";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // // location list
    public function locationList() {
        $sql = "SELECT * FROM t_location";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    // HOST 모집글 작성
    public function boardInsert(&$param) {
        $sql = "INSERT INTO t_board
                SET iuser = :iuser
                  , title = :title
                  , ctnt = :ctnt
                  , area = :area
                  , main_img = :main_img
                  , s_date = :s_date
                  , e_date = :e_date";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->bindValue(":title", $param["title"]);
        $stmt->bindValue(":ctnt", $param["ctnt"]);
        $stmt->bindValue(":area", $param["area"]);
        $stmt->bindValue(":main_img", $param["main_img"]);
        $stmt->bindValue(":s_date", $param["s_date"]);
        $stmt->bindValue(":e_date", $param["e_date"]);
        $stmt->execute();
        return intval($this->pdo->lastInsertId());
    }

    public function detail(&$param) {
        $sql="SELECT *
        FROM t_board A
        INNER JOIN t_board_ctnt B
        ON A.iboard = B.iboard
        INNER JOIN t_board_img C
        ON A.iboard = C.iboard
        INNER JOIN t_user D
        ON A.iuser = D.iuser
        WHERE A.iboard = :iboard";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iboard", $param["iboard"]);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}