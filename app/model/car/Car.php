<?php

namespace app\model\car;

class Car {

    private $type                = '';
    private $color               = '';
    private $kilometers_traveled = '';
    private $year_of_manufacture = '';
    private $condition           = '';
    private $type_of_fuel        = '';


    /**
     * @return string
     */
    public function getCondition(): string {

        return $this->condition;
    }


    /**
     * @param string $condition
     */
    public function setCondition(string $condition): void {

        $this->condition = $condition;
    }


    /**
     * @return string
     */
    public function getTypeOfFuel(): string {

        return $this->type_of_fuel;
    }


    /**
     * @param string $type_of_fuel
     */
    public function setTypeOfFuel(string $type_of_fuel): void {

        $this->type_of_fuel = $type_of_fuel;
    }


    private const TYPEOFFUEL = ['benzin', 'dízel'];
    private const CONDITION  = ['leharcolt', 'megkímélt, megkímélt'];

    protected $errors = [];


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

}
