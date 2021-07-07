<?php
    include_once('../class/users.php');
    $action = explode("-", $_POST["action"]);
    if ($action[0] == "update") {
        include_once("update-users.php");

    } elseif ($action[0] == "delete") {
        $error = "delete";

        include_once("check-users.php");
    }

    if (isset($_POST['confirmation'])) {
        if ($_POST['confirmation'] != "non") {
            $id = intval($_POST['confirmation']);
            $users->deleteUser($id);
            $error = "Utilisateur " . $users->get_name($id) . "supprimé.";
        }
        include_once("check-users.php");
    }
?>