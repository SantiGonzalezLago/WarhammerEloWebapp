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

class Games extends BaseController
{

    public function index() {
        $games = $this->isAdmin() ? $this->gameModel->getGames() : $this->gameModel->getFinishedGames();

        $this->setData('games', $games);
        $this->setTitle("Partidas");
        return $this->loadView('games_list');
    }

    public function view($id) {
        $game = $this->gameModel->getGame($id);

        if (!$game) {
            return redirect()->to('/games');
        }

        $this->setData('game', $game);
        $this->setTitle($game['title']);
        return $this->loadView('game_view');
    }

    public function add() {
        $players = $this->userModel->getPlayers();

        $this->setData('players', $players);
        $this->setTitle("Añadir partida");
        return $this->loadView('game_add');
    }

    public function add2() {
        helper('elo');

        $title = $this->request->getVar('title');
        $player1 = $this->request->getVar('player1');
        $player2 = $this->request->getVar('player2');
        $result = $this->request->getVar('result');
        $description = $this->request->getVar('description');

        $eloPlayer1 = $this->userModel->getPlayer($player1)['elo'];
        $eloPlayer2 = $this->userModel->getPlayer($player2)['elo'];

        switch ($result) {
            case '1-0':
                $results = array(1,0);
                break;
            case '0-1':
                $results = array(0,1);
                break;
            case 'TIE':
                $results = array(0.5,0.5);
                break;
            default:
                $result = null;
        }

        $newElo1 = isset($results) ? calculateNewRating($eloPlayer1, $eloPlayer2, $results[0]) : null;
        $newElo2 = isset($results) ? calculateNewRating($eloPlayer2, $eloPlayer1, $results[1]) : null;

        $this->gameModel->insertGame($title, $description, $player1, $player2, $result, $newElo1, $newElo2);

        return redirect()->to('/games');
    }
}