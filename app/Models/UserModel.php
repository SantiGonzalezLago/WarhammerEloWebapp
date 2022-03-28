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

class UserModel extends Model {

	protected $table = 'user';
	protected $primaryKey = 'id';

	protected $allowedFields = [
		'id',
		'email',
		'password',
		'display_name',
		'active',
		'admin',
	];

	public function getUsers() {
		return $this->db->table('user')->get()->getResultArray();
	}

	public function getPlayers() {
		$settingModel = new SettingModel();
		$baseElo = $settingModel->getSettingValue('base_elo');

		$subquery = "(SELECT IF(`game`.`player1_id` = `u`.`id`, `game`.`player1_elo_after`, `game`.`player2_elo_after`) AS `elo` FROM `game` WHERE (`game`.`player1_id` = `u`.`id` OR `game`.`player2_id` = `u`.`id`) AND `game`.`result` IS NOT NULL ORDER BY `game`.`date` DESC LIMIT 1)";
		$query = "SELECT
				`u`.*,
				COALESCE($subquery, $baseElo) AS `elo`
			FROM
				`user` `u`
			WHERE
				`u`.`active` = 1
			ORDER BY elo DESC";

		return $this->db->query($query)->getResultArray();
	}

	public function getPlayer($id) {
		$settingModel = new SettingModel();
		$baseElo = $settingModel->getSettingValue('base_elo');

		$subquery = "(SELECT IF(`game`.`player1_id` = `u`.`id`, `game`.`player1_elo_after`, `game`.`player2_elo_after`) AS `elo` FROM `game` WHERE (`game`.`player1_id` = `u`.`id` OR `game`.`player2_id` = `u`.`id`) AND `game`.`result` IS NOT NULL ORDER BY `game`.`date` DESC LIMIT 1)";
		$query = "SELECT
				`u`.*,
				COALESCE($subquery, $baseElo) AS `elo`
			FROM
				`user` `u`
			WHERE
				`u`.`active` = 1 AND `u`.`id` = $id
			ORDER BY elo DESC";

		return $this->db->query($query)->getResultArray()[0];
	}
	
	public function checkEmailExists($email) {
		$user = $this->where('email', $email)->first();
		return isset($user);
		
	}

	public function checkDisplayNameExists($displayName) {
		$user = $this->where('display_name', $displayName)->first();
		return isset($user);
	}

	public function addUser($data) {
		$this->db->table('user')->insert($data);

		return $this->db->affectedRows();
	}

	public function changeField($id, $field, $value) {
		$this->db->table('user')->set($field, $value)->where('id', $id)->update();

		return $this->db->affectedRows();
	}

}