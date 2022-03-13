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

<div class="h2 text-center">Reinicio de contraseña</div>
<form id="reset-form" action="<?= base_url('/login/reset') ?>" method="POST" class="col-sm">
    <div class="form-group mb-3">
        <label for="password">Nueva contraseña</label>
        <input type="password" name="password" id="password" class="form-control pwd-register" required />
    </div>

    <div class="form-group mb-3">
        <label for="repeat-password">Repetir contraseña</label>
        <input type="password" name="repeat-password" id="repeat-password" class="form-control pwd-register" required />
    </div>

    <div id="pwd-not-match" class="form-group mb-3 alert alert-warning">Las contraseñas deben ser iguales</div>

    <div class="form-group mb-3 d-grid">
        <button type="submit" class="btn btn-primary">Reiniciar contraseña</button>
    </div>
</form>