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
    <?php if (session()->getFlashdata('activeTab')) : ?>
        <input type="hidden" id="active-tab" value="<?= session()->getFlashdata('activeTab') ?>"></input>
    <?php endif; ?>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="true">Configuración</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="false">Administrar usuarios</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="game-options-tab" data-toggle="tab" href="#game-options" role="tab" aria-controls="game-options" aria-selected="false">Opciones de partida</a>
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
            <table class="table table-borderless">
                <tr>
                    <th></th>
                    <th>Usuario</th>
                    <th>Email</th>
                </tr>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td>
                            <?php if ($user['active']) : ?>
                                <a class="btn btn-danger <?= ($user['id'] == session('id'))?'disabled':'' ?>" href="<?= base_url('/admin/setactive/' . $user['id'] . '/0') ?>">Desactivar</a>
                            <?php else : ?>
                                <a class="btn btn-success"  href="<?= base_url('/admin/setactive/' . $user['id'] . '/1') ?>">Activar</a>
                            <?php endif; ?>
                        </td>
                        <td><?= $user['display_name'] ?></td>
                        <td><?= $user['email'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="tab-pane fade" id="game-options" role="tabpanel" aria-labelledby="game-options-tab">
            <div class="row border-between">
                <div class="col-4">
                    <h2>Tipos de partida</h2>
                    <table class="table table-borderless">
                        <?php foreach ($gameTypes as $gameType) : ?>
                            <tr>
                                <td>
                                    <a class="btn btn-danger" href="<?= base_url('/admin/deleteType/' . $gameType['id']) ?>">Eliminar</a>
                                </td>
                                <td><?= $gameType['name'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div class="col-4">
                    <h2>Tamaños de partida</h2>
                    <table class="table table-borderless">
                        <?php foreach ($gameSizes as $gameSize) : ?>
                            <tr>
                                <td>
                                    <a class="btn btn-danger" href="<?= base_url('/admin/deleteSize/' . $gameSize['id']) ?>">Eliminar</a>
                                </td>
                                <td><?= $gameSize['name'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div class="col-4">
                    <h2>Ejércitos</h2>
                    <table class="table table-borderless">
                        <?php foreach ($armies as $army) : ?>
                            <tr>
                                <td>
                                    <a class="btn btn-danger" href="<?= base_url('/admin/deleteArmy/' . $army['id']) ?>">Eliminar</a>
                                </td>
                                <td><?= $army['name'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
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