<?php

namespace app\model\topic;

class Topic {

    private $id         = 0;
    private $title      = '';
    private $content    = '';
    private $owner      = '';
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


    public function checkIsValidInsert(): bool {

        $this->errors = [];

        if (mb_strlen($this->title) < 3) {
            $this->errors['title'] = 'A cím hossza legalább 3 karakter hosszúnak kell lennie!';
        }
        if (empty($this->title)) {
            $this->errors['title'] = 'A cím megadása kötelező';
        }
        if (mb_strlen($this->content) < 3) {
            $this->errors['content'] = 'A tartalom hossza legalább 3 karakter hosszúnak kell lennie!';
        }
        if (empty($this->title)) {
            $this->errors['content'] = 'A tartalom megadása kötelező';
        }
        if (empty($this->owner)) {
            $this->errors['owner'] = 'A tulajdonos megadása kötelező';
        }
        return (empty($this->errors));
    }


    public function checkIsValidUpdate(): bool {

        $this->errors = [];

        $this->checkIsValidInsert();

        if (empty($this->id)) {
            $this->errors['id'] = 'Hiba! Az entitás id-ja üres.';
        }

        return empty($this->errors);
    }


    public function checkIsValidSave(): bool {

        if (empty($this->id)) {
            return $this->checkIsValidInsert();
        } else {
            return $this->checkIsValidUpdate();
        }
    }


    public function getErrors(): array {

        return $this->errors;
    }


    public function getErrorsAsString($separator = '<br>'): string {

        return implode($separator, $this->errors);
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
     * @return string|null
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
     * @return string|null
     */
    public function getOwner(): ?string {

        return $this->owner;
    }


    /**
     * @param string $owner
     */
    public function setOwner(string $owner): void {

        $this->owner = $owner;
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
}
