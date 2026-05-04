<?php
include "../includes/header.php"; 
require_once "../config/Database.php";
require_once "../classes/livre.php";
require_once "../classes/auteur.php";
require_once "../classes/categorie.php";

$db = (new Database())->getConnection();

$livre = new Livre($db);
$auteur = new Auteur($db);
$categorie = new Categorie($db);

if($_POST){
    $livre->create(
        $_POST['titre'],
        $_POST['isbn'],
        $_POST['annee'],
        $_POST['quantite'],
        $_POST['auteur'],
        $_POST['categorie']
    );
    header("Location: index.php");
}

$auteurs = $auteur->getAll();
$categories = $categorie->getAll();
?>

<h2>Ajouter livre</h2>

<form method="POST">
<input name="titre" placeholder="Titre"><br>
<input name="isbn" placeholder="ISBN"><br>
<input type="number" name="annee"><br>
<input type="number" name="quantite"><br>

<select name="auteur">
<?php foreach($auteurs as $a): ?>
<option value="<?= $a['id'] ?>"><?= $a['nom'] ?></option>
<?php endforeach; ?>
</select>

<select name="categorie">
<?php foreach($categories as $c): ?>
<option value="<?= $c['id'] ?>"><?= $c['libelle'] ?></option>
<?php endforeach; ?>
</select>

<button>Ajouter</button>
</form>

<?php include "../includes/footer.php"; ?>