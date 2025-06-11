<?php
session_start();


if (!isset($_SESSION["user"]) || $_SESSION["user"]["rola"] !== 'uczen') {
	header("Location: login.php");
	exit();
}

require_once 'db_connect.php';

$loggedUserId = $_SESSION["user"]["id"];
$historia = [];


$stmt = $mysqli->prepare("SELECT * FROM `oceny` WHERE `id_ucznia` = ?");
$stmt->bind_param("i", $loggedUserId);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();


if (isset($_GET['ocena_id'])) {
	$ocena_id = intval($_GET['ocena_id']);

	
	$stmt = $mysqli->prepare("SELECT * FROM oceny WHERE id = ? AND id_ucznia = ?");
	$stmt->bind_param("ii", $ocena_id, $loggedUserId);
	$stmt->execute();
	$ocena = $stmt->get_result()->fetch_assoc();
	$stmt->close();

	if ($ocena) {
		
		$stmt = $mysqli->prepare("
			SELECT h.*, u.login AS zmodyfikowane_przez_login
			FROM historia_ocen h
			LEFT JOIN uzytkownicy u ON h.zmodyfikowane_przez = u.id
			WHERE h.id_oceny = ?
			ORDER BY h.data_modyfikacji DESC
		");
		$stmt->bind_param("i", $ocena_id);
		$stmt->execute();
		$historia = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close();
	}
}
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

	<div class="container">
	<table>
		<tr>
			<th>ID</th><th>Ocena</th><th>Przedmiot</th><th>Komentarz</th><th>Akcje</th>
		</tr>
		<?php while($row = $result->fetch_object()): ?>
		<tr>
			<td><?= $row->id ?></td>
			<td><?= htmlspecialchars($row->ocena) ?></td>
			<td><?= htmlspecialchars($row->przedmiot) ?></td>
			<td><?= htmlspecialchars($row->komentarz) ?></td>
			<td><a class="detail-link" href="?ocena_id=<?= $row->id ?>">Szczegóły</a></td>
		</tr>
		<?php endwhile; ?>
	</table>
	</div>

	
	<?php if (isset($_GET['ocena_id'])): ?>
		<div class="details">
			<h3>Szczegóły modyfikacji oceny ID <?= htmlspecialchars($ocena_id) ?></h3>
			<?php if (count($historia) > 0): ?>
				<table>
					<tr>
						<th>Stara ocena</th>
						<th>Nowa ocena</th>
						<th>Data</th>
						<th>Kto zmodyfikował</th>
					</tr>
					<?php foreach ($historia as $entry): ?>
					<tr>
						<td><?= htmlspecialchars($entry['stara_ocena']) ?></td>
						<td><?= htmlspecialchars($entry['nowa_ocena']) ?></td>
						<td><?= htmlspecialchars($entry['data_modyfikacji']) ?></td>
						<td><?= htmlspecialchars($entry['zmodyfikowane_przez_login'] ?? 'brak') ?></td>
					</tr>
					<?php endforeach; ?>
				</table>
			<?php else: ?>
				<p>Brak historii modyfikacji dla tej oceny.</p>
			<?php endif; ?>
			<p><a href="uczen.php">Ukryj szczegóły</a></p>
		</div>
	<?php endif; ?>

	<br>
	<a href="logout.php">Wyloguj się</a>
</body>
</html>
