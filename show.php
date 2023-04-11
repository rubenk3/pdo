<?php
$errors = [];

require 'connec.php';
$pdo = new PDO(DSN, USER, PASS);

// si je suis en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // nettoyage
    $story = array_map('trim', $_POST);

    // validation
    if (empty($story['title'])) {
        $errors[] = 'Le champ titre est obligatoire';
    }

    $maxTitleLength = 255;
    if (mb_strlen($story['title']) > $maxTitleLength) {
        $errors[] = 'Le champ titre doit faire moins de ' . $maxTitleLength . ' caractères';
    }

    if (empty($story['author'])) {
        $errors[] = 'Le champ auteur est obligatoire';
    }

    $maxAuthorLength = 100;
    if (mb_strlen($story['author']) > $maxAuthorLength) {
        $errors[] = 'Le champ auteur doit faire moins de ' . $maxAuthorLength . ' caractères';
    }

    if (empty($story['content'])) {
        $errors[] = 'Le champ content est obligatoire';
    }

    // si pas d'erreur
    if (empty($errors)) {
        // insertion 

        // requete non préparée => faille de sécurité injection SQL
        // $query = "INSERT INTO story 
        // (title, author, content) 
        // VALUES ('" . $story['title'] . "' , '" . $story['author'] . "', '" . $story['content'] . "')";
        // $pdo->exec($query);

        // requete préparée
        $query = "INSERT INTO story (title, author, content)
        VALUES(:title, :author, :content)";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':title', $story['title'], PDO::PARAM_STR);
        $statement->bindValue(':author', $story['author'], PDO::PARAM_STR);
        $statement->bindValue(':content', $story['content'], PDO::PARAM_STR);

        $statement->execute();
        header('Location: index.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atelier PDO</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main>
        <h1>Atelier PDO</h1>

        <?php if (!empty($errors)) : ?>
            <ul class="error">
                <?php foreach ($errors as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form action="" method="POST" novalidate>
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" value="<?= $story['title'] ?? '' ?>" required>

            <label for="author">Auteur</label>
            <input type="text" name="author" id="author" value="<?= $story['author'] ?? '' ?>"required>

            <label for="content">Contenu</label>
            <textarea name="content" id="content" cols="30" rows="10" required><?= $story['content'] ?? '' ?></textarea>

            <button>Ajouter</button>
        </form>
        <a href="index.php">Retour</a>

    </main>
</body>

</html>