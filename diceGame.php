<?php
include_once 'dice.php';
include_once 'bucket.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jeu de dé</title>
</head>
<body>
<?php
// Bucket Game
if (isset($_SESSION['bucket']) && $_SESSION['turn'] >= 0) {
	$bucket = unserialize($_SESSION['bucket']);
	if (isset($_POST['toReroll'])){
		foreach ($_POST['toReroll'] as $key => $diceNumber) {
			$bucket->rerollDice($diceNumber);
		}
	}
	gameTurn($bucket,$_SESSION['turn']);
	echo $bucket->yamScore('Full') . ' Full</br>';
	echo $bucket->yamScore('Brelan') . ' Brelan</br>';
	echo $bucket->yamScore('Carre') . ' Carre</br>';
	echo $bucket->yamScore('Yam') . ' Yam</br>';
	echo $bucket->yamScore('Chance') . ' Chance</br>';
	echo $bucket->yamScore('PSuite') . ' PSuite</br>';
	echo $bucket->yamScore('GSuite') . ' Gsuite</br>';
	echo $bucket->yamScore('Maximum') . ' Maximum</br>';
}
elseif (isset($_SESSION['bucket']) && $_SESSION['turn'] <= 0) {
	session_destroy();
	header('location:diceGame.php');
}
else {
	$bucket = new Bucket(5);
	$_SESSION['turn'] = 2;
	gameTurn($bucket,$_SESSION['turn']);
	echo $bucket->yamScore('Full') . ' Full</br>';
	echo $bucket->yamScore('Brelan') . ' Brelan</br>';
	echo $bucket->yamScore('Carre') . ' Carre</br>';
	echo $bucket->yamScore('Yam') . ' Yam</br>';
	echo $bucket->yamScore('Chance') . ' Chance</br>';
	echo $bucket->yamScore('PSuite') . ' PSuite</br>';
	echo $bucket->yamScore('Gsuite') . ' Gsuite</br>';
	echo $bucket->yamScore('Maximum') . ' Maximum</br>';
}

function gameTurn($bucket,$turn){
	$bucketValues = $bucket->getDicesValues();
	echo '<div><form method="post" action="">';
			
	foreach ($bucketValues as $key => $value) {
		echo '<div><label>Le dé ' . $key . ' a fait ' . $value . ', relancer : </label>';
		if ($turn >0) {
		echo '<input type="checkbox" name="toReroll[]" value="' . $key . '"/>';
		}
		echo '</div>';
	}
	echo '<label>Il vous reste ' . $_SESSION['turn'] . ' lancés</label></br>';
	echo '<button type="submit">';
	if ($turn >0) {
		echo 'Relancer';
	}
	else {
		echo 'Nouvelle Partie';
	}
	echo '</button></form></div>';
	$_SESSION['bucket'] = serialize($bucket);
	$_SESSION['turn'] --;
	
}
?>
</body>
</html>