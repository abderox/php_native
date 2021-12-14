
<?php
include_once '../dbUtil/dbConnection.php';
include_once '../dbUtil/dbCreation.php';

session_start();
$usr_id = $_SESSION['id'];


$bg_image  =trim( $_POST['bg_image']);
$icon  = trim($_POST['icon_']);
$db_name  = trim($_POST['db_name']);
$web_name  = trim($_POST['web_name']);
$num_page  = $_POST['num_page'];
$menu_bool  = $_POST['menu_Radio'];
$web_err = $db_err = $page_err ="";
$menu_ = 0;

try {
    $conn = new dbConnection();

    if (empty(trim($db_name))) {
        $web_err = "Please enter a website name.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM website_infos WHERE database_name = :database_name";

        if ($stmt = $conn->connect()->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":database_name", $db_name, PDO::PARAM_STR);


            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $db_err = "This database name is already taken.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
   if($menu_bool == "true")
   {
       $menu_ = 1;
   }
   else{
       $menu_ = 0;
   }
    if (empty(trim($web_name))) {
        $db_err = "Please enter a database name.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM website_infos WHERE website_name = :website_name";

        if ($stmt = $conn->connect()->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":website_name", $web_name, PDO::PARAM_STR);


            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $web_err = "This website name is already taken.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    if ((int)$num_page < 1) {
        $page_err = "Not a valid number.";
    }


    if (empty($db_err) && empty($web_err) && empty($page_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO website_infos (database_name, website_name, bg_image, navbar, nbre_pages, icon,id_user ) VALUES (:database_name, :website_name, :bg_image, :navbar, :nbre_pages, :icon, :id_user)";

        if ($stmt = $conn->connect()->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":database_name", $db_name, PDO::PARAM_STR);
            $stmt->bindParam(":website_name", $web_name, PDO::PARAM_STR);

            $stmt->bindParam(":bg_image", $bg_image, PDO::PARAM_STR);
            $stmt->bindParam(":navbar", $menu_, PDO::PARAM_STR);
            $stmt->bindParam(":nbre_pages", $num_page, PDO::PARAM_STR);
            $stmt->bindParam(":icon", $icon, PDO::PARAM_STR);
            $stmt->bindParam(":id_user", $usr_id, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $con = new dbCreation();
                    if( $con->createDB($db_name) == 1)
                    {
                        header("location: ../modules/mainFactory.php");
                    }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }



//$sql = "INSERT INTO `modules` (`id`, `name`, `type`) VALUES (NULL, $button, 'button')";
//$conn->connect()->exec($sql);
// echo "New record created successfully";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

?>
