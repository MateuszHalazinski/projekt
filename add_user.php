<?php
	session_start();

	$formData = $_SESSION['form_data'] ?? [];
	unset($_SESSION['form_data']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dodaj użytkownika</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<h2>Dodaj użytkownika</h2>
	<form action="store_user.php" method="post">
		<label>Imię: <input type="text" name="imie" value="<?= htmlspecialchars($formData['imie'] ?? '') ?>" required></label><br><br>
		<label>Nazwisko: <input type="text" name="nazwisko" value="<?= htmlspecialchars($formData['nazwisko'] ?? '') ?>" required></label><br><br>
		<label>Login: <input type="text" name="login" value="<?= htmlspecialchars($formData['login'] ?? '') ?>" required></label><br><br>
		<label>Hasło: <input type="text" name="haslo" value="<?= htmlspecialchars($formData['haslo'] ?? '') ?>" required></label><br><br>
		<label>Rola:
			<select name="rola" required>
				<option value="">-- wybierz --</option>
				<option value="admin" <?= ($formData['rola'] ?? '') === 'admin' ? 'selected' : '' ?>>admin</option>
				<option value="nauczyciel" <?= ($formData['rola'] ?? '') === 'nauczyciel' ? 'selected' : '' ?>>nauczyciel</option>
				<option value="uczeń" <?= ($formData['rola'] ?? '') === 'uczen' ? 'selected' : '' ?>>uczen</option>
			</select>
		</label><br><br>
		
			

			<button type="submit" class="btn-save">Zapisz</button>
	</form>
    </div>
	<br>
	<button class="btn-back" onclick="window.location.href='list_user.php'">Wróć</button>

</body>
</html>


