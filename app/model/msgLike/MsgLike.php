<?php

namespace app\model\msgLike;

class MsgLike{
    private $id =0;
    private $comment_id='';
    private $user_id='';

    public function __construct(?array $data = null) {

        $this->fill($data);
    }


    public function fill(?array $data = null): void {

        if (!is_null($data)) {
            foreach ($this as $key => $value) {
                if (array_key_exists($key, $data)) {
                    $this->{$key} = $data[$key];
                }
            }
        }
    }


    /**
     * @return int
     */
    public function getId(): int {

        return $this->id;
    }


    /**
     * @param int $id
     */
    public function setId(int $id): void {

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
    public function getUserId(): string {

        return $this->user_id;
    }


    /**
     * @param string $user_id
     */
    public function setUserId(string $user_id): void {

        $this->user_id = $user_id;
    }
}
