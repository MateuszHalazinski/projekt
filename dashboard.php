<?php
session_start();

if (!isset($_SESSION["user"]) || $_SESSION["user"]["rola"] !== 'admin') {
    header("location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Panel administratora</title>
</head>
<body>
    <h2>Witaj, <?php echo htmlspecialchars($_SESSION["user"]["login"]); ?> (<?php echo $_SESSION["user"]["rola"]; ?>)</h2>
    <div class="container">
    <h2>Panel administratora</h2>
    <button class="btn-go" onclick="window.location.href='list_user.php'">Użytkownicy</button>
    <br>
    <br>
    <button class="btn-go" onclick="window.location.href='oceny.php'">Oceny</button>
    <br>
    <br>
    <a href="logout.php">Wyloguj się</a>
</div>
</body>
</html>
