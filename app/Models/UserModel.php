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
		return $this->db->table('user_elo')->get()->getResultArray();
	}

	public function getPlayer($id) {
		$query = $this->db->table('user')->select('user.*, user_elo.elo')->where('user.id', $id)->join('user_elo', 'user.id = user_elo.id');
		return $query->get()->getResultArray()[0];
	}

}