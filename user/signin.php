<?php
include_once("layouts/header.php");
include_once("connexBDD.php");
include_once("../class/securite.php");

if (!(empty($_POST['password']) && empty($_POST['email']))) {
    $email             = htmlspecialchars($_POST['email']);
    $password         = htmlspecialchars($_POST['password']);
    $error = $securite->signIn($bdd, $email, $password);
    if (isset($error)) {
        if ($error == "admin") {
            header('location: ../admin/admin.php');
            exit();
        } elseif ($error == "user") {
            header('location: ../index.php');
            exit();
        }
    }
}
?>

<div class="case-connexion">
    <div class="bienvenu">
        <h2 id="info"> Your email or username <br> to join us</h2>
    </div>

    <?php
    if (isset($error)) {
    ?>
        <div class="error">
            <p><?= $error ?></p>
        </div>
    <?php
    }
    ?>

    <form method="post" action="signin.php">

        <input type="text" name="email" placeholder="Email address or Username" required />
        <input type="password" name="password" placeholder="Password" required minlength="5" />

        <button class="grey" type="submit">Sign In</button>
    </form>
</div>
</body>

</html>