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
        $location = $param["location"];

        $sql = "SELECT * 
            FROM t_travel A
            INNER JOIN t_user B
            ON A.iuser = B.iuser
            INNER JOIN t_area C
            ON A.area = C.iarea
            LEFT JOIN t_location D
            ON A.location = D.ilocation";
        if($l_price <= $h_price){ //비용
            $sql .= " WHERE A.f_price >= {$l_price} AND A.f_price <= {$h_price}";
        }
        if($f_age > 0){ //나이
            $sql .= " AND A.f_age = {$f_age}";
        }
        if($f_gender > 0){ //성별
            $sql .= " AND A.f_gender = {$f_gender}";
        }
        if($f_people >= 2 && $f_people < 8){ //인원
            $sql .= " AND A.f_people = {$f_people}";
        }else if($f_people === 8){
            $sql .= " AND A.f_people >= 8";
        }
        if($s_date < $e_date){ //기간
            $sql .= " AND A.s_date >= '{$s_date}' AND A.e_date <= '{$e_date}'";
        }
        if(count($arr_area) > 0){ //지역
            if(count($arr_area) === 1) {
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
        if($location > 0) {
            $sql .= " AND A.location = $location";
        }
        $sql .= " ORDER BY A.reg_dt DESC"; // 리스트 띄우는 순서 : 등록일수 역순
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
    //travel 추가
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
    //ctnt 추가
    public function insCtnt(&$param){
        $sql = "INSERT INTO t_travel_ctnt
                SET itravel = :itravel
                  , day = :day
                  , seq = :seq
                  , ctnt = :ctnt
                  , img = :img";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":itravel", $param["itravel"]);
        $stmt->bindValue(":day", $param["day"]);
        $stmt->bindValue(":seq", $param["seq"]);
        $stmt->bindValue(":ctnt", $param["ctnt"]);
        $stmt->bindValue(":img", $param["img"]);
        $stmt->execute();
        return $stmt->rowCount();
    }

    // 디테일
    public function selTravelByItravel(&$param){
        $sql = "SELECT * FROM t_travel A
        INNER JOIN t_area B
        ON A.area = B.iarea
        INNER JOIN t_location C
        ON A.location = C.ilocation
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

    // 신청하기
    public function seltravelState($param){
        $sql = "SELECT count(*) as tts FROM t_travel_state 
        WHERE iuser = :iuser
        AND itravel = :itravel";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->bindValue(":itravel", $param["itravel"]);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function IntravelState(&$param) { // 신청 
        $sql="INSERT INTO t_travel_state
        (iuser,itravel,isconfirm)
        VALUES
        (:iuser,:itravel, 0)
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->bindValue(":itravel", $param["itravel"]);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function DeletetravelState($param) { // 신청 취소
        $sql="DELETE FROM t_travel_state
        WHERE iuser = :iuser
        AND itravel = :itravel";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->bindValue(":itravel", $param["itravel"]);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function updateState(&$param) { // 신청 수락
        $sql="UPDATE t_travel_state 
        SET isconfirm = 1
        WHERE iuser = :iuser
        AND itravel = :itravel";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->bindValue(":itravel", $param["itravel"]);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function refusalState(&$param) { // 신청 거절
        $sql="UPDATE t_travel_state 
        SET 
        isconfirm = 3,
        isnew =1
        WHERE iuser = :iuser
        AND itravel = :itravel";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->bindValue(":itravel", $param["itravel"]);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function selState(&$param) { // 헤더 알림
        $sql="SELECT A.*, B.*, C.iuser AS loginIuser,C.title 
        FROM t_travel_state A
        INNER JOIN t_user B
        ON A.iuser = B.iuser
        INNER JOIN t_travel C
        ON A.itravel = C.itravel
        WHERE A.isconfirm = 0
        AND C.iuser = :iuser";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function refusalTell(&$param) { // 거절 알림
        $sql="SELECT A.*, B.*, C.iuser AS loginIuser,C.title 
        FROM t_travel_state A
        INNER JOIN t_user B
        ON A.iuser = B.iuser
        INNER JOIN t_travel C
        ON A.itravel = C.itravel
        WHERE A.isnew = 1
        AND A.iuser = :iuser";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function agreeTell(&$param) { // 수락 알림
        $sql="SELECT A.*, B.*, C.iuser AS loginIuser,C.title 
        FROM t_travel_state A
        INNER JOIN t_user B
        ON A.iuser = B.iuser
        INNER JOIN t_travel C
        ON A.itravel = C.itravel
        WHERE A.isconfirm = 1 
        AND A.iuser = :iuser";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function selIsJoin(&$param){
        $sql = 
        " SELECT count(*) as isChat FROM t_travel_state
          WHERE iuser = :iuser
          AND itravel = :itravel
          AND isconfirm = 1
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->bindValue(":itravel", $param["itravel"]);
    }
    
    public function getPrice(){
        $sql = 
        " SELECT max(f_price) as max, min(f_price) as min
          FROM t_travel
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}