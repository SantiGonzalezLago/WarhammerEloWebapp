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

	<div class="form-group mb-3">
		<label for="email">Email</label>
		<input type="text" name="email" id="email"  class="form-control" value="<?= session()->getFlashdata('email')?session()->getFlashdata('email'):'' ?>" required />
	</div>

	<div class="form-group mb-3">
		<label for="password">Contraseña</label>
		<input type="password" name="password" id="password" class="form-control" required />
	</div>
	
	<div class="form-group mb-3 d-grid">
		<button type="submit" class="btn btn-primary">Iniciar sesión</button>
	</div>

	<div class="form-group mb-3 d-grid">
		<a href="<?= base_url('/login/resetPassword') ?>" class="btn btn-warning">He olvidado mi contraseña</a>
	</div>
	
	<div class="form-group mb-3 d-grid">
		<a href="<?= base_url('/login/register') ?>" class="btn btn-secondary">Crear cuenta nueva</a>
	</div>

</form>