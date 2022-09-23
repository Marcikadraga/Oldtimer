<?php

namespace app\controller;

use app\core\logger\SystemLog;
use app\model\comment\Comment;
use app\model\comment\CommentModel;
use app\model\forum\Forum;
use app\model\forum\ForumModel;
use app\model\msgLike\MsgLikeModel;
use app\model\reply\Reply;
use app\model\reply\ReplyModel;
use app\model\user\Authenticator;
use app\model\user\UserModel;
use DateTime;
use Exception;
use Throwable;

class ForumController extends BaseController {

    public function showView($id) {

        $auth = new Authenticator();
        $forumModel = new ForumModel();
        $commentModel = new CommentModel();
        $forum = new Forum();
        $topic = $forumModel->getTopic($id);
        $comments = $commentModel->getComment($id, $auth->getUserId());
        $numberOfComments = $commentModel->getNumberOfComments($id);
        $msgLikeModel = new MsgLikeModel();
        $replyModel = new ReplyModel();
        $allReply = $replyModel->getAllreply($id);
        $userModel = new UserModel();





        $data = [
            'topic'            => $topic,
            'pageId'           => $id,
            'forum'            => $forum,
            'comments'         => $comments,
            'numberOfComments' => $numberOfComments,
            'auth'             => $auth,
            'msgLikeModel'     => $msgLikeModel,
            'allReply'         => $allReply,
            'userModel'        => $userModel,

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


    public function delete() {

        $commentId = $this->request->getPost('commentId', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($commentId)) {
            throw new Exception('Hiba! A comment azonosítója nem elérhető.');
        }

        $commentModel = new CommentModel();
        $result = $commentModel->delete($commentId);

        if ($result) {
            echo json_encode("success");
            return;
        }
        echo json_encode("error");
    }


    public function getComment() {

        $this->checkPermission('admin');

        $commentModel = new CommentModel();

        $result = $commentModel->getCommentById($this->request->getPost('commentId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        if ($result) {
            echo json_encode($result);
            return;
        }

        echo json_encode("error");
    }


    public function update() {

        $this->checkAjax();
        $this->checkPermission('admin');

        try {

            $id = $this->request->getPost('id', FILTER_SANITIZE_SPECIAL_CHARS);
            if (empty($id)) {
                throw new Exception('Nincs id');
            }
            $commentModel = new CommentModel();
            $comment = $commentModel->getById($id);

            if (empty($comment)) {
                throw new Exception('Nem létezik ilyen comment');
            }

            $comment->setMessage($this->request->getPost('message', FILTER_SANITIZE_SPECIAL_CHARS));

            if (!$commentModel->update($comment)) {
                throw new Exception('Hiba a mentés során');
            }

            echo json_encode('success');

        } catch (Throwable $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
            echo json_encode($exception->getMessage(), JSON_UNESCAPED_UNICODE);
        }
        return true;
    }

}
