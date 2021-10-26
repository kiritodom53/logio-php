<?php


namespace App\Database;

use App\Conf\Config;
use App\Interfaces\IMySQLDriver;
use mysqli;

class MySQLDriver implements IMySQLDriver
{
    private mysqli $db;

    public function __construct()
    {
        $this->db = new mysqli(Config::DB_SERVER, Config::DB_USERNAME, Config::DB_PASSWORD, Config::DB_NAME);

        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    /**
     * @param string $id Product id
     * @return array
     */
    public function findProduct(string $id): array
    {
        // TODO: Implement findProduct() method.
        return [];
    }
}