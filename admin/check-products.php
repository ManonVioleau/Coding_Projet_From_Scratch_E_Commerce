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

if (isset($_POST["confirm_product_delete"])) {
    $id = $_POST["confirm_product_delete"];

    $error = $product_class->deleteProduct($id);
}

if ($action[0] == "update") {
    include_once("update-product.php");
    exit;
}

?>

<div class="update">
    <?php if (isset($error)) { ?>
        <div class="error" style="margin-left:2rem;padding-left:1rem;"> <?php if ($error == "delete") { ?>
                <p>
                    You are about to delete the product : <?= $product_class->getProductName($action[1]) ?> . Do you want to proceed ?
                </p>
                <form action="check-products.php" method="post">
                    <button type="submit" name="confirm_product_delete" value="<?= $action[1] ?>">Confirm</button>
                    <button type="submit" name="annul_product_delete" value="annul">Annul</button>
                <?php } else { ?>
                    <p><?= $error ?></p>
                <?php } ?>
                </form>
        </div>
    <?php } ?>
    <div class="title-admin">
        <h2>Products</h2>
        <form id="add_product" action="add-product.php" method="post">
            <button type="submit"><img src="/assets/add_black_24dp.svg" alt=""></button>
        </form>
    </div>
    <div class="products">
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
            <h3>Picture</h3>
        </div>
        <div class="display">
        </div>
        <?php
        if (isset($_GET["page"])) {
            $offset = ($_GET["page"] * 10) - 10;
        } else {
            $offset = 0;
        }
        $selectall = $product_class->selectAll(10, $offset);
        foreach ($selectall as $product) {
            $category_name = $category_class->getCatgoryName($product["category_id"]);
        ?>
            <form id="change_product" action="check-products.php" method="post">
                <div class="display">
                    <input type="text" name="id" value="<?php echo $product["id"]; ?>" placeholder="<?php echo $product["id"]; ?>" style="display:none;">
                    <p><?php echo $product["id"]; ?></p>
                </div>
                <div class="display">
                    <input type="text" name="product_name" value="<?php echo $product["name"]; ?>" placeholder="<?php echo $product["name"]; ?>" style="display:none;">
                    <p><?php echo $product["name"]; ?></p>
                </div>
                <div class="display">
                    <input type="text" name="price" value="<?php echo $product["price"]; ?>" placeholder="<?php echo $product["price"]; ?>" style="display:none;">
                    <p><?php echo $product["price"]; ?></p>
                </div>
                <div class="display">
                    <input type="text" name="description" value="<?php echo $product["description"]; ?>" placeholder="<?php echo $product["description"]; ?>" style="display:none;">
                    <p><?php echo $product["description"]; ?></p>
                </div>
                <div class="display">
                    <input type="text" name="category" value="<?php echo $category_name; ?>" placeholder="<?php echo $category_name; ?>" style="display:none;">
                    <p><?php echo $category_name; ?></p>
                </div>
                <div class="display_product">
                    <img src="<?php echo $product["picture"]; ?>" alt="image du produit"></img>
                </div>
                <div class="display">
                    <button type="submit" name="action" value="update-<?= $product["id"]; ?>"><img src="/assets/edit_black_24dp.svg" alt=""></button>
                    <button type="submit" name="action" value="delete-<?= $product["id"]; ?>"><img src="/assets/delete_black_24dp.svg" alt=""></button>
                </div>
            <?php
        }
            ?>

            </form>

    </div>

    <?php

    $nbProducts  = $product_class->countProducts();

    $nbPages = ceil($nbProducts / 10);
    ?>

    <div class="footer-page-number">
        <span class="page-number">
            <?php
            for ($i = 1; $i <= $nbPages; $i++) {
                if ($i == $page) { ?>
                    <a style="background-color: RGBa(0, 0, 0, 0.8); color: white; font-weight: bold;"> <?php echo $i; ?>&nbsp</a>
                <?php } else { ?>
                    <a href="check-products.php?page=<?php echo $i; ?>"> <?php echo $i; ?>&nbsp</a>
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