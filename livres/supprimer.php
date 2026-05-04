<?php
require_once "../config/Database.php";
require_once "../classes/livre.php";

$db = (new Database())->getConnection();
$livre = new Livre($db);

$livre->id = $_GET['id'];

if($livre->delete()) {
    header("Location: index.php");
}
?>