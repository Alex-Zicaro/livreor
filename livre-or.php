<?php
session_start();

require_once("bdd/bdd.php");

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Livre d'or</title>
</head>

<body>

    <header>
    <?php if (isset($_SESSION['login'])) {
            include_once("include/headerOnline.php");
        } else{
            include_once('include/header.php'); 
        }
        ?>
    </header>

    <main>
        <div align="center">    
            <h2>Livre d'or</h2>
        
        <a class="btn btn-primary" href="commentaire.php">Ajouté un commentaire</a>   
        </div>
        <div class="container">
    

    <?php
    if(isset($_SESSION['id'])) 
    {
    $query = $bdd->prepare("SELECT c.commentaire, u.login, c.date FROM commentaires AS c INNER JOIN utilisateurs AS u ON c.id_utilisateur = u.id ORDER BY date DESC");
    $query->execute();

    $resultcoms = $query-> fetchAll(PDO::FETCH_ASSOC);
    

    foreach ($resultcoms as $commentaire)
    {
        echo '<p class="p-3 mb-3 bg-secondary text-white rounded">Posté le : '.$commentaire['date'].'<br>';
        echo 'Utilisateur : '.$commentaire['login'].'<br>';
        echo 'Commentaire : '.$commentaire['commentaire'].'</p>';
    }   


    
    $resultcoms = $query-> fetchAll(PDO::FETCH_OBJ);

    foreach ($resultcoms as $commentaire)
    {
        echo 'Utilisateur : '.$commentaire->login.'<br>';
        echo 'Date : '.$commentaire->date.'<br>';
        echo 'Commentaire : '.$commentaire->commentaire.'<br><br>';
    }   

    ?>
    </div>
</main>
    <footer>
        <?php include_once('include/footer.php'); ?>
    </footer>

</body>

</html>

<?php   
}
?>