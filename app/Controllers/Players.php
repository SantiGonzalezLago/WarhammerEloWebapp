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

namespace App\Controllers;

class Players extends BaseController
{

    public function index() {
        $players = $this->userModel->getPlayers();

        for ($i = 0; $i < count($players); $i++) {
            if ($i == 0 || $players[$i]['elo'] < $players[$i-1]['elo']) {
                $players[$i]['pos'] = $i + 1;
            } else {
                $players[$i]['pos'] = $players[$i-1]['pos'];
            }
            if ($i == 0) {
                $players[$i]['dif'] = '-';
            } else {
                $players[$i]['dif'] = $players[$i-1]['elo'] - $players[$i]['elo'];
            }
        }

        $this->setData('players', $players);
        $this->setTitle("Jugadores");
        return $this->loadView('player_list');
    }

    public function view($id) {
        $player = $this->userModel->getPlayer($id);

        if (!$player) {
            return redirect()->to('/players');
        }

        $this->setData('player', $player);
        $this->setTitle($player['display_name']);
        return $this->loadView('player_view');
    }

    public function changeDisplayNameAjax() {
        $displayName = $this->request->getVar('displayName');
        $id = session('id');
        if ($this->userModel->checkDisplayNameExists($displayName)) {
            return json_encode(0);
        }
        return json_encode($this->userModel->changeField($id, 'display_name', $displayName));
    }

    public function changeEmailAjax() {
        $email = $this->request->getVar('email');
        $id = session('id');
        if ($this->userModel->checkEmailExists($email)) {
            return json_encode(0);
        }
        return json_encode($this->userModel->changeField($id, 'email', $email));
    }
}