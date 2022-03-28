<?php

// WarhammerEloWebapp
// Copyright (C) 2022 Santiago González Lago

// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <https://www.gnu.org/licenses/>.

namespace App\Models;  
use CodeIgniter\Model;

class GameModel extends Model {

	protected $table = 'game';
	protected $primaryKey = 'id';

	protected $allowedFields = [
		'id',
		'title',
		'description',
		'player1_id',
		'player2_id',
		'result',
		'player1_elo_after',
		'player2_elo_after',
		'date',
		'game_type_id',
		'game_size_id',
		'player1_army_id',
		'player2_army_id',
	];

	public function getGames() {
		$query = $this->db->table('game')->orderBy('date', 'DESC')
			->select('game.*, p1.display_name AS player1_name, p2.display_name AS player2_name, p1a.name AS player1_army, p2a.name AS player2_army, game_type.name AS type, game_size.name AS size')
			->join('user p1', 'game.player1_id = p1.id')->join('user p2', 'game.player2_id = p2.id')
			->join('army p1a', 'game.player1_army_id = p1a.id', 'LEFT')->join('army p2a', 'game.player2_army_id = p2a.id', 'LEFT')
			->join('game_type', 'game.game_type_id = game_type.id', 'LEFT')->join('game_size', 'game.game_size_id = game_size.id', 'LEFT');
		return $query->get()->getResultArray();
	}

	public function getGame($id) {
		$query = $this->db->table('game')->orderBy('date', 'DESC')->where('game.id', $id)
			->select('game.*, p1.display_name AS player1_name, p2.display_name AS player2_name, p1a.name AS player1_army, p2a.name AS player2_army, game_type.name AS type, game_size.name AS size')
			->join('user p1', 'game.player1_id = p1.id')->join('user p2', 'game.player2_id = p2.id')
			->join('army p1a', 'game.player1_army_id = p1a.id', 'LEFT')->join('army p2a', 'game.player2_army_id = p2a.id', 'LEFT')
			->join('game_type', 'game.game_type_id = game_type.id', 'LEFT')->join('game_size', 'game.game_size_id = game_size.id', 'LEFT');
		return $query->get()->getResultArray()[0];
	}

	public function insertGame($title, $description, $player1, $player2, $result, $elo1, $elo2, $army1, $army2, $gameType, $gameSize) {
		$this->db->table('game')->insert(array(
			'title' => $title,
			'description' => $description,
			'player1_id' => $player1,
			'player2_id' => $player2,
			'result' => $result,
			'player1_elo_after' => $elo1,
			'player2_elo_after' => $elo2,
			'player1_army_id' => $army1 != '' ? $army1 : NULL,
			'player2_army_id' => $army2 != '' ? $army2 : NULL,
			'game_type_id' => $gameType != '' ? $gameType : NULL,
			'game_size_id' => $gameSize != '' ? $gameSize : NULL,
		));

		return $this->db->affectedRows();
	}

	public function changeDescription($id, $description) {
		$this->db->table('game')->set('description', $description)->where('id', $id)->update();

		return $this->db->affectedRows();
	}

	public function getGameTypes() {
		return $this->db->table('game_type')->get()->getResultArray();
	}

	public function addGameType($name) {
		$this->db->table('game_type')->insert(['name' => $name]);

		return $this->db->affectedRows();
	}

	public function editGameType($id, $name) {
		$this->db->table('game_type')->set('name', $name)->where('id', $id)->update();

		return $this->db->affectedRows();
	}

	public function deleteGameType($id) {
		$this->db->table('game_type')->delete(['id' => $id]);

		return $this->db->affectedRows();
	}

	public function getGameSizes() {
		return $this->db->table('game_size')->get()->getResultArray();
	}

	public function addGameSize($name) {
		$this->db->table('game_size')->insert(['name' => $name]);

		return $this->db->affectedRows();
	}

	public function editGameSize($id, $name) {
		$this->db->table('game_size')->set('name', $name)->where('id', $id)->update();

		return $this->db->affectedRows();
	}

	public function deleteGameSize($id) {
		$this->db->table('game_size')->delete(['id' => $id]);

		return $this->db->affectedRows();
	}

	public function getArmies() {
		return $this->db->table('army')->get()->getResultArray();
	}

	public function addArmy($name) {
		$this->db->table('army')->insert(['name' => $name]);

		return $this->db->affectedRows();
	}

	public function editArmy($id, $name) {
		$this->db->table('army')->set('name', $name)->where('id', $id)->update();

		return $this->db->affectedRows();
	}

	public function deleteArmy($id) {
		$this->db->table('army')->delete(['id' => $id]);

		return $this->db->affectedRows();
	}

}