<?php
require("../user/connexBDD.php");
include_once("../class/products_benoit.php");
include_once("../class/category_benoit.php");
include_once("./layouts/header.php");

if (isset($_POST["add_product"])) {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = intval($_POST["price"]);
    $picture = $_POST["picture"];
    $product_cat = $_POST["category"];

    $category_id = $category_class->getCatgoryId($product_cat);

    if (!$category_id) {
        $error = "This category name does not exist, please put a valid category name" . PHP_EOL;
    } elseif ($price <= 0) {
        $error = "The price must be a positive number !" . PHP_EOL;
    } else {
        $error = $product_class->addProduct($name, $price, $picture, $description, $category_id);
    }
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
        <h2 style="padding-bottom:1rem;">Add a Product</h2>
    </div>
    <div class="users">
        <div class="display">
            <h2>Name</h2>
        </div>
        <div class="display">
            <h2>Price</h2>
        </div>
        <div class="display">
            <h2>Description</h2>
        </div>
        <div class="display">
            <h2>Category</h2>
        </div>
        <div class="display">
            <h2>Picture</h2>
        </div>
        <div class="display">
        </div>
        <form id="add_product" action="add-product.php" method="post">
            <div class="display">
                <p>
                    <input type="text" name="name" placeholder="Name" required>
                </p>
            </div>
            <div class="display">
                <p>
                    <input type="number" name="price" placeholder="Price" required>
                </p>
            </div>
            <div class="display">
                <p>
                    <input type="text" name="description" placeholder="Description" required>
                </p>
            </div>
            <div class="display">
                <p>
                    <select name="category">
                        <option value="null">Select a Category</option>
                        <?php
                        $selectall = $category_class->selectCatProduct();
                        foreach ($selectall as $category) {
                            $category_name = $category["name"];
                        ?>
                            <option value="<?= $category_name ?>"><?= $category_name ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </p>
            </div>
            <div class="display">
                <p>
                    <input type="text" name="picture" placeholder="URL Link of the Picture">
                </p>
            </div>
            <div class="display">
                <button type="submit" name="add_product"><img src="/assets/add_black_24dp.svg" alt=""></button>
            </div>

        </form>

    </div>
</div>
<div class="retour">
    <a href="/admin/check-products.php">Products page</a>
</div>
<?php

include_once("./layouts/footer.php");

?>