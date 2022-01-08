<?php

include_once "I_DAO.php";
include_once "../dbUtil/DbConnection.php";

class PageRepository implements I_DAO
{
    private $conn;

    public function __construct()
    {
        $connection = new DbConnection();
        $c = $connection->connect();
        $this->conn = $c;
    }

    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    public function findOneBy($col_name, $criteria)
    {
        // TODO: Implement findOneBy() method.
    }

//    public function createTable($table_name, $table_cols) {
//
//    }

    public function createTable() {
        include_once "../migrations/DbQueries.php";
        $created = false;
        $sql = createPageTable();
        if ($this->conn->exec($sql)) {
            $created = true;
        }
        return $created;
    }

    public function findAllByPageId($page_id)
    {
        // TODO: Implement findOneBy() method.

        try {
            $sql = 'SELECT * FROM page WHERE id_website_infos = :id_website_infos ';

            if ($stmt = $this->conn->prepare($sql)) {
                $stmt->bindParam(":id_website_infos", $web_id, PDO::PARAM_STR);
                $stmt->execute();
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                unset($stmt);
                return $res;
            }
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }
}