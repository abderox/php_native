<?php


class dbCreation
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
?>