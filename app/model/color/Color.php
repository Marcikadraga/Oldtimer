<?php

namespace app\model\color;

use DateTime;

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
     * @return null
     */
    public function getUpdatedAt() {

        return $this->updated_at;
    }


    /**
     * @param DateTime|null $updated_at
     */
    public function setUpdatedAt($updated_at): void {

        if ($updated_at instanceof DateTime) {
            $this->updated_at = $updated_at->format('Y-m-d H:i:s');
        } else {
            $this->updated_at = null;
        }
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
