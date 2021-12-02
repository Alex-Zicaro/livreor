<?php
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=alex-zicaro_livreor;charset=utf8', 'alexz', 'alexzicaro');
        $bdd ->setAttribute(PDO::ATTR_ERRMODE ,PDO::ERRMODE_WARNING);
        } 
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}
        
?>