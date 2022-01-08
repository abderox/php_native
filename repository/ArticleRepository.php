<?php

include_once "I_DAO.php";
include_once "../dbUtil/DbConnection.php";



class ArticleRepository implements I_DAO
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

    public function createTable() {
        include_once "../migrations/DbQueries.php";
        $created = false;
        $sql = createArticleTable();
        if ($this->conn->exec($sql)) {
            $created = true;
        }
        return $created;
    }

    public function findAllByPageId($page_id)
    {
        // TODO: Implement findOneBy() method.

        try {
            $sql = 'SELECT * FROM article WHERE page_id= : page_id';

            if ($stmt = $this->conn->prepare($sql)) {
                $stmt->bindParam(":page_id", $page_id, PDO::PARAM_STR);
                $stmt->execute();
                $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                unset($stmt);
                return $articles;
            }
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }
}