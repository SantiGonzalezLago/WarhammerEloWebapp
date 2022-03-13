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
			session()->setFlashdata('login_error', 'El nombre de usuario no existe, la contrase&ntilde;a no coincide o el usuario no est&aacute; activo.');
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

        $errorText = "";
        
        $email = $this->request->getVar('email');
		$password = $this->request->getVar('password');
		$repeatPassword = $this->request->getVar('repeat-password');
		$displayName = $this->request->getVar('display-name');

        if ($this->userModel->checkEmailExists($email)) {
            $errorText .= "El email ya est&aacute; en uso<br/>";
        }

        if ($this->userModel->checkDisplayNameExists($displayName)) {
            $errorText .= "El nombre de usuario ya est&aacute; en uso<br/>";
        }

        if ($password != $repeatPassword) {
            $errorText .= "Las contrase&ntilde;as deben ser iguales<br/>";
        }

        if (strlen($errorText) > 0) {
            session()->setFlashdata('login_error', $errorText);
        } else {
            $userAutoRegister = $this->settingModel->getSettingValue('user_autoregister');

            session()->setFlashdata('success', 'Se ha creado su cuenta. ' . ($userAutoRegister ? 'Introduzca los datos a continuaci&oacute;n para acceder.' : 'Su registro deber&aacute; ser aceptado por un administrador antes de que pueda acceder.'));
            
            $this->userModel->addUser(array(
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT ),
                'display_name' => $displayName,
                'active' => $userAutoRegister,
            ));
        }

        return redirect()->back();
    }

    public function resetPassword() {
        if (session('id')) {
            return redirect()->to('/');
        }
        // TODO
    }
}
