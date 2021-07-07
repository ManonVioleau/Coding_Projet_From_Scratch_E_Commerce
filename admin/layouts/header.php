<?php
session_start();

if ($_SESSION['admin'] != 1) {
    header('location: ../user/deconnexion.php');
    exit();
}
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

    <link rel="stylesheet" href="../style/style-CRUD.css">

</head>

<body>
    <header>
        <!-- left menu -->
        <nav class="left-menu">
            <a href="/admin/admin.php">
                <img src="/assets/Logo.png" alt="">
            </a>
            <ul>
                <li>
                    <h1> <a href="/admin/admin.php">Adminitrator</a> </h1>
                </li>
            </ul>
        </nav>

        <nav class="right-menu">
            <ul>
                <li>
                    <h1><a href="../user/deconnexion.php">Déconnection</a></h1>
                </li>
            </ul>
        </nav>
    </header>