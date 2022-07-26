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
}