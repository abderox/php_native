<?php
namespace DBconection;
Class DbConnection
{
    private $user ;
    private $host;
    private $pass ;
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

            $link = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $link;
          }

    }
?>

