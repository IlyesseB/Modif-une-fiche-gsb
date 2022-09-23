<?php
session_start();

if($_POST){
    if(isset($_POST['id']) && !empty($_POST['id'])
    && isset($_POST['idEtat']) && !empty($_POST['idEtat'])){
        require_once('connect.php');

        $id = strip_tags($_POST['id']);
        $idEtat = strip_tags($_POST['idEtat']);

        $sql = 'UPDATE `FicheFrais` SET `idEtat`=:idEtat WHERE `id`=:id;';

        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':idEtat', $idEtat, PDO::PARAM_STR);

        $query->execute();

        $_SESSION['message'] = "idEtat modifié";
        require_once('close.php');

        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connect.php');

    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM `FicheFrais` WHERE `id` = :id;';

    $query = $db->prepare($sql);

    $query->bindValue(':id', $id, PDO::PARAM_INT);

    $query->execute();

    $idEtat = $query->fetch();

    if(!$idEtat){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: index.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un idEtat</title>

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
                <h1>Modifier un idEtat</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="idEtat">idEtat</label>
                        <p>
                            <select name="idEtat">
                                <option value="CL">Saisie clôturée</option>
                                <option value="CR">Fiche créée, saisie en cours</option>
                                <option value="RB">Remboursée</option>
                                <option value="VA">Validée et mise en paiement</option>
                            </select>
                        </p>
                    </div>
                    <input type="hidden" value="<?= $idEtat['id']?>" name="id">
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>