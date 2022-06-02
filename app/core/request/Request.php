<?php

namespace app\core\request;

/**
 * @link https://www.php.net/manual/en/filter.filters.sanitize.php
 */
class Request {

    private array $errors = [];


    /**
     * $_GET tömb elemeinek biztonságos beolvasása
     * @param string $key A $_GET tömb kulcsa
     * @param string $options A filter típusa (default: FILTER_SANITIZE_SPECIAL_CHARS)
     * @return string A filterezett érték, hiba esetén empty string
     */
    public function getGet($key, $options): string {

        // A htaccess által esetlegesen meghagyott záró "/" eltávolításával

        $string = filter_input(INPUT_GET, $key, $options) ?? '';
        return rtrim($string, '/');
    }


    /**
     * $_POST tömb elemeinek biztonságos beolvasása
     * @param string $key A $_POST tömb kulcsa
     * @param string $options A filter típusa (default: FILTER_SANITIZE_SPECIAL_CHARS)
     * @return string A filterezett érték, hiba esetén empty string
     */
    public function getPost($key, $options): string {

        return filter_input(INPUT_POST, $key, $options) ?? '';
    }


    /**
     * A kérs validációja
     * @return bool True ha a kérés valid | False ha nem
     */
    public function validate(): bool {

        if ($this->getIpAddress() == '') {
            $this->errors[] = 'Hiba! Az ip cím nem létezik.';
        } elseif ($this->getUserAgent() == '') {
            $this->errors[] = 'Hiba! A böngésző nem azonosítható.';
        }

        return empty($this->errors);
    }


    /**
     * A request ip címe
     * REMOTE_ADDR ?? HTTP_X_FORWARDED_FOR ?? HTTP_CLIENT_IP
     * @return string Hiba esetén empty string
     */
    public function getIpAddress(): string {

        if (array_key_exists('REMOTE_ADDR', $_SERVER) && filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) !== false) {
            return $_SERVER['REMOTE_ADDR'];
        }
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP) !== false) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        if (array_key_exists('HTTP_CLIENT_IP', $_SERVER) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP) !== false) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        return '';
    }


    /**
     * Visszaadja a böngésző azonosítóját
     * @return string Hiba esetén empty string
     */
    public function getUserAgent(): string {

        if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            return filter_var($_SERVER['HTTP_USER_AGENT'], FILTER_SANITIZE_SPECIAL_CHARS);
        }
        return '';
    }


    /**
     * Visszaadja a kérés metódusát, GET vagy POST
     * @return string
     */
    public function getMethod(): string {

        if (array_key_exists('REQUEST_METHOD', $_SERVER)) {
            return filter_var($_SERVER['REQUEST_METHOD'], FILTER_SANITIZE_SPECIAL_CHARS);
        }
        return '';
    }


    /**
     * Annak vizsgálata hogy a kérés GET request-e vagy sem
     * @return bool True ha ajax request | False ha nem
     */
    public function isGetRequest(): bool {

        return strtolower($this->getMethod()) == 'get';
    }


    /**
     * Annak vizsgálata hogy a kérés POST request-e vagy sem
     * @return bool True ha ajax request | False ha nem
     */
    public function isPostRequest(): bool {

        return strtolower($this->getMethod()) == 'post';
    }


    /**
     * Annak vizsgálata hogy a kérés ajax request-e vagy sem
     * @return bool True ha ajax request | False ha nem
     */
    public function isAjaxRequest(): bool {

        if (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER)) {
            return filter_var($_SERVER['HTTP_X_REQUESTED_WITH'], FILTER_SANITIZE_SPECIAL_CHARS) == 'XMLHttpRequest';
        }
        return false;
    }


    public function getErrors(): array {

        return $this->errors;
    }


    public function getErrorsAsString($separator = ', '): string {

        return implode($separator, $this->errors);
    }
}
