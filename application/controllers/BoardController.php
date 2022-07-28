<?php
namespace application\controllers;
use application\libs\application;

class BoardController extends Controller{
    // 리스트
    public function boardList() {
        return $this->model->boardList();
    }

    public function create() {
        $json = getJson();
        print_r($json);
        return [_RESULT => $this->model->boardInsert($json)];
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
            "iboard" => intval($urlPaths[2])
        ];
        return $this->model->detail($param);
    }
}