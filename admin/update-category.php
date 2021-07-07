<?php
require("../user/connexBDD.php");
include_once("../class/products_benoit.php");
include_once("../class/category_benoit.php");
include_once("./layouts/header.php");

$error = null;
if (isset($action)) {
    $id = $action[1];
    $category = $category_class->getCategory($id);
    $name = $category["name"];
    $parent_id = $category["parent_id"];
    $parent_name = $category_class->getCatgoryName($parent_id);
} elseif (isset($_POST['update_category'])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $parent_name = $_POST["category_parent"];
    if ($parent_name == "null") {
        $parent_id = NULL;
    } else {
        $parent_id = intval($category_class->getCatgoryId($parent_name));
    }
    $error = $category_class->updateCategory($id, $name, $parent_id);
} else {
    $error = "Retourner à la page categories" . PHP_EOL;
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
        <h2>Update Category</h2>
    </div>
    <div class="categories">
        <div class="display">
            <h2>#ID</h2>
        </div>
        <div class="display">
            <h2>Name</h2>
        </div>
        <div class="display">
            <h2>Category Parent</h2>
        </div>
        <form action="update-category.php" method="post">
            <div class="display">
                <input class="disable" type="text" name="id" value="<?php echo $id; ?>" disabled="disabled">
            </div>
            <input class="disable" type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="display">
                <input type="text" name="name" value="<?php echo $name; ?>" required>
            </div>
            <div class="display">
                <select name="category_parent">
                    <option value="null">Select a Category</option>
                    <?php
                    $selectall = $category_class->selectAll();
                    foreach ($selectall as $category) {
                        if (substr_count($category["name"], ' ') !== 2) {
                            $category_name = $category["name"];
                        }
                    ?>
                        <option value="<?= $category_name ?>"><?= $category_name ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
    </div>
    <button class="update-button" name="update_category" type="submit">Update</button>
    </form>
</div>
<div class="retour">
    <a href="/admin/check-categories.php">Categories page</a>
</div>
<?php
include_once("./layouts/footer.php");
?>