<?php
	session_start();
	require_once 'db_connect.php';

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$imie = trim($_POST['imie']);
		$nazwisko = trim($_POST['nazwisko']);
		$login = trim($_POST['login']);
		$haslo = password_hash(trim($_POST['haslo']), PASSWORD_DEFAULT);
		$rola = trim($_POST['rola']);

		if ($imie && $nazwisko && $login && $haslo && $rola) {
			$stmt = $mysqli->prepare("INSERT INTO `uzytkownicy` (`imie`, `nazwisko`, `login`, `haslo`, `rola`) VALUES (?, ?, ?, ?, ?);");
			$stmt->bind_param("sssss", $imie, $nazwisko, $login, $haslo ,$rola );
			$stmt->execute();

			header("Location: list_user.php?added=1");
			exit;
		}else{
			$_SESSION['form_data'] = $_POST;
			header("Location: add_user.php?error=1");
			exit;
		}
	}
