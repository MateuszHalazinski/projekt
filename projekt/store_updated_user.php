<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $imie = trim($_POST['imie']);
    $nazwisko = trim($_POST['nazwisko']);
    $rola = trim($_POST['rola']);

    if (empty($imie) || empty($nazwisko) || empty($rola)) {
        echo "Wszystkie pola są wymagane.";
        exit();
    }

    $stmt = $mysqli->prepare("UPDATE uzytkownicy SET imie = ?, nazwisko = ?, rola = ? WHERE id = ?");
    $stmt->bind_param("sssi", $imie, $nazwisko, $rola, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: list_user.php?edited=1");
    exit();
}
?>
