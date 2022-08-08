<?php

namespace application\models;

use PDO;

class TravelModel extends Model
{
    // 리스트 
    public function travelList(&$param)
    {
        $f_age = $param["f_age"];
        $f_gender = $param["f_gender"];
        $f_people = $param["f_people"];
        $l_price = $param["l_price"];
        $h_price = $param["h_price"];
        $s_date = $param["s_date"];
        $e_date = $param["e_date"];
        $arr_area = $param["arr_area"];

        $sql = "SELECT * 
            FROM t_travel A
            INNER JOIN t_user B
            ON A.iuser = B.iuser";
        if($f_age > 0){ //나이
            $sql .= " WHERE A.f_age = {$f_age}";
        }
        if($f_gender > 0){ //성별
            $sql .= " AND A.f_gender = {$f_gender}";
        }
        if($f_people >= 2 && $f_people < 8){ //인원
            $sql .= " AND A.f_people = {$f_people}";
        }else if($f_people === 8){
            $sql .= " AND A.f_people >= 8";
        }
        if($l_price <= $h_price){ //비용
            $sql .= " AND A.f_price >= {$l_price} AND A.f_price <= {$h_price}";
        }
        if($s_date < $e_date){ //기간
            $sql .= " AND A.s_date >= '{$s_date}' AND A.e_date <= '{$e_date}'";
        }
        if(count($arr_area) > 0){ //지역
            if(count($arr_area) === 1){
                $sql .= " AND A.area = {$arr_area[0]}";
            }else{
                for ($i=0; $i < count($arr_area); $i++) { 
                    if($i === 0){
                        $sql .= " AND (A.area = {$arr_area[$i]}";
                    }else{
                        $sql .= " OR A.area = {$arr_area[$i]}";
                    }
                }
                $sql .= ")";
            }
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // filter list
    public function travelFilterList(&$param)
    {
        $f_area = $param["area"];
        $f_location = $param["location"];
        $s_date = $param["s_date"];
        $e_date = $param["e_date"];
        $f_people = $param["people"];
        $f_gender = $param["gender"];
        $f_age = $param["age"];
        $l_price = $param["l_price"];
        $h_price = $param["h_price"];

        $sql = "SELECT * 
                FROM t_travel A
                INNER JOIN t_user B
                ON A.iuser = B.iuser";
        if($f_area > 0) {
            $sql .= " WHERE A.area = $f_area";
        }
        if($f_location > 0) {
            $sql .= " AND A.location = $f_location";
        }
        if($f_age > 0) {
            $sql .= " AND A.f_age = $f_age";
        }
        if($f_gender > 0) {
            $sql .= " AND A.f_gender = $f_gender";
        }
        if($f_people >= 2 && $f_people < 8) {
            $sql .= " AND A.f_people = {$f_people}";
        }else if($f_people >= 8){
            $sql .= " AND A.f_people >= 8";
        }
        if($l_price <= $h_price) {
            $sql .= " AND A.f_price >= $l_price AND A.f_price <= $h_price";
        }
        if($s_date < $e_date) {
            $sql .= " AND A.s_date >= '$s_date' AND A.e_date <= '$e_date'";
        }
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

    // age list
    public function ageList()
    {
        $sql = "SELECT * FROM t_age";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function travelInsert(&$param)
    {
        $sql = "INSERT INTO t_travel
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
            $location = $param["location"];
            $sql .= ", location = ${location}";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->bindValue(":title", $param["title"]);
        $stmt->bindValue(":area", $param["area"]);
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
    public function selTravelByItravel(&$param){
        $sql = "SELECT * FROM t_travel
        WHERE itravel = :itravel";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":itravel", $param["itravel"]);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function selUserByItravel(&$param){
        $sql = "SELECT * FROM t_user
        WHERE iuser = 
        (SELECT iuser FROM t_travel
        WHERE itravel = :itravel)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":itravel", $param["itravel"]);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function selDayByItravel(&$param){
        $sql = "SELECT day FROM t_travel_ctnt
        WHERE itravel = :itravel
        GROUP BY DAY";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":itravel", $param["itravel"]);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function selCtntByItravel(&$param){
        $sql = "SELECT * FROM t_travel_ctnt
        WHERE itravel = :itravel
        ORDER BY DAY";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":itravel", $param["itravel"]);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    // 좋아요 한 게시물
    public function selTravelFav(&$param){
        $sql = "SELECT * FROM t_travel_fav WHERE iuser = :iuser";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ); // 여러 값 fetchAll (SELECT)
    }
    // 좋아요
    public function TravelUserFav(&$param) {
        $sql="INSERT INTO t_travel_fav
        (itravel,iuser)
        VALUES
        (:itravel,:iuser)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":itravel", $param["itravel"]);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->execute();
        return $stmt->rowCount(); // 값이 한개 추가될때 
    }
    // 좋아요 취소 
    public function travelDeleteFav(&$param) {
        $sql="DELETE FROM t_travel_fav 
        WHERE itravel=:itravel AND iuser=:iuser";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":itravel", $param["itravel"]);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->execute();
        return $stmt->rowCount(); // 값이 한개 추가될때 
    }
}