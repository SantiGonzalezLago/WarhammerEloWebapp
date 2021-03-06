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

<h1 align="center">Añadir partida</h1>
<form id="add-game-form" action="<?= base_url('/games/add2') ?>" method="POST">
    <div class="form-group mb-3">
		<input type="text" class="form-control" id="title" name="title" placeholder="Título" required>
	</div>
    <div class="form-group row input-group mb-3">
        <div class="col-6">
            <select name="game-type" id="game-type" data-width="100%" data-live-search="true" title="Tipo de partida">
                <?php foreach ($gameTypes as $gameType) : ?>
                    <option value="<?= $gameType['id'] ?>"><?= $gameType['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-6">
            <select name="game-size" id="game-size" data-width="100%" data-live-search="true" title="Tamaño de partida">
                <?php foreach ($gameSizes as $gameSize) : ?>
                    <option value="<?= $gameSize['id'] ?>"><?= $gameSize['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
	</div>
    <div class="form-group row input-group mb-3">
        <div class="col-5">
            <select name="player1" id="player1" data-width="100%" data-live-search="true" data-show-subtext="true" title="Jugador 1" required>
                <?php foreach ($players as $player) : ?>
                    <option value="<?= $player['id'] ?>" data-subtext="<?= $player['elo'] ?>"><?= $player['display_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-2">
            <select name="result" id="result" data-width="100%" title="Resultado" required>
                <option value="1-0">1-0</option>
                <option value="0-1">0-1</option>
                <option value="TIE">&half;-&half;</option>
            </select>
        </div>
        <div class="col-5">
            <select name="player2" id="player2" data-width="100%" data-live-search="true" data-show-subtext="true" title="Jugador 2" required>
                <?php foreach ($players as $player) : ?>
                    <option value="<?= $player['id'] ?>" data-subtext="<?= $player['elo'] ?>"><?= $player['display_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group row input-group mb-3">
        <div class="col-6">
            <select name="army1" id="army1" data-width="100%" data-live-search="true" data-show-subtext="true" title="Ejército del jugador 1">
                <?php foreach ($armies as $army) : ?>
                    <option value="<?= $army['id'] ?>"><?= $army['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-6">
            <select name="army2" id="army2" data-width="100%" data-live-search="true" data-show-subtext="true" title="Ejército del jugador 2">
                <?php foreach ($armies as $army) : ?>
                    <option value="<?= $army['id'] ?>"><?= $army['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group mb-3">
        <textarea class="form-control" name="description" id="description" rows="5" placeholder="Descripción (opcional)"></textarea>
	</div>
    <div align="center"><button class="btn btn-success">Guardar</button></div>
</form>