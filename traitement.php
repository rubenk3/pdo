<?php
require_once('connec.php');

$firstname = trim($_POST['firstname']);
$lastname = trim($_POST['lastname']);

$query = "INSERT INTO friend('firstname', 'lastname') VALUES (:firstname, :lastname)";
$statement->prepare($query);
$statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
$statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
$statement->execute();

header('Location: index.php');
exit();
?>
