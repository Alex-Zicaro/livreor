<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css" />
    <strong><title>livreor</title></strong>
</head>
<body>
    <main>
        <?php
include_once("bdd/bdd.php");

        @$login = htmlspecialchars($_POST['login']);


        // header différent si un utilisateur est co ou redirection s'il n'est pas co 

        if (isset($_SESSION['login'])) {
            include("include/headerOnline.php");
        } else{
            header('Location: connexion.php'); 
        }
        if(isset($_SESSION['id']) === false) 
        {
            header("Location: connexion.php");
        }

 //récupère les données du compte 

        $req = $bdd->prepare('SELECT * FROM utilisateurs  WHERE id  = :id');
        $req->execute(array('id' => $_SESSION['id']));
        $donnees = $req->fetch();
        ?>
        
        <div class="container " id="page_centrale_connexion">
            <div class="row h-100  ">
                <div class="col-12 h-100 d-flex justify-content-center align-items-center">
                    <form class="w-50" action="profil.php" method="post">
                        <div class="form-group">
                            <label for="login">Modifier votre pseudo</label>
                            <input type="login" name="login" class="form-control form-control-lg" id="login" placeholder="<?php echo $donnees['login'];   ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Modifier votre password</label>
                            <input type="password" name="password" class="form-control form-control-lg" id="password">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirmer la modification du password</label>
                            <input type="password" name="confirm_password" class="form-control form-control-lg" id="confirm_password">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <?php if (isset($_POST['submit'])) //verif d'envoi du formulaire
        {
            if (!$_POST['password'] == NULL or !$_POST['confirm_password'] == NULL) //verif pour le password
            {
                if (!$_POST['password'] == NULL and $_POST['confirm_password'] == NULL) {
                    ?>
                    <div class=row>
                        <div class="col-12">
                            <p class="text-center">Vous devez confirmer votre mot de passe</p>
                        </div>
                    </div> 
                    <?php
                }
                if ($_POST['password'] == NULL and !$_POST['confirm_password'] == NULL) {
                    ?>
                    <div class=row>
                        <div class="col-12">
                            <p class="text-center">Vous n'avez pas saisi le champs " Modifier votre password "</p>
                        </div>
                    </div> 
                    <?php
                }
                if (!$_POST['password'] == NULL and !$_POST['confirm_password'] == NULL and  $_POST['password'] !== $_POST['confirm_password']) {
                    ?> <div class=row>
                        <div class="col-12">
                            <p class="text-center">Vous devez saisir deux mots de passe identiques</p>
                        </div>
                    </div>

                    <?php
                    
                    
                }
                if ($_POST['password'] === $_POST['confirm_password']) //modification du password
                {
                    $password = $_POST['password'];
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $req = $bdd->prepare('UPDATE utilisateurs SET password = :password WHERE id  = :id');
                    $req->execute(array(
                        'password' => $password,
                        'id' => $donnees['id']));
                }
            } 
            if (!$_POST['login'] == NULL) //verif  changement pour le login
            {
                $req = $bdd->prepare('UPDATE utilisateurs SET login = :login WHERE id  = :id');
                $req->execute(array(
                    'login' => $_POST['login'],
                    'id' => $donnees['id']));
                $_SESSION['login'] = $_POST['login'];
            }
            
            header('Location: profil.php'); //rafraichissement de la page pour remettre les valeurs affichées dans les inputs à jour
        }
?>
</main>
    <footer>
        <?php include("include/footer.php"); ?>
    </footer>
</body>
</html>