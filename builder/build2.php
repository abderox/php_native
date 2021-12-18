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
$username = $_SESSION["username"];
$localhost = "http://127.0.0.1:4000";

$page_name = array();
$page_url = array();
$name_err = array("");
$validation_err = "";
$menu_ = 0;
$id_website = 0;
$num_page = 0;
$conn = new dbConnection();
$architectures = array("Blog", "Gallery", "Form", "Other");
$social_media = array("Facebook","Instagram","Google","Twitter");
$page_architecture = array();
$social_media_selected =array();
$num_fields_sm = "";
$url_social_med = array();
$url_errors = array();
$nbre_url_errs = 0;
$sql_errs = 0;

try {



// Prepare a select statement
    $sql = "SELECT id, nbre_pages, website_name FROM website_infos WHERE id_user = :id_user ORDER BY ID DESC LIMIT 1";

    if ($stmt = $conn->connect()->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id_user", $usr_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $res) {
            $id_website = (int)$res['id'];
            $num_page = (int)$res['nbre_pages'];
            $web_name =  $res['website_name'];
        }
        unset($stmt);
    }
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$path = $localhost.'/template/'.$username.'/'.$web_name;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num_fields_sm = trim($_POST['number_']);
    for($i = 1; $i <= (int)$num_fields_sm; $i++)
    {
        if(!empty($_POST['social_media_'.$i])) {
            $social_media_selected[$i]  = $_POST['social_media_'.$i];
        }
        if(!empty($_POST['url_'.$i])) {
            $url_social_med[$i]  = $_POST['url_'.$i];
        } else {
            $url_errors[$i] = "Not a valid URL.";
            $nbre_url_errs++;
        }

    }
    for ($i = 0; $i < $num_page; $i++) {
        if(!empty($_POST['page_architecture_'.$i])) {
            $page_architecture[$i]  = $_POST['page_architecture_'.$i];
        }
    }
    for ($i = 0; $i < $num_page; $i++) {
        $page_name[$i] = $_POST['page_' . $i];
    }
    $nbre_errs = 0;


    for ($i = 0; $i < $num_page; $i++) {
        if (empty(trim($page_name[$i]))) {
            $name_err[$i] = "Please enter a page name.";
            $nbre_errs++;
        } else {
//            $page_url[$i] = $path.'/'.preg_replace('/\s+/', '_', $page_name[$i]).'.html';
            $page_url[$i] = preg_replace('/\s+/', '_', $page_name[$i]).'.html';
        }
    }

    if ($nbre_errs == 0 && $nbre_url_errs == 0) {

//        for ($i = 1; $i <= (int)$num_fields_sm; $i++)
//        {
//            echo $social_media_selected[$i];
//        }
//        try {
//          $sql = "INSERT INTO page (page_name, architecture, page_url, id_website_infos) VALUES ($page_name[$i], ':architecture', ':page_url' , ':id_website_infos')";
//         $stmt = $conn->connect()->prepare($sql);

            for ($i = 0; $i < $num_page; $i++) {
                $sql = "INSERT INTO page (page_name, architecture, page_url, id_website_infos) VALUES ('$page_name[$i]', '$page_architecture[$i]', '$page_url[$i]' , '$id_website')";
                if($conn->connect()->exec($sql)) {
                    continue;
                } else {
                    $sql_errs++;
                }
            }
            for ($i = 1; $i <= $num_fields_sm; $i++) {
                $sql = "INSERT INTO socialmedia ( type, url, id_webinfos) VALUES ( '$social_media_selected[$i]', '$url_social_med[$i]', '$id_website')";
                if($conn->connect()->exec($sql)) {
                    continue;
                } else {
                    $sql_errs++;
                }
            }
            if($sql_errs == 0) {
                header("location: ../modules/mainFactory2.php");
            }

////                $stmt->bindValue(":page_name", $page_name[$i]);
////                $stmt->bindValue(":architecture", "dfghj");
////                $stmt->bindValue(":page_url", $page_url[$i]);
////                $stmt->bindValue(":id_website_infos", $id_website);
////                $result = $stmt->execute();

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
                  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h1 class="text-center mb-5">Step 2</h1>
                <?php
                if ($nbre_url_errs!=0) {
                    echo '<div class="alert alert-danger">Blank field(s)</div>';
                }
                ?>

                <?php
                $options = array();
                for ($i = 0; $i < count($architectures); $i++) {
                    $options[$i] = '<option value="' . $architectures[$i] . '">' . $architectures[$i] . '</option>';
                }
                for ($i = 0; $i < $num_page; $i++) {
                    $error = (!empty($name_err[$i])) ? 'is-invalid' : '';
                    $err = (!empty($name_err[$i])) ? $name_err[$i] : '';
                    echo '<div class="row">
                            <div class="form-group col-8">
                            <label for="">Page ' . $i . '</label>
                            <input
                                type="text"
                                name="page_' . $i . '"
                                class="form-control ' . $error . '"
                                placeholder="page name">
                            <span class="invalid-feedback">' . $err . '</span>
                          </div> 
                          <div class="form-group col-4">
                            <label for="page_architecture">Architecture</label>
                            <select id="page_architecture" name="page_architecture_' . $i . '" class="form-control">
                                <option  selected value="Other">--Choose--</option>
                                    ' .
                        $options[0] . $options[1] . $options[2] . $options[3]
                        . '</select>
                           </div>
                           </div>';
                }




                $options_ = array();
                for ($i = 0; $i < count($social_media); $i++) {
                $options_[$i] = '<option value="' . $social_media[$i] . '">' . $social_media[$i] . '</option>';
                }
               echo  '<div class="container1 ">
<label for="page_architecture">Social Medias</label>
                    <div class="row ">
                    
                            <div class="form-group col">
                            <input type="text" name="url_1" class="form-control mb-3 " placeholder="URL : (eg:https://m.facebook.com/****)"> <span class="invalid-feedback"></span>
                            </div>
                        <div class="form-group col-4">
                   <input type="hidden" name="number_" id="number" value="1">
                            <select id="socil_media" name="social_media_1" class="form-control">
                                <option  selected value="Other">--Choose--</option>
                                ' .
                   $options_[0] . $options_[1] . $options_[2] . $options_[3]
                   . '
                                
                            </select>
                        </div>
                    </div>
                <div class="row">
                    <div class="col">
                        <button class="btn btn-dark add_form_field mb-4" >+</button>
                      
                    </div>
                    
                </div>
                </div>'
                  ?>

                <button type="submit" class="btn btn-dark btn-block">Build !</button>
            </form>
        </div>
    </div>
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
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
                    '<div class="row"> ' +
                    '<div class="form-group col"> ' +
                    '<input type="text" name="url_' + i + '" class="form-control mb-3 " placeholder="URL : (eg:https://m.facebook.com/****)"> ' +
                    '<span class="invalid-feedback"></span>' +
                    '</div> ' +
                    '<div class="form-group col-4"> ' +
                    '<select id="" name="social_media_' + i + '" class="form-control"> ' +
                    '<option selected value="Other">--Choose--</option>' +
                    '<option value="Facebook">Facebook</option>' +
                    '<option value="Instagram">Instagram</option>' +
                    '<option value="Google">Google</option>' +
                    '<option value="Twitter">Twitter</option>' +
                    '</select>' +
                    '</div>' +
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
