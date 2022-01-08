<?php
include_once '../../models/FactoryComposnt.php';
include_once '../../models/I_Composants.php';
include_once '../../models/I_Squelette.php';
include_once '../../models/Horizontal_Menu.php';
include_once '../../models/Vertical_Menu.php';

session_start();
$usr_id = $_SESSION['id'];
$username = $_SESSION["username"];
$db_name = $_SESSION["db_name"];

$fact = new FactoryComposnt();
$array = array();
$site_generated="";
$menu = "";
$web_name ="";
$nbr_pages="";

require "../../repository/WebInfosRepository.php";
$web_repo = new WebInfosRepository();

$web_infos = $web_repo->findOneBy("database_name", $db_name);

if ($web_infos != null) {
    $web_name =  $web_infos['website_name'];
    $nbr_pages = $web_infos['nbre_pages'];
    if($web_infos['navbar']=="1")
    {
        $menu = $fact->choose('vertical');
    }
    else{
        $menu = $fact->choose('horizontal');
    }
}



$path = "../../generated/".$username."/".$db_name."/";

if (!file_exists($path)) {
    mkdir($path, 0777, true);
}


//$str = htmlspecialchars(include_once "../../templates/factory/factory1Content.php");


$str = '<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Preview 1</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
          crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/vertical_menu.css">
</head>
<body>
'.$menu = $menu->getMenu((int)$nbr_pages,array(),array(),$web_name,'').'
<div class="container" style="margin-bottom: 20px">
    <h1 class="text-center">'.$web_name .'</h1>

   

</div>
</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="../public/js/vertical_menu.js"  type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
</html>';

require_once '../../services/factory/GetCss.php';
$get_css = new GetCss();
$vertical_menu_css = $get_css->getCssVerticalMenu();

require_once '../../services/factory/GetJs.php';
$get_js = new GetJs();
$vertical_menu_js = $get_js->getJsVerticalMenu();

$dirpath = $path.'pages';
if (!file_exists($dirpath)) {
    mkdir($dirpath, 0777, true);
}
$filepath = $dirpath.'/preview.php';
$f = fopen($filepath, "w");
fwrite($f, $str);
fclose($f);

$dirpath = $path.'public/css';
if (!file_exists($dirpath)) {
    mkdir($dirpath, 0777, true);
}
$csspath = $dirpath.'/vertical_menu.css';
$f = fopen($csspath, "w");
fwrite($f, $vertical_menu_css);
fclose($f);

$dirpath = $path.'public/js';
if (!file_exists($dirpath)) {
    mkdir($dirpath, 0777, true);
}
$jspath = $dirpath.'/vertical_menu.js';
$f = fopen($jspath, "w");
fwrite($f, $vertical_menu_js);
fclose($f);

?>