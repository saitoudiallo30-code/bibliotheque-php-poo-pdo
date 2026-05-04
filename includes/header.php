<?php
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
$current_file = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque</title>
    <link rel="stylesheet" href="<?= $current_dir == 'auteurs' || $current_dir == 'categories' || $current_dir == 'livres' ? '../assets/style.css' : 'assets/style.css' ?>">
</head>
<body>
<div class="container">
    <h1>Gestion de Bibliothèque</h1>
        <a href="auteurs/index.php" class="btn">Auteurs</a>
        <a href="categories/index.php" class="btn">Catégories</a> 
        <a href="livres/index.php" class="btn">Livres</a>
    </h1>