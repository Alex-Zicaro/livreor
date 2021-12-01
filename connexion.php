<? session_start() ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />
    <strong><title>livre d'or</title></strong>
</head>

<body>
<header>

</header>
<main >
<?php

include_once("bdd/bdd.php");
        
        @$login = htmlspecialchars($_POST['login']);
        @$password = password_hash($_POST['password'], PASSWORD_BCRYPT);   
if ( isset($_POST['submit']))
{   
    
    //vérification que l'utilisateur existe bien dans la bdd
    $requete = $bdd->prepare(' SELECT * FROM utilisateurs where login = :login');
    $requete->execute(['login' => $_POST['login']]);
    $result = $requete->fetch();
    if ( $result == true)
    {
                        if ( password_verify($_POST['password'],$result['password']))// sinon cerification du mpd, pour ouvrir une session utilisateur classique
                            {
                                session_start();
                                $req = $bdd->prepare('SELECT * FROM utilisateurs  WHERE login  = :login');
                                $req->execute(array('login' => $_POST['login']));
                                $_SESSION = $req->fetch();
                                $_SESSION['login'] = $_POST['login'];
                                header('Location: profil.php');//redirection
                            }
                        else 
                        {
                            ?> <p class='alert alert-danger alert-dismissible fade show'> identifiants incorrects </p>;
	<?php
                            
                        }
                }
    }




include("include/header.php");
?>
<!-- formulaire de connexion -->
<div class="container  " id="page_centrale_connexion">
<div class="row h-100  ">
    <div class="col-12 h-100 d-flex justify-content-center align-items-center">
            <form class="w-50"  action="connexion.php" method="post">
                        <p class="text-center"> <?php  echo @$mauvaisidentifiants;  ?> </p>
                        <div class="form-group">
                            <label for="login">Login</label>
                            <input  type="login" name="login" required class="form-control" id="login" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" required class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="row">
                        <button type="submit" name="submit" class="btn btn-primary mt-3 ">Connexion</button>
							<br>
                        <div class="ins">
							
                            <p class="alert alert-info alert-dismissible fade show mt-3 rounded">Vous n'êtes pas encore inscrit ?</p>
							
                        <a href="inscription.php" class="btn btn-primary mb-3">Inscription</a>
            </form>
    </div>
</div>       
</div>
</main>
<footer>
<?php include("include/footer.php");?>
</footer>


</body>

</html>