<?php
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jeu de dé</title>
    <link rel="stylesheet" type="text/css" href="yam.css">
</head>
<body>
	<form method="post" action="yam.php">
		<label>Player 1</label>
		<input type="text" name="player1" required>
		<label>Player 2</label>
		<input type="text" name="player2" required>
		<button type="submit" name="reset" value="1">Nouvelle Partie</button>
	</form>
</body>
</html>