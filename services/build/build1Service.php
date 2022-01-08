<?php

session_start();
$usr_id = $_SESSION['id'];
$username = $_SESSION['username'];

$extension = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $db_name = trim($_POST['db_name']);
    $web_name = trim($_POST['web_name']);
    $web_desc = trim($_POST['web_desc']);
    $num_page = $_POST['num_page'];
    $menu_bool = $_POST['menu_Radio'];
    $web_err = $db_err = $page_err = "";
    $validation_err = "";
    $menu_ = 0;
    $newFileName = "";
    $file_err = "";
    $icon = "";
    $file_path="";
    $created = false;

    try {

        require "../../repository/WebInfosRepository.php";
        $web_repo = new WebInfosRepository();

        if (empty(trim($db_name))) {
            $db_err = "Please enter a database name.";
        } else {

            $web_infos = $web_repo->findOneBy("database_name", $db_name);

            if ($web_infos != null) {
                $db_err = "This database name is already taken.";
            } else {
                $validation_err = "Oops! Something went wrong. Please try again later.";
            }
        }

        if ($menu_bool == "true") {
            $menu_ = 1;
        } else {
            $menu_ = 0;
        }
        if (empty(trim($web_name))) {
            $web_err = "Please enter a website name.";
        } else {

            $web_infos = $web_repo->findOneBy("website_name", $web_name);

            if ($web_infos != null) {
                $web_err = "This website name is already taken.";
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }


        if (empty(trim($web_name))) {
            $web_err = "Please enter a website description.";
        }

        if ((int)$num_page < 1) {
            $page_err = "Not a valid number.";
        }

        $extension = array("jpeg", "jpg", "png", "gif");
        $file_name = $_FILES["bg_image"]["name"];
        $file_tmp = $_FILES["bg_image"]["tmp_name"];
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);

        $file_path = "../../generated/".$username."/".$db_name."/public/images/";

        if (!file_exists($file_path)) {
            mkdir($file_path, 0777, true);
        }

        if (empty($db_err) && empty($web_err) && empty($page_err)) {

            if (in_array($ext, $extension)) {
                if (file_exists($file_path . $file_name)) {
                    move_uploaded_file($file_tmp = $_FILES["bg_image"]["tmp_name"], $file_path . $file_name);
                    $newFileName = $file_name;
                } else {
                    $filename = basename($file_name, $ext);
                    $newFileName = $filename . time() . "." . $ext;
                    move_uploaded_file($file_tmp = $_FILES["bg_image"]["tmp_name"], $file_path . $newFileName);
                }
            } else {
                $file_err = 'Upload error';
            }

            if (empty($file_err)) {

                $added = $web_repo->addWebInfos($db_name, $web_name, $web_desc, $newFileName, $menu_, $num_page, $icon, $usr_id);

                if ($added) {
                    require_once "../../dbUtil/DbConnection.php";
                    $con = new DbConnection();
                    $created = $con->createDB($db_name);
                    if ($created) {
                        $_SESSION["db_name"] = $db_name;
                        header("location: ../../controllers/factory/factory1.php");
                    }
                } else {
                    $validation_err = "Oops! Something went wrong. Please try again later.";
                }
            }
        }


    } catch
    (PDOException $e) {
        echo $e->getMessage();
    }
}

?>