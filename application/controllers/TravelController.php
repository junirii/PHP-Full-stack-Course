<?php
namespace application\controllers;
use application\libs\application;

class TravelController extends Controller{
    // 리스트
    public function travelList() {
        return $this->model->travelList();
    }

    public function create() {
        $json = getJson();
        print_r($json);
        return [_RESULT => $this->model->travelInsert($json)];
    }

    // area list
    public function areaList() {
        return $this->model->areaList();
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

    public function detail() {
        $urlPaths = getUrlPaths();
        $param = [
            "itravel" => intval($urlPaths[2])
        ];
        return $this->model->detail($param);
    }
    // 좋아요한 게시물
    public function travelFav() {
        $urlPaths = getUrlPaths();
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
                return [_RESULT => $this->model->travelDelteFav($param)];           
        }
    }

    public function TravelUserFav() {
        $urlPaths = getUrlPaths();
        $param = [
            "iuser" => intval($urlPaths[2])
        ];
        return [_RESULT => $this->model->TravelUserFav($param)];
    }

    public function travelDeleteFav() {
        $urlPaths = getUrlPaths();
        $param = [
            "iuser" => intval($urlPaths[2])
        ];
        return [_RESULT => $this->model->travelDeleteFav($param)];
    }
    
}
