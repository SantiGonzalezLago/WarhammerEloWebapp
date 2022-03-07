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

class Login extends BaseController
{
    public function index() {
        if (session('id')) {
            return redirect()->to('/');
        }

        $this->setTitle("Inicio de sesión");
        return $this->loadView('login');
    }

    public function auth() {
        $email = $this->request->getVar('email');
		$password = $this->request->getVar('password');

        $data = $this->userModel->where('email', $email)->where('active', 1)->first();

		if ($data && password_verify($password, $data['password']) ) {

			session()->set([
				'id' => $data['id'],
			]);

            return redirect()->to('/');

		} else {
			session()->setFlashdata('login_error', 'El nombre de usuario no existe o la contrase&ntilde;a no coincide');
			session()->setFlashdata('email', $email);

            return redirect()->back();
		}

    }

    public function logout() {
        session()->destroy();

		return redirect()->back();
    }

    public function register() {
        if (session('id')) {
            return redirect()->to('/');
        }
        // TODO
    }

    public function resetPassword() {
        if (session('id')) {
            return redirect()->to('/');
        }
        // TODO
    }
}
