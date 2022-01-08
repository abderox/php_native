<?php

include_once "I_DAO.php";
include_once "../../dbUtil/DbConnection.php";

class WebInfosRepository implements I_DAO
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

//    public function findByDbName($db_name)
//    {
//        try {
//            $sql = "SELECT * FROM website_infos WHERE database_name = :db_name";
//
//            if ($stmt = $this->conn->prepare($sql)) {
//
//                $stmt->bindParam(":db_name", $db_name, PDO::PARAM_STR);
//                $stmt->execute();
//                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
//                unset($stmt);
//                return $res;
//            }
//        } catch (PDOException $e) {
//            echo $sql . "<br>" . $e->getMessage();
//        }
//    }

    public function findOneBy($col_name, $criteria)
    {
        // TODO: Implement findOneBy() method.
        try {
            $sql = 'SELECT * FROM website_infos WHERE '.$col_name.'= :criteria LIMIT 1';
            if ($stmt = $this->conn->prepare($sql)) {
                $stmt->bindParam(":criteria", $criteria, PDO::PARAM_STR);
                $stmt->execute();
                if($stmt->rowCount() == 1){
                    $res = $stmt->fetch();
                    unset($stmt);
                    return $res;
                }
                unset($stmt);
                return null;
            }
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

//    public function findByUserId($user_id)
//    {
//        try {
//            $sql = "SELECT * FROM website_infos WHERE id_user = :id ORDER BY ID DESC LIMIT 1";
//
//            if ($stmt = $this->conn->prepare($sql)) {
//                $stmt->bindParam(":id", $usr_id, PDO::PARAM_STR);
//                $stmt->execute();
//                $res = $stmt->fetch();
//                unset($stmt);
//                return $res;
//            }
//        } catch (PDOException $e) {
//            echo $sql . "<br>" . $e->getMessage();
//        }
//    }

    public function addWebInfos($database_name, $website_name, $description, $bg_image, $navbar, $nbre_pages, $icon, $id_user) {
        $sql = "INSERT INTO website_infos (database_name, website_name, description, bg_image, navbar, nbre_pages, icon,id_user ) VALUES (:database_name, :website_name, :website_desc, :bg_image, :navbar, :nbre_pages, :icon, :id_user)";
        $created = false;

        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bindParam(":database_name", $database_name, PDO::PARAM_STR);
            $stmt->bindParam(":website_name", $website_name, PDO::PARAM_STR);
            $stmt->bindParam(":website_desc", $description, PDO::PARAM_STR);
            $stmt->bindParam(":bg_image", $bg_image, PDO::PARAM_STR);
            $stmt->bindParam(":navbar", $navbar, PDO::PARAM_STR);
            $stmt->bindParam(":nbre_pages", $nbre_pages, PDO::PARAM_STR);
            $stmt->bindParam(":icon", $icon, PDO::PARAM_STR);
            $stmt->bindParam(":id_user", $id_user, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $created = true;
            } else {
                $created = false;
            }
            unset($stmt);
        }
        return $created;
    }
}