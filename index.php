<?php
require_once '_connec.php';

$pdo = new \PDO(DSN, USER, PASS);

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll();
?>

<!doctype html>
<html>

<head>
    <title>
        FRIENDS
    </title>
    <meta charset="utf-8">
</head>

<body>
    <h1>
        Liste de mes Friends
    </h1>

    <table>
        <tr>
            <th>Prénom</th>
            <th>Nom</th>
        </tr>
        <tr>
            <?php foreach ($friends as $friend) { ?>
                <td><?php echo $friend['firstname']; ?></td>
                <td><?php echo $friend['lastname']; ?></td>
        </tr>
    <?php } ?>
    </table>
    <h1>Ajouter un ami</h1> <br>

    <form method="POST" action="">

        <label for="firstname">Prénom</label><br>
        <input type="text" name="firstname" /><br>

        <label for="lastname">Nom</label></br>
        <input type="text" name="lastname" /><br>

        <input type="submit" name="btn" value="Ajouter">
    </form>
    <?php

    if (isset($_POST['btn'])) {

        if (empty($_POST['firstname']) || empty($_POST['lastname'])) {
            echo "Veuillez remplir tous les champs";
        } else if (strlen($_POST['firstname']) >= 45) {
            echo "Veuillez choisir un prénom plus court";
        } else if (strlen($_POST['lastname']) >= 45) {
            echo "Veuillez choisir un nom plus court";
        } else if (!empty($_POST)) {
            $firstname = trim($_POST['firstname']);
            $lastname = trim($_POST['lastname']);

            $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';

            $statement = $pdo->prepare($query);

            $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
            $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

            $statement->execute();

            $friends = $statement->fetchAll();

            header('Location: index.php');
        }
    }
    ?>
</body>
</html>