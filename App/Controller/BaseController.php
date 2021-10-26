<?php


namespace App\Controller;

use App\Database\MySQLDriver;

abstract class BaseController
{
    /**
     * Get db
     * @return \App\Database\MySQLDriver|null
     */
    protected static function getDB(): ?MySQLDriver{
        static $db = null;

        if ($db === null){
            $db = new MySQLDriver();
        }

        return $db;
    }

    /**
     * Load cache from json file
     *
     * @param string $path File path
     * @return mixed
     */
    protected function loadCacheFile(string $path): mixed{
        return json_decode(file_get_contents($path), true);
    }

    /**
     * Save data to cache json file
     * @param string $path
     * @param array $data
     * @return int|bool
     */
    protected function saveCacheFile(string $path, array $data): int|bool
    {
        return file_put_contents($path, json_encode($data));
    }
}