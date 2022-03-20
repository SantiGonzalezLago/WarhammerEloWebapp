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

<table class="table">
    <tr>
        <th>Nombre</th>
        <td>
            <?= $player['display_name'] ?>
            <?php if ($player['id'] == session('id')) : ?>
                <input type="button" class="btn btn-outline-primary btn-sm float-right"  data-toggle="modal" data-target="#change-display-name-modal" value="Cambiar">
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th>Elo</th>
        <td><?= $player['elo'] ?></td>
    </tr>
    <?php if ($player['id'] == session('id')) : ?>
        <tr>
            <th>Email</th>
            <td>
                <?= $player['email'] ?>
                <input type="button" class="btn btn-outline-primary btn-sm float-right" data-toggle="modal" data-target="#change-email-modal" value="Cambiar">
            </td>
        </tr>
        <tr>
            <th>Contraseña</th>
            <td>
                &bull;&bull;&bull;&bull;&bull;&bull;
                <input type="button" class="btn btn-outline-primary btn-sm float-right" data-toggle="modal" data-target="#change-password-modal" value="Cambiar">
            </td>
        </tr>
    <?php endif; ?>
</table>
<a href="<?= base_url('/players') ?>" class="btn btn-outline-secondary float-right">Volver a Jugadores</a>

<?php if ($player['id'] == session('id')) : ?>

    <div class="modal" id="change-display-name-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar nombre</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="display-name">Nuevo nombre</label>
                        <input type="text" name="display-name" id="display-name" class="form-control" required />
                    </div>
                    <div id="display-name-used" class="in-use form-group mb-3 alert alert-warning">Ese nombre está en uso.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="change-email-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar email</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="email">Nuevo email</label>
                        <input type="email" name="email" id="email" class="form-control" required />
                    </div>
                    <div id="email-used" class="in-use form-group mb-3 alert alert-warning">Ese email está en uso.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="change-password-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="password">Nueva contraseña</label>
                        <input type="password" name="password" id="password" class="form-control pwd-register" required />
                    </div>
                    <div class="form-group mb-3">
                        <label for="repeat-password">Repetir contraseña</label>
                        <input type="password" name="repeat-password" id="repeat-password" class="form-control pwd-register" required />
                    </div>
                    <div id="pwd-not-match" class="form-group mb-3 alert alert-warning">Las contraseñas deben ser iguales</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="password-changed-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="pwd-not-match" class="form-group mb-3 alert alert-success">Se ha cambiado la contraseña</div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>
