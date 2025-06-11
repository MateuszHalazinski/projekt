<?php
	session_start();
	require_once 'db_connect.php';

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$id_ucznia = trim($_POST['id_ucznia']);
		$ocena = trim($_POST['ocena']);
		$przedmiot = trim($_POST['przedmiot']);
		$komentarz = trim($_POST['komentarz']);

		if ($id_ucznia && $ocena && $przedmiot) {
			$stmt = $mysqli->prepare("INSERT INTO `oceny` (`id_ucznia`, `ocena`, `przedmiot`, `komentarz`) VALUES (?, ?, ?, ?)");
			$stmt->bind_param("idss", $id_ucznia, $ocena, $przedmiot, $komentarz);
			$stmt->execute();

			header("Location: oceny.php?added=1");
			exit;
		} else {
			$_SESSION['form_data'] = $_POST;
			header("Location: add_grade.php?error=1");
			exit;
		}
	}
?>
