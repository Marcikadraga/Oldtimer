<?php

namespace app\model\carType;

use DateTime;

class CarType {

    private $id                    = '';
    private $manufacturer          = '';
    private $type                  = '';
    private $startOfProductionTime = '';
    private $endOfProductionTime   = '';
    private $created_at            = '';
    private $is_active             = '';
    private $updated_at            = null;
    private $deleted_at            = null;

    private const MIN_MANUFACTURE_LENGTH       = 3;
    private const MIN_TYPE_LENGTH              = 3;
    private const START_PRODUCTION_TIME_LENGTH = 4;
    private const END_PRODUCTION_TIME_LENGTH   = 4;

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


    public function isValidManufacturer($manufacturer): bool {

        $this->error = [];

        $countCharacters = mb_strlen($manufacturer);
        if ($countCharacters < self::MIN_MANUFACTURE_LENGTH) {
            $this->error['min_length'] = 'Az autó minimális hossza ' . self::MIN_MANUFACTURE_LENGTH . ' Karakter legyen';
        }

        return empty($this->errors);
    }


    public function isValidType($type): bool {

        $this->error = [];

        $countCharacters = mb_strlen($type);
        if ($countCharacters < self::MIN_TYPE_LENGTH) {
            $this->error['min_length'] = 'Az autó minimális hossza ' . self::MIN_TYPE_LENGTH . ' Karakter legyen';
        }

        return empty($this->errors);
    }


    public function isValidStartProductionTime($startOfProductionTime): bool {

        $this->error = [];

        $countCharacters = mb_strlen($startOfProductionTime);

        if ($countCharacters == self::START_PRODUCTION_TIME_LENGTH) {
            $this->error['min_length'] = 'Az gyártás kezdetének az éve  ' . self::START_PRODUCTION_TIME_LENGTH . ' Karakter legyen';
        }

        return empty($this->errors);
    }


    public function isValidEndProductionTime($endOfProductionTime): bool {

        $this->error = [];

        $countCharacters = mb_strlen($endOfProductionTime);
        if ($countCharacters < self::END_PRODUCTION_TIME_LENGTH) {
            $this->error['min_length'] = 'Az gyártás befejezésének éve ' . self::END_PRODUCTION_TIME_LENGTH . ' Karakter legyen';
        }

        return empty($this->errors);
    }


    public function checkIsValidInsert(): bool {

        $this->errors = [];

        if (empty($this->manufacturer)) {
            $this->errors['manufacturer'] = 'A gyártó megadása kötelező!';
        }
        if (mb_strlen($this->manufacturer) < 3) {
            $this->errors['min_length'] = 'Az autó minimális hossza 3 Karakter legyen';
        }
        if (empty($this->type)) {
            $this->errors['type'] = 'A típus megadása kötelező!';
        }
        if (empty($this->startOfProductionTime)) {
            $this->errors['startOfProductionTime'] = 'A gyártási év megadása kötelező!';
        } elseif (mb_strlen($this->startOfProductionTime) != 4) {
            $this->errors['startOfProductionTime'] = 'Az gyártás kezdetének éve hossza ' . self::START_PRODUCTION_TIME_LENGTH . ' Karakter legyen';
        }

        if (empty($this->endOfProductionTime)) {
            $this->errors['end_of_production_time'] = 'A gyártási év megadása kötelező!';
        }
        if (mb_strlen($this->endOfProductionTime) != 4) {
            $this->errors['min_length'] = 'Az gyártás záróévének a hossza ' . self::END_PRODUCTION_TIME_LENGTH . ' Karakter legyen';
        }

        return empty($this->errors);
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
     * @return string
     */
    public function getManufacturer(): string {

        return $this->manufacturer;
    }


    /**
     * @param string $manufacturer
     */
    public function setManufacturer(string $manufacturer): void {

        $this->manufacturer = $manufacturer;
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
    public function getStartOfProductionTime(): string {

        return $this->startOfProductionTime;
    }


    /**
     * @param string $startOfProductionTime
     */
    public function setStartOfProductionTime(string $startOfProductionTime): void {

        $this->startOfProductionTime = $startOfProductionTime;
    }


    /**
     * @return string
     */
    public function getEndOfProductionTime(): string {

        return $this->endOfProductionTime;
    }


    /**
     * @param string $endOfProductionTime
     */
    public function setEndOfProductionTime(string $endOfProductionTime): void {

        $this->endOfProductionTime = $endOfProductionTime;
    }


    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string {

        return $this->created_at;
    }


    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void {

        $this->created_at = $created_at;
    }


    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string {

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
    public function getIsActive(): string {

        return $this->is_active;
    }


    /**
     * @param string $is_active
     */
    public function setIsActive(string $is_active): void {

        $this->is_active = $is_active;
    }
}
