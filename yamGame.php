<?php
include_once 'player.php';

class YamGame {
	private $players = [];
	private $currentPlayer = 0;
	private $currentPlayerRerolls = 2;

	public function __construct($playerList) {
		foreach ($playerList as $key => $value) {
			$this->addPlayer($value);
		}
	}

	public function addPlayer($player) {
		$this->players[]=$player;
	}

	public function getPlayers(){
		return $this->players;
	}

	public function getCurrentPlayer(){
		return $this->players[$this->currentPlayer];
	}

	public function getCurrentPlayerRerolls(){
		return $this->currentPlayerRerolls;
	}

	public function rerollCountDown(){
		$this->currentPlayerRerolls -= 1;
	}

	public function nextPlayer(){
		if($this->currentPlayer < count($this->getPlayers()) - 1){
			$this->currentPlayer +=1;
		} else {
			$this->currentPlayer =0;
		}
		$this->currentPlayerRerolls = 2;
		$this->getCurrentPlayer()->getBucket()->rollDices();
	}

	public function getPlayersScores(){
		$playersScores = [];
		foreach ($this->players as $player) {
			$playersScores[]=$player->getScore();
		}
		return $playersScores;
	}

	public function getPlayerScore($idPlayer){
		return $this->players[$idPlayer]->getScore();
	}

	public function getPlayersScoreTables(){
		$playersScoreTables = [];
		foreach ($this->players as $player) {
			$playersScoreTables[]=$player->getScoreTable();
		}
		return $playersScoreTables;
	}
}
