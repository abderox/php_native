<?php
include_once '../dbUtil/dbConnection.php';
include_once './FactoryComposnt.php';
include_once './I_Composants.php';
include_once './I_Squelette.php';
include_once './Horizontal_Menu.php';
include_once './Vertical_Menu.php';

session_start();
$usr_id = $_SESSION['id'];
$username = $_SESSION["username"];

$conn =new dbConnection();

$localhost = "http://127.0.0.1:4000/template/";


$fact = new FactoryComposnt();
$array = array();
$site_generated="";
$menu = "";
$web_name ="";
$nbr_pages="";
$web_id = 0;
$db_name = "";

$stmt = $conn->connect()->prepare('SELECT * FROM website_infos WHERE id_user = :id ORDER BY ID DESC LIMIT 1');
$stmt->bindParam(":id", $usr_id, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $res)
{
    $web_id = $res['id'];
    $db_name = $res['database_name'];
    $web_name =  $res['website_name'];
    $nbr_pages = $res['nbre_pages'];
    if($res['navbar']=="1")
    {
        $menu = $fact->choose('vertical');
    }
    else{
        $menu = $fact->choose('horizontal');
    }
}

$strGal = 'Gallery';

$stmt = $conn->connect()->prepare('SELECT * FROM page WHERE id_website_infos = :id_website_infos ');
$stmt->bindParam(":id_website_infos", $web_id, PDO::PARAM_STR);
$stmt->execute();
$result_pages = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_names = array();
$page_urls = array();
$str =array();
foreach ($result_pages as $res)
{
//    $page_names += array($res['page_name']);
    array_push($page_names,$res['page_name']);
    array_push($page_urls,$res['page_url']);

}

$strGalName = 'Gallery';
$strGal =array();
$id_pages = array();

$stmt = $conn->connect()->prepare('SELECT * FROM page WHERE id_website_infos = :id_website_infos and architecture = :gallery ');
$stmt->bindParam(":id_website_infos", $web_id, PDO::PARAM_STR);
$stmt->bindParam(":gallery", $strGalName, PDO::PARAM_STR);
$stmt->execute();
$result_gallery = $stmt->fetchAll(PDO::FETCH_ASSOC);
$images =array();
$gal_names = array();

foreach ($result_gallery as $item)
{
    $stmt = $conn->connect()->prepare('SELECT * FROM gallery WHERE id_page = :id_page ');
    $stmt->bindParam(":id_page", $item['id'], PDO::PARAM_STR);
    $stmt->execute();
    $result_ = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result_ as $item_)
    {
       $images = $images + array($item_['file_path']=>$item['id']);
    }
    array_push($id_pages,$item['id']);
    array_push($gal_names,$item['page_name']);

}
for ($i =0 ; $i<count($id_pages);$i++)
{$strGal[$i] = "";
foreach ($images as $key=>$value)
{


        if($value == $id_pages[$i])
        {
            $strGal[$i] .= '     
                <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
                    <img
                            src="http://127.0.0.1:4000/public/image/photo_gallery/'.$key.'"
                            class="w-100 shadow-1-strong rounded mb-4"
                            alt=""
                    />
                    
                </div>
            ';
//            array_push($strGal[$i],$str);
        }
    }

}


//for($i = 0 ;$i<count($id_pages);$i++)
//{
//    array_push($id_pages,$item['id']);
//}

$footer =$fact->choose('footer');

$stmt = $conn->connect()->prepare('SELECT * FROM socialmedia WHERE id_webinfos = :id_webinfos');
$stmt->bindParam(":id_webinfos", $web_id, PDO::PARAM_STR);
$stmt->execute();
$result_sm = $stmt->fetchAll(PDO::FETCH_ASSOC);

$social_medias = array();
$sm_urls = array();

foreach ($result_sm as $res)
{
//    $page_names += array($res['page_name']);
    array_push($social_medias,strtolower($res['type']));
    array_push($sm_urls,$res['url']);

}

$strIn	=	'<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>'.$web_name.'</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="http://127.0.0.1:4000/public/css/vertical_menu.css" >


</head>
    <body>'.
    $menu->getMenu((int)$nbr_pages, $page_names, $page_urls, $web_name, $localhost)
    .'
        <div class="container" style="margin-bottom: 20px">
         
                        <h1 class="text-center">'.$web_name.'</h1> ';

$strOut	=
    	'            
        </div>
        '.$footer->getFooter($social_medias, $sm_urls, $db_name).'
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="http://127.0.0.1:4000/public/js/vertical_menu.js"  type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
</html>';

//foreach($array as $x => $x_value) {
//    $type = $fact->choose($x_value);
//    $returnedComposant = $type->getComposant($x);
//    $site_henerated = $site_henerated .'<br>'.$returnedComposant;
//    $returnedComposant = '';
//}

$path = '../template/'.$username.'/'.$web_name.'/';
if (!file_exists($path)) {
    mkdir($path, 0777, true);
}

for ($i=0;$i<count($strGal);$i++)
{
    $site_generated = $strIn ;
    $site_generated =$site_generated.'<div class="row">'.$strGal[$i].'</div>'.'<br><br>'.$strOut;

    $filepath = $path.$gal_names[$i].'.html';
    $f = fopen($filepath, "w");
    fwrite($f, $site_generated);
    fclose($f);
}
header("location: ../modules/mainFactory4.php");
//$site_generated =$site_generated.'<br><br>'.$strOut;
//$f = fopen("../template/webgen.html", "w");
//fwrite($f, $site_generated);
//fclose($f);
//echo('<a href="../template/webgen.html">Show</a> <br>
//<a href="../builder/build2.php">proceed</a>
//.');
?>