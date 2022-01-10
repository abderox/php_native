<?php
namespace UserRepository;
use DBconection\dbConnection;
use DbQqueries\DbQueries;
use I_DAO\I_DAO;
use PDO;
use PDOException;

include_once "./App/Vendor/service_/I_DAO.php";
include_once "./App/Config/dbUtil/DbConnection.php";
include_once "./App/Migrations/DbQueries.php";

class UserRepository implements I_DAO
{

    private $conn;

    public function __construct()
    {
        $connection = new DbConnection();
        $this->conn = $connection->connect();
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
        try {
            $sql = 'SELECT * FROM user WHERE '.$col_name.'= :criteria LIMIT 1';
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

    public function createTable($table_name, $table_cols) {

        $created = false;
        $db = new DbQueries();
        $sql = $db->createUserTable();
        if ($this->conn->exec($sql)) {
            $created = true;
        }
        return $created;
    }

    public function addUser($username, $email, $password) {
        $sql = "INSERT INTO user (user_name, email, password) VALUES (:username, :email, :password)";
        $created = false;

        if ($stmt = $this->conn->prepare($sql)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $password_hash, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $created = true;
//                // Redirect to login page
//                header("location: login.php");
            } else {
                $created = false;
//                echo "Oops! Something went wrong. Please try again later.";
            }
            unset($stmt);
        }
        return $created;
    }
}