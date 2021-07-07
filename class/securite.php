<?php

require("../user/connexBDD.php");

class Securite
{
    function __construct()
    {
    }

    function my_password_hash(string $password)
    {

        $crypt_password = password_hash($password, PASSWORD_DEFAULT);
        return $crypt_password;
    }

    function my_password_verify(string $password, string $crypt_password)
    {
        return password_verify($password, $crypt_password);
    }


    function signUp($bdd, $username, $password, $password_conf, $email, $isadmin)
    {
        // password = password_conf
        if ($password != $password_conf) {
            return "The passwords are not identicals";
        }

        // email n'existe pas
        $requete = $bdd->prepare('SELECT COUNT(*) AS numberEmail FROM users WHERE email = ?');
        $requete->execute(array($email));

        while ($result = $requete->fetch()) {

            if ($result['numberEmail'] != 0) {
                return "Email address already exists";
            }
        }

        // login n'existe pas
        $requete = $bdd->prepare('SELECT COUNT(*) AS numberlogin FROM users WHERE username = ?');
        $requete->execute(array($username));

        while ($result = $requete->fetch()) {

            if ($result['numberlogin'] != 0) {
                return "Username already exists";
            }
        }

        // chiffrage mdp
        // $password = sha1($password . "d7f");
        $password_crypt = $this->my_password_hash($password);

        // $password = password_hash($password . "d7f", PASSWORD_DEFAULT);
        // ajout user
        $requete = $bdd->prepare('INSERT INTO users(username, email, password ,admin) VALUES(?, ?, ?, ?)');
        $requete->execute(array($username, $email, $password_crypt, $isadmin));

        return "Sign up done";
    }

    function signIn($bdd, $login, $password)
    {
        $email = null;
        $username = null;
        // recherche si login est email ou username
        if (strpos($login, "@")) {
            $email = $login;
        } else {
            $username = $login;
        }

        if ($email != null) {
            // recherche email dans bdd
            $requete = $bdd->prepare('SELECT COUNT(*) AS numberEmail FROM users WHERE email = ?');
            $requete->execute(array($email));

            while ($result = $requete->fetch()) {

                if ($result['numberEmail'] != 1) {
                    return "Incorrect login or password";
                }
            }

            // récupération de la ligne
            $requete = $bdd->prepare('SELECT * FROM users WHERE email = ?');
            $requete->execute(array($email));

        } elseif ($username != null) {
            // recherche username dans bdd
            $requete = $bdd->prepare('SELECT COUNT(*) AS numberuser FROM users WHERE username = ?');
            $requete->execute(array($username));

            while ($result = $requete->fetch()) {

                if ($result['numberuser'] != 1) {
                    return "Incorrect login or password";
                }
            }


            // récupération de la ligne
            $requete = $bdd->prepare('SELECT * FROM users WHERE username = ?');
            $requete->execute(array($username));

        } else {
            return "Incorrect login or password";
        }

        if ($email != null) {
        }

        // verifier si mot de passe ok

        while ($donnees = $requete->fetch()) {

            // $vérifier password ok
            $pass_ok = $this->my_password_verify($password, $donnees['password']);

            if ($pass_ok == true) {

                $_SESSION['connect']        = 1;   // creation variables session
                $_SESSION['username']       = $donnees['username'];
                $_SESSION['email']          = $donnees['email'];
                $_SESSION['created_at']     = $donnees['created_at'];
                $_SESSION['admin']          = $donnees['admin'];

                if ($_SESSION['admin'] == 1) {
                    return "admin";
                } else {
                    return "user";
                }
            } else {
                return "Incorrect login or password";
            }
        }
    }
}

$securite = new Securite();

// $login = "user11@connexion.fr";
// $password = "admin";

// var_dump($securite->signIn($bdd, $login, $password));
