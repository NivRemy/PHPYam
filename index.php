<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jeu de dé</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="yam.css">
</head>
<body>
	<div class="container">
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
		<h1>Yam's</h1>
		<form method="post" action="yam.php">
			<div class="form-group">
				<label for="P1">Joueur 1</label>
				<input type="text" name="player1" id="P1" required>
			</div>
			<div class="form-group">
			<label for="P2">Joueur 2</label>
				<input type="text" id="P2" name="player2" required>
			</div>
			<div class="form-group">
				<button type="submit" name="pNumber" value="2" class="newGame btn btn-primary">Nouvelle Partie
				</button>
			</div>
		</form>

		<h2>Plus de Joueurs?</h2>
		<form method="get">
			<div class="form-group">
			<label for="NbP">Choisissez le nombre de joueurs</label>
				<select id="NbP" name="playerNumber">
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
				</select>
			</div>
			<div class="form-group">
				<button class="newGame btn btn-primary" type="submit">Jouer
				</button>
			</div>
		</form>
	<?php	
	}
	?>
	</div>
</body>
</html>