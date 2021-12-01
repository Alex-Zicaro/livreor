
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/style.css" />
    <strong><title>livre d'or</title></strong>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        
</head>
<body>
    <header>
        <?php include("include/header.php"); ?>
    </header>
    <main>
        <?php
include_once("bdd/bdd.php");

        @$login = htmlspecialchars($_POST['login']);
        @$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        if ($_POST == NULL) // génération d'un forumaile de base
    { 
        ?>
            <div class="container " id="page_centrale_connexion">
                <div class="row h-100  ">
                    <div class="col-12 h-100 d-flex justify-content-center align-items-center">
                        <form class="w-50" action="inscription.php" method="post">
                            <div class="form-group form-control-lg">
                                <label for="login">Choisissez votre Login:</label>
                                <input type="login" name="login" class="form-control form-control-lg" id="login">
                            </div>
                            <div class="form-group form-control-lg">
                                <label for="password">Password:</label>
                                <input type="password" name="password" class="form-control form-control-lg" id="password">
                            </div>
                            <div class="form-group form-control-lg">
                                <label for="confirm_password">Confirmez le Password:</label>
                                <input type="password" name="confirm_password" class="form-control form-control-lg" id="confirm_password">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>

            </div>

            <?php
        } else {
            $req = $bdd->prepare(' SELECT * FROM utilisateurs WHERE login = :login '); //on va chercher dans la bdd si le login existe déjà
            $req->execute(array('login' => $_POST['login']));
            $donnees = $req->fetch();
            if (@$donnees['login'] == $_POST['login']) // on compare le résultat, si c'est le cas on générère un form avec le message " login déjà utilisé " 
            {
            ?>
                <div class="container " id="page_centrale_connexion">
                    <div class="row h-100  ">
                        <div class="col-12 h-100 d-flex justify-content-center align-items-center">
                            <form class="w-50" action="inscription.php" method="post">
                                <div class="form-group form-control-lg">
                                    <label for="login">Choisissez votre Login:</label>
                                    <input type="login" name="login" class="form-control form-control-lg" id="login" value="<?php if (isset($login)) {echo $login;} ?>">
                                </div>
                                <div class="form-group form-control-lg">
                                    <label for="password">Password:</label>
                                    <input type="password" name="password" class="form-control form-control-lg" id="password">
                                </div>
                                <div class="form-group form-control-lg">
                                    <label for="confirm_password">Confirmer le Password:</label>
                                    <input type="password" name="confirm_password" class="form-control form-control-lg" id="confirm_password">
                                </div>
                                <p class="alert alert-danger alert-dismissible fade show">Login déjà utilisé, veuillez en choisir un autre.</p>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                if ($_POST['login'] != NULL and $_POST['password'] != NULL and  $_POST['confirm_password'] != NULL)
                // si tous les champs sont remplis, on peu passer à la suite
                {
                    if (@$_POST['confirm_password'] === @$_POST['password'])
                    // on verifie d'abord que les mdp sont bien identiques
                    {
                        $req = $bdd->prepare('INSERT INTO utilisateurs(login, password) VALUES(:login, :password)');
                        $req->execute(array(
                            'login' => $login,
                            'password' => $password,));
                        header('Location: connexion.php'); //redirection
                    } else
                    // si mdp non identiques, on génère le formulaire avec un message
                    { ?>
                        <div class="container " id="page_centrale_connexion">
                            <div class="row h-100  ">
                                <div class="col-12 h-100 d-flex justify-content-center align-items-center">
                                    <form class="w-50" action="inscription.php" method="post">
                                        <div class="form-group form-control-lg">
                                            <label for="login">Choisissez votre Login:</label>
                                            <input type="login" name="login" class="form-control form-control-lg" id="login" value="<?php if (isset($login)) {echo $login;} ?>">
                                        </div>
                                        <div class="form-group form-control-lg">
                                            <label for="password">Password:</label>
                                            <input type="password" name="password" class="form-control form-control-lg" id="password">
                                        </div>
                                        <div class="form-group form-control-lg">
                                            <label for="confirm_password">Confirmer le Password:</label>
                                            <input type="password" name="confirm_password" class="form-control form-control-lg" id="confirm_password">
                                        </div>
                                        <p class="alert alert-danger alert-dismissible fade show"><strong>Erreur!</strong>Les mots de passe ne sont pas identiques</p>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                } else
                // if empty :
                { ?>
                    <div class="container " id="page_centrale_connexion">
                        <div class="row h-100  ">
                            <div class="col-12 h-100 d-flex justify-content-center align-items-center">
                                <form class="w-50" action="inscription.php" method="post">
                                    <div class="form-group form-control-lg">
                                        <label for="login">Choisissez votre Login:</label>
                                        <input type="login" name="login" class="form-control form-control-lg" id="login" value="<?php if (isset($login)) echo $login;} ?>">
                                    </div>
                                    <div class="form-group form-control-lg">
                                        <label for="password">Password:</label>
                                        <input type="password" name="password" class="form-control form-control-lg" id="password">
                                    </div>
                                    <div class="form-group form-control-lg">
                                        <label for="confirm_password">Confirmer le Password:</label>
                                        <input type="password" name="confirm_password" class="form-control form-control-lg" id="confirm_password">
                                    </div>
                                    <p class="alert alert-info alert-dismissible fade show">veuillez remplir tous les champs:</p>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
        <?php
                }
            }
        $bdd = null;
        ?>
        <footer>
            <?php include("include/footer.php"); ?>
        </footer>

    </main>
</body>

</html>