<?php 
    session_start(); // initialise la session avec un no id 
                    // (ici déja crée lors de l'ouverture de la session identification)
    session_unset(); // desactive la session et genere un nouveau id session
    session_destroy(); // detruit ancien id

header('location: ../index.php');
exit(); // inutile ici car fin de code mais bon ...

?>