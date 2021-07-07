<?php
include_once("layouts/header.php");
include_once("connexBDD.php");
include_once("../class/securite.php");

if (!(empty($_POST['username']) && empty($_POST['email']) && empty($_POST['password']) && empty($_POST['password_two']))) {
    $username         = htmlspecialchars($_POST['username']);
    $email             = htmlspecialchars($_POST['email']);
    $password         = htmlspecialchars($_POST['password']);
    $password_conf     = htmlspecialchars($_POST['password_two']);
    $isadmin = 0;
    $error = $securite->signUp($bdd, $username, $password, $password_conf, $email, $isadmin);
}
?>

<div class="case-connexion">
    <div class="bienvenu">
        <h2 id="info">Join us or <br> <a href="signin.php">Sign in</a></h2>
    </div>

    <?php
    if (isset($error)) {
        if ($error == "Sign up done") {
            header('location: signin.php');
            exit();
        }
    ?>
        <div class="error">
            <p><?= $error ?></p>
        </div>
    <?php
    }
    ?>

    <form method="post" action="signup.php">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required /></td>
        <input type="email" name="email" placeholder="Adresse email" required /></td>
        <input type="password" name="password" placeholder="Mot de passe" required minlength="5" /></td>
        <input type="password" name="password_two" placeholder="Mot de passe confirmation" required /></td>

        <button class="grey" type="submit">Sign up</button>
    </form>
</div>
</body>

</html>