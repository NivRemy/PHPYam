<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jeu de dé</title>
    <link rel="stylesheet" type="text/css" href="yam.css">
</head>
<body>
	<?php
	if (isset($_GET['playerNumber'])){
		?>
	<form method="post" action="yam.php">
		<?php
		for($i=1;$i<=$_GET['playerNumber'];$i++){
		?>
		<div>
			<label>Joueur <?= $i; ?></label>
			<input type="text" name="player<?= $i; ?>" required>
		</div>
		<?php
		}
		?>
		<button type="submit" name="pNumber" value="<?= $_GET['playerNumber']; ?>">Jouer</button>
	</form>
	
<?php

} else {

	?>
	<form method="post">
		<label>Joueur 1</label>
		<input type="text" name="player1" required>
		<label>Joueur 2</label>
		<input type="text" name="player2" required>
		<button type="submit" name="pNumber" value="2" class="newGame">Nouvelle Partie</button>
	</form>

	<h2>Plus de Joueurs?</h2>
	<form method="get">
		<label>Choisissez le nombre de joueurs</label>
		<select name="playerNumber">
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
		</select>
		<button type="submit">Jouer</button>
	</form>
<?php
}
?>

</body>
</html>