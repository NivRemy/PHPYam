<?php

class Dice {
	private $nb_of_sides;
	private $current_value;

	public function __construct(){
		$ctp = func_num_args();
    	$args = func_get_args();
    	switch ($ctp){
    		case 1:
	    		$this->nb_of_sides = $args[0];
				$this->rollDice();
				break;
			default:
				$this->nb_of_sides = 6;
				$this->rollDice();
				break;
    	}

		
	}

	public function rollDice() {
		$this->current_value = rand(1,$this->nb_of_sides);
	}

	public function getCurrentValue(){
		return $this->current_value;
	}
}