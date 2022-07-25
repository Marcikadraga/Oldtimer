<?php

namespace app\model\car;

use app\model\user\UserModel;
use DateTime;

class Car {

    private const TYPEOFFUEL = [
        0 => 'benzin',
        1 => 'dízel'
    ];
    private const CONDITION  = [
        0 => 'leharcolt',
        1 => 'megkímélt',
        2 => 'felújított'
    ];
    protected $errors = [];
    private $id                  = '';
    private $type                = '';
    private $color               = '';
    private $kilometers_traveled = '';
    private $year_of_manufacture = '';
    private $car_condition       = '';
    private $type_of_fuel        = '';
    private $id_of_owner         = '';
    private $created_at          = null;
    private $updated_at          = null;
    private $deleted_at          = null;

    //    public function checkIsValidSave(): bool {
    //
    //        if (empty($this->id)) {
    //            return $this->checkIsValidInsert();
    //        } else {
    //            return $this->checkIsValidUpdate();
    //        }
    //    }


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


    public function getNameOfOwnerById() {

        $userModel = new UserModel();

        return $userModel->getById($this->getIdOfOwner())?->getUsername();

        //        $userModel = new UserModel();
        //
        //        $user = $userModel->getById($this->getIdOfOwner());
        //
        //        if (empty($user)) {
        //            return '';
        //        }
        //        return $user->getUsername();

    }


    /**
     * @return string
     */
    public function getIdOfOwner(): string {

        return $this->id_of_owner;
    }


    /**
     * @param string $id_of_owner
     */
    public function setIdOfOwner(string $id_of_owner): void {

        $this->id_of_owner = $id_of_owner;
    }


    public function getTypeOfFuelValueOfIndex(): string {

        $typeOfFuel = $this->getTypeOfFuel();

        return self::TYPEOFFUEL[$typeOfFuel];
    }


    /**
     * @return int
     */
    public function getTypeOfFuel(): int {

        return (int)$this->type_of_fuel;
    }


    /**
     * @param string $type_of_fuel
     */
    public function setTypeOfFuel(string $type_of_fuel): void {

        $this->type_of_fuel = $type_of_fuel;
    }


    public function getIndexOfCondition(): string {

        $condition = $this->getCarCondition();

        return self::CONDITION[$condition];
    }


    /**
     * @return string
     */
    public function getCarCondition(): string {

        return $this->car_condition;
    }


    /**
     * @param string $car_condition
     */
    public function setCarCondition(string $car_condition): void {

        $this->car_condition = $car_condition;
    }


    /**
     * @return string
     */
    public function getType(): string {

        return $this->type;
    }


    /**
     * @param string $type
     */
    public function setType(string $type): void {

        $this->type = $type;
    }


    /**
     * @return string
     */
    public function getColor(): string {

        return $this->color;
    }


    /**
     * @param string $color
     */
    public function setColor(string $color): void {

        $this->color = $color;
    }


    /**
     * @return string
     */
    public function getKilometersTraveled(): string {

        return $this->kilometers_traveled;
    }


    /**
     * @param string $kilometers_traveled
     */
    public function setKilometersTraveled(string $kilometers_traveled): void {

        $this->kilometers_traveled = $kilometers_traveled;
    }


    /**
     * @return string
     */
    public function getYearOfManufacture(): string {

        return $this->year_of_manufacture;
    }


    /**
     * @param string $year_of_manufacture
     */
    public function setYearOfManufacture(string $year_of_manufacture): void {

        $this->year_of_manufacture = $year_of_manufacture;
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
     * @param string $updated_at
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
     * @param string $deleted_at
     */
    public function setDeletedAt($deleted_at): void {

        $this->deleted_at = $deleted_at;
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
}
