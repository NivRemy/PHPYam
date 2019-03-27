<?php
include_once 'dice.php';

class Bucket {
	private $diceList = [];

	public function __construct($nbDice) {
		for ($i=0; $i<$nbDice; $i++) {
			array_push($this->diceList,new Dice(6));
		}
	}

	public function rollDices() {
		foreach ($this->diceList as $key => $dice) {
			$dice->rollDice();
		}
	}

	public function getDicesValues(){
		$diceValues=[];
		foreach ($this->diceList as $key => $dice) {
			//echo 'Le dé ' . $key . ' a fait ' . $dice->getCurrentValue() . '</br>';
			array_push($diceValues,$dice->getCurrentValue());	
		}
		return $diceValues;
	}

	public function rerollDice($diceNumber){
		$this->diceList[$diceNumber]->rollDice();
	}

	public function yamScore($key){
		switch ($key) {
			case 'Brelan':
				$diceValues = array_count_values($this->getDicesValues());
				foreach ($diceValues as $diceValue => $value) {
					if ($value >= 3) {
						return 10 + 3 * $diceValue;
					}
				}
				return 0;
				break;

			case "Carre":
				$diceValues = array_count_values($this->getDicesValues());
				foreach ($diceValues as $diceValue => $value) {
					if ($value >= 4) {
						return 30 + 4 * $diceValue;
					}
				}
				return 0;
				break;

			case "Full":
				$diceValues = array_count_values($this->getDicesValues());
				$double=false;
				$triple=false;
				foreach ($diceValues as $value) {
					if ($value == 2){
						$double = true;
					}
					elseif ($value == 3) {
						$triple = true;
					}
				}
				if ($double && $triple) {
					return 25;
				} else {
					return 0;
				}
				break;

			case "PSuite":
				$diceValues = $this->getDicesValues();
				sort($diceValues);
				$row_size = 1;
				$max_row_size=1;
				foreach ($diceValues as $key => $value) {
					if ($key > 0){
						if ($value == ($diceValues[($key - 1)] +1)){
							$row_size += 1;
						} elseif ($value != $diceValues[($key - 1)]){
							if($max_row_size < $row_size){
								$max_row_size = $row_size;
								$row_size = 0;
							}
						}

						if($max_row_size < $row_size){
						$max_row_size = $row_size;
						}
					}
				}
				if ($max_row_size >= 4){
					return 30;
				} else {
					return 0;
				}
				break;

			case "GSuite":

				if (count(array_count_values($this->getDicesValues())) == 5){
					return 40;
				} else {
					return 0;
				}
				break;

			case "Yam":
				if (count(array_count_values($this->getDicesValues())) == 1){
					return 50 + array_sum($this->getDicesValues());
				} else {
					return 0;
				}
				break;

			case "Chance":
				return array_sum($this->getDicesValues());
				break;

			case "Maximum":
				return array_sum($this->getDicesValues());
				break;

			case "Minimum":
				return array_sum($this->getDicesValues());
				break;

			default:
				$score = 0;
				foreach ($this->diceList as $diceValue => $dice) {
					if ($dice->getCurrentValue() == $key) {
						$score += $dice->getCurrentValue();
					}
				}
				return $score;
				break;
		}
	}

}