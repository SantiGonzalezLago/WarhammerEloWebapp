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

<!DOCTYPE html>
<head>
	<title><?= (isset($title) ? $title . ' - ' : '') ?>Warhammer</title>
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" type="image/png" href="<?= base_url('/favicon.ico') ?>"/>

	<link rel="stylesheet" type="text/css" href="<?= base_url('/assets/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('/assets/css/main.css') ?>">

	<script type="text/javascript" src="<?= base_url('/assets/js/jquery-3.6.0.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('/assets/js/jquery-ui.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('/assets/js/bootstrap.bundle.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('/assets/js/main.js') ?>"></script>
</head>

<body>

	<header class="p-0">
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
			<div class="container-fluid">
				<a class="navbar-brand" href="<?= base_url() ?>">Warhammer</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">

					<?php if (isset($userdata)) : ?>
						<ul class="navbar-nav me-auto mb-2 mb-lg-0">
							<li class="nav-item"><a class="nav-link" href="<?= base_url('/players') ?>">Jugadores</a></li>
							<li class="nav-item"><a class="nav-link" href="<?= base_url('/games') ?>">Partidas</a></li>
							<?php if ($userdata['admin']) : ?>
								<li class="nav-item"><a class="nav-link" href="<?= base_url('/games/add') ?>">Añadir partida</a></li>
							<?php endif; ?>
						</ul>

						<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
						<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<?= $userdata['display_name'] ?>
						</a>
						<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
							<li><a class="dropdown-item" href="<?= base_url('/players/view/' . $userdata['id']) ?>">Perfil</a></li>
							<li><a class="dropdown-item" href="#">Cambiar contraseña</a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="<?= base_url('/login/logout') ?>">Cerrar Sesión</a></li>
						</ul>

					<?php endif; ?>
				</div>
			</div>
		</nav>
	</header>

	<main class="container container-l">
		<?= view($view, $data ?? []) ?>
	</main>

</body>