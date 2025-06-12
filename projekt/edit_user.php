<?php
session_start();
require_once 'db_connect.php';


if (!isset($_SESSION["user"]) || $_SESSION["user"]["rola"] !== 'admin') {
    header("Location: login.php");
    exit();
}


$id_uzytkownika = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id_uzytkownika === 0) {
    echo "Nieprawidłowe ID użytkownika.";
    exit();
}


$stmt = $mysqli->prepare("SELECT * FROM uzytkownicy WHERE id = ?");
$stmt->bind_param("i", $id_uzytkownika);
$stmt->execute();
$result = $stmt->get_result();
$uzytkownik = $result->fetch_assoc();
$stmt->close();

if (!$uzytkownik) {
    echo "Nie znaleziono użytkownika.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj użytkownika</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Edytuj użytkownika</h2>
    <form action="store_updated_user.php" method="post">
        <input type="hidden" name="id" value="<?= $uzytkownik['id'] ?>">

        <label>Imię:
            <input type="text" name="imie" value="<?= htmlspecialchars($uzytkownik['imie']) ?>" required pattern="^[A-Za-zĄĆĘŁŃÓŚŹŻąćęłńóśźż]{2,50}$"
             title="Imię może zawierać tylko litery, bez cyfr i znaków specjalnych (2–50 znaków)">
        </label><br><br>

        <label>Nazwisko:
            <input type="text" name="nazwisko" value="<?= htmlspecialchars($uzytkownik['nazwisko']) ?>" required pattern="^[A-Za-zĄĆĘŁŃÓŚŹŻąćęłńóśźż]{2,50}$"
             title="Imię może zawierać tylko litery, bez cyfr i znaków specjalnych (2–50 znaków)">
        </label><br><br>

        <label>Login:
             <input type="text" name="login" value="<?= htmlspecialchars($uzytkownik['login'] ?? '') ?>" required>
            </label><br><br>

        <label>Hasło: 
            <input type="text" name="haslo" value="<?= htmlspecialchars($uzytkownik['haslo'] ?? '') ?>" required pattern="^(?=.*[A-Z]).{5,}$" 
		    title="Hasło musi mieć min. 5 znaków i zawierać przynajmniej 1 duża literę">
        </label><br><br>

        <label>Rola:
            <select name="rola" required>
                <option value="admin" <?= $uzytkownik['rola'] === 'admin' ? 'selected' : '' ?>>admin</option>
                <option value="nauczyciel" <?= $uzytkownik['rola'] === 'nauczyciel' ? 'selected' : '' ?>>nauczyciel</option>
                <option value="uczen" <?= $uzytkownik['rola'] === 'uczen' ? 'selected' : '' ?>>uczeń</option>
            </select>
        </label><br><br>

        <button type="submit" class="btn-save">Zapisz zmiany</button>
    </form>
</div>
<br>
<button class="btn-back" onclick="window.location.href='list_user.php'">Wróć</button>
</body>
</html>