<?php
include_once '../config/Database.php';
include_once '../classes/auteur.php';
include_once '../includes/header.php';

$database = new Database();
$db = $database->getConnection();
$auteur = new Auteur($db);
$message = "";

if(isset($_POST['submit'])) {
    $auteur->nom = trim($_POST['nom']);
    if(!empty($_POST['id'])) {
        $auteur->id = $_POST['id'];
        if($auteur->modifier()) $message = "Auteur modifié";
    } else {
        if($auteur->creer()) $message = "Auteur ajouté";
    }
}

if(isset($_GET['delete'])) {
    $auteur->id = $_GET['delete'];
    if($auteur->supprimer()) $message = "Auteur supprimé ❌";
}

$edit = false;
if(isset($_GET['edit'])) {
    $auteur->id = $_GET['edit'];
    $auteur->lireUn();
    $edit = true;
}

if($message) echo "<p class='msg'>$message</p>";
?>

<h3><?= $edit ? "Modifier un auteur" : "Ajouter un auteur" ?></h3>
<form method="POST" action="index.php">
    <input type="hidden" name="id" value="<?= $edit ? $auteur->id : '' ?>">
    <label>Nom :</label>
    <input type="text" name="nom" value="<?= $edit ? $auteur->nom : '' ?>" required>
    <button type="submit" name="submit" class="btn btn-add"><?= $edit ? "Modifier" : "Ajouter" ?></button>
    <?php if($edit) echo '<a href="index.php" class="btn btn-delete">Annuler</a>'; ?>
</form>

<h3>Liste des auteurs</h3>
<table>
    <tr><th>ID</th><th>Nom</th><th>Actions</th></tr>
    <?php
    $stmt = $auteur->lireTous();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nom']}</td>
                <td>
                    <a href='index.php?edit={$row['id']}' class='btn btn-edit'>✏️ Modifier</a>
                    <a href='index.php?delete={$row['id']}' class='btn btn-delete' onclick='return confirm(\"Supprimer ?\")'>🗑️ Supprimer</a>
                </td>
              </tr>";
    }
    ?>
</table>

<?php include_once '../includes/footer.php'; ?>