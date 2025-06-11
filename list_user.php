<?php
    session_start();

    if (!isset($_SESSION["user"]) || $_SESSION["user"]["rola"] !== 'admin') {
      header("location: login.php");
      exit();
    }
	require_once 'db_connect.php';

	$selectedUser = null;

	$sql = "SELECT * FROM `uzytkownicy`;";
	$result = $mysqli->query($sql);



	if (isset($_GET['uzytkownik_id'])) {
		$id = (int) $_GET['uzytkownik_id'];
		$stmt = $mysqli->prepare("SELECT * FROM uzytkownicy WHERE id = ?");
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
				&#x2705 Użytkownik został pomyślnie usunięty
			</div>
		<?php endif; ?>
		
		<div class="container">
			<h2>Lista użytkowników</h2>
		<table>
			<tr>
				<th>ID</th><th>Imie</th><th>Nazwisko</th><th>Rola</th>
			</tr>
			<?php while($row = $result->fetch_object()): ?>
			<tr>
				<td><?= $row->id ?></td>
				<td><?= htmlspecialchars($row->imie) ?></td>
				<td><?= htmlspecialchars($row->nazwisko) ?></td>
				<td><?= htmlspecialchars($row->rola) ?></td>
				<td>
					<a class="detail-link" href="?uzytkownik_id=<?= $row->id ?>">Szczegóły</a>
					<a class="delete-link" href="delete_user.php?id=<?= $row->id ?>" onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika');">Usuń</a>
				</td>

			</tr>
			<?php endwhile; ?>
		</table>
			</div>
		<?php if ($selectedUser): ?>
			<div class="details">
			<h3>Szczegóły użytkownika: <?= htmlspecialchars($selectedUser->id) ?></h3>
			<p>Login: <?= $selectedUser->login ?></p>
			<p>Haslo: <?= $selectedUser->haslo ?></p>
			<p>Rola: <?= $selectedUser->rola ?></p>
			<p><a href="list_user.php">Ukryj szczegóły</a></p>
			</div>
		<?php endif; ?>
		<p><a href="add_user.php"><span style="color:purple; font-family: Arial, sans-serif;">&#x2795;</span>Dodaj nowego użytkownika</a></p>
		<br>
        <button class="btn-back" onclick="window.location.href='dashboard.php'">Wróć</button>
	</body>
	</html>