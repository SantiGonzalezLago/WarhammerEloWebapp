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
        <td><?= $player['display_name'] ?></td>
    </tr>
    <tr>
        <th>Elo</th>
        <td><?= $player['elo'] ?></td>
    </tr>
    <?php if ($player['id'] == session('id')) : ?>
        <tr>
            <th>Email</th>
            <td><?= $player['email'] ?></td>
        </tr>
    <?php endif; ?>
</table>
<a href="<?= base_url('/players') ?>" class="btn btn-outline-secondary float-end">Volver a Jugadores</a>
