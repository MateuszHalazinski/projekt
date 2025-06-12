<?php
session_start();
require_once 'db_connect.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id_oceny = intval($_POST['id_oceny']);
	$stara_ocena = floatval($_POST['stara_ocena']);
	$nowa_ocena = floatval($_POST['ocena']);
	$przedmiot = trim($_POST['przedmiot']);
	$komentarz = trim($_POST['komentarz']);
	$admin_id = $_SESSION["user"]["id"];

	// Aktualizacja rekordu w tabeli oceny
	$stmt = $mysqli->prepare("UPDATE oceny SET ocena = ?, przedmiot = ?, komentarz = ? WHERE id = ?");
	$stmt->bind_param("dssi", $nowa_ocena, $przedmiot, $komentarz, $id_oceny);
	$stmt->execute();
	$stmt->close();

	
	$stmt2 = $mysqli->prepare("INSERT INTO historia_ocen (id_oceny, stara_ocena, nowa_ocena, zmodyfikowane_przez) VALUES (?, ?, ?, ?)");
	$stmt2->bind_param("dddi", $id_oceny, $stara_ocena, $nowa_ocena, $admin_id);
	$stmt2->execute();
	$stmt2->close();

	
	header("Location: oceny.php?edited=1");
	exit();
}
?>
