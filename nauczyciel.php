<?php
    session_start();

  if (!isset($_SESSION["user"]) || $_SESSION["user"]["rola"] !== 'nauczyciel' ) {
    header("location: login.php");
    exit();
   }
	require_once 'db_connect.php';

	$selectedUser = null;

	$sql = "SELECT * FROM `oceny`;";
	$result = $mysqli->query($sql);



	if (isset($_GET['user_id'])) {
		$id = (int) $_GET['user_id'];
		$stmt = $mysqli->prepare("SELECT * FROM oceny WHERE id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$selectedUser = $stmt->get_result()->fetch_object();
		$stmt->close();
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
		<h2>Lista ocen</h2>
		<div class="container">
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
					<a class="delete-link" href="nauczyciel_delete.php?id=<?= $row->id ?>" onclick="return confirm('Czy na pewno chcesz usunąć ocene');">Usuń</a>
				</td>

			</tr>
			<?php endwhile; ?>
		</table>
		</div>
	 <p><a href="nauczyciel_add.php"><span style="color:purple; font-family: Arial, sans-serif;">&#x2795;</span>Dodaj nową ocene</a></p>
    <a href="logout.php">Wyloguj się</a>
</body>
</html>
