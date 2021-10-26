<?php


namespace App\Database;

use App\Interfaces\IElasticSearchDriver;

class ElasticSearchDriver implements IElasticSearchDriver
{
    public function findById(string $id): array
    {
        // TODO: Implement findById() method.
        return [];
    }
}