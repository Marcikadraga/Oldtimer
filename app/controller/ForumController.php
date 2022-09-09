<?php

namespace app\controller;

use app\core\logger\SystemLog;
use app\model\comment\Comment;
use app\model\comment\CommentModel;
use app\model\forum\Forum;
use app\model\forum\ForumModel;
use app\model\user\Authenticator;
use DateTime;
use Exception;
use Throwable;

class ForumController extends BaseController {

    public function showView($id) {

        $forumModel = new ForumModel();
        $commentModel = new CommentModel();
        $forum = new Forum();
        $topic = $forumModel->getTopic($id);
//        $allComment = $commentModel->getCommentsById($id);
        $comments = $commentModel->getComments();

        $data = [
            'topic'      => $topic,
//            'allComment' => $allComment,
            'pageId'     => $id,
            'forum'      => $forum,
            'comments'   => $comments,
        ];

        $this->render('forum/index', $data);
    }


    public function insert() {

        //$this->checkAjax();
        $this->checkPermission('admin');

        $errors = [];
        $errorMsg = '';
        $successMsg = '';
        $comment = new Comment();
        $commentModel = new CommentModel();

        if ($this->request->isPostRequest()) {
            try {

                $userId = $this->request->getPost('user-id', FILTER_SANITIZE_SPECIAL_CHARS);
                $topicId = $this->request->getPost('topic-id', FILTER_SANITIZE_SPECIAL_CHARS);
                $message = $this->request->getPost('message', FILTER_SANITIZE_SPECIAL_CHARS);

                $user = new Authenticator();
                $forumModel = new ForumModel();

                if ($userId != $user->getUserId()) {
                    $errors['userId'] = 'Nem egyezik meg a userID';
                }

                if (empty($message)) {
                    $errors['message'] = 'Üres üzenetet nem küldhetsz be.';
                }

                $comment->setMessage($message);
                $comment->setTopicId($topicId);
                $comment->setUserId($userId);
                $comment->setCreatedAt(new DateTime());

                if (!empty($errors)) {
                    throw new Exception('Kérjük ellenőrizze az űrlapot!');
                }

                $commentModel->insert($comment);

            } catch (Throwable $exception) {
                $log = new SystemLog();
                $log->exceptionLog($exception);
                echo json_encode($exception->getMessage(), JSON_UNESCAPED_UNICODE);
            }
        }
        $data['errors'] = $errors;
        $data['errorMsg'] = $errorMsg;
        $data['successMsg'] = $successMsg;
        $data['submitted'] = true;

        $this->response->redirect("/forumController/showView/$topicId", 200);
    }
}
