<?php
require("../user/connexBDD.php");
include_once("../class/products_benoit.php");
include_once("../class/category_benoit.php");
include_once("./layouts/header.php");

$error = null;
if (isset($action)) {
    $id = $action[1];
    $product = $product_class->getProduct($id);
    $name = $product["name"];
    $price = $product["price"];
    $description = $product["description"];
    $category_name_ancien = $category_class->getCatgoryName($product["category_id"]);
    $picture = $product["picture"];
} elseif (isset($_POST['update_product'])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $price = intval($_POST["price"]);
    $description = $_POST["description"];
    $picture = $_POST["picture"];
    if ($_POST["category"] != "null"){
        $category_name = $_POST["category"];
    }
    else {
        $category_name = $_POST["category_name"];
    }

    $category_id = $category_class->getCatgoryId($category_name);

    if (!$category_id) {
        $error = "This category name does not exist, please put a valid category name" . PHP_EOL;
    } elseif ($price <= 0) {
        $error = "The price must be a positive number !" . PHP_EOL;
    } else {
        $error = $product_class->updateProduct($id, $name, $price, $description, $category_id, $picture);
    }
} else {
    $error = "Retourner à la page products" . PHP_EOL;
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
        <h2>Update product</h2>
    </div>
    <div class="users">
        <div class="display">
            <h2>#ID</h2>
        </div>
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
        <form action="update-product.php" method="post">
            <div class="display">
                <input class="disable" type="text" name="id" value="<?php echo $id; ?>" disabled="disabled">
            </div>
            <input class="disable" type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="display">
                <input type="text" name="name" value="<?php echo $name; ?>" required>
            </div>
            <div class="display">
                <input type="number" name="price" value="<?php echo $price; ?>" required>
            </div>
            <div class="display">
                <input type="text" name="description" value="<?php echo $description; ?>" required>
            </div>
            <div class="display">
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
                <input class="disable" type="hidden" name="category_name" value="<?php echo $category_name_ancien; ?>">
            </div>
            <div class="display">
                <input type="text" name="picture" value="<?php echo $picture; ?>">
            </div>


    </div>
    <button class="update-button" name="update_product" type="submit">Update</button>
    </form>
</div>
<div class="retour">
    <a href="/admin/check-products.php">Products page</a>
</div>
<?php
include_once("./layouts/footer.php");
?>