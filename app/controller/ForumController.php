<?php

namespace app\controller;

use app\model\comment\CommentModel;
use app\model\forum\ForumModel;
use app\model\user\UserModel;

class ForumController extends BaseController {

    public function showView($id) {
        $forumModel=new ForumModel();
        $commentModel= new CommentModel();

        $data=[
            'forum'=>$forumModel->getTopic($id),
            'chiefComments'=>$commentModel->getCommentsById($id),
            'pageId'=>$id,
        ];

        $this->render('forum/view',$data);
    }
}
