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

        $rawGames = $this->gameModel->getGames($id);
        $games = array();
        foreach ($rawGames as $rawGame) {
            if ($rawGame['player1_id'] == $id) {
                $result = $rawGame['result'];
            } elseif ($rawGame['result'] == "1-0") {
                $result = "0-1";
            } elseif ($rawGame['result'] == "0-1") {
                $result = "1-0";
            } else {
                $result = "TIE";
            }
            if ($result == "1-0") {
                $rowClass = "table-success";
            } elseif ($result == "0-1") {
                $rowClass = "table-danger";
            } else {
                $rowClass = "table-warning";
            }
            $games[] = array(
                'opponent'          => ($id == $rawGame['player1_id']) ? $rawGame['player2_name'] : $rawGame['player1_name'],
                'result'            => $result,
                'player_army'       => ($id == $rawGame['player1_id']) ? $rawGame['player1_army'] : $rawGame['player2_army'],
                'opponent_army'     => ($id == $rawGame['player1_id']) ? $rawGame['player2_army'] : $rawGame['player1_army'],
                'type'              => $rawGame['type'],
                'size'              => $rawGame['size'],
                'title'             => $rawGame['title'],
                'id'                => $rawGame['id'],
                'rowClass'          => $rowClass,
            );
        }

        $this->setData('player', $player);
        $this->setData('games', $games);
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

    public function changePasswordAjax() {
        $password = $this->request->getVar('password');
        $repeatPassword = $this->request->getVar('repeatPassword');
        $id = session('id');
        if ($password != $repeatPassword) {
            return json_encode(0);
        }
        return json_encode($this->userModel->changeField($id, 'password', password_hash($password, PASSWORD_BCRYPT)));
    }
}