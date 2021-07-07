<?php

require("../user/connexBDD.php");

class Category
{

    public $bdd;
    const ERROR_LOG_FILE = "errors.log";

    function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    function getCatgoryId($name)
    {
        try {
            $request = $this->bdd->prepare("SELECT id FROM categories WHERE LOWER(name) = :product_cat;");
            $request->bindParam(':product_cat', strtolower($name), PDO::PARAM_STR);
            $request->execute();
            $response = $request->fetch();
            $id = $response["id"];
            return $id;
        } catch (PDOException $error) {
            $message = $error->getMessage();

            echo "PDO ERROR: $message storage in " . $this::ERROR_LOG_FILE . PHP_EOL;
            file_put_contents($this::ERROR_LOG_FILE, $message . PHP_EOL, FILE_APPEND);
            return NULL;
        }
    }

    function getCatgoryName($id)
    {
        try {
            $request = $this->bdd->prepare("SELECT name FROM categories WHERE id = :id;");
            $request->bindParam(':id', $id, PDO::PARAM_INT);
            $request->execute();
            $response = $request->fetch();
            $name = $response["name"];
            return $name;
        } catch (PDOException $error) {
            $message = $error->getMessage();

            echo "PDO ERROR: $message storage in " . $this::ERROR_LOG_FILE . PHP_EOL;
            file_put_contents($this::ERROR_LOG_FILE, $message . PHP_EOL, FILE_APPEND);
            return NULL;
        }
    }

    function getCategory($id)
    {
        $bdd = $this->bdd;

        try {
            $reponse = $bdd->query("SELECT * FROM categories WHERE id = $id");
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

    function getAllName()
    {
        $bdd = $this->bdd;
        $name = [];

        try {
            $reponse = $bdd->query('SELECT name FROM categories');
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

    function selectAll(int $limit = 0, int $offset = 0)
    {
        $bdd = $this->bdd;

        if ($limit !== 0) {
            $reponse = $bdd->query("SELECT * FROM categories ORDER BY id LIMIT $limit OFFSET $offset");
        } else {
            $reponse = $bdd->query("SELECT * FROM categories ORDER BY id");
        }

        if (!$reponse) {
            throw new Exception("Error in query");
        }

        $donnee = $reponse->fetchAll();

        return $donnee;  // donnees tableau
    }

    function selectCatProduct()
    {
        $bdd = $this->bdd;

        $reponse = $bdd->query("SELECT name FROM categories WHERE name LIKE '% % %' ORDER BY id");

        if (!$reponse) {
            throw new Exception("Error in query");
        }

        $donnee = $reponse->fetchAll();

        return $donnee;  // donnees tableau
    }

    function countCategories()
    {

        $bdd = $this->bdd;


        $reponse = $bdd->query('SELECT COUNT(*) AS numberCategories FROM categories');
        $result = $reponse->fetch();

        $nbcategories = $result['numberCategories'];
        return $nbcategories;
    }

    function addCategory($name, $parent_id)
    {

        $status = TRUE;

        if (strpos($name, ';') == TRUE) {
            return "The name must not contain ;" . PHP_EOL;
            $status = FALSE;
        }

        foreach ($this->getAllName() as $names) {
            if ($name == $names) {
                return "The name of the category is already used, please choose another name for your category !" . PHP_EOL;
                $status = FALSE;
            }
        }

        if ((!is_int($parent_id)) && ($parent_id !== null)) {
            return "The parent_id must be null or a number !" . PHP_EOL;
            $status = FALSE;
        }

        if ($status == TRUE) {

            try {
                $request = $this->bdd->prepare("INSERT INTO categories 
                                            (name, 
                                            parent_id) 
                                            VALUES 
                                            (:name, 
                                            :parent_id);");
                $request->bindParam(':name', $name, PDO::PARAM_STR);
                $request->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
                $request->execute();
                return "Category created successfully !" . PHP_EOL;
            } catch (PDOException $error) {
                $message = $error->getMessage();

                file_put_contents($this::ERROR_LOG_FILE, $message . PHP_EOL, FILE_APPEND);
                return "PDO ERROR: $message storage in " . $this::ERROR_LOG_FILE . PHP_EOL;
            }
        }
    }

    function deleteCategory($id)
    {
        $check_categories = $this->bdd->query(  "with recursive cte (id, name, parent_id) as (
                                                select      id, 
                                                            name,
                                                            parent_id
                                                from        categories   
                                                where       parent_id = $id  
                                                union all   
                                                select      p.id,
                                                            p.name,
                                                            p.parent_id
                                                from        categories p
                                                inner join  cte
                                                on          p.parent_id = cte.id )
                                                select * from cte;");
        $category_parent = $check_categories->fetchAll();
        $check_product = $this->bdd->query("SELECT * FROM products WHERE category_id = '$id';");
        $product_link = $check_product->fetchAll();
        if($category_parent){
            return "Cannot delete : The Category you try to delete is link to others Category !" . PHP_EOL;
        }
        elseif($product_link) {
            return "Cannot delete : The Category you try to delete is link to Products !" . PHP_EOL;
        }
        else {
            try {
                $this->bdd->query("DELETE FROM categories WHERE id = '$id';");
                return "Category succesfully delete!" . PHP_EOL;
            } catch (PDOException $error) {
                $message = $error->getMessage();
    
                file_put_contents($this::ERROR_LOG_FILE, $message . PHP_EOL, FILE_APPEND);
                return "PDO ERROR: $message storage in " . $this::ERROR_LOG_FILE . PHP_EOL;
            }
        }
    }

    function updateCategory($id, $name, $parent_id)
    {
        $status = TRUE;

        if (strpos($name, ';') == TRUE) {
            return "The name must not contain ;" . PHP_EOL;
            $status = FALSE;
        }

        if ((!is_int($parent_id)) && ($parent_id !== null)) {
            return "The category parent id must be null or a number !" . PHP_EOL;
            $status = FALSE;
        }

        if ($status == TRUE) {

            try {
                $request = $this->bdd->prepare('UPDATE categories 
                                                SET name = :name,
                                                parent_id = :parent_id
                                                WHERE id = :id;');
                $request->bindParam(':name', $name, PDO::PARAM_STR);
                $request->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
                $request->bindParam(':id', $id, PDO::PARAM_INT);
                $request->execute();
                return "Category updated successfully !" . PHP_EOL;
            } catch (PDOException $error) {
                $message = $error->getMessage();

                file_put_contents($this::ERROR_LOG_FILE, $message . PHP_EOL, FILE_APPEND);
                return "PDO ERROR: $message storage in " . $this::ERROR_LOG_FILE . PHP_EOL;
            }
        }
    }
}

$category_class = new Category($bdd);
