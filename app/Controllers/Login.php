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

    public function resetPassword($encryptedText = '') {
        if (session('id')) {
            return redirect()->to('/');
        }

        $encrypter = \Config\Services::encrypter();

        if ($encryptedText == '') {
            $email = $this->request->getVar('email');
            $player = $this->userModel->where('email', $email)->where('active', 1)->first();
            session()->setFlashdata('success', 'Se ha enviado un email con instrucciones para reiniciar la contraseña.');
            if (isset($player)) {
                $id = $player['id'];
                $email = $player['email'];
                $time = time();

                $code = $id . '__' . $email . '__' . $time;
                $encryptedCode = bin2hex($encrypter->encrypt($code));

                // TODO Send mail: <a href="'.base_url('/login/resetPassword/' . $encryptedCode).'">ENLACE</a>
            }
            return redirect()->back();
        } else {
            try {
                $decrypted = explode('__', $encrypter->decrypt(hex2bin($encryptedText)));
                $id = $decrypted[0];
                $email = $decrypted[1];
                $timeCreated = $decrypted[2];
            } catch (\Exception $e) {
                session()->setFlashdata('login_error', 'El enlace no es válido.');
                return redirect()->to('/login');
            }
            $timeNow = time();
            if ($timeNow - $timeCreated > (24*60*60)) {
                session()->setFlashdata('login_error', 'El enlace ha caducado.');
                return redirect()->to('/login');
            }

			session()->set([
				'reset_id' => $id,
			]);

            $this->setTitle("Reinicio de contraseña");
            return $this->loadView('reset_password');
        }
    }

    public function reset() {
        if (session('id')) {
            return redirect()->to('/');
        }

        $id = session('reset_id');
		$password = $this->request->getVar('password');
		$repeatPassword = $this->request->getVar('repeat-password');

        unset($_SESSION['reset_id']);

        if (isset($id) && $password == $repeatPassword) {
            $this->userModel->changeField($id, 'password', password_hash($password, PASSWORD_BCRYPT));
            session()->setFlashdata('success', 'Se ha actualizado la contraseña. Ya puedes iniciar sesión.');
        } else {
            session()->setFlashdata('login_error', 'No se ha podido cambiar la contraseña.');
        }
        return redirect()->to('/login');
    }
}
