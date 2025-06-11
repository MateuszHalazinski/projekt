<?php
session_start();



// Sprawdzenie, czy użytkownik jest zalogowany i czy jest uczniem
if (!isset($_SESSION["user"]) || $_SESSION["user"]["rola"] !== 'uczen') {
	header("Location: login.php");
	exit();
}

require_once 'db_connect.php';

$loggedUserId = $_SESSION["user"]["id"]; // ID zalogowanego ucznia
$selectedUser = null;

// Pobranie tylko ocen ucznia, który jest zalogowany
$stmt = $mysqli->prepare("SELECT * FROM `oceny` WHERE `id_ucznia` = ?");
$stmt->bind_param("i", $loggedUserId);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Moje oceny</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<h2>Twoje oceny</h2>
	<table>
		<tr>
			<th>ID</th><th>Ocena</th><th>Przedmiot</th><th>Komentarz</th>
		</tr>
		<?php while($row = $result->fetch_object()): ?>
		<tr>
			<td><?= $row->id ?></td>
			<td><?= htmlspecialchars($row->ocena) ?></td>
			<td><?= htmlspecialchars($row->przedmiot) ?></td>
			<td><?= htmlspecialchars($row->komentarz) ?></td>
		</tr>
		<?php endwhile; ?>
	</table>

	<a href="logout.php">Wyloguj się</a>
</body>
</html>
