<?php
/*include('config.php');
if(!empty($_POST["rating"]) && !empty($_POST["id"])) {
$rating=$_POST["rating"];
$id=$_GET['id'];
$query ="UPDATE comment SET rating='$rating' WHERE tutorialid='$id'";echo $query;
$result = mysql_query($query);
}*/
?>
<?php
include('db_config.php');
if(!empty($_POST["rating"]) && !empty($_POST["id"])) 
{
$query ="UPDATE comment SET rating='" . $_POST["rating"] . "' WHERE rating_id='" . $_POST["id"] . "'";
$result = mysqli_query($con,$query);
}
?>