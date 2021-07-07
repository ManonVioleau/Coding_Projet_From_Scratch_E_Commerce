<?php

require("../user/connexBDD.php");

class Users
{

    public $bdd;

    function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    function get_name($id)
    {
        $bdd = $this->bdd;
        $reponse = $bdd->query('SELECT username FROM users WHERE id = ' . $id);

        if (!$reponse) {
            throw new Exception("Invalid id given");
        }

        $donnee = $reponse->fetchAll();

        foreach ($donnee as $val) {
            $username = $val["username"];
        }


        return $username;
    }

    function get_password($id)
    {
        $bdd = $this->bdd;

        $reponse = $bdd->query('SELECT password FROM users WHERE id = ' . $id);

        if (!$reponse) {
            throw new Exception("Invalid id given");
        }

        $donnee = $reponse->fetchAll();

        foreach ($donnee as $val) {
            $password = $val["password"];
        }


        return $password;
    }

    function get_email($id)
    {
        $bdd = $this->bdd;

        $reponse = $bdd->query('SELECT email FROM users WHERE id = ' . $id);

        if (!$reponse) {
            throw new Exception("Invalid id given");
        }

        $donnee = $reponse->fetchAll();

        foreach ($donnee as $val) {
            $email = $val["email"];
        }


        return $email;
    }

    function is_admin($id)
    {
        $bdd = $this->bdd;

        $reponse = $bdd->query('SELECT admin FROM users WHERE id = ' . $id);

        if (!$reponse) {
            throw new Exception("Invalid id given");
        }

        $donnee = $reponse->fetchAll();

        foreach ($donnee as $val) {
            $admin = $val["admin"];
        }

        return $admin;
    }

    function select_all(int $limit = 0, int $offset = 0)
    {
        $bdd = $this->bdd;

        if ($limit !== 0){
            $reponse = $bdd->query("SELECT * FROM users ORDER BY id LIMIT $limit OFFSET $offset");
        }
        else {
            $reponse = $bdd->query("SELECT * FROM users ORDER BY id");
        }

        if (!$reponse) {
            throw new Exception("Error in query");
        }

        $donnee = $reponse->fetchAll();
        
        return $donnee;  // donnees tableau

        // $bdd = $this->bdd;
        // $reponse = $bdd->query('SELECT * FROM users');

        // if (!$reponse) {
        //     throw new Exception("Invalid id given");
        // }

        // $donnee = $reponse->fetchAll();

        // return $donnee;  // donnees tableau
    }

    function deleteUser(int $id)
    {
        $bdd = $this->bdd;
        $requete = $bdd->prepare('DELETE from users WHERE id = ' . $id);

        if (!$requete) {
            throw new Exception("Invalid id given");
        }

        $requete->execute();
    }

    function updateUser($bdd, $id, $username, $password, $email, $isadmin)
    {
        // email n'existe pas
        if ($email != $this->get_email($id)) {

            $requete = $bdd->prepare('SELECT COUNT(*) AS numberEmail FROM users WHERE email = ?');
            $requete->execute(array($email));

            while ($result = $requete->fetch()) {

                if ($result['numberEmail'] != 0) {
                    return "Email address already exists";
                }
            }
        }

        // chiffrage mdp

        if ($password != "..." && $password != $this->get_password($id)) {
            $password = sha1($password . "d7f");
        } elseif ($password == "...") {
            $password = $this->get_password($id);
        }

        // update user
        $requete = $bdd->prepare('UPDATE users 
            SET username = :username,
            password = :password,
            email = :email,
            admin = :admin
            WHERE id = :id;');
        $requete->execute(array(
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'admin' => $isadmin,
            'id' => $id
        ));

        return "Update Saved";
    }

    function countUsers() {

        $bdd = $this->bdd; 

        $reponse = $bdd->query('SELECT COUNT(*) AS numberUsers FROM users');
        $result = $reponse->fetch();

        $nbUsers = $result['numberUsers'];
        return $nbUsers;
    }
}

$users = new Users($bdd);
// $id = 8;
// $username = 'Manon54';
// $email = 'manon@manon';
// $password = 'Manon54';
// $isadmin = 0;

// $users->updateUser($bdd, $id, $username, $password, $email, $isadmin);
// $users->deleteUser(6);
