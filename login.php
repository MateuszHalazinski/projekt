<?php
session_start();

// Jeśli użytkownik już jest zalogowany, przekieruj go
if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
    exit();
}

require_once 'db_connect.php';
$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputusername = $_POST['username'] ?? "";
    $inputpassword = $_POST['password'] ?? "";

    // Pobierz również ID użytkownika
    $stmt = $mysqli->prepare("SELECT id, haslo, rola FROM uzytkownicy WHERE login = ?");
    $stmt->bind_param("s", $inputusername);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashedPassword, $rola);
        $stmt->fetch();

        if (password_verify($inputpassword, $hashedPassword)) {
            $_SESSION["user"] = [
                "id" => $id, 
                "login" => $inputusername,
                "rola" => $rola
            ];

            switch ($rola) {
                case 'admin':
                    header("Location: dashboard.php");
                    break;
                case 'nauczyciel':
                    header("Location: nauczyciel.php");
                    break;
                case 'uczen':
                    header("Location: uczen.php");
                    break;
                default:
                    header("Location: login.php");
                    break;
            }

            exit();
        }
    }

    $error = "Nieprawidłowe dane logowania";
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Logowanie</title>
</head>
<body>
    <div class="container">
    <h2>Zaloguj się</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="login.php" method="post">
        <label>Login: <input type="text" name="username" required></label><br>
        <label>Hasło: <input type="password" name="password" required></label><br>
        <button type="submit">Zaloguj się</button>
    </form>
    <div>
</body>
</html>

