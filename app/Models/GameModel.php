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

	public function getFinishedGames() {
		$query = $this->db->table('game')->select('game.*, p1.display_name AS player1_name, p2.display_name AS player2_name')->where('result IS NOT NULL')
			->orderBy('date', 'DESC')->join('user p1', 'game.player1_id = p1.id')->join('user p2', 'game.player2_id = p2.id');
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

	public function insertGame($title, $description, $player1, $player2, $result, $elo1, $elo2) {
		$this->db->table('game')->insert(array(
			'title' => $title,
			'description' => $description,
			'player1_id' => $player1,
			'player2_id' => $player2,
			'result' => $result,
			'player1_elo_after' => $elo1,
			'player2_elo_after' => $elo2,
		));

		return $this->db->affectedRows();
	}

}