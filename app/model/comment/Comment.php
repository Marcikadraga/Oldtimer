<?php

namespace app\model\comment;

use DateTime;

class Comment {

    private $id      = '';
    private $topic_id = '';
    private $user_id='';
    private $real_name='';
    private $message='';
    private $created_at = '';
    private $updated_at = null;
    private $deleted_at = null;

    private $is_liked = 0; // a belépet user likeolta-e a kommentet, több táblás lekérdezés
    private $is_disliked=0;// a belépet user dislikeolta-e a kommentet, több táblás lekérdezés

    public function isLikedByCurrentUser():bool{
        return $this->is_liked == 1;
    }

    public function isDislikedCurrentUser():bool{
        return $this->is_disliked==1;
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
     * @param DateTime|null $created_at
     */
    public function setCreatedAt($created_at): void {

        if ($created_at instanceof DateTime) {
            $this->created_at = $created_at->format('Y-m-d H:i:s');
        } else {
            $this->created_at = null;
        }
    }




    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string {

        return $this->updated_at;
    }


    /**
     * @param string $updated_at
     */
    public function setUpdatedAt(string $updated_at): void {

        $this->updated_at = $updated_at;
    }


    /**
     * @return string|null
     */
    public function getDeletedAt(): ?string {

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


    /**
     * @return string
     */
    public function getRealName(): string {

        return $this->real_name;
    }


    /**
     * @param string $real_name
     */
    public function setRealName(string $real_name): void {

        $this->real_name = $real_name;
    }


}
