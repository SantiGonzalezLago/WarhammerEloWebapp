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

	public function getPlayers() {
		$settingModel = new SettingModel();
		$baseElo = $settingModel->getSettingValue('base_elo');

		$subquery = "(SELECT IF(`warhammer`.`game`.`player1_id` = `u`.`id`, `warhammer`.`game`.`player1_elo_after`, `warhammer`.`game`.`player2_elo_after`) AS `elo` FROM `warhammer`.`game` WHERE (`warhammer`.`game`.`player1_id` = `u`.`id` OR `warhammer`.`game`.`player2_id` = `u`.`id`) AND `warhammer`.`game`.`result` IS NOT NULL ORDER BY `warhammer`.`game`.`date` DESC LIMIT 1)";
		$query = "SELECT
				`u`.*,
				COALESCE($subquery, $baseElo) AS `elo`
			FROM
				`warhammer`.`user` `u`
			WHERE
				`u`.`active` = 1
			ORDER BY elo DESC";

		return $this->db->query($query)->getResultArray();
	}

	public function getPlayer($id) {
		$settingModel = new SettingModel();
		$baseElo = $settingModel->getSettingValue('base_elo');

		$subquery = "(SELECT IF(`warhammer`.`game`.`player1_id` = `u`.`id`, `warhammer`.`game`.`player1_elo_after`, `warhammer`.`game`.`player2_elo_after`) AS `elo` FROM `warhammer`.`game` WHERE (`warhammer`.`game`.`player1_id` = `u`.`id` OR `warhammer`.`game`.`player2_id` = `u`.`id`) AND `warhammer`.`game`.`result` IS NOT NULL ORDER BY `warhammer`.`game`.`date` DESC LIMIT 1)";
		$query = "SELECT
				`u`.*,
				COALESCE($subquery, $baseElo) AS `elo`
			FROM
				`warhammer`.`user` `u`
			WHERE
				`u`.`active` = 1 AND `u`.`id` = $id
			ORDER BY elo DESC";

		return $this->db->query($query)->getResultArray()[0];
	}

}