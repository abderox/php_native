<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>website</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<?php
include_once '../dbUtil/dbConnection.php';
include_once '../dbUtil/dbCreation.php';

session_start();
$usr_id = $_SESSION['id'];

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

    try {
        $conn = new dbConnection();

        if (empty(trim($db_name))) {
            $db_err = "Please enter a database name.";
        } else {
            // Prepare a select statement
            $sql = "SELECT id FROM website_infos WHERE database_name = :database_name";

            if ($stmt = $conn->connect()->prepare($sql)) {

                $stmt->bindParam(":database_name", $db_name, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    if ($stmt->rowCount() == 1) {
                        $db_err = "This database name is already taken.";
                    }
                } else {
                    $validation_err = "Oops! Something went wrong. Please try again later.";
                }

                unset($stmt);
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

            $sql = "SELECT id FROM website_infos WHERE website_name = :website_name ";

            if ($stmt = $conn->connect()->prepare($sql)) {

                $stmt->bindParam(":website_name", $web_name, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    if ($stmt->rowCount() == 1) {
                        $web_err = "This website name is already taken.";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                unset($stmt);
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

        if (empty($db_err) && empty($web_err) && empty($page_err)) {

            if (in_array($ext, $extension)) {
                if (file_exists("../public/image/" . $file_name)) {
                    move_uploaded_file($file_tmp = $_FILES["bg_image"]["tmp_name"], "../public/image/" . $file_name);
                    $newFileName = $file_name;
                } else {
                    $filename = basename($file_name, $ext);
                    $newFileName = $filename . time() . "." . $ext;
                    move_uploaded_file($file_tmp = $_FILES["bg_image"]["tmp_name"], "../public/image/" . $newFileName);
                }
            } else {
                $file_err = 'Upload error';
            }

            if (empty($file_err)) {

                $sql = "INSERT INTO website_infos (database_name, website_name, description, bg_image, navbar, nbre_pages, icon,id_user ) VALUES (:database_name, :website_name, :website_desc, :bg_image, :navbar, :nbre_pages, :icon, :id_user)";

                if ($stmt = $conn->connect()->prepare($sql)) {

                    $stmt->bindParam(":database_name", $db_name, PDO::PARAM_STR);
                    $stmt->bindParam(":website_name", $web_name, PDO::PARAM_STR);
                    $stmt->bindParam(":website_desc", $web_desc, PDO::PARAM_STR);
                    $stmt->bindParam(":bg_image", $newFileName, PDO::PARAM_STR);
                    $stmt->bindParam(":navbar", $menu_, PDO::PARAM_STR);
                    $stmt->bindParam(":nbre_pages", $num_page, PDO::PARAM_STR);
                    $stmt->bindParam(":icon", $icon, PDO::PARAM_STR);
                    $stmt->bindParam(":id_user", $usr_id, PDO::PARAM_STR);

                    if ($stmt->execute()) {
                        $con = new dbCreation();
                        if ($con->createDB($db_name) == 1) {
                            header("location: ../modules/mainFactory.php");
                        }
                    } else {
                        $validation_err = "Oops! Something went wrong. Please try again later.";
                    }

                    // Close statement
                    unset($stmt);
                }
            }
        }


    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}
?>


<body>
<?php
include_once './Nav/navbar.html'
?>
<div class="container" style="margin-bottom: 20px">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <form class="form-horizontal" id="" method="post"
                  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <h1 class="text-center mb-5">Step 1</h1>
                <?php
                if (!empty($validation_err)) {
                    echo '<div class="alert alert-danger">' . $validation_err . '</div>';
                }
                ?>
                <div class="form-group ">
                    <label for="">Website Name</label>
                    <input
                            type="text"
                            name="web_name"
                            class="form-control <?php echo (!empty($web_err)) ? 'is-invalid' : ''; ?>"
                            placeholder="website name">
                    <span class="invalid-feedback"><?php echo $web_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="">Database Name</label>
                    <input
                            type="text"
                            name="db_name"
                            class="form-control <?php echo (!empty($db_err)) ? 'is-invalid' : ''; ?>"
                            placeholder="Database name">
                    <span class="invalid-feedback"><?php echo $db_err; ?></span>
                </div>
                <div class="form-group ">
                    <label for="">Website Description</label>
                    <textarea
                            rows="3"
                            name="web_desc"
                            class="form-control <?php echo (!empty($desc_err)) ? 'is-invalid' : ''; ?>"
                            placeholder="About website"></textarea>
                    <span class="invalid-feedback"><?php echo $desc_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="">N° de pages </label>
                    <input
                            type="number"
                            name="num_page"
                            class="form-control <?php echo (!empty($page_err)) ? 'is-invalid' : ''; ?>"
                            placeholder="#">
                    <span class="invalid-feedback"><?php echo $page_err; ?></span>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Background Image</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" name="bg_image" class="custom-file-input" id="bg_image">
                        <label class="custom-file-label" for="bg_image">Choose file</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Icon</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" name="icon_" class="custom-file-input" id="inputGroupFile01">
                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                    </div>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio1" name="menu_Radio" class="custom-control-input" value="true"
                           checked>
                    <label class="custom-control-label" for="customRadio1">Vertical Menu</label>
                </div>
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" id="customRadio2" name="menu_Radio" class="custom-control-input" value="false">
                    <label class="custom-control-label" for="customRadio2">Horizontal Menu</label>
                </div>
                <button type="submit" class="btn btn-dark btn-block">Build !</button>
            </form>
        </div>
    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</html>
