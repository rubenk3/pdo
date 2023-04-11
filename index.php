<?php

require __DIR__. '/connec.php';
$pdo = new \PDO(DSN, USER, PASS);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<?php

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<ul>
<?php foreach ($friends as $friend) {
    echo "<li>". $friend['firstname'] . " " . $friend['lastname'] . "</li>";
}
?>
</ul>

<form method="post" action="traitement.php">
    <label for="firstname">Entrez votre prénom</label>
    <input type="text" id="firstname" name="firstname" max="45" required>

    <label for="lastname">Entrez votre nom</label>
    <input type="text" id="lastname" name="lastname" max="45" required>

    <input type="submit" value="Send">
</form>

</body>

</html>
