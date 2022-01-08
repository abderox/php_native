<?php

include_once "I_DAO.php";


class SocialMediaRepository implements I_DAO
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

//    public function findByPageId($page_id)
//    {
//        // TODO: Implement findOneBy() method.
//
//        try {
//            $sql = 'SELECT * FROM article WHERE page_id= : page_id';
//
//            if ($stmt = $conn->connect()->prepare($sql)) {
//                // Bind variables to the prepared statement as parameters
//                $stmt->bindParam(":id_user", $usr_id, PDO::PARAM_STR);
//                $stmt->execute();
//                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//                foreach ($result as $res) {
//                    $id_website = (int)$res['id'];
//                    $num_page = (int)$res['nbre_pages'];
//                    $web_name =  $res['website_name'];
//                }
//                unset($stmt);
//            }
//        } catch (PDOException $e) {
//            echo $sql . "<br>" . $e->getMessage();
//        }
//    }
}