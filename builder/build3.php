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
$conn = new dbConnection();
$id_pages = array();
$page_names = array();
$architectures = array();
$id_website = 0;
$sql_errs = 0;

//$page_name = array();
//$page_url = array();
//$name_err = array("");
//$validation_err = "";
//$menu_ = 0;
//$num_page = 0;
//$architectures = array("Blog", "Gallery", "Form", "Other");
//$social_media = array("Facebook","Instagram","Google","Twitter");
//$page_architecture = array();
//$social_media_selected =array();
//$num_fields_sm = "";
//$url_social_med = array();
//$url_errors = array();
//$nbre_url_errs = 0;
//$sql_errs = 0;

try {
    $sql = "SELECT id FROM website_infos WHERE id_user = :id_user ORDER BY ID DESC LIMIT 1";

    if ($stmt = $conn->connect()->prepare($sql)) {
        $stmt->bindParam(":id_user", $usr_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $res) {
            $id_website = (int)$res['id'];
        }
        unset($stmt);
    }
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

try {
    $sql = "SELECT * FROM page WHERE id_website_infos = :id_website";

    if ($stmt = $conn->connect()->prepare($sql)) {
        $stmt->bindParam(":id_website", $id_website, PDO::PARAM_STR);
        $stmt->execute();
        $result_pages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result_pages as $res) {
            array_push($id_pages, $res['id']);
            array_push($page_names, $res['page_name']);
            array_push($architectures, $res['architecture']);
        }
        unset($stmt);
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}


$newFileName = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $error = array();
    $extension = array("jpeg", "jpg", "png", "gif");
    for ($i = 0; $i < count($page_names); $i++) {
        if ($architectures[$i] == "Gallery") {
            foreach ($_FILES["files_$i"]["tmp_name"] as $key => $tmp_name) {
                $file_name = $_FILES["files_$i"]["name"][$key];
                $file_tmp = $_FILES["files_$i"]["tmp_name"][$key];
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);

                if (in_array($ext, $extension)) {
                    if (file_exists("../public/image/photo_gallery/" . $file_name)) {
                        move_uploaded_file($file_tmp = $_FILES["files_$i"]["tmp_name"][$key], "../public/image/photo_gallery/" . $file_name);
                        $newFileName = $file_name;
                    } else {
                        $filename = basename($file_name, $ext);
                        $newFileName = $filename . time() . "." . $ext;
                        move_uploaded_file($file_tmp = $_FILES["files_$i"]["tmp_name"][$key], "../public/image/photo_gallery/" . $newFileName);
                    }
                    $sql = "INSERT INTO gallery (file_path, id_page) VALUES ('$newFileName', '$id_pages[$i]')";
                    if ($conn->connect()->exec($sql)) {
                        continue;
                    } else {
                        $sql_errs++;
                    }
                } else {
                    array_push($error, "$file_name");
                }
            }
        }
    }
    if($sql_errs == 0) {
        header("location: ../modules/mainFactory3.php");
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
                <h1 class="text-center mb-5">Step 3</h1>

                <?php
                //                if ($nbre_url_errs != 0) {
                //                    echo '<div class="alert alert-danger">Blank field(s)</div>';
                //                }
                ?>

                <?php

                for ($i = 0; $i < count($page_names); $i++) {
                    if ($architectures[$i] == 'Gallery') {
                        echo ' <div class="row">
                     <div class="col">
                        <h4>' . $page_names[$i] . '</h4>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col">
                        <div class="input-group">
                            <input type="file" name="files_' . $i . '[]" class="form-control" multiple/><br>
                        </div>
                        <div class="input-group">
                            <p class="text-muted">Note: Supported image format: .jpeg, .jpg, .png, .gif</p>
                        </div>
                    </div>
                </div>';
                    }

                    else if ($architectures[$i] == 'Blog') {
                        echo ' <div class="row">
                     <div class="col">
                        <h4>' . $page_names[$i] . '</h4>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col">
                        <div class="input-group">
                            <input type="text" name="headline" class="form-control"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <input type="file" name="banner" class="form-control"/><br>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                     <div class="col">
                        <h4>' . $page_names[$i] . '</h4>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col">
                        <div class="input-group">
                            <input type="text" name="headline" class="form-control"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <input type="file" name="banner" class="form-control"/><br>
                        </div>
                    </div>
                    
                </div>
                ';
                    }
                }

                ?>

                <button type="submit" class="btn btn-dark btn-block">Build !</button>
            </form>
        </div>
    </div>
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var maxInputs = 5;
        var footer = $(".container1");
        var add_button = $(".add_form_field");
        var i = 2;

        var x = 1;
        $(add_button).click(function (e) {
            e.preventDefault();
            if (x < maxInputs) {
                x++;
                $(footer).append(
                    '<div class="row">'+
                    '<div class="col">'+
                    '<div class="input-group">'+
                    '<input type="text" name="post_title"'+i+' class="form-control"/>'+
                    '</div>'+
                     '</div>'+
                   '<div class="col">'+
                    '<div class="input-group">'+
                        '<textarea rows="7" name="post_desc" class="form-control " placeholder="Post content"></textarea>'+
                    '</div>'+
                '</div>'+
            '</div>');
                i++;
                $('input[name=number_]').val(i - 1);
            }
        });


    });
</script>
<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"-->
<!--        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"-->
<!--        crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</html>
