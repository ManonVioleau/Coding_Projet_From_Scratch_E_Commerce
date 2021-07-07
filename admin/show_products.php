<div class="update">
    <div class="title-admin">
        <h2>Products</h2>
        <form id="add_product" action="add-product.php" method="post">
            <button type="submit"><img src="/assets/add_black_24dp.svg" alt=""></button>
        </form>
    </div>
    <div class="users">
        <div class="display">
            <h3>#Id</h3>
        </div>
        <div class="display">
            <h3>Name</h3>
        </div>
        <div class="display">
            <h3>Price</h3>
        </div>
        <div class="display">
            <h3>Description</h3>
        </div>
        <div class="display">
            <h3>Category</h3>
        </div>
        <div class="display">
            <h3>Picture</h3>
        </div>
        <?php
        $selectall = $product_class->selectAll(5);
        for ($i = 0; $i < 5; $i++) {
            $product = $selectall[$i];
            $description = substr($product["description"], 0, 20);
            if ($description !== $product["description"]){
                $description .= "...";
            }
            $category_name = $category_class->getCatgoryName($product["category_id"]);
        ?>
                <div class="display">
                    <input type="text" name="id" value="<?php echo $product["id"]; ?>" placeholder="<?php echo $product["id"]; ?>" style="display:none;">
                    <p><?php echo $product["id"]; ?></p>
                </div>
                <div class="display">
                    <input type="text" name="name" value="<?php echo $product["name"]; ?>" placeholder="<?php echo $product["name"]; ?>" style="display:none;">
                    <p><?php echo $product["name"]; ?></p>
                </div>
                <div class="display">
                    <input type="text" name="price" value="<?php echo $product["price"]; ?>" placeholder="<?php echo $product["price"]; ?>" style="display:none;">
                    <p><?php echo $product["price"]; ?></p>
                </div>
                <div class="display">
                    <input type="text" name="description" value="<?php echo $description; ?>" placeholder="<?php echo $description; ?>" style="display:none;">
                    <p><?php echo $description; ?></p>
                </div>
                <div class="display">
                    <?php
                    ?>
                    <input type="text" name="category_id" value="<?php echo $category_name; ?>" placeholder="<?php echo $category_name; ?>" style="display:none;">
                    <p><?php echo $category_name; ?></p>
                </div>
                <div class="display">
                    <?php
                    ?>
                    <img src="<?php echo $product["picture"]; ?>" alt="image du produit"></img>
                </div>
            <?php
        }
            ?>
            <div class="display" style="grid-column: 1 / span 6">
                <p> <a href="/admin/check-products.php"> ... See more </a></p>
            </div>


    </div>
</div>