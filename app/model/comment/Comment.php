<?php

namespace app\model\comment;

class Comment {

    private $id      = '';
    private $topic_id = '';
    private $user_id='';
    private $message='';
    private $created_at = '';
    private $updated_at = '';
    private $deleted_at = '';

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


    /**
     * @return string
     */
    public function getId(): string {

        return $this->id;
    }


    /**
     * @return string
     */
    public function getMessage(): string {

        return $this->message;
    }


    /**
     * @param string $message
     */
    public function setMessage(string $message): void {

        $this->message = $message;
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
     * @return string
     */
    public function getUpdatedAt(): string {

        return $this->updated_at;
    }


    /**
     * @param string $updated_at
     */
    public function setUpdatedAt(string $updated_at): void {

        $this->updated_at = $updated_at;
    }


    /**
     * @return string
     */
    public function getDeletedAt(): string {

        return $this->deleted_at;
    }


    /**
     * @param string $deleted_at
     */
    public function setDeletedAt(string $deleted_at): void {

        $this->deleted_at = $deleted_at;
    }




    /**
     * @return string
     */
    public function getTopicId(): string {

        return $this->topic_id;
    }


    /**
     * @param string $topic_id
     */
    public function setTopicId(string $topic_id): void {

        $this->topic_id = $topic_id;
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
