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

class Admin extends BaseController {

    public function index() {
        $settings = $this->settingModel->getSettings();

        $this->setData('settings', $settings);
        $this->setTitle("Administración");
        return $this->loadView('admin');
    }

    public function saveSettingsAjax() {
        $settings = $this->request->getVar('settings');

        // return json_encode($settings);

        $affectedRows = 0;

        foreach ($settings as $setting) {
            $affectedRows += $this->settingModel->saveSetting($setting['key'], $setting['value']);
        }

        return json_encode($affectedRows);
    }
}