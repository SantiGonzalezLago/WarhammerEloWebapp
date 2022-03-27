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
        <th colspan="3"><?= $game['title'] ?></th>
    </tr>
    <?php if ($game['type'] || $game['size']) : ?>
    <tr>
        <td colspan="3"><?= $game['type'] ?> <small class="text-muted"><?= $game['size'] ?></small></td>
    </tr>
    <?php endif; ?>
    <tr>
        <td><?= $game['player1_name'] ?> <small class="text-muted"><?= $game['player1_army'] ?></td>
        <td><?= $game['result'] == "TIE" ? "&half;-&half;" : $game['result'] ?></td>
        <td><?= $game['player2_name'] ?> <small class="text-muted"><?= $game['player2_army'] ?></td>
    </tr>
    <tr>
        <td colspan="3" class="<?= $game['description'] == "" ? "text-muted" : "" ?>"><?= $game['description'] == "" ? "Sin descripción" : $game['description']?></td>
    </tr>
</table>
<?php if ($userdata['admin']) : ?>
    <btn type="button" class="btn btn-outline-success float-left" data-toggle="modal" data-target="#change-description-modal">Editar descripción</btn>
<?php endif; ?>
<a href="<?= base_url('/games') ?>" class="btn btn-outline-secondary float-right">Volver a Partidas</a>


<?php if ($userdata['admin']) : ?>
    <div class="modal" id="change-description-modal" tabindex="-1">
        <form class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar descripción</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" name="id" value="<?= $game['id'] ?>"></input>
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="description" id="description" rows="5" placeholder="Descripción"><?= $game['description'] ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </form>
    </div>
<?php endif; ?>