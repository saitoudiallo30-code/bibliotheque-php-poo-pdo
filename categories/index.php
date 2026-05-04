<?php include "../includes/header.php"; ?>

<div class="container">

<h2>Catégories</h2>

<form method="POST">
    <input name="libelle" placeholder="Nom catégorie">
    <button class="btn">Ajouter</button>
</form>

<table>
<tr>
    <th>Libellé</th>
    <th>Action</th>
</tr>

<?php
require_once "../config/Database.php";
require_once "../classes/categorie.php";

$db = (new Database())->getConnection();
$categorie = new Categorie($db);

if($_POST){
    $categorie->create($_POST['libelle']);
}

if(isset($_GET['delete'])){
    $categorie->delete($_GET['delete']);
}

$data = $categorie->getAll();

foreach($data as $row):
?>
<tr>
    <td><?= $row['libelle'] ?></td>
    <td>
        <a class="delete" href="?delete=<?= $row['id'] ?>">Supprimer</a>
    </td>
</tr>
<?php endforeach; ?>

</table>

</div>

<?php include "../includes/footer.php"; ?>