<?php

namespace application\models;

use PDO;

class BoardModel extends Model
{
    // 리스트 
    public function boardList()
    {
        $sql = "SELECT * 
            FROM t_board A
            INNER JOIN t_user B
            ON A.iuser = B.iuser";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // area list
    public function areaList()
    {
        $sql = "SELECT * FROM t_area";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // location list
    public function locationList(&$param)
    {
        $sql = "SELECT * FROM t_area A
        LEFT JOIN t_location B
        ON A.iarea = B.iarea
        WHERE A.iarea = :iarea";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iarea", $param["iarea"]);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function boardInsert(&$param)
    {
        $sql = "INSERT INTO t_board
                SET iuser = :iuser
                  , title = :title
                  , area = :area
                  , main_img = :main_img
                  , s_date = :s_date
                  , e_date = :e_date
                  , f_people = :f_people
                  , f_price = :f_price
                  , f_gender = :f_gender
                  , f_age = :f_age";
        if(isset($param["location"])) {
            $sql .= ", location = :location";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->bindValue(":title", $param["title"]);
        $stmt->bindValue(":area", $param["area"]);
        $stmt->bindValue(":location", $param["location"]);
        $stmt->bindValue(":main_img", $param["main_img"]);
        $stmt->bindValue(":s_date", $param["s_date"]);
        $stmt->bindValue(":e_date", $param["e_date"]);
        $stmt->bindValue(":f_people", $param["f_people"]);
        $stmt->bindValue(":f_price", $param["f_price"]);
        $stmt->bindValue(":f_gender", $param["f_gender"]);
        $stmt->bindValue(":f_age", $param["f_age"]);
        $stmt->execute();
        return intval($this->pdo->lastInsertId());
    }
    // 디테일
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
        return $stmt->fetch(PDO::FETCH_OBJ); // 행을 하나만 가져오는것  fetch = SELECT 
    }
    // 좋아요 한 게시물
    public function selBoardFav(&$param){
        $sql = "SELECT * FROM t_board_fav WHERE iuser = :iuser";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ); // 여러 값 fetchAll (SELECT)
    }
    // 좋아요
    public function BoardUserFav(&$param) {
        $sql="INSERT INTO t_board_fav
        (iboard,iuser)
        VALUES
        (:iboard,:iuser)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iboard", $param["iboard"]);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->execute();
        return $stmt->rowCount(); // 값이 한개 추가될때 
    }
    // 좋아요 취소 
    public function boardDelteFav(&$param) {
        $sql="DELETE FROM t_board_fav 
        WHERE iboard=:iboard AND iuser=:iuser";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iboard", $param["iboard"]);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->execute();
        return $stmt->rowCount(); // 값이 한개 추가될때 
    }
}
