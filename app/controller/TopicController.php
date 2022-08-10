<?php

namespace app\controller;

use app\model\topic\TopicModel;

class TopicController extends BaseController {

    public function index() {

        $topicModel = new TopicModel();

        $data = [
            'allTopics' => $topicModel->GetAllTopics()
        ];

        $this->render('index/index', $data ?? []);
    }

}
