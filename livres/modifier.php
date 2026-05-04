<?php
include "../includes/header.php"; 
require_once "../config/Database.php";
require_once "../classes/livre.php";

$db = (new Database())->getConnection();
$livre = new Livre($db);

$data = $livre->getById($_GET['id']);

if($_POST){
    $livre->update(
        $_GET['id'],
        $_POST['titre'],
        $_POST['isbn'],
        $_POST['annee'],
        $_POST['quantite']
    );
    header("Location: index.php");
}
?>

<form method="POST">
<input value="<?= $data['titre'] ?>" name="titre"><br>
<input value="<?= $data['isbn'] ?>" name="isbn"><br>
<input value="<?= $data['annee'] ?>" name="annee"><br>
<input value="<?= $data['quantite'] ?>" name="quantite"><br>
<button>Modifier</button>
</form>

<?php include "../includes/footer.php"; ?>