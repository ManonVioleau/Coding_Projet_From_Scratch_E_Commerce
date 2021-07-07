<?php
require("../user/connexBDD.php");
include_once("../class/users.php");
include_once("../class/securite.php");
include_once("./layouts/header.php");


if (!(empty($_POST['username']) && empty($_POST['email']) && empty($_POST['password']) && empty($_POST['password_two']))) {
    $username         = htmlspecialchars($_POST['username']);
    $email             = htmlspecialchars($_POST['email']);
    $username = str_replace(' ', '', $username);
    $email = str_replace(' ', '', $email);
    $password         = htmlspecialchars($_POST['password']);
    $password_conf     = htmlspecialchars($_POST['password_two']);
    if ($_POST["admin"] == "Yes" || $_POST["admin"] == "yes") {
        $isadmin = 1;
    } elseif ($_POST["admin"] == "No" || $_POST["admin"] == "no") {
        $isadmin = 0;
    }
    $error = $securite->signUp($bdd, $username, $password, $password_conf, $email, $isadmin);
}

?>


<div class="update">
    <?php if (isset($error) && $error != null) { ?>
        <div class="error" style="margin-left:2rem;padding-left:1rem;">
            <p>
                <?php
                echo $error;
                ?>
            </p>
        </div>
    <?php } ?>
    <div class="title-admin">
        <h2 style="padding-bottom:1rem;">Add a user</h2>
    </div>
    <div class="users">
        <div class="display">
            <h2>Name</h2>
        </div>
        <div class="display">
            <h2>Password</h2>
        </div>
        <div class="display">
            <h2>Password <br> Confirmation</h2>
        </div>
        <div class="display">
            <h2>Email</h2>
        </div>
        <div class="display">
            <h2>Admin</h2>
        </div>
        <div class="display">
        </div>
        <form id="add_user" action="add-users.php" method="post">
            <div class="display">
                <p>
                    <input type="text" name="username" placeholder="Name" required>
                </p>
            </div>
            <div class="display">
                <p>
                    <input type="password" name="password" placeholder="Password" minlength="5" required>
                </p>
            </div>
            <div class="display">
                <p>
                    <input type="password" name="password_two" placeholder="Password" minlength="5" required>
                </p>
            </div>
            <div class="display">
                <p>
                    <input type="email" name="email" placeholder="Email" required>
                </p>
            </div>
            <div class="display">
                <p>
                    <input type="text" name="admin" placeholder="Yes/No" required>
                </p>
            </div>
            <div class="display">
                <button type="submit"><img src="/assets/add_black_24dp.svg" alt=""></button>
            </div>

        </form>

    </div>
</div>

<div class="retour">
    <a href="/admin/check-users.php">Users Page</a>
</div>
<?php

include_once("./layouts/footer.php");
?>