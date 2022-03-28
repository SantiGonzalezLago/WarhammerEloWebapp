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
                            <?php if ($setting['type'] == "checkbox") : ?>
                                <input type="checkbox" name="<?= $setting['key'] ?>" id="<?= $setting['key'] ?>" value="1" <?= $setting['value'] ? "checked" : "" ?> >
                            <?php else: ?>
                                <input autocomplete="off" type="<?= $setting['type'] ?>" name="<?= $setting['key'] ?>" id="<?= $setting['key'] ?>" value="<?= $setting['value'] ?>" class="form-control">
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
                    <div class="form-group">
                        <select name="game-type" id="game-type"  data-width="100%" data-live-search="true" data-show-subtext="true" title="Tipo de partida">
                            <?php foreach ($gameTypes as $gameType) : ?>
                                <option value="<?= $gameType['id'] ?>"><?= $gameType['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                            <button id="add-type" type="button" class="btn-block btn btn-success">Añadir</button>
                        </div>
                        <div class="col-4">
                            <button id="edit-type" type="button" class="btn-block btn btn-warning">Editar</button>
                        </div>
                        <div class="col-4">
                            <button id="delete-type" type="button" class="btn-block btn btn-danger">Eliminar</button>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <h2>Tamaños de partida</h2>
                    <div class="form-group">
                        <select name="game-size" id="game-size"  data-width="100%" data-live-search="true" data-show-subtext="true" title="Tamaño de partida">
                            <?php foreach ($gameSizes as $gameSize) : ?>
                                <option value="<?= $gameSize['id'] ?>"><?= $gameSize['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                            <button id="add-size" type="button" class="btn-block btn btn-success">Añadir</button>
                        </div>
                        <div class="col-4">
                            <button id="edit-size" type="button" class="btn-block btn btn-warning">Editar</button>
                        </div>
                        <div class="col-4">
                            <button id="delete-size" type="button" class="btn-block btn btn-danger">Eliminar</button>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <h2>Ejércitos</h2>
                    <div class="form-group">
                        <select name="game-size" id="game-army"  data-width="100%" data-live-search="true" data-show-subtext="true" title="Ejército">
                            <?php foreach ($armies as $army) : ?>
                                <option value="<?= $army['id'] ?>"><?= $army['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                            <button id="add-army" type="button" class="btn-block btn btn-success">Añadir</button>
                        </div>
                        <div class="col-4">
                            <button id="edit-army" type="button" class="btn-block btn btn-warning">Editar</button>
                        </div>
                        <div class="col-4">
                            <button id="delete-army" type="button" class="btn-block btn btn-danger">Eliminar</button>
                        </div>
                    </div>
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

<div class="modal" id="type-modal" tabindex="-1">
    <form class="modal-dialog" action="<?= base_url('/admin/editType') ?>" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id" name="id" value=""></input>
                <div class="form-group mb-3">
                    <input type="text" name="name" id="name" class="form-control" required />
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Aceptar</button>
            </div>
        </div>
    </form>
</div>

<div class="modal" id="size-modal" tabindex="-1">
    <form class="modal-dialog" action="<?= base_url('/admin/editSize') ?>" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id" name="id" value=""></input>
                <div class="form-group mb-3">
                    <input type="text" name="name" id="name" class="form-control" required />
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Aceptar</button>
            </div>
        </div>
    </form>
</div>

<div class="modal" id="army-modal" tabindex="-1">
    <form class="modal-dialog" action="<?= base_url('/admin/editArmy') ?>" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id" name="id" value=""></input>
                <div class="form-group mb-3">
                    <input type="text" name="name" id="name" class="form-control" required />
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Aceptar</button>
            </div>
        </div>
    </form>
</div>