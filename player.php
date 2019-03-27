<?php
include_once 'bucket.php';
class Player {
	private $name;
	private $scoreTable = [
		1 => NULL,
		2 => NULL,
		3 => NULL,
		4 => NULL,
		5 => NULL,
		6 => NULL,
		'Maximum' => NULL,
		'Minimum' => NULL,
		'Brelan' => NULL,
		'Carre' => NULL,
		'Full' => NULL,
		'PSuite' => NULL,
		'GSuite' => NULL,
		'Yam' => NULL,
		'Chance' => NULL
	];
	private $bucket;

	public function __construct($name){
		$this->setName($name);
		$this->setBucket(5);
	}

	private function setName($name){
		$this->name = $name;
	}

	public function getName(){
		return $this->name;
	}

	private function setBucket($nbDices){
		$this->bucket = new Bucket(5);
	}

	public function getBucket(){
		return $this->bucket;
	}

	public function setValue($key,$value){
		$this->scoreTable[$key]=$value;
	}

	public function getScoreTable(){
		return $this->scoreTable;
	}

	public function getScore(){
		$bonus = 0;
		$sub_total= 0;
		foreach ($this->scoreTable as $key => $value) {
			if (in_array($key,[1,2,3,4,5,6])){
				$sub_total += $value;
			}		
		}
		if ($sub_total > 63) {
			$bonus = 35;
		}
		return array_sum($this->scoreTable) - ($this->scoreTable['Minimum'] * 2) + $bonus;
	}

	public function scorePoints($category){
		$score = $this->getBucket()->yamScore($category);
		$this->setValue($category,$score);
	}


}