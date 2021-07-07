<?php
include_once("./user/connexBDD.php");

class Product
{

    public $bdd;

    function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    function selectAll(int $limit = 0, int $offset = 0)
    {
        $bdd = $this->bdd;

        if ($limit !== 0) {
            $reponse = $bdd->query("SELECT * FROM products ORDER BY id LIMIT $limit OFFSET $offset");
        } else {
            $reponse = $bdd->query("SELECT * FROM products ORDER BY id");
        }

        if (!$reponse) {
            throw new Exception("Error in query");
        }

        $donnee = $reponse->fetchAll();

        return $donnee;  // donnees tableau
    }

    function getInfos($name_product)
    {

        $bdd = $this->bdd;

        $reponse = $bdd->query("SELECT categories.name AS category
        FROM categories
        INNER JOIN products
        ON categories.id = products.category_id
        WHERE products.name = '$name_product'");


        $result = $reponse->fetch();

        $category = $result['category'];

        $product_infos = explode(' ', $category);

        return $product_infos;
    }

    function select_search($search, int $limit = 0, int $offset = 0)
    {

        $bdd = $this->bdd;
        $search = '%' . $search . '%';

        if ($limit !== 0) {
            $reponse = $bdd->query("SELECT * FROM products WHERE name LIKE '" . $search . "' ORDER BY id LIMIT $limit OFFSET $offset");
        } else {
            $reponse = $bdd->query("SELECT * FROM products WHERE name LIKE '" . $search . "' ORDER BY id");
        }

        if (!$reponse) {
            throw new Exception("Error in query");
        }

        $donnee = $reponse->fetchAll();

        return $donnee;  // donnees tableau

    }

    function get_products_from_categories($categories_asked)
    {
        $bdd = $this->bdd;
        // création array categories renseignant l'ensemble des catégories concernées pas categories_asked
        $categories = [];
        $products_id = [];
        $products = [];

        // pour chacune des categories asked :
        foreach ($categories_asked as $category_asked) {
            // récupération de l'année si categories asked du type "60's"
            $array = explode("'", $category_asked);
            $category_asked = $array[0];

            // requete permettant de récupérer les id des categories
            $requete = $bdd->query("SELECT * FROM categories WHERE name LIKE '%" . $category_asked . "%'");
            $donnees = $requete->fetchAll();

            // pour chaque résultat, les renseigner dans le tableau categories via le format : [[0] => 'category_id', [1] => 'category-name'
            foreach ($donnees as $donnee) {
                array_push($categories, [$donnee['id'], $donnee['name']]);
            }
        }
        array_unique($categories);
        // une fois categories rempli, aller rechercher les id des produits correspondants
        foreach ($categories as $category) {
            $requete = $bdd->query("SELECT * FROM products WHERE category_id = " . $category[0]);
            $results = $requete->fetchAll();
            foreach ($results as $result) {
                array_push($products_id, $result['id']);
            }
        }
        $products_id = array_unique($products_id);
        // retourne tableau du type [[0] => 'product_id']

        foreach ($products_id as $product_id) {
            $bdd = $this->bdd;

            $reponse = $bdd->query("SELECT * FROM products WHERE id = $product_id");

            $donnees = $reponse->fetchAll();
            foreach ($donnees as $donnee) {
                $array = [];
                foreach ($donnee as $key => $val) {
                    if (!is_int($key) == true) {
                        $array[$key] = $val;
                    }
                }
                if ($array != []) {
                    array_push($products, $array);
                }
            }
        }

        return $products;
    }
}


$products = new Product($bdd);
