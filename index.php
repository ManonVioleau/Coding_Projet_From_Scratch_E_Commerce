<?php
session_start(); // tout en haut
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>E-commerce</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700&display=swap" rel="stylesheet">
    


    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>

    <!-- ---------------- HEADER ---------------------- -->
    <header>
        <!-- left menu -->
        <nav class="left-menu">
            <a href="/">
                <img src="/assets/Logo.png" alt="">
            </a>
            <ul>
                <li>
                    <h1> <a href="/">Home</a> </h1>
                </li>
                <li>
                    <h1> <a href="/">Shop</a> </h1>
                </li>
                <li>
                    <h1> <a href="/">Magazine</a> </h1>
                </li>
            </ul>
        </nav>
        <!-- right menu -->
        <nav class="right-menu">
            <a href="/">
                <img src="/assets/shopping_cart_black_24dp.svg" alt="">
            </a>
            <ul>
                <li>
                    <?php
                    if (isset($_SESSION['username'])) {
                    ?>
                        <h1 style="text-transform: none;" id="success">Sign in done <br> Welcome <?= $_SESSION['username'] ?> !</h1>
                        <h1>
                            <a href="/user/deconnexion.php">Sign out</a>
                        </h1>
                    <?php

                    } else {
                        echo '<h1> <a href="/user/signin.php">Login</a> </h1>';
                    }
                    ?>
                </li>
            </ul>
            <a href="/">
                <img class="menu-black" src="/assets/menu_black_24dp.svg" alt="">
            </a>
        </nav>
    </header>
    <!-- ---------------- SEARCH ---------------------- -->
    <div class="search-grid">

        <!-- --- search block --- -->
        <form method="post" action="index.php">
            <!-- - loupe      - -->
            <div class="loupe">
                <button type="submit">
                    <img src="/assets/Search.png" alt="">
                </button>
            </div>
            <!-- - input flex - -->
            <div class="input-flex">
                <!-- input -->
                <input class="input-text" type="text" name="search" id="search" placeholder="Product name">
                <!-- algolia -->
                <div class="algolia">
                    <p class="algolia-para">
                        Powered by Algolia
                    </p>
                    <img src="/assets/Sajari Logo.png" alt="">
                </div>
                <div class="input-draw"></div>
            </div>
        </form>
        <!-- --- best match   --- -->
        <div class="best-match">
            <div class="best-match-title">
                <h2>Best match</h2>
                <img src="/assets/expand_more_black_24dp.svg" class="expandmore" alt="">
                <div class="match-draw"></div>
            </div>
            <!-- <ul class="subfilter">
                <li><a href="/">Classic Living</a></li>
                <li><a href="/">Wild Room</a></li>
                <li><a href="/">Zen Bedroom</a></li>
            </ul> -->
        </div>
    </div>
    <!-- ---------------- SECTION ---------------------- -->
    <div class="section">
        <!-- case -->

        <?php
        include_once('filters.php');
        if (isset($_GET['page']) && !empty($_GET['page'])) {

            $page = (int) $_GET["page"];
        } else {


            $page = 1;
        }
        include_once('displayProduct.php');
        ?>

    </div>

    <!-- ---------------- FOOTER ---------------------- -->

    <footer>

        <?php
        $nbPages = ceil($number_items / 7);
        ?>

        <div class="footer-page-number">
            <span class="page-number">
                <?php
                for ($i = 1; $i <= $nbPages; $i++) {
                    if ($i == $page) { ?>
                        <a style="background-color: RGBa(0, 0, 0, 0.8); color: white; font-weight: bold;"> <?php echo $i; ?>&nbsp</a>
                    <?php } else {  ?>
                        <a href="index.php?page=<?php echo $i; ?>"> <?php echo $i; ?>&nbsp</a>
                <?php }
                } ?>
            </span>
        </div>


    </footer>

</body>

</html>