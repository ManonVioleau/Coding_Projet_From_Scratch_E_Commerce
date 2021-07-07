<div class="update">
    <div class="title-admin">
        <h2>Categories</h2>
        <form id="add_category" action="add-category.php" method="post">
            <button type="submit"><img src="/assets/add_black_24dp.svg" alt=""></button>
        </form>
    </div>
    <div class="categories">
        <div class="display">
            <h3>#Id</h3>
        </div>
        <div class="display">
            <h3>Name</h3>
        </div>
        <div class="display">
            <h3>Category Parent</h3>
        </div>
        <?php
        $selectall = $category_class->selectAll(5);
        for ($i = 0; $i < 5; $i++) {
            $category = $selectall[$i];
            if ($category["parent_id"] == NULL){
                $category_name = "no parent";
            } else {
                $category_name = $category_class->getCatgoryName($category["parent_id"]);
            }
        ?>
                <div class="display">
                    <input type="text" name="id" value="<?php echo $category["id"]; ?>" placeholder="<?php echo $category["id"]; ?>" style="display:none;">
                    <p><?php echo $category["id"]; ?></p>
                </div>
                <div class="display">
                    <input type="text" name="name" value="<?php echo $category["name"]; ?>" placeholder="<?php echo $category["name"]; ?>" style="display:none;">
                    <p><?php echo $category["name"]; ?></p>
                </div>
                <div class="display">
                    <input type="text" name="parent_name" value="<?php echo $category_name; ?>" placeholder="<?php echo $category_name; ?>" style="display:none;">
                    <p><?php echo $category_name; ?></p>
                </div>
            <?php
        }
            ?>
            <div class="display" style="grid-column: 1 / span 3">
                <p> <a href="/admin/check-categories.php"> ... See more </a></p>
            </div>


    </div>
</div>