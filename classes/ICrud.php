<?php

interface ICrud
{
    function getAllAsObjects(): array;

    function deleteObjectById(int $id): bool;

    function getObjectById(int $id): ?object;

    function updateById(int $id, array $data): bool;

    function createObject():?object;

}