<?php

class Dice {
	private $nb_of_sides;
	private $current_value;

	public function __construct($nb_sides){
		$this->nb_of_sides = $nb_sides;
		$this->current_value = rand(1,$this->nb_of_sides);
	}

	public function rollDice() {
		$this->current_value = rand(1,$this->nb_of_sides);
	}

	public function getCurrentValue(){
		return $this->current_value;
	}
}