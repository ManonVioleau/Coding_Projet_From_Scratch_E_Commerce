<?php
require("../user/connexBDD.php");
include_once("../class/products_benoit.php");
include_once("../class/category_benoit.php");
include_once("./layouts/header.php");

if (isset($_GET['page']) && !empty($_GET['page'])) {

    $page = (int) $_GET['page'];
} else $page = 1;

if (isset($_POST["action"])) {
    $action = explode("-", $_POST["action"]);
}
if ($action[0] == "delete") {
    $error = "delete";
}

if (isset($_POST["confirm_category_delete"])) {
    $id = $_POST["confirm_category_delete"];

    // if $product_class
    $error = $category_class->deleteCategory($id);
}

if ($action[0] == "update") {
    include_once("update-category.php");
    exit;
}

?>

<div class="update">
    <?php if (isset($error)) { ?>
        <div class="error" style="margin-left:2rem;padding-left:1rem;"> <?php if ($error == "delete") { ?>
                <p>
                    You are about to delete the category : <?= $category_class->getCatgoryName($action[1]) ?> . Do you want to proceed ?
                </p>
                <form action="check-categories.php" method="post">
                    <button type="submit" name="confirm_category_delete" value="<?= $action[1] ?>">Confirm</button>
                    <button type="submit" name="annul_category_delete" value="annul">Annul</button>
                <?php } else { ?>
                    <p><?= $error ?></p>
                <?php } ?>
                </form>
        </div>
    <?php } ?>
    <div class="title-admin">
        <h2>Categories</h2>
        <form id="add_category" action="add-category.php" method="post">
            <button type="submit"><img src="/assets/add_black_24dp.svg" alt=""></button>
        </form>
    </div>
    <div class="categories-check">
        <div class="display">
            <h2>#ID</h2>
        </div>
        <div class="display">
            <h2>Name</h2>
        </div>
        <div class="display">
            <h2>Category Parent</h2>
        </div>
        <div class="display">
        </div>
        <?php
        if (isset($_GET["page"])) {
            $offset = ($_GET["page"] * 10) - 10;
        } else {
            $offset = 0;
        }
        $selectall = $category_class->selectAll(10, $offset);
        foreach ($selectall as $category) {
            if ($category["parent_id"] == NULL){
                $category_name = "no parent";
            } else {
                $category_name = $category_class->getCatgoryName($category["parent_id"]);
            }
        ?>
            <form id="change_category" action="check-categories.php" method="post">
                <div class="display">
                    <input type="text" name="id" value="<?php echo $category["id"]; ?>" placeholder="<?php echo $category["id"]; ?>" style="display:none;">
                    <p><?php echo $category["id"]; ?></p>
                </div>
                <div class="display">
                    <input type="text" name="product_name" value="<?php echo $category["name"]; ?>" placeholder="<?php echo $category["name"]; ?>" style="display:none;">
                    <p><?php echo $category["name"]; ?></p>
                </div>
                <div class="display">
                    <input type="text" name="parent_name" value="<?php echo $category_name; ?>" placeholder="<?php echo $category_name; ?>" style="display:none;">
                    <p><?php echo $category_name; ?></p>
                </div>
                <div class="display">
                    <button type="submit" name="action" value="update-<?= $category["id"]; ?>"><img src="/assets/edit_black_24dp.svg" alt=""></button>
                    <button type="submit" name="action" value="delete-<?= $category["id"]; ?>"><img src="/assets/delete_black_24dp.svg" alt=""></button>
                </div>
            <?php
        }
            ?>

            </form>

    </div>

    <?php

    $nbCategories  = $category_class->countCategories();

    $nbPages = ceil($nbCategories / 10);
    ?>

    <div class="footer-page-number">
        <span class="page-number">
            <?php
            for ($i = 1; $i <= $nbPages; $i++) {
                if ($i == $page) { ?>
                    <a style="background-color: RGBa(0, 0, 0, 0.8); color: white; font-weight: bold;"> <?php echo $i; ?>&nbsp</a>
                <?php } else { ?>
                    <a href="check-categories.php?page=<?php echo $i; ?>"> <?php echo $i; ?>&nbsp</a>
            <?php }
            } ?>
        </span>

    </div>
</div>

<div class="retour">
    <a href="/admin/admin.php">Admin page</a>
</div>

<?php
include_once("./layouts/footer.php");
?>