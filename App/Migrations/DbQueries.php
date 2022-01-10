<?php
namespace DbQqueries;

class DbQueries
{
    private $user ;
    private $host;
    private $pass ;


    public function __construct()
    {
        $this->user = "root";
        $this->host = "localhost";
        $this->pass = "";
    }

    public function createUserTable() {
        return "CREATE TABLE user(
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                user_name VARCHAR(30) NOT NULL UNIQUE,
                email VARCHAR(30) NOT NULL UNIQUE,
                password VARCHAR(70) NOT NULL 
            )";
    }

    public function createPage() {
    return "CREATE TABLE page(
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                page_name VARCHAR(30) NOT NULL UNIQUE,
                FOREIGN KEY (user_id) REFERENCES user(id)
            )";
    }

    public function createArticle() {
        return "CREATE TABLE article(
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                title VARCHAR(30) NOT NULL UNIQUE,
                image VARCHAR(30) NOT NULL UNIQUE,
                content VARCHAR(1000) NOT NULL UNIQUE,
                title VARCHAR(30) NOT NULL UNIQUE,
                FOREIGN KEY (page_id) REFERENCES page(id)
            )";
    }
    public function createDB($db_name)
    {
        $check = 0 ;
        $conn = new PDO("mysql:host=$this->host", $this->user,$this->pass );
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE $db_name ";
        // use exec() because no results are returned

        if($conn->exec($sql))
        {
            $check = 1;
        }

        return $check;
    }
}