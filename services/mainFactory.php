<?php
include_once '../dbUtil/dbConnection.php';
include_once './FactoryComposnt.php';
include_once './I_Composants.php';

$conn =new dbConnection();
$stmt = $conn->connect()->prepare('SELECT * FROM modules');
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$fact = I_Composants::class;
$fact = new FactoryComposnt();
$array = array();

foreach ($result as $res)
{

    $array +=  array(  $res['name']=>$res['type']);

}

$strIn	=	'<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>website</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
        <div class="container" style="margin-bottom: 20px">
            <div class="row">
            <div class="col-md-4 "></div>
                <div class="col-md-4">
                    <form class="form-horizontal" id="" method="post" action="/services/UploadToDB.php">
                        <h1 class="text-center">generated</h1>';

$strOut	=
    	'             </form>
                </div>
            </div>
        </div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>';
$site_henerated = $strIn ;
foreach($array as $x => $x_value) {
    $type = $fact->choose($x_value);
    $returnedComposant = $type->getComposant($x);
    $site_henerated = $site_henerated .'<br>'.$returnedComposant;
    $returnedComposant = '';
}
$site_henerated =$site_henerated.'<br><br>'.$strOut;
$f = fopen("../template/websitegen.html", "w");
fwrite($f, $site_henerated);
fclose($f);
echo('<a href="../template/websitegen.html">Show</a> .');
?>