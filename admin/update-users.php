<?php
require("../user/connexBDD.php");
include_once("../class/users.php");
include_once("./layouts/header.php");

$error = null;
if (isset($action)) {
    $id = $action[1];
    $username = $users->get_name($id);
    $email = $users->get_email($id);
    $isadmin = $users->is_admin($id);
} elseif (isset($_POST['id'])) {
    $id = str_replace(' ', '', $_POST['id']);
    $username = str_replace(' ', '', $_POST['username']);
    $email = str_replace(' ', '', $_POST['email']);
    if ($_POST['admin'] == "Yes") {
        $isadmin = "1";
    } elseif ($_POST['admin'] == "No") {
        $isadmin = "0";
    }
} else {
    $error = "Retourner à la page users";
}

if (!isset($action)) {
    $error = $users->updateUser($bdd, $id, $username, $password, $email, $isadmin);
}

?>


<div class="update">
    <?php if ($error != null) { ?>
        <div class="error" style="margin-left:2rem;padding-left:1rem;">
            <p>
                <?php
                echo $error;
                ?>
            </p>
        </div>
    <?php } ?>
    <div class="title-admin" style="padding-bottom:1rem;">
        <h2>Update user</h2>
    </div>
    <div class="users">
        <div class="display">
            <h2>#</h2>
        </div>
        <div class="display">
            <h2>Name</h2>
        </div>
        <div class="display">
            <h2>Email</h2>
        </div>
        <div class="display">
            <h2>Password</h2>
        </div>
        <div class="display">
            <h2>Admin</h2>
        </div>
        <div class="display">
        </div>
        <form action="update-users.php" method="post">
            <div class="display">
                <input class="disable" type="text" name="id" value="<?php echo $id; ?>" disabled="disabled">
            </div>
            <input class="disable" type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="display">
                <input type="text" name="username" value="<?php echo $username; ?>" required>
            </div>
            <div class="display">
                <input type="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="display">
                <input type="text" name="password" value="..." minlength="5" required>
            </div>
            <div class="display">
                <input type="text" name="admin" value="<?php if ($isadmin == "1" || $_POST["admin"] == "1") {
                                                            echo "Yes";
                                                        } elseif ($isadmin == "0" || $_POST["admin"] == "0") {
                                                            echo "No";
                                                        } else {
                                                            echo $_POST["admin"];
                                                        }
                                                        ?>" required>

            </div>
            <div class="display">
            </div>


    </div>
    <button class="update-button" type="submit">Update</button>
    </form>
</div>
<div class="retour">
    <a href="/admin/check-users.php">Users page</a>
</div>
<?php
include_once("./layouts/footer.php");
?>