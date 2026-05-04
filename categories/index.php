<?php
include_once '../config/Database.php';
include_once '../classes/categorie.php';
include_once '../includes/header.php';

$database = new Database();
$db = $database->getConnection();
$categorie = new Categorie($db);
$message = "";

if(isset($_POST['submit'])) {
    $categorie->libelle = trim($_POST['libelle']);
    if(!empty($_POST['id'])) {
        $categorie->id = $_POST['id'];
        if($categorie->modifier()) $message = "Catégorie modifiée ";
    } else {
        if($categorie->creer()) $message = "Catégorie ajoutée ";
    }
}

if(isset($_GET['delete'])) {
    $categorie->id = $_GET['delete'];
    if($categorie->supprimer()) $message = "Catégorie supprimée ";
}

$edit = false;
if(isset($_GET['edit'])) {
    $categorie->id = $_GET['edit'];
    $categorie->lireUn();
    $edit = true;
}

if($message) echo "<p class='msg'>$message</p>";
?>

<h3><?= $edit ? "Modifier une catégorie" : "Ajouter une catégorie" ?></h3>
<form method="POST" action="index.php">
    <input type="hidden" name="id" value="<?= $edit ? $categorie->id : '' ?>">
    <label>Libellé :</label>
    <input type="text" name="libelle" value="<?= $edit ? $categorie->libelle : '' ?>" required>
    <button type="submit" name="submit" class="btn btn-add"><?= $edit ? "Modifier" : "Ajouter" ?></button>
    <?php if($edit) echo '<a href="index.php" class="btn btn-delete">Annuler</a>'; ?>
</form>

<h3>Liste des catégories</h3>
<table>
    <tr><th>ID</th><th>Libellé</th><th>Actions</th></tr>
    <?php
    $stmt = $categorie->lireTous();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['libelle']}</td>
                <td>
                    <a href='index.php?edit={$row['id']}' class='btn btn-edit'>✏️ Modifier</a>
                    <a href='index.php?delete={$row['id']}' class='btn btn-delete' onclick='return confirm(\"Supprimer ?\")'>🗑️ Supprimer</a>
                </td>
              </tr>";
    }
    ?>
</table>

<?php include_once '../includes/footer.php'; ?>