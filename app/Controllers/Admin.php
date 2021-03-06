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

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Admin extends BaseController {

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);

        if (!$this->isAdmin()) {
            header("Location: " . base_url('/')); 
            die();
        }
    }

    public function index() {
        $settings = $this->settingModel->getSettings();
        $users = $this->userModel->getUsers();

        $gameTypes = $this->gameModel->getGameTypes();
        $gameSizes = $this->gameModel->getGameSizes();
        $armies = $this->gameModel->getArmies();

        $this->setData('settings', $settings);
        $this->setData('users', $users);
        $this->setData('gameTypes', $gameTypes);
        $this->setData('gameSizes', $gameSizes);
        $this->setData('armies', $armies);
        $this->setTitle("Administración");
        return $this->loadView('admin');
    }

    public function setActive($playerId, $active) {
        $this->userModel->changeField($playerId, 'active', $active);

		session()->setFlashdata('activeTab', 'users');
        return redirect()->back();
    }

    public function saveSettingsAjax() {
        $settings = $this->request->getVar('settings');

        $affectedRows = 0;

        foreach ($settings as $setting) {
            $affectedRows += $this->settingModel->saveSetting($setting['key'], $setting['value']);
        }

        return json_encode($affectedRows);
    }

    public function deleteType($id) {
        $this->gameModel->deleteGameType($id);

		session()->setFlashdata('activeTab', 'game-options');
        return redirect()->back();
    }

    public function editType() {
        $id = $this->request->getVar('id');
        $name = $this->request->getVar('name');

        if ($id) {
            $this->gameModel->editGameType($id, $name);
        } else {
            $this->gameModel->addGameType($name);
        }

		session()->setFlashdata('activeTab', 'game-options');
        return redirect()->back();
    }

    public function deleteSize($id) {
        $this->gameModel->deleteGameSize($id);

		session()->setFlashdata('activeTab', 'game-options');
        return redirect()->back();
    }

    public function editSize() {
        $id = $this->request->getVar('id');
        $name = $this->request->getVar('name');

        if ($id) {
            $this->gameModel->editGameSize($id, $name);
        } else {
            $this->gameModel->addGameSize($name);
        }

		session()->setFlashdata('activeTab', 'game-options');
        return redirect()->back();
    }

    public function deleteArmy($id) {
        $this->gameModel->deleteArmy($id);

		session()->setFlashdata('activeTab', 'game-options');
        return redirect()->back();
    }

    public function editArmy() {
        $id = $this->request->getVar('id');
        $name = $this->request->getVar('name');

        if ($id) {
            $this->gameModel->editArmy($id, $name);
        } else {
            $this->gameModel->addArmy($name);
        }

		session()->setFlashdata('activeTab', 'game-options');
        return redirect()->back();
    }
}
