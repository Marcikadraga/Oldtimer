<?php

namespace app\core\pdo;

use Exception;

/**
 * Class CustomStatementException
 *
 * A CustomStatement osztályhoz készült kivétel
 * Segítségével elérhető a hibát okozó query string és a hozzá tartozó paraméterlista
 *
 * @package app\core\pdo
 */
class CustomStatementException extends Exception {

    /**
     * A PDO statementnek átadott query string
     * @var string|null
     */
    private ?string $queryString;

    /**
     * A PDO statementnek átadott paraméterlista
     * @var array|null
     */
    private ?array $params;


    /**
     * ExceptionLevel constructor.
     * @param Exception $exception
     * @param string|null $queryString
     * @param array|null $params
     */
    public function __construct(Exception $exception, ?string $queryString = '', ?array $params = []) {

        $this->queryString = $queryString ?? '';
        $this->params = $params ?? [];

        parent::__construct($exception->getMessage(), (int)$exception->getCode(), $exception->getPrevious());
    }


    /**
     * A hibát okozó query string
     * @return string
     */
    public function getQueryString(): string {

        return CustomStatementDebug::getInstance()->clearQuery((string)$this->queryString);
    }


    /**
     * A hibát okozó query string paraméterlistája
     * @return array|null
     */
    public function getParams(): ?array {

        return $this->params;
    }


    /**
     * A hibát okozó query interpolált változata
     * @return string
     */
    public function getDebugQuery(): string {

        $query = CustomStatementDebug::getInstance()->interpolateQuery($this->queryString, $this->params);
        return CustomStatementDebug::getInstance()->clearQuery($query);
    }
}
