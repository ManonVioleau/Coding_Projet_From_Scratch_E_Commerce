
<div class="update">
    <div class="title-admin">
        <h2>Users</h2>
        <form id="add_user" action="add-users.php" method="post">
            <button type="submit"><img src="/assets/add_black_24dp.svg" alt=""></button>
        </form>
    </div>
    <div class="users">
        <div class="display">
            <h3>#</h3>
        </div>
        <div class="display">
            <h3>Name</h3>
        </div>
        <div class="display">
            <h3>Email</h3>
        </div>
        <div class="display">
            <h3>Created at</h3>
        </div>
        <div class="display">
            <h3>Admin</h3>
        </div>
        <div class="display">
        </div>
        <?php
        $selectall = $users->select_all();
        for ($i = 0; $i < 5; $i++) {
            $user = $selectall[$i];
            // foreach ($selectall as $user) {
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
                    <?php
                    ?>
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
                    <!-- <button type="submit" name="action" value="update"><img src="/assets/edit_black_24dp.svg" alt=""></button>
                    <button type="submit" name="action" value="delete"><img src="/assets/delete_black_24dp.svg" alt=""></button> -->
                </div>
            <?php
        }
            ?>
            <div class="display" style="grid-column: 1 / span 6">
                <p> <a href="/admin/check-users.php"> ... See more </a></p>
            </div>

            </form>

    </div>
</div>