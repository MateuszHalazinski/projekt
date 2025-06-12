<?php
	session_start();
	require_once 'db_connect.php';

    $uczniowie = $mysqli->query("SELECT id, imie, nazwisko FROM uzytkownicy WHERE rola = 'uczen'")->fetch_all(MYSQLI_ASSOC);

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
	<h2>Dodaj ocene</h2>
	<form action="store_grade.php" method="post">
		<label>ID ucznia: 
          <select name="id_ucznia" required>
           <option value="">-- wybierz ucznia --</option>
           <?php foreach ($uczniowie as $u): ?>
            <option value="<?= $u['id'] ?>">
                <?= $u['id'] ?> – <?= htmlspecialchars($u['imie'] . ' ' . $u['nazwisko']) ?>
            </option>
          <?php endforeach; ?>
         </select>
        </label>
		<label>Ocena (np. 4.5): <input type="number" step="0.1" name="ocena" value="<?= htmlspecialchars($formData['ocena'] ?? '') ?>" required></label><br><br>
		<label>Przedmiot: <input type="text" name="przedmiot" value="<?= htmlspecialchars($formData['przedmiot'] ?? '') ?>" required></label><br><br>
		<label>Komentarz:
			<textarea name="komentarz" cols="50" rows="4"><?= htmlspecialchars($formData['komentarz'] ?? '') ?></textarea>
		</label><br><br>

		<button type="submit" class="btn-save">Zapisz</button>
	</form>
</div>
	<br>
	<button class="btn-back" onclick="window.location.href='oceny.php'">Wróć</button>
</body>
</html>
