<?php

namespace ArticleRepository;
use DBconection as DB;
use I_DAO\I_DAO;

class ArticleRepository implements I_DAO
{

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

    public function findByPageId($page_id)
    {
        $conn = new DB\dbConnection();
        $result = "";
        try {
            $sql = 'SELECT * FROM article WHERE page_id= : page_id';

            if ($stmt = $conn->connect()->prepare($sql)) {

                $stmt->bindParam(":page_id", $page_id, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                unset($stmt);
        } } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
        return $result;
      }
}