<?php

namespace app\model\color;

class Color {

    private $id            = '';
    private $name_of_color = '';
    private $rgb           = '';
    private $created_at    = null;
    private $updated_at    = null;
    private $deleted_at    = null;


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
    public function getRgb(): string {

        return $this->rgb;
    }


    /**
     * @param string $rgb
     */
    public function setRgb(string $rgb): void {

        $this->rgb = $rgb;
    }


    /**
     * @return integer
     */
    public function getId(): int {

        return $this->id;
    }


    /**
     * @param integer $id
     */
    public function setId(int $id): void {

        $this->id = $id;
    }





    /**
     * @return null
     */
    public function getCreatedAt() {

        return $this->created_at;
    }


    /**
     * @param null $created_at
     */
    public function setCreatedAt($created_at): void {

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
    /**
     * @return string
     */
    public function getNameOfColor(): string {

        return $this->name_of_color;
    }


    /**
     * @param string $name_of_color
     */
    public function setNameOfColor(string $name_of_color): void {

        $this->name_of_color = $name_of_color;
    }
}
