<?php
session_start();

require_once('bdd/bdd.php');

    if(isset($_SESSION["login"]) === false){
    header('Location: connexion.php');
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>

    <header>
        <?php 
        if(isset($_SESSION["login"]) === true){
            include_once('include/headerOnline.php');
        }else{
        include_once('include/header.php');
    }
        ?>
    </header>

    <main>
        <div align="center">
            <h2>Commentaire</h2>
            <br>
            <h3>écris par : <?php $_SESSION['login'] ?></h3>

            <form method="post" action="commentaire.php">
                <textarea name="commentaire" placeholder="Veuillez saisir votre commentaire..."></textarea><br /><br>
                <input type="submit" name="subCommentaire" value="Publier votre commentaire" />
            </form>

            <?php
if (isset($_SESSION['id'])) {
    $req = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?");
    $req->execute(array($_SESSION['login']));
    $user = $req->fetch();



    if (isset($_POST['subCommentaire'])) {
        $commentaire = $_POST['commentaire'];
        $id_utilisateur = $_SESSION['id'];

        if (isset($commentaire) and !empty($_POST['commentaire'])) {
            
            
            $req2 = $bdd->prepare("INSERT INTO commentaires(commentaire, id_utilisateur, date) VALUES(?, ?, NOW())");
            $req2->execute(array($commentaire, $id_utilisateur));
            ?>
            
            <span class="alert alert-succes alert-dismissible fade show"> commentaire publié vous allez être redirigé vers le livre d'or </span>
            <?php
            sleep(3);
            header("location : livre-or.php ");


            
            
        } else {
            ?>
            <span class='alert alert-danger alert-dismissible fade show'>Nous n'avons pas pu publier votre commentaire</span>";
            <?php
        }
    }
}
?>

        </div>
    </main>

    <footer>
        <?php include_once('include/footer.php') ?>
    </footer>

</body>

</html>