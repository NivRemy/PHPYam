<?php

class Dice {
	private $_nbOfSides;
	private $_currentValue;

	public function __construct($nbSides){
		$this->setCurrentValue($nbSides);
	}

	public function getCurrentValue(){
		return $this->_currentValue;
	}

	private function setCurrentValue($nbSides){
		if (!is_int($nbSides)) {
			trigger_error('Le nombre de faces d\'un dé dois être un nombre entier', E_USER_WARNING);
		}
		$this->nbOfSides = $nbSides;
	}

	public function rollDice() {
		$this->currentValue = rand(1,$this->nbOfSides);
		return $this->getCurrentValue();
	}
}


$d6 = new Dice(6);
$d8etdemi = new Dice(8.2); // affiche un warning

echo $d6->rollDice();

echo $d6->getCurrentValue(); // affiche la valeur du dé

echo $d6->_currentValue; // Fatal error: cannot access private property.

echo $d6->rollDice();

echo $d6->rollDice();

echo '</br></br>';

echo gettype($d6);

echo '</br></br>';

var_dump($d6);

class Montre {
	private $heure;

	public function getHeure() {
		echo $this->heure;
	}

	public function setHeure($nouvelleHeure) {
		$this->heure = $nouvelleHeure;
	}
}

class MontreElectronique extends montre {
	public $altimetre;

	public function getAltitude() {
		echo $this->altimetre;
	}

	public function setAltitude($altitude) {
		$this->altimetre = $altitude;
	}
}

//Montre normale
$maMontre = new Montre();

$maMontre->setHeure('16:30'); 

echo '</br></br>';

$maMontre->getHeure();   

//Montre Electronique
$montre2 = new MontreElectronique();

$montre2->setAltitude('200');

echo '</br></br>';

$montre2->getAltitude();

$montre2->setHeure('18:00');

echo '</br></br>';

$montre2->getHeure();

$maMontre = new Montre();


echo '</br></br>';
echo '</br></br>';

var_dump($maMontre);

echo '</br></br>';
echo '</br></br>';

$maMontre->getHeure();
