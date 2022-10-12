<?php
session_start();

if($_POST){
    if(isset($_POST['id']) && !empty($_POST['id'])){
        require_once('connect.php');
        var_dump ($_GET);
        var_dump ($_POST);
        $id = strip_tags($_POST['id']);
        $visiteur = strip_tags($_GET['visiteur']);
        $mois = strip_tags($_GET['mois']);


        $sql = 'UPDATE `FicheFrais` SET `idEtat`=:id WHERE `idVisiteur`=:visiteur AND `mois`=:mois; ';

        $query = $db->prepare($sql);

        $query->bindValue(':id', $id,  PDO::PARAM_STR);
        $query->bindValue(':visiteur', $visiteur,  PDO::PARAM_STR);
        $query->bindValue(':mois', $mois,  PDO::PARAM_STR);

        $query->execute();

        $_SESSION['message'] = "libelle modifié";
        require_once('close.php');
        header('Location: index.php');
        
    }
} else { 

    if(isset($_GET['visiteur']) && !empty($_GET['visiteur']) && isset($_GET['mois']) && !empty($_GET['mois'])){
        require_once('connect.php');
    
        $visiteur = strip_tags($_GET['visiteur']);
        $mois = strip_tags($_GET['mois']);
    
        $sql = 'SELECT * FROM `Etat`';
    
        $query = $db->prepare($sql);
    
        $query->execute();
    
        $libelle = $query->fetchAll();
    
    }else{
        $_SESSION['erreur'] = "URL invalide";
        header('Location: index.php');
    }

}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un libelle</title>

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
                <h1>Modifier un libelle</h1>
                <form method="post">
                    
                    
                    <div class="form-group">
                        <label for="etat">etat</label><br>
                        <select name="id">
                            <?php 
                            foreach ($libelle as $libbb) { ?>
                            <option value="<?= $libbb['id'] ?>"><?= $libbb['libelle'] ?></option>

                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type ="submit"></input>
                </form>
            </section>
        </div>
    </main>
</body>
</html>