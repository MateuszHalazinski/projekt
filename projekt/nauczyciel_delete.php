<?php
	require_once 'db_connect.php';

	if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
		$id = (int) $_GET['id'];

		$stmt = $mysqli->prepare("DELETE FROM oceny WHERE `oceny`.`id` = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();

		header("Location: nauczyciel.php?deleted=1");
		exit();
	}