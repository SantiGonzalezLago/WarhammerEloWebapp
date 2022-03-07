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
        <th></th>
        <th>Nombre</th>
        <th>Elo</th>
        <th>Diferencia</th>
    </tr>
    <?php foreach ($players as $player) : ?>
        <tr>
            <td><?= $player['pos'] ?></td>
            <td><a href="<?= base_url('/players/view/' . $player['id']) ?>" ><?= $player['display_name'] ?></a></td>
            <td><?= $player['elo'] ?></td>
            <td><?= $player['dif'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>