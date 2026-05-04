<?php include "../includes/header.php"; ?>

<div class="container">

<h2>Gestion des auteurs</h2>

<form method="POST">
    <input name="nom" placeholder="Nom">
    <input name="prenom" placeholder="Prénom">
    <input name="nationalite" placeholder="Nationalité">
    <button class="btn">Ajouter</button>
</form>

<table>
<tr>
    <th>Nom</th>
    <th>Prénom</th>
    <th>Nationalité</th>
    <th>Action</th>
</tr>

<?php
require_once "../config/Database.php";
require_once "../classes/auteur.php";

$db = (new Database())->getConnection();
$auteur = new Auteur($db);

if($_POST){
    $auteur->create($_POST['nom'],$_POST['prenom'],$_POST['nationalite']);
}

if(isset($_GET['delete'])){
    $auteur->delete($_GET['delete']);
}

$data = $auteur->getAll();

foreach($data as $row):
?>
<tr>
    <td><?= $row['nom'] ?></td>
    <td><?= $row['prenom'] ?></td>
    <td><?= $row['nationalite'] ?></td>
    <td>
        <a class="delete" href="?delete=<?= $row['id'] ?>">Supprimer</a>
    </td>
</tr>
<?php endforeach; ?>

</table>

</div>

<?php include "../includes/footer.php"; ?>