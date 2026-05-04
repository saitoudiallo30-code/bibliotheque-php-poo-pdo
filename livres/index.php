<?php
include_once '../config/Database.php';
include_once '../classes/auteur.php';
include_once '../classes/categorie.php';
include_once '../classes/livre.php';
include_once '../includes/header.php';

$database = new Database();
$db = $database->getConnection();
$livre = new Livre($db);
$auteur = new Auteur($db);
$categorie = new Categorie($db);
$message = "";

if(isset($_POST['submit'])) {
    $livre->titre = trim($_POST['titre']);
    $livre->isbn = trim($_POST['isbn']);
    $livre->annee = $_POST['annee'];
    $livre->quantite = $_POST['quantite'];
    $livre->auteur_id = $_POST['auteur_id'];
    $livre->categorie_id = $_POST['categorie_id'];
    if(!empty($_POST['id'])) {
        $livre->id = $_POST['id'];
        if($livre->modifier()) $message = "Livre modifié ";
    } else {
        if($livre->creer()) $message = "Livre ajouté ";
    }
}

if(isset($_GET['delete'])) {
    $livre->id = $_GET['delete'];
    if($livre->supprimer()) $message = "Livre supprimé ";
}

$edit = false;
if(isset($_GET['edit'])) {
    $livre->id = $_GET['edit'];
    $livre->lireUn();
    $edit = true;
}

if($message) echo "<p class='msg'>$message</p>";
?>

<h3><?= $edit ? "Modifier un livre" : "Ajouter un livre" ?></h3>
<form method="POST" action="index.php">
    <input type="hidden" name="id" value="<?= $edit ? $livre->id : '' ?>">
    <label>Titre :</label><input type="text" name="titre" value="<?= $edit ? $livre->titre : '' ?>" required>
    <label>ISBN :</label><input type="text" name="isbn" value="<?= $edit ? $livre->isbn : '' ?>" required>
    <label>Année :</label><input type="number" name="annee" value="<?= $edit ? $livre->annee : '' ?>" required>
    <label>Quantité :</label><input type="number" name="quantite" value="<?= $edit ? $livre->quantite : '' ?>" required>
    <label>Auteur :</label>
    <select name="auteur_id" required>
        <option value="">-- Choisir --</option>
        <?php $stmt_a = $auteur->lireTous(); while($row = $stmt_a->fetch()) {
            $selected = ($edit && $row['id'] == $livre->auteur_id) ? 'selected' : '';
            echo "<option value='{$row['id']}' $selected>{$row['nom']}</option>"; } ?>
    </select>
    <label>Catégorie :</label>
    <select name="categorie_id" required>
        <option value="">-- Choisir --</option>
        <?php $stmt_c = $categorie->lireTous(); while($row = $stmt_c->fetch()) {
            $selected = ($edit && $row['id'] == $livre->categorie_id) ? 'selected' : '';
            echo "<option value='{$row['id']}' $selected>{$row['libelle']}</option>"; } ?>
    </select>
    <button type="submit" name="submit" class="btn btn-add"><?= $edit ? "Modifier" : "Ajouter" ?></button>
    <?php if($edit) echo '<a href="index.php" class="btn btn-delete">Annuler</a>'; ?>
</form>

<h3>Liste des livres</h3>
<table>
    <tr><th>Titre</th><th>ISBN</th><th>Année</th><th>Qté</th><th>Auteur</th><th>Catégorie</th><th>Actions</th></tr>
    <?php $stmt = $livre->lireTous(); while($row = $stmt->fetch()) {
        echo "<tr>
                <td>{$row['titre']}</td><td>{$row['isbn']}</td><td>{$row['annee']}</td>
                <td>{$row['quantite']}</td><td>{$row['auteur_nom']}</td><td>{$row['categorie_libelle']}</td>
                <td>
                    <a href='index.php?edit={$row['id']}' class='btn btn-edit'>✏️ Modifier</a>
                    <a href='index.php?delete={$row['id']}' class='btn btn-delete' onclick='return confirm(\"Supprimer ?\")'>🗑️ Supprimer</a>
                </td>
              </tr>"; } ?>
</table>

<?php include_once '../includes/footer.php'; ?>