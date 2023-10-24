<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap 5.3.2 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<title>Poliklinik</title>
	<style>
		body {
			padding-top: 30px;
			padding-bottom: 30px;
		}
	</style>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
		<div class="container-fluid">
			<a class="navbar-brand" href="index.php">Poliklinik</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" arialabel="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" ariaexpanded="false">
							Data Master
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<li><a class="dropdown-item" href="index.php?page=dokter">Dokter</a></li>
							<li><a class="dropdown-item" href="index.php?page=pasien">Pasien</a></li>
						</ul>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="index.php?page=periksa">Periksa</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<main class="container mt-5">
		<?php
		include("koneksi.php");
		if (isset($_GET['page'])) {
		?>
			<h2><?php ($_GET['page']) ?></h2>
		<?php
			include($_GET['page'] . ".php");
		} else {
			echo "<h2 class='text-center'>Selamat Datang di Sistem Informasi 
Poliklinik</h2>";
		}
		?>
	</main>
	<!-- Bootstrap 5.3.2 JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js
"></script>
</body>

</html>