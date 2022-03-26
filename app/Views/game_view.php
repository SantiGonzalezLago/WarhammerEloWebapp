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
    <tr>
        <td colspan="3"><?= $game['type'] ?> <small class="text-muted"><?= $game['size'] ?></small></td>
    </tr>
    <tr>
        <td><?= $game['player1_name'] ?> <small class="text-muted"><?= $game['player1_army'] ?></td>
        <td><?= $game['result'] == "TIE" ? "&half;-&half;" : $game['result'] ?></td>
        <td><?= $game['player2_name'] ?> <small class="text-muted"><?= $game['player2_army'] ?></td>
    </tr>
    <tr>
        <td colspan="3" class="<?= $game['description'] == "" ? "text-muted" : "" ?>"><?= $game['description'] == "" ? "Sin descripción" : $game['description']?></td>
    </tr>
</table>
<a href="<?= base_url('/games') ?>" class="btn btn-outline-secondary float-right">Volver a Partidas</a>
