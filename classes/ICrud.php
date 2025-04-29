<?php

interface ICrud
{
    static function getAllAsObjects(): array;

    function delete(): bool;

    static function getObjectById(int $id): ?object;

    function update(): bool;

    static function createObject():?object;

}