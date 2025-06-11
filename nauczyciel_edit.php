<?php
session_start();
require_once 'db_connect.php';


if (!isset($_SESSION["user"]) || $_SESSION["user"]["rola"] !== 'nauczyciel') {
	header("Location: login.php");
	exit();
}


$id_oceny = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id_oceny === 0) {
	echo "Nieprawidłowe ID oceny.";
	exit();
}


$stmt = $mysqli->prepare("SELECT * FROM oceny WHERE id = ?");
$stmt->bind_param("i", $id_oceny);
$stmt->execute();
$result = $stmt->get_result();
$ocena = $result->fetch_assoc();
$stmt->close();

if (!$ocena) {
	echo "Nie znaleziono oceny.";
	exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<title>Edytuj ocenę</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
	<h2>Edytuj ocenę</h2>
	<form action="nauczyciel_store_grade.php" method="post">
		<input type="hidden" name="id_oceny" value="<?= $ocena['id'] ?>">
		<input type="hidden" name="stara_ocena" value="<?= htmlspecialchars($ocena['ocena']) ?>">

		<label>Ocena:
			<input type="number" step="0.1" name="ocena" value="<?= htmlspecialchars($ocena['ocena']) ?>" required>
		</label><br><br>

		<label>Przedmiot:
			<input type="text" name="przedmiot" value="<?= htmlspecialchars($ocena['przedmiot']) ?>" required>
		</label><br><br>

		<label>Komentarz:
			<textarea name="komentarz" rows="4" cols="50"><?= htmlspecialchars($ocena['komentarz']) ?></textarea>
		</label><br><br>

		<button type="submit" class="btn-save">Zapisz zmiany</button>
	</form>
</div>
<br>

<button class="btn-back" onclick="window.location.href='nauczyciel.php'">Wróć</button>
</body>
</html>