<?php
include_once 'yamGame.php';
include_once 'player.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jeu de dé</title>
    <link rel="stylesheet" type="text/css" href="yam.css">
</head>
<body>
	<form method="post">
		<label>Player 1</label>
		<input type="text" name="player1" required>
		<label>Player 2</label>
		<input type="text" name="player2" required>
		<button type="submit" name="reset" value="1">Nouvelle Partie</button>
	</form>
</br></br>
<?php
if (isset($_POST['reset'])){
	$player1= new Player($_POST['player1']);
	$player2= new Player($_POST['player2']);
	$game = new YamGame([$player1,$player2]);
} else if (isset($_SESSION['yamGame'])) {
	$game = unserialize($_SESSION['yamGame']);
} else {
	header("location: index.php");
}
if (isset($_POST['toReroll'])){
	foreach ($_POST['toReroll'] as $diceNumber) {
		$game->getCurrentPlayer()->getBucket()->rerollDice($diceNumber);
	}
	$game->rerollCountDown();
}
if (isset($_POST['score'])){
	$player= $game->getCurrentPlayer();
	$player->scorePoints($_POST['score']);
	$game->nextPlayer();
}
displayScoreTables($game);

$_SESSION['yamGame'] = serialize($game);

?>
</body>
</html>


<?php

function displayDices($game){
	$bucketValues = $game->getCurrentPlayer()->getBucket()->getDicesValues();
	echo '<div class="dicevalues"><h2>' . $game->getCurrentPlayer()->getName() . ' playing</h2><form method="post" action="">';
	$rerollsLeft = $game->getCurrentPlayerRerolls();
			
	foreach ($bucketValues as $key => $value) {
		echo '<div><label>Le dé ' . $key . ' a fait ' . $value . ', relancer : </label>';
		if ($rerollsLeft >0) {
		echo '<input type="checkbox" name="toReroll[]" value="' . $key . '"/>';
		}
		echo '</div>';
	}
	echo '<label>Il vous reste ' . $rerollsLeft . ' lancés</label></br>';
	if ($rerollsLeft >0) {
		echo '<button type="submit">Relancer</button>';
	}
	echo '</form></div>';
}

function displayScoreTables($game){
	$players = $game->getPlayers();
	echo '<div class="playertable">';
	displayDices($game);
	foreach ($players as $idPlayer => $player) {
		echo '<table><tr><th>Joueur</th><th>' . ($idPlayer + 1) . '  ' . $player->getName() . '</th></tr>';
		foreach ($player->getScoreTable() as $category => $score) {
			if (is_null($score)) {
				$score = 'A jouer';
			}
		 	echo '<tr><td>' . $category . '</td><td>' . $score . '</td>';
		 	if ($player == $game->getCurrentPlayer() && $score == 'A jouer') {
		 		echo '<td><form method="post"><button type="submit" name="score" value="' . $category . '">Marquer</button></form></td>';
		 	}
		 	echo '</tr>';
		}
		echo '<tr><td>Total</td><td>' . $game->getPlayerScore($idPlayer) . '</td></tr></table>';
	}
	'</div>';
}