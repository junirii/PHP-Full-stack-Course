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

    public function detail() {
        $urlPaths = getUrlPaths();
        $param = [
            "iboard" => intval($urlPaths[2])
        ];
        return $this->model->detail($param);
    }
    // 좋아요한 게시물
    public function boardFav() {
        $urlPaths = getUrlPaths();
        $iuser = $urlPaths[2];
        $param = [
            "iuser" => $iuser,
        ];
        switch (getMethod()) {
            case _GET:
                return [_RESULT => $this->model->selBoardFav($param)];
            case _POST:
                $iboard = $urlPaths[3];
                $param["iboard"] = $iboard;
                return [_RESULT => $this->model->BoardUserFav($param)];
            case _DELETE:
                $iboard = $urlPaths[3];
                $param["iboard"] = $iboard;
                return [_RESULT => $this->model->boardDelteFav($param)];           
        }
    }

    public function BoardUserFav() {
        $urlPaths = getUrlPaths();
        $param = [
            "iuser" => intval($urlPaths[2])
        ];
        return [_RESULT => $this->model->BoardUserFav($param)];
    }

    public function boardDeleteFav() {
        $urlPaths = getUrlPaths();
        $param = [
            "iuser" => intval($urlPaths[2])
        ];
        return [_RESULT => $this->model->boardDeleteFav($param)];
    }
    
}
