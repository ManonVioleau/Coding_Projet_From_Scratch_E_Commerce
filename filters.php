<?php
// à remplir à l'aide d'un select all :
$filters = [
    "collections" => ["60's", "70's", "80's"],
    "colors" => ["blue", "green", "orange", "red", "purple"],
    "categories" => ["table", "chair", "lounge"]
    // ,
    // "price" => ["$0-$25", "$25-$50", "$50-$100", "$100-$150", "$150-+"]
];

// chacun des filtres cochés sont rangés dans la variable session tel que :
// var_dump($_SESSION['collections']);
// var_dump($_SESSION['colors']);
// var_dump($_SESSION['categories']);
// var_dump($_SESSION['price']);

?>

<div class="case-filter">
    <!-- responsive -->
    <div class="filters">
        <h2>Filters</h2>
        <img src="/assets/expand_more_black_24dp.svg" alt="">
        <div class="match-draw"></div>
    </div>
    <!-- end responsive -->
    <div class="filter-by">
        <h3>Filter by</h3>
    </div>
    <ul class="filters-list">
        <?php
        // pour chacun des filtres renseignés, récupérer le filtre (key ex : collection, couleur et catégorie) et ses valeurs (values ex : 60's, ...)
        foreach ($filters as $filter => $values) {
        ?>
            <li class="filter">
                <a href="/">
                    <div class="filter-up">
                        <div class="filter-title">
                            <!-- nom du filtre -->
                            <h4><?= $filter ?></h4>
                            <img src="/assets/expand_more_black_24dp.svg" alt="" class="expandmore">
                            <img src="/assets/expand_less_black_24dp.svg" alt="" class="expandless">

                            <form action="/" method="post" class="subfilter">
                                <!-- pour chacune des valeurs du filtre concerné -->
                                <?php foreach ($values as $value) {
                                ?>
                                    <!-- afficher les checkbox -->
                                    <p>
                                        <input type="submit" class="check-button" name="<?= $value ?>" value="+">
                                        <input type="checkbox" name="collection" value="<?= $value ?>" style="display:none;"> <?= $value ?> <br>
                                    </p>

                                <?php
                                }
                                ?>
                            </form>
                            <div class="filter-draw"></div>
                        </div>
                        <div class="filter-checked">
                            <!-- pour chacune des valeurs du filtre concerné -->
                            <?php
                            foreach ($values as $value) {
                                if (isset($_POST[$value])) {
                                    // si on souhaite enlever une valeur d'un filtre
                                    if ($_POST[$value] == "X") {

                                        if (isset($_SESSION[$filter]) && !empty($_SESSION[$filter])) {
                                            unset($_SESSION[$filter][array_search($value, $_SESSION[$filter])]);
                                        }
                                    } elseif ($_POST[$value] == "+") {
                                        // si on souhaite ajouter une valeur d'un filtre
                                        // si session['filtre'] existe, on rempli le tableau
                                        if (isset($_SESSION[$filter])) {
                                            array_push($_SESSION[$filter], $value);
                                            $_SESSION[$filter] = array_unique($_SESSION[$filter]);
                                            // sinon on le crée
                                        } else {
                                            $_SESSION[$filter] = [$value];
                                        }
                                    }
                                }
                            }

                            // si session['filtre'] existe et n'est pas vide, on affiche chacune des valers
                            if (isset($_SESSION[$filter])) {
                                if (!empty($_SESSION[$filter])) {
                            ?>
                                    <p>
                                    <form action="/" method="post">
                                        <?php
                                        foreach ($_SESSION[$filter] as $value) { ?>
                                            <p>
                                                <input type="submit" class="check-button" name="<?= $value ?>" value="X">
                                                <input type="checkbox" name="value" value="<?= $value ?>" style="display:none;"> <?= $value ?> <br>
                                            </p>
                                        <?php } ?>

                                    </form>
                                    </p>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </a>

            </li>
        <?php
        }
        ?>
        <!-- -----------price range -------------- -->
        <!-- <li class="filter-price">
            <h4>Price Range</h4>
            <div id="filter-price-draw"></div>
            <div id="price-spot-min"></div>
            <div id="price-spot-max"></div>
            <div id="price-min">
                $0
            </div>
            <div id="price-max">
                $10,000+
            </div>
        </li> -->
        <li class="filter-price">
            <script>
                $(function() {
                    $("#slider-range").slider({
                        range: true,
                        min: 0,
                        max: 10000,
                        values: [0, 10000],
                        slide: function(event, ui) {
                            $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                        }
                    });
                    $("#amount").val("$" + $("#slider-range").slider("values", 0) +
                        " - $" + $("#slider-range").slider("values", 1));
                });
            </script>
            <label for="amount">
                <h4 style="margin-bottom: 1rem;">Price Range</h4>
            </label>
            <div id="slider-range"></div>
            <input class="input-price" type="text" id="amount" readonly>
            <div id="filter-price-draw"></div>
        </li>
    </ul>
</div>