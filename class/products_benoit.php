<?php

require_once("../user/connexBDD.php");
require_once("category_benoit.php");

class Products
{

    public $bdd;
    const ERROR_LOG_FILE = "errors.log";

    function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    function getProduct($id)
    {
        $bdd = $this->bdd;

        try {
            $reponse = $bdd->query("SELECT * FROM products WHERE id = $id");
        } catch (PDOException $error) {
            $message = $error->getMessage();

            echo "PDO ERROR: $message storage in " . $this::ERROR_LOG_FILE . PHP_EOL;
            file_put_contents($this::ERROR_LOG_FILE, $message . PHP_EOL, FILE_APPEND);
            return NULL;
        }



        if (!$reponse) {
            throw new Exception("Error query");
        }

        $donnee = $reponse->fetch();

        return $donnee;
    }

    function getProductName($id)
    {
        $bdd = $this->bdd;

        try {
            $reponse = $bdd->query("SELECT name FROM products WHERE id = $id");
        } catch (PDOException $error) {
            $message = $error->getMessage();

            echo "PDO ERROR: $message storage in " . $this::ERROR_LOG_FILE . PHP_EOL;
            file_put_contents($this::ERROR_LOG_FILE, $message . PHP_EOL, FILE_APPEND);
            return NULL;
        }



        if (!$reponse) {
            throw new Exception("Error query");
        }

        $donnee = $reponse->fetchAll();

        foreach ($donnee as $val) {
            if (isset($val["name"])) {
                return $val["name"];
            }
        }
    }

    function getAllName()
    {
        $bdd = $this->bdd;
        $name = [];

        try {
            $reponse = $bdd->query('SELECT name FROM products');
        } catch (PDOException $error) {
            $message = $error->getMessage();

            echo "PDO ERROR: $message storage in " . $this::ERROR_LOG_FILE . PHP_EOL;
            file_put_contents($this::ERROR_LOG_FILE, $message . PHP_EOL, FILE_APPEND);
            return NULL;
        }



        if (!$reponse) {
            throw new Exception("Error query");
        }

        $donnee = $reponse->fetchAll();

        foreach ($donnee as $val) {
            if (isset($val["name"])) {
                array_push($name, $val["name"]);
            }
        }


        return $name;
    }

    function countProducts()
    {

        $bdd = $this->bdd;


        $reponse = $bdd->query('SELECT COUNT(*) AS numberProducts FROM products');
        $result = $reponse->fetch();

        $nbProducts = $result['numberProducts'];
        return $nbProducts;
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

    function deleteProduct($id)
    {

        try {
            $this->bdd->query("DELETE FROM products WHERE id = '$id';");
            return "Product succesfully delete!" . PHP_EOL;
        } catch (PDOException $error) {
            $message = $error->getMessage();

            file_put_contents($this::ERROR_LOG_FILE, $message . PHP_EOL, FILE_APPEND);
            return "PDO ERROR: $message storage in " . $this::ERROR_LOG_FILE . PHP_EOL;
        }
    }

    function addProduct($name, $price, $picture, $description, $category_id)
    {

        $status = TRUE;

        if (strpos($name, ';') == TRUE) {
            return "The name must not contain ;" . PHP_EOL;
            $status = FALSE;
        }

        foreach ($this->getAllName() as $names) {
            if ($name == $names) {
                return "The name of the product is already used, please choose another name for your product !" . PHP_EOL;
                $status = FALSE;
            }
        }

        if (strpos($description, ';') == TRUE) {
            return "The description must not contain ;" . PHP_EOL;
            $status = FALSE;
        }

        if ((!is_int($price)) && ($price <= 0)) {
            return "The price must be a positive number !" . PHP_EOL;
            $status = FALSE;
        }

        if (strpos($picture, ';') == TRUE) {
            return "The picture's link must not contain any ;" . PHP_EOL;
            $status = FALSE;
        }

        if ($status == TRUE) {

            try {
                $request = $this->bdd->prepare("INSERT INTO products 
                                            (name, 
                                            description, 
                                            price, 
                                            picture, 
                                            category_id) 
                                            VALUES 
                                            (:name, 
                                            :description, 
                                            :price, 
                                            :picture, 
                                            '$category_id');");
                $request->bindParam(':name', $name, PDO::PARAM_STR);
                $request->bindParam(':description', $description, PDO::PARAM_STR);
                $request->bindParam(':price', $price, PDO::PARAM_INT);
                $request->bindParam(':picture', $picture, PDO::PARAM_STR);
                $request->execute();
                return "Product created successfully !" . PHP_EOL;
            } catch (PDOException $error) {
                $message = $error->getMessage();

                file_put_contents($this::ERROR_LOG_FILE, $message . PHP_EOL, FILE_APPEND);
                return "PDO ERROR: $message storage in " . $this::ERROR_LOG_FILE . PHP_EOL;
            }
        }
    }

    function updateProduct($id, $name, $price, $description, $category_id, $picture)
    {
        $status = TRUE;

        if (strpos($name, ';') == TRUE) {
            return "The name must not contain ;" . PHP_EOL;
            $status = FALSE;
        }

        if (strpos($description, ';') == TRUE) {
            return "The description must not contain ;" . PHP_EOL;
            $status = FALSE;
        }

        if ((!is_int($price)) && ($price <= 0)) {
            return "The price must be a positive number !" . PHP_EOL;
            $status = FALSE;
        }

        if (strpos($picture, ';') == TRUE) {
            return "The picture's link must not contain any ;" . PHP_EOL;
            $status = FALSE;
        }

        if ($status == TRUE) {

            try {
                $request = $this->bdd->prepare('UPDATE products 
                                                SET name = :name,
                                                price = :price,
                                                picture = :picture,
                                                description = :description,
                                                category_id = :category_id 
                                                WHERE id = :id;');
                $request->bindParam(':name', $name, PDO::PARAM_STR);
                $request->bindParam(':description', $description, PDO::PARAM_STR);
                $request->bindParam(':price', $price, PDO::PARAM_INT);
                $request->bindParam(':picture', $picture, PDO::PARAM_STR);
                $request->bindParam(':category_id', $category_id, PDO::PARAM_INT);
                $request->bindParam(':id', $id, PDO::PARAM_INT);
                $request->execute();
                return "Product updated successfully !" . PHP_EOL;
            } catch (PDOException $error) {
                $message = $error->getMessage();

                file_put_contents($this::ERROR_LOG_FILE, $message . PHP_EOL, FILE_APPEND);
                return "PDO ERROR: $message storage in " . $this::ERROR_LOG_FILE . PHP_EOL;
            }
        }
    }
}

$product_class = new Products($bdd);
