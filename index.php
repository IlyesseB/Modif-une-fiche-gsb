<?php
session_start();

require_once('connect.php');

$sql = 'SELECT * FROM `FicheFrais`';

$query = $db->prepare($sql);

$query->execute();

$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des idEtat</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
            <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <?php
                    if(!empty($_SESSION['message'])){
                        echo '<div class="alert alert-success" role="alert">
                                '. $_SESSION['message'].'
                            </div>';
                        $_SESSION['message'] = "";
                    }
                ?>
                <h1>Liste des idEtat</h1>
                <table class="table">
                    <thead>
                        <th>id</th>
                        <th>idVisiteur</th>
                        <th>mois</th>
                        <th>nbJustificatifs</th>
                        <th>montantValide</th>
                        <th>dateModif</th>
                        <th>idEtat</th>
                    </thead>
                    <tbody>
                        <?php
                        // On boucle sur la variable result
                        foreach($result as $idEtat){
                        ?>
                            <tr>
                                <td><?= $idEtat['id'] ?></td>
                                <td><?= $idEtat['idVisiteur'] ?></td>
                                <td><?= $idEtat['mois'] ?></td>
                                <td><?= $idEtat['nbJustificatifs'] ?></td>
                                <td><?= $idEtat['montantValide'] ?></td>
                                <td><?= $idEtat['dateModif'] ?></td>
                                <td><?= $idEtat['idEtat'] ?></td>
                                <td><a href="details.php?id=<?= $idEtat['id'] ?>">Voir</a> <a href="edit.php?id=<?= $idEtat['id'] ?>">Modifier</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </main>
</body>
</html>