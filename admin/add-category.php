<?php
require("../user/connexBDD.php");
include_once("../class/products_benoit.php");
include_once("../class/category_benoit.php");
include_once("./layouts/header.php");

if (isset($_POST["add_category"])) {
    $name = $_POST["name"];
    $parent_name = $_POST["category_parent"];

    if ($parent_name == "null") {
        $parent_id = NULL;
    } else {
        $parent_id = intval($category_class->getCatgoryId($parent_name));
    }

    $error = $category_class->addCategory($name, $parent_id);
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
        <h2 style="padding-bottom:1rem;">Add a Category</h2>
    </div>
    <div class="categories">
        <div class="display">
            <h2>Name</h2>
        </div>
        <div class="display">
            <h2>Category Parent</h2>
        </div>
        <div class="display">
        </div>
        <form id="add_category" action="add-category.php" method="post">
            <div class="display">
                <p>
                    <input type="text" name="name" placeholder="Name" required>
                </p>
            </div>
            <div class="display">
                <p>
                    <select name="category_parent">
                        <option value="null">Select a Category</option>
                        <?php
                        $selectall = $category_class->selectAll();
                        foreach ($selectall as $category) {
                            if (substr_count($category["name"], ' ') !== 2){
                                $category_name = $category["name"];
                            }
                        ?>
                            <option value="<?= $category_name ?>"><?= $category_name ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </p>
            </div>
            <div class="display">
                <button type="submit" name="add_category"><img src="/assets/add_black_24dp.svg" alt=""></button>
            </div>

        </form>

    </div>
</div>
<div class="retour">
    <a href="/admin/check-categories.php">Categories page</a>
</div>
<?php

include_once("./layouts/footer.php");

?>