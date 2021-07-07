<?php

class Connect
{
    const ERROR_LOG_FILE = "error_log_file";

    function connect_db()
    {
        try {
            $connexion = new PDO("mysql:host=localhost;dbname=my_shop;port=3306", 'benoit', 'Js1udDB_30=P');
            return $connexion;
        } catch (PDOException $e) {
            $error = $e->getMessage();
            echo "PDO ERROR: $error storage in " . self::ERROR_LOG_FILE . PHP_EOL;
            file_put_contents(self::ERROR_LOG_FILE, $error . PHP_EOL, FILE_APPEND);
        }
    }
}

$bdd = new Connect();
