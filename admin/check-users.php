<?php
require("../user/connexBDD.php");
include_once("../class/users.php");
include_once("./layouts/header.php");
?>

<div class="update">
    <?php if (isset($error)) { ?>
        <div class="error" style="margin-left:2rem;padding-left:1rem;"> <?php if ($error == "delete") { ?>
                <p>
                    Do you really want to delete the User : <?= $users->get_name($action[1]) ?> ?
                </p>
                <form action="change-users.php" method="post">
                    <button type="submit" name="confirmation" value="<?= $action[1] ?>">confirm</button>
                    <button type="submit" name="confirmation" value="non">back</button>
                <?php } else { ?>
                    <p><?= $error ?></p>
                <?php } ?>
                </form>
        </div>
    <?php } ?>
    <div class="title-admin">
        <h2>Users</h2>
        <form id="add_user" action="add-users.php" method="post">
            <button type="submit"><img src="/assets/add_black_24dp.svg" alt=""></button>
        </form>
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
            <h2>Created at</h2>
        </div>
        <div class="display">
            <h2>Admin</h2>
        </div>
        <div class="display">
        </div>
        <?php
        if (isset($_GET["page"])) {
            $offset = ($_GET["page"] * 10) - 10;
        } else {
            $offset = 0;
        }
        $selectall = $users->select_all(10, $offset);
        foreach ($selectall as $user) {
        ?>
            <form id="change_user" action="change-users.php" method="post">
                <div class="display">
                    <input type="text" name="id" value="<?php echo $user["id"]; ?>" placeholder="<?php echo $user["id"]; ?>" style="display:none;">
                    <p><?php echo $user["id"]; ?></p>
                </div>
                <div class="display">
                    <input type="text" name="username" value="<?php echo $user["username"]; ?>" placeholder="<?php echo $user["username"]; ?>" style="display:none;">
                    <p><?php echo $user["username"]; ?></p>
                </div>
                <div class="display">
                    <input type="text" name="email" value="<?php echo $user["email"]; ?>" placeholder="<?php echo $user["email"]; ?>" style="display:none;">
                    <p><?php echo $user["email"]; ?></p>
                </div>
                <div class="display">
                    <input type="text" name="created_at" value="<?php echo $user["created_at"]; ?>" placeholder="<?php echo $user["created_at"]; ?>" style="display:none;">
                    <p><?php echo $user["created_at"]; ?></p>
                </div>
                <div class="display">
                    <input type="text" name="admin" value="<?php echo $user["admin"]; ?>" placeholder="<?php echo $user["admin"]; ?>" style="display:none;">
                    <p>
                        <?php
                        if ($user["admin"] == 1) {
                            echo "Yes";
                        } elseif ($user["admin"] == 0) {
                            echo "No";
                        }
                        ?>
                    </p>
                </div>
                <div class="display">
                    <button type="submit" name="action" value="update-<?= $user["id"]; ?>"><img src="/assets/edit_black_24dp.svg" alt=""></button>
                    <button id="delete" type="submit" name="action" value="delete-<?= $user["id"]; ?>"><img src="/assets/delete_black_24dp.svg" alt=""></button>
                    <!-- <div id="alert">
                        <p>Sure to delete ?</p>
                        <button id="yes" type="submit">Yes</button>
                        <button id="no" type="submit">No</button>
                    </div> -->
                </div>
            <?php
        }
            ?>

            </form>

    </div>


    <?php
include_once("./class/users.php");
include_once("./class/products.php");
if (isset($_GET['page']) && !empty($_GET['page'])) {

    $page = (int) $_GET['page'];
} else $page = 1;

$nbUsers  = $users->countUsers();

$nbPages = ceil($nbUsers / 10);
?>

<div class="footer-page-number">
    <span class="page-number">
        <?php
        for ($i = 1; $i <= $nbPages; $i++) {
            if ($i == $page) { ?>
                <a style="background-color: RGBa(0, 0, 0, 0.8); color: white; font-weight: bold;"> <?php echo $i; ?>&nbsp</a>
            <?php } else { ?>
                <a href="check-users.php?page=<?php echo $i; ?>"> <?php echo $i; ?>&nbsp</a>
        <?php }
        } ?>
    </span>

</div>
</div>

<div class="retour">
    <a href="/admin/admin.php">Admin Page</a>
</div>

<!-- <script>
    var $delete = document.getElementById('delete');
    var $alert = document.getElementById('alert');
    var $yes = document.getElementById('yes');
    var $no = document.getElementById('no');

    $delete.onclick = function() {
  $alert.style.display = "block";
}

// $yes.onclick = function() {

// }
</script> -->

<?php

include_once("./layouts/footer.php");
?>