<?php
include_once 'yamGame.php';
include_once 'player.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jeu de dé</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="yam.css">
</head>
<body>
	<div class="container playmenu">
		<div class="play-menu"><h1>Yam's</h1></div>
		<div class="play-menu"><div class="dropdown">	
  			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    	Nouvelle Partie
  			</button>
  			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<form method="post" action="index.php">
					<div class="form-group">	
						<label>Joueur 1</label>
						<input type="text" name="player1" required>
					</div>
					<div class="form-group">
						<label>Joueur 2</label>
						<input type="text" name="player2" required>
					</div>
					<div class="form-group">
						<button type="submit" name="pNumber" value="2" class="newGame">Partie 2 Joueurs
						</button>
					</div>
				</form>
				<form method="get" action="index.php">
					<div class="form-group">
						<label>Choisissez le nombre de joueurs</label>
						<select name="playerNumber">
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
						</select>
					</div>
					<div class="form-group">
						<button class="newGame" type="submit">Nouvelle partie</button>
					</div>
				</form>
			</div></div>
		</div>
	</div>
</br></br>
<?php
if (isset($_POST['pNumber'])){
	$playerList=[];
	for($i=1;$i<=$_POST['pNumber'];$i++){
		$player= 'player' . $i;
		$$player = new Player($_POST[$player]);
		$playerList[$i]=$$player;
	}
	$game = new YamGame($playerList);
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
$endOfGame=true;
foreach ($game->getPlayers() as $idPlayer => $player) {
	if(in_array(null,$player->getScoreTable(),true)){
		$endOfGame=false;
		break;
	}
}
if ($endOfGame == true) {
	$message = "| ";
	$finalScore = $game->getPlayersScores();
	array_multisort($finalScore,SORT_DESC);
	foreach ($finalScore as $playerName => $playerScore) {
		if (!isset($firstPlayer)){
			$firstPlayer = false;
			$message .= 'Gagnant: ';
		}
		$message .= $playerName . ' a fait ' . $playerScore . ' | ';
	}
	echo '<h2>' . $message . '<h2>';
}
displayScoreTables($game,$endOfGame);

$_SESSION['yamGame'] = serialize($game);

?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>


<?php

function displayDices($game){
	$bucketValues = $game->getCurrentPlayer()->getBucket()->getDicesValues();
	echo '<div class="dicevalues"><h2>' . $game->getCurrentPlayer()->getName() . ' playing</h2><form method="post" action="yam.php">';
	$rerollsLeft = $game->getCurrentPlayerRerolls();
			
	foreach ($bucketValues as $key => $value) {
		echo '<div class="reroll"><label>Le dé ' . ($key+1) . ' a fait ' . $value . ', relancer : </label>';
		if ($rerollsLeft >0) {
		echo '<input type="checkbox" name="toReroll[]" value="' . $key . '"/>';
		}
		echo '</div>';
	}
	echo '<label class="reroll">Il vous reste ' . $rerollsLeft . ' relances</label></br>';
	if ($rerollsLeft >0) {
		echo '<button type="submit">Relancer</button>';
	}
	echo '</form></div>';
}

function displayScoreTables($game,$endOfGame){
	$players = $game->getPlayers();
	echo '<div class="playertable">';
	if (!$endOfGame){
		displayDices($game);
	}
	foreach ($players as $idPlayer => $player) {
		echo '<table><tr><th>Joueur</th><th>' . ($idPlayer + 1) . '  ' . $player->getName() . '</th></tr>';
		foreach ($player->getScoreTable() as $category => $score) {
			if ($score === NULL) {
				$score = 'A jouer';
			}
		 	echo '<tr><td>' . $category . '</td><td>' . $score . '</td>';
		 	if ($player == $game->getCurrentPlayer() && $score === 'A jouer') {
		 		echo '<td><form method="post" action="yam.php"><button type="submit" name="score" value="' . $category . '">Marquer</button></form></td>';
		 	}
		 	echo '</tr>';
		}
		echo '<tr><td>Total</td><td>' . $game->getPlayerScore($idPlayer) . '</td></tr></table>';
	}
	'</div>';
}