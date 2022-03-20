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

<div class="align-items-start pt-3">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="home" aria-selected="true">Configuración</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#users" role="tab" aria-controls="profile" aria-selected="false">Administrar usuarios</a>
        </li>
    </ul>
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
            <table class="table table-borderless">
                <?php foreach ($settings as $setting) : ?>
                    <tr class="setting-row">
                        <th class="text-center w-25" data-toggle="tooltip" data-original-title="<?= $setting['description'] ?>">
                            <label for="<?= $setting['key'] ?>"><?= $setting['key'] ?></label>
                        </th>
                        <td>
                            <?php if ($setting['type'] != "checkbox") : ?>
                                <input type="<?= $setting['type'] ?>" name="<?= $setting['key'] ?>" id="<?= $setting['key'] ?>" value="<?= $setting['value'] ?>" class="form-control">
                            <?php else: ?>
                                <input type="checkbox" name="<?= $setting['key'] ?>" id="<?= $setting['key'] ?>" value="1" <?= $setting['value'] ? "checked" : "" ?> >
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" id="save-settings" class="btn btn-primary" disabled>Guardar</button>
            </div>
        </div>
        <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
            Administrar usuarios
        </div>
    </div>
</div>

<div class="modal" id="save-settings-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Se han guardado los cambios.</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>