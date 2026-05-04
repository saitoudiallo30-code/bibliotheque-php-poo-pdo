<?php include "../includes/header.php"; ?>

<?php
require_once "../config/Database.php";
require_once "../classes/livre.php";

$db = (new Database())->getConnection();
$livre = new Livre($db);
$data = $livre->getAll();
?>

<div class="container">

<h2>Liste des livres</h2>

<a class="btn" href="ajout.php">Ajouter un livre</a>

<table>
<tr>
    <th>Titre</th>
    <th>ISBN</th>
    <th>Année</th>
    <th>Actions</th>
</tr>

<?php foreach($data as $row): ?>
<tr>
    <td><?= $row['titre'] ?></td>
    <td><?= $row['isbn'] ?></td>
    <td><?= $row['annee'] ?></td>
    <td>
        <a class="edit" href="modifier.php?id=<?= $row['id'] ?>">Modifier</a>
        <a class="delete" href="supprimer.php?id=<?= $row['id'] ?>">Supprimer</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

</div>

<?php include "../includes/footer.php"; ?>