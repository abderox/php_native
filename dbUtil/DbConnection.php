<?php

class DbConnection
{
    /*private $user;
    private $host;
    private $pass;
    private $db;

    public function __construct()
    {
        $this->user = "root";
        $this->host = "localhost";
        $this->pass = "";
        $this->db = "generatewebsite";
    }

    public function connect()
    {
        $conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }*/

    public function connect($user = "root",$host = "localhost",$pass = "",$db = "generatewebsite")
    {
        $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }

    public function createDB($db_name, $user = "root",$host = "localhost",$pass = "")
    {
        $check = false ;
        $conn = new PDO("mysql:host=$host", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE $db_name ";
        if($conn->exec($sql))
        {
            $check = true;
        }
        return $check;
    }
}