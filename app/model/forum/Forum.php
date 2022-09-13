<?php

namespace app\model\forum;

use app\model\GeneralEntity;
use DateTime;

class Forum implements GeneralEntity {
    private $id         = 0;
    private $title      = '';
    private $content    = '';
    private $userId      = '';
    private $created_at = '';
    private $updated_at = '';
    private $deleted_at = '';
    private $img='';
    private $small_content='';

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
    public function getTitle(): string {

        return $this->title;
    }


    /**
     * @param string $title
     */
    public function setTitle(string $title): void {

        $this->title = $title;
    }


    /**
     * @return string
     */
    public function getContent(): string {

        return $this->content;
    }


    /**
     * @param string $content
     */
    public function setContent(string $content): void {

        $this->content = $content;
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
    public function getImg(): string {

        return $this->img;
    }


    /**
     * @param string $img
     */
    public function setImg(string $img): void {

        $this->img = $img;
    }


    /**
     * @return string
     */
    public function getSmallContent(): string {

        return $this->small_content;
    }


    /**
     * @param string $small_content
     */
    public function setSmallContent(string $small_content): void {

        $this->small_content = $small_content;
    }


    /**
     * @return string
     */
    public function getUserId(): string {

        return $this->userId;
    }


    public function setUserId(string $userId): void {

        $this->userId = $userId;
    }


    /**
     * @param string $userId
     */
}
