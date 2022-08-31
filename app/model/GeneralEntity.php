<?php

namespace app\model;

interface GeneralEntity {

    public function __construct(?array $data = null);

    public function fill(?array $data = null): void;
}
