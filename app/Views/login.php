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
?>

<div class="h2 text-center">Inicio de sesión</div>
<form id="login-form" action="<?= base_url('/login/auth') ?>" method="POST" class="col-sm">

	<?php if(session()->getFlashdata('login_error')) : ?>
		<div class="form-group mb-3 alert alert-warning"><?= session()->getFlashdata('login_error') ?></div>
	<?php endif; ?>

	<?php if(session()->getFlashdata('success')) : ?>
		<div class="form-group mb-3 alert alert-success"><?= session()->getFlashdata('success') ?></div>
	<?php endif; ?>

	<div class="form-group mb-3">
		<label for="email">Email</label>
		<input type="email" name="email" id="email" class="form-control" value="<?= session()->getFlashdata('email')?session()->getFlashdata('email'):'' ?>" required />
	</div>

	<div class="form-group mb-3">
		<label for="password">Contraseña</label>
		<input type="password" name="password" id="password" class="form-control" required />
	</div>
	
	<div class="form-group mb-3">
		<button type="submit" class="btn-block btn btn-primary">Iniciar sesión</button>
	</div>

	<!-- <div class="form-group mb-3">
		<button type="button" class="btn-block btn btn-warning" data-toggle="modal" data-target="#reset-password-modal">He olvidado mi contraseña</button>
	</div> -->
	
	<div class="form-group mb-3">
		<button type="button" class="btn-block btn btn-secondary" data-toggle="modal" data-target="#register-modal">Crear cuenta nueva</button>
	</div>

</form>

<div class="modal" id="register-modal" tabindex="-1">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Crear cuenta nueva</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="register-form" action="<?= base_url('/login/register') ?>" method="POST">
					<div class="form-group mb-3">
						<label for="email">Email</label>
						<input type="email" name="email" id="email" class="form-control" required />
					</div>
					<div class="form-group mb-3">
						<label for="password">Contraseña</label>
						<input type="password" name="password" id="password" class="form-control pwd-register" required />
					</div>
					<div class="form-group mb-3">
						<label for="repeat-password">Repetir contraseña</label>
						<input type="password" name="repeat-password" id="repeat-password" class="form-control pwd-register" required />
					</div>
					<div id="pwd-not-match" class="form-group mb-3 alert alert-warning">Las contraseñas deben ser iguales</div>
					<div class="form-group mb-3">
						<label for="display-name">Nombre de usuario</label>
						<input type="text" name="display-name" id="display-name" class="form-control" required />
					</div>
					<div class="form-group mb-3">
						<button type="submit" class="btn-block btn btn-primary">Registrarse</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="reset-password-modal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Contraseña olvidada</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="reset-password-form" action="<?= base_url('/login/resetPassword') ?>" method="POST">
					<div class="form-group mb-3">
						<label for="email">Email</label>
						<input type="email" name="email" id="email"  class="form-control" value="<?= session()->getFlashdata('email')?session()->getFlashdata('email'):'' ?>" required />
					</div>
					<div class="form-group mb-3">
						<button type="submit" class="btn-block btn btn-primary">Reiniciar contraseña</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>