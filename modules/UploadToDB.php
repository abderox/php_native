
<?php
include_once '../dbUtil/dbConnection.php';
$headline = $_POST['headline'];
$button = $_POST['button'];
$texts = $_POST['texts'];

try {
$conn =new dbConnection();
$sql = "INSERT INTO `modules` (`id`, `name`, `type`) VALUES (NULL, $button, 'button')";
$conn->connect()->exec($sql);
 echo "New record created successfully";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

?>
