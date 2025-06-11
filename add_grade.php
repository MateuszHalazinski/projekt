<?php
	session_start();

	$formData = $_SESSION['form_data'] ?? [];
	unset($_SESSION['form_data']);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dodaj ocenę</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
	<form action="store_grade.php" method="post">
		<label>ID ucznia: <input type="number" name="id_ucznia" value="<?= htmlspecialchars($formData['id_ucznia'] ?? '') ?>" required></label><br><br>
		<label>Ocena (np. 4.5): <input type="number" step="0.1" name="ocena" value="<?= htmlspecialchars($formData['ocena'] ?? '') ?>" required></label><br><br>
		<label>Przedmiot: <input type="text" name="przedmiot" value="<?= htmlspecialchars($formData['przedmiot'] ?? '') ?>" required></label><br><br>
		<label>Komentarz:
			<textarea name="komentarz" cols="50" rows="4"><?= htmlspecialchars($formData['komentarz'] ?? '') ?></textarea>
		</label><br><br>

		<button type="submit">Zapisz</button>
	</form>
</div>
	<br>
	<button class="btn-back" onclick="window.location.href='oceny.php'">Wróć</button>
</body>
</html>
