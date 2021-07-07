<?php
include("./user/connexBDD.php");
include_once("./class/products.php");

$offset =  (7 * $page) - 7;

// IF SEARCH
if (isset($_POST['search']) && !empty($_POST['search'])) {

    $search = $_POST['search'];
    $selectall = $products->select_search($search, 7, $offset);
    $all = $products->select_search($search);
}
// IF FILTER
elseif (isset($_SESSION['colors']) || isset($_SESSION['collections']) || isset($_SESSION['categories'])) {
    $all = $products->selectAll();
    $array_filter = [];


    if (isset($_SESSION['colors']) && !empty($_SESSION['colors'])) {
        foreach ($_SESSION['colors'] as $color) {
            array_push($array_filter, $color);
        }
    }
    if (isset($_SESSION['collections']) && !empty($_SESSION['collections'])) {
        foreach ($_SESSION['collections'] as $collections) {
            array_push($array_filter, $collections);
        }
    }
    if (isset($_SESSION['categories']) && !empty($_SESSION['categories'])) {
        foreach ($_SESSION['categories'] as $categories) {
            array_push($array_filter, $categories);
        }
    }
    if (!empty($array_filter)) {
        $all = $products->get_products_from_categories($array_filter);
    }

    $selectall = array_slice($all, $offset, 7);
} else {
    $all = $products->selectAll();
    $selectall = $products->selectAll(7, $offset);
}

$number_items = count($all);
if ($number_items != 0) {

    foreach ($selectall as $product) {

?>

        <div class="case">
            <div class="case-image">
                <img src="<?php echo ($product['picture']); ?>" alt="<?php echo ($product['description']); ?>">
            </div>
            <div class="overview">
                <h3>Product details</h3>
                <?php echo ($product['description']); ?>
            </div>
            <div class="case-description-top">
                <h5><?php echo ($product['name']); ?></h5>
                <p class="price">$ <?php echo ($product['price']); ?></p>
            </div>
            <div class="case-description-bottom">
                <div class="evaluation">
                    <h6><?php echo ($products->getInfos($product['name'])[0]); ?></h6>
                    <div class="stars">
                        <img src="/assets/Star - On.png" alt="">
                        <img src="/assets/Star - On.png" alt="">
                        <img src="/assets/Star - On.png" alt="">
                        <img src="/assets/Star - On.png" alt="">
                        <img src="/assets/Star.png" alt="">
                    </div>
                </div>
                <a href=#><img src="/assets/add_shopping_cart_black_24dp.svg" alt=""></a>
            </div>
        </div>
<?php   }
} else {
    echo ('NO ITEM FOUND, PLEASE TRY ANOTHER SEARCH.');
}
