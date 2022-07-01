<?php
namespace application\models;
use PDO;


//$pdo -> lastInsertId();

class UserModel extends Model {
    public function insUser(&$param) {
        $sql = "INSERT INTO t_user
                ( email, pw, nm ) 
                VALUES 
                ( :email, :pw, :nm )";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":email", $param["email"]);
        $stmt->bindValue(":pw", $param["pw"]);
        $stmt->bindValue(":nm", $param["nm"]);
        $stmt->execute();
        return $stmt->rowCount();
    }
    public function selUser(&$param) {
        $sql = "SELECT * FROM t_user
                WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":email", $param["email"]);        
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
    public function selUserProfile(&$param) {
        $feedIuser = $param["feedIuser"];
        $loginIuser = $param["loginIuser"];
        $sql = "SELECT iuser, email, nm, cmt, mainimg
                       , (SELECT COUNT(ifeed) FROM t_feed WHERE iuser = $feedIuser) AS feedcnt
                       , (SELECT COUNT(fromiuser) FROM t_user_follow WHERE fromiuser = $feedIuser AND toiuser = $loginIuser) AS youme
		               , (SELECT COUNT(fromiuser) FROM t_user_follow WHERE fromiuser = $loginIuser AND toiuser = $feedIuser) AS meyou
                  FROM t_user
                 WHERE iuser = $feedIuser";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}