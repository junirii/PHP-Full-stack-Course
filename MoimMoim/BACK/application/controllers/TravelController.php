<?php
namespace application\controllers;
use application\libs\application;
use application\models\TravelModel;
use Exception;

class TravelController extends Controller{
    // 리스트
    public function travelList() {
        $json = getJson();

        $param = [
            "arr_area" => $json["filter"]["selectedArea"],
            "location" => $json["filter"]["selectedLocation"],
            "s_date" => $json["filter"]["s_date"],
            "e_date" => $json["filter"]["e_date"],
            "f_people" => $json["filter"]["f_people"],
            "l_price" => $json["filter"]["l_price"],
            "h_price" => $json["filter"]["h_price"],
            "f_gender" => $json["filter"]["f_gender"],
            "f_age" => $json["filter"]["f_age"],
        ];
        return $this->model->travelList($param);
    }

    public function create() {
        $json = getJson();
        return [_RESULT => $this->model->travelInsert($json)];
    }

    // area list
    public function areaList() {
        return $this->model->areaList();
    }

    // gender List
    public function genderList() {
        return $this->model->genderList();
    }

    // people List
    public function peopleList() {
        return $this->model->peopleList();
    }

    // location list
    public function locationList() {
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 3) {
            exit();
        }        
        $param = [ "iarea" => $urlPaths[2] ];
        return $this->model->locationList($param);
    }
    
    // age List
    public function ageList() {
        return $this->model->ageList();
    }

    public function detail() {
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 3) {
            exit();
        }  
        $param = [
            "itravel" => intval($urlPaths[2])
        ];
        $hostUser = $this->model->selUserByItravel($param);
        $travelData = $this->model->selTravelByItravel($param);
        $day = $this->model->selDayByItravel($param);
        $ctnt = $this->model->selCtntByItravel($param);
        $joinPeople = $this->model->selJoinByItravel($param);
        
        $data = [
            "hostUser" => $hostUser,
            "day" => $day,
            "ctnt" => $ctnt,
            "travelData" => $travelData,
            "joinPeople" => $joinPeople,
        ];
        return [_RESULT => $data];
    }
    public function favDetail() {
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 3) {
            exit();
        }  
        $iuser = $urlPaths[2];
        $param = [
            "iuser" => $iuser,
        ];
        $favUser = $this->model->selTravelFav($param);

        $travelfav = [
            "favUser" => $favUser,
        ];
        return [_RESULT => $travelfav];
    }

    // 좋아요한 게시물
    public function travelFav() {
        $urlPaths = getUrlPaths();
        // if(count($urlPaths) !== 4) {
        //     exit();
        // }
        $iuser = $urlPaths[2];
        $param = [
            "iuser" => $iuser,
        ];
        switch (getMethod()) {
            case _GET:
                return [_RESULT => $this->model->selTravelFav($param)];
            case _POST:
                $itravel = $urlPaths[3];
                $param["itravel"] = $itravel;
                return [_RESULT => $this->model->TravelUserFav($param)];
            case _DELETE:
                $itravel = $urlPaths[3];
                $param["itravel"] = $itravel;
                return [_RESULT => $this->model->travelDeleteFav($param)];           
        }
    }

    public function TravelUserFav() {
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 3) {
            exit();
        }  
        $param = [
            "iuser" => intval($urlPaths[2])
        ];
        return [_RESULT => $this->model->TravelUserFav($param)];
    }

    public function travelDeleteFav() {
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 3) {
            exit();
        }  
        $param = [
            "iuser" => intval($urlPaths[2])
        ];
        return [_RESULT => $this->model->travelDeleteFav($param)];
    }

    public function insTravelAndCtnt(){
        switch (getMethod()) {
            case _POST:
                $json = getJson();
                $image_parts = explode(";base64,", $json["travel"]["main_img"]);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileNm = uniqid() . "." . $image_type;

                $param = [
                    "iuser" => $json["travel"]["iuser"],
                    "title" => $json["travel"]["title"],
                    "area" => $json["travel"]["area"],
                    "location" => $json["travel"]["location"],
                    "main_img" => $fileNm,
                    "s_date" => $json["travel"]["s_date"],
                    "e_date" => $json["travel"]["e_date"],
                    "f_people" => $json["travel"]["f_people"],
                    "f_price" => $json["travel"]["f_price"],
                    "f_gender" => $json["travel"]["f_gender"],
                    "f_age" => $json["travel"]["f_age"],
                ];
                $itravel = $this->model->travelInsert($param); //DB에 글 추가
                if($itravel){ //썸네일 사진 백엔드에 저장
                    $dirPath = _IMG_PATH . "/travel/" . $itravel . "/main";
                    $filePath = $dirPath . "/" . $fileNm;
                    if(!is_dir($dirPath)) {
                        mkdir($dirPath, 0777, true);
                    }
                    $result = file_put_contents($filePath, $image_base64);
                    if($result){ //ctnt 추가
                        for ($i=0; $i < count($json["ctnt"]); $i++) { 
                            for($z=0; $z < count($json["ctnt"][$i]); $z++){
                                $image_parts = explode(";base64,", $json["ctnt"][$i][$z]["img"]); //ctnt사진 저장
                                $image_type_aux = explode("image/", $image_parts[0]);
                                $image_type = $image_type_aux[1];
                                $image_base64 = base64_decode($image_parts[1]);
                                $dirPath = _IMG_PATH . "/travel/" . $itravel . "/detail";
                                $fileNm = uniqid() . "." . $image_type;
                                $filePath = $dirPath . "/" . $fileNm;
                                if(!is_dir($dirPath)) {
                                    mkdir($dirPath, 0777, true);
                                }
                                $result = file_put_contents($filePath, $image_base64);
                                if($result){
                                    $param = [
                                        "itravel" => $itravel,
                                        "day" => $json["ctnt"][$i][$z]["day"],
                                        "seq" => $json["ctnt"][$i][$z]["seq"],
                                        "ctnt" => $json["ctnt"][$i][$z]["ctnt"],
                                        "img" => $fileNm
                                    ];
                                    $this->model->insCtnt($param);
                                }
                            }
                        }
                        return [_RESULT => $itravel];
                    }
                }
        }
    }

    public function updTravelAndCtnt(){
        switch (getMethod()) {
            case _PUT:
                $json = getJson();

                //기존 메인 이미지 삭제
                $itravel = $json["params"]["itravel"];
                $param = ["itravel" => $itravel];
                $travelData = $this->model->selTravelByItravel($param);
                $ex_main_img = $travelData->main_img;
                $savedImg = _IMG_PATH . "/travel/" . $itravel . "/main/" . $ex_main_img;
                if(file_exists($savedImg)){
                    unlink($savedImg);
                }

                //새로운 메인 이미지 추가
                $image_parts = explode(";base64,", $json["params"]["travel"]["main_img"]);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileNm = uniqid() . "." . $image_type;

                $param = [
                    "iuser" => $json["params"]["travel"]["iuser"],
                    "title" => $json["params"]["travel"]["title"],
                    "area" => $json["params"]["travel"]["area"],
                    "location" => $json["params"]["travel"]["location"],
                    "main_img" => $fileNm,
                    "s_date" => $json["params"]["travel"]["s_date"],
                    "e_date" => $json["params"]["travel"]["e_date"],
                    "f_people" => $json["params"]["travel"]["f_people"],
                    "f_price" => $json["params"]["travel"]["f_price"],
                    "f_gender" => $json["params"]["travel"]["f_gender"],
                    "f_age" => $json["params"]["travel"]["f_age"],
                    "itravel" => $itravel
                ];
                if($this->model->updTravel($param)){ //썸네일 사진 백엔드에 저장
                    $dirPath = _IMG_PATH . "/travel/" . $itravel . "/main";
                    $filePath = $dirPath . "/" . $fileNm;
                    if(!is_dir($dirPath)) {
                        mkdir($dirPath, 0777, true);
                    }
                    $result = file_put_contents($filePath, $image_base64);
                    if($result){ //ctnt 추가
                        $param = ["itravel" => $itravel];
                        if($this->model->delCtntAll($param)){ //db 내 ctnt 삭제
                            $dir = _IMG_PATH . "/travel/" . $itravel . "/detail/";
                            LIB_removeAllData($dir); //백엔드 ctnt detail 이미지 삭제
                            for ($i=0; $i < count($json["params"]["ctnt"]); $i++) { 
                                for($z=0; $z < count($json["params"]["ctnt"][$i]); $z++){
                                    $image_parts = explode(";base64,", $json["params"]["ctnt"][$i][$z]["img"]); //ctnt사진 저장
                                    $image_type_aux = explode("image/", $image_parts[0]);
                                    $image_type = $image_type_aux[1];
                                    $image_base64 = base64_decode($image_parts[1]);
                                    $dirPath = _IMG_PATH . "/travel/" . $itravel . "/detail";
                                    $fileNm = uniqid() . "." . $image_type;
                                    $filePath = $dirPath . "/" . $fileNm;
                                    if(!is_dir($dirPath)) {
                                        mkdir($dirPath, 0777, true);
                                    }
                                    $result = file_put_contents($filePath, $image_base64);
                                    if($result){
                                        $param = [
                                            "itravel" => $itravel,
                                            "day" => $json["params"]["ctnt"][$i][$z]["day"],
                                            "seq" => $json["params"]["ctnt"][$i][$z]["seq"],
                                            "ctnt" => $json["params"]["ctnt"][$i][$z]["ctnt"],
                                            "img" => $fileNm
                                        ];
                                        $this->model->insCtnt($param);
                                    }
                                }
                            }
                        }
                        return [_RESULT => 1];
                    }
                }
        }
    }

    public function uploadMainImg() {
        // $itravel = 
        $json = getJson();
        $image_parts = explode(";base64,", $json["image"]);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $dirPath = _IMG_PATH . "/travel/" . $json["travel"]["iuser"] . "/main";
        $fileNm = uniqid() . "." . $image_type;
        $filePath = $dirPath . "/" . $fileNm;
        if(!is_dir($dirPath)) {
            mkdir($dirPath, 0777, true);
        }
        $result = file_put_contents($filePath, $image_base64);
        return [_RESULT => $result ? 1 : 0];
    }

    public function getPrice(){
        return [_RESULT => $this->model->getPrice()];
    }
    
    public function travelState() {
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 4) {
            exit();
        }  
        $iuser = $urlPaths[2];
        $itravel = $urlPaths[3];
        $param = [
            "iuser" => $iuser,
            "itravel" => $itravel
        ];
        switch (getMethod()) {
            case _GET:
                return [_RESULT => $this->model->seltravelState($param)];
            case _POST:
                return [_RESULT => $this->model->IntravelState($param)];
            case _DELETE:
                return [_RESULT => $this->model->DeletetravelState($param)];
        }
      }
 
    public function selRequest() // 신청 ??
    {
        // put update
        // get sel
        // del delte 
        switch (getMethod()) {
        case _DELETE:
            $urlPaths = getUrlPaths();
            if(count($urlPaths) !== 4) {
                exit();
            }
            $itravel = $urlPaths[2];
            $iuser = $urlPaths[3];
            $param = [
                "itravel" => $itravel,
                "iuser" => $iuser
            ];
            return [_RESULT => $this->model->DeletetravelState($param)];

        case _GET:
            $iuser = getIuser();
            $param = [
                "iuser" => $iuser
            ];
            return [_RESULT => $this->model->selState($param)];

        case _PUT:
            $json = getJson();
            $itravel = $json["params"]["itravel"];
            $iuser = $json["params"]["iuser"];
            $param = [
                "itravel" => $itravel,
                "iuser" => $iuser
            ];
            if(isset($json["params"]["isyes"])){
                if($json["params"]["isyes"]){
                    return [_RESULT => $this->model->updateState($param)];
                }else {
                    return [_RESULT => $this->model->refusalState($param)];
                }
            }else{
                return [_RESULT => $this->model->requestOk($param)];
            }
        }
    }

    public function selYesNo() {
        switch (getMethod()) {
        case _DELETE:
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 4) {
            exit();
        }  
        $itravel = $urlPaths[2];
        $iuser = $urlPaths[3];
        $param = [
            "itravel" => $itravel,
            "iuser" => $iuser
        ];
        return [_RESULT => $this->model->DeletetravelState($param)];

        case _PUT:
            $json = getJson();
            $itravel = $json["params"]["itravel"];
            $iuser = $json["params"]["iuser"];
            $param = [
                "itravel" => $itravel,
                "iuser" => $iuser
            ];
            if($json["params"]["isyes"]){
                return [_RESULT => $this->model->test($param)];
            }
        }
    }
    // del travel
    public function del() {
        $json = getJson();
        $param = [
            "itravel" => $json["params"]["itravel"],
        ];
        switch (getMethod()) {
            case _PUT:
                $result = $this->model->delTravel($param);
                if($result) {
                    return [_RESULT => 1];
                }
        }
    }

    public function getTravelData(){
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 3) {
            exit();
        }  
        $itravel = $urlPaths[2];
        $param = [
            "itravel" => $itravel
        ];
        return [_RESULT => $this->model->selTravelData($param)];
    }

    public function joiningTravel(){
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 3) {
            exit();
        }  
        $loginIuser = $urlPaths[2];
        $param = ["iuser" => $loginIuser];
        return [_RESULT => $this->model->selJoiningTravel($param)];
    }

    public function updIsConfirm(){
        switch (getMethod()) {
            case _PUT:
                $json = getJson();
                $param = [
                    "itravel" => $json["params"]["itravel"],
                    "iuser" => $json["params"]["loginIuser"]
                ];
                return [_RESULT => $this->model->updIsConfirm($param)];
        }
    }
}