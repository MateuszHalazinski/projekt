<?php
    session_start();

  if (!isset($_SESSION["user"]) || $_SESSION["user"]["rola"] !== 'admin') {
    header("location: login.php");
    exit();
}

	require_once 'db_connect.php';

	$selectedUser = null;

	$sql = "SELECT * FROM `oceny`;";
	$result = $mysqli->query($sql);

	$historia = [];

if (isset($_GET['user_id'])) {
    $id = (int) $_GET['user_id'];
    $stmt = $mysqli->prepare("SELECT * FROM oceny WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $selectedUser = $stmt->get_result()->fetch_object();
    $stmt->close();

   
    $stmt2 = $mysqli->prepare("
        SELECT h.*, u.login AS zmodyfikowane_przez_login
        FROM historia_ocen h
        JOIN uzytkownicy u ON h.zmodyfikowane_przez = u.id
        WHERE h.id_oceny = ?
        ORDER BY h.data_modyfikacji DESC
    ");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $historia = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt2->close();
}

?>

	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lista użytkowników</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
			<div class="alert alert-success">
				&#x2705 ocena został pomyślnie usunięta
			</div>
		<?php endif; ?>
		<div class="container">
			<h2>Lista ocen</h2>
		<table>
			<tr>
				<th>ID</th><th>id_ucznia</th><th>ocena</th><th>przedmiot</th><th>komentarz</th>
			</tr>
			<?php while($row = $result->fetch_object()): ?>
			<tr>
				<td><?= $row->id ?></td>
				<td><?= htmlspecialchars($row->id_ucznia) ?></td>
				<td><?= htmlspecialchars($row->ocena) ?></td>
				<td><?= htmlspecialchars($row->przedmiot) ?></td>
                <td><?= htmlspecialchars($row->komentarz) ?></td>
				<td>
					<a class="detail-link" href="?user_id=<?= $row->id ?>">Szczegóły</a>
					<a class="detail-link" href="edit_grade.php?id=<?= $row->id ?>">Edytuj</a>
					<a class="delete-link" href="delete_grade.php?id=<?= $row->id ?>" onclick="return confirm('Czy na pewno chcesz usunąć ocene');">Usuń</a>
				</td>

			</tr>
			<?php endwhile; ?>
		</table>
		</div>
		<?php if ($selectedUser): ?>
	    <div class="details">

		<h4>Historia modyfikacji:</h4>
		<?php if (count($historia) > 0): ?>
			<table>
				<tr>
					<th>Stara ocena</th>
					<th>Nowa ocena</th>
					<th>Data modyfikacji</th>
					<th>Zmodyfikował</th>
				</tr>
				<?php foreach ($historia as $entry): ?>
					<tr>
						<td><?= htmlspecialchars($entry['stara_ocena']) ?></td>
						<td><?= htmlspecialchars($entry['nowa_ocena']) ?></td>
						<td><?= htmlspecialchars($entry['data_modyfikacji']) ?></td>
						<td><?= htmlspecialchars($entry['zmodyfikowane_przez_login']) ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		<?php else: ?>
			<p>Brak historii modyfikacji dla tej oceny.</p>
		<?php endif; ?>

		<p><a href="oceny.php">Ukryj szczegóły</a></p>
	    </div>
        <?php endif; ?>
	 <p><a href="add_grade.php"><span style="color:purple; font-family: Arial, sans-serif;">&#x2795;</span>Dodaj nową ocene</a></p>
	<br>
	<button class="btn-back" onclick="window.location.href='dashboard.php'">Wróć</button>

   
</body>
</html>