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
        <th>Título</th>
        <th>Jugador 1</th>
        <th></th>
        <th>Jugador 2</th>
    </tr>
    <?php foreach ($games as $game) : ?>
        <tr>
            <td><a href="<?= base_url('/games/view/' . $game['id']) ?>" ><?= $game['title'] ?></a></td>
            <td><?= $game['player1_name'] ?></td>
            <td><?= $game['result'] == "TIE" ? "&half;-&half;" : $game['result'] ?></td>
            <td><?= $game['player2_name'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>