<?php

namespace app\model\reply;

use app\model\user\UserModel;

class Reply {

    private $id         = '';
    private $comment_id = '';
    private $reply      = '';
    private $user_id    = '';
    private $created_at = '';
    private $updated_at = null;
    private $deleted_at = null;


    public function fill(?array $data = null): void {

        if (!is_null($data)) {
            foreach ($this as $key => $value) {
                if (array_key_exists($key, $data)) {
                    $this->{$key} = $data[$key];
                }
            }
        }
    }


    public function __construct(?array $data = null) {

        $this->fill($data);
    }


    //TODO miii
    public function getUserName() {

        $userModel = new UserModel();
        $user = $userModel->getById($this->user_id);
        if (empty($user)) {
            return '';
        }
        return $user->getUsername();
    }


//    public function getlengthOfReply(){
//
//        $replyModel = new ReplyModel();
//        return $replyModel->getReplysLength($this->comment_id);
//
//    }


    /**
     * @return string
     */
    public function getUserId(): string {

        return $this->user_id;
    }


    /**
     * @param string $user_id
     */
    public function setUserId(string $user_id): void {

        $this->user_id = $user_id;
    }


    /**
     * @return string
     */
    public function getReply(): string {

        return $this->reply;
    }


    /**
     * @param string $reply
     */
    public function setReply(string $reply): void {

        $this->reply = $reply;
    }


    /**
     * @return string
     */
    public function getId(): string {

        return $this->id;
    }


    /**
     * @param string $id
     */
    public function setId(string $id): void {

        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getCommentId(): string {

        return $this->comment_id;
    }


    /**
     * @param string $comment_id
     */
    public function setCommentId(string $comment_id): void {

        $this->comment_id = $comment_id;
    }


    /**
     * @return string
     */
    public function getCreatedAt(): string {

        return $this->created_at;
    }


    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void {

        $this->created_at = $created_at;
    }


    /**
     * @return null
     */
    public function getUpdatedAt() {

        return $this->updated_at;
    }


    /**
     * @param null $updated_at
     */
    public function setUpdatedAt($updated_at): void {

        $this->updated_at = $updated_at;
    }


    /**
     * @return null
     */
    public function getDeletedAt() {

        return $this->deleted_at;
    }


    /**
     * @param null $deleted_at
     */
    public function setDeletedAt($deleted_at): void {

        $this->deleted_at = $deleted_at;
    }

}
