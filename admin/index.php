
<?php

	include('../config.php');

	session_start();

	if(!$_SESSION['user_firstname']){
		header("location: ../index.php");
		exit();
	}
	if($_SESSION['user_level']!=1){
		header("location: ../index.php");
		exit();
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Home</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../asset/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="../asset/css_pribadi.css">
	<link rel="shortcut icon" href="../favicon.ico" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		/*body{
			background: gambar/back.jpg;
		}*/
	</style>
</head>

<body background="../back.jpg">

	<!-- Menu -->
	<!-- <div class="navbar-fixed"> -->
		<!-- menu dropdown1 -->
		<nav class="light-blue darken-3">
		<div class="container_body">
			<div class="nav-wrapper">
				<a href="index.php" class="brand-logo">KEP</a>
				<a href="#" data-activates="mobile-menu" class="button-collapse">
					<i class="material-icons">menu</i>
				</a>

				<ul class="right hide-on-med-and-down">
					<li class="active"><a href="index.php">Beranda</a></li>
					<li><a href="barang.php">Data Barang</a></li>
					<li><a href="pelanggan.php">Data Pelanggan</a></li>
					<li><a href="approve_pesanan.php">Approve Pesanan</a></li>
					<li><a href="pesanan.php">Detail Pesanan</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>

				<ul class="side-nav" id="mobile-menu">
					<li class="active"><a href="index.php">Beranda</a></li>
					<li><a href="barang.php">Data Barang</a></li>
					<li><a href="pelanggan.php">Data Pelanggan</a></li>
					<li><a href="approve_pesanan.php">Approve Pesanan</a></li>
					<li><a href="pesanan.php">Detail Pesanan</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>
		</div>
		</nav>
	<!-- </div> -->

	<!-- Menu -->

	<!-- Konten -->
	<br><br>
	<div class="container_body">

		<div class="row">
			<div class="col s12 white">
				<h5>Hallo ! ! ! <?php echo $_SESSION['user_firstname']; ?> </h5>
				<p>
					<?php
			        	$Today=date('y:m:d');
			        	$new=date('l, F d, Y',strtotime($Today));
			        	echo $new;
		            ?>
				</p>
				<p>
					<span>
						Gunakan dengan bijak ya 
					</span>
				</p>
			</div>
		</div>
		<div class="row">

			<div class="col s12 m4 l4 light-green accent-1">
				<div class="card blue-grey darken-1 center-align">
		            <div class="card-content white-text">
		              <span class="card-title">Data Barang</span>
		              <img src="../gambar/dragonstone.jpg" class="responsive-img" alt="">
		            </div>
		            <div class="card-action">
		              <a href="barang.php" class="orange darken-4 waves-effect waves-light btn">Kelola</a>
		            </div>
		        </div>
		    </div>

		    <div class="col s12 m4 l4 light-green accent-1">
		        <div class="card blue-grey darken-1 center-align">
		            <div class="card-content white-text">
		              <span class="card-title">Data Pelanggan</span>
		              <img src="../gambar/co2.png" class="responsive-img" alt="">
		            </div>
		            <div class="card-action">
		              <a href="pelanggan.php" class="orange darken-4 waves-effect waves-light btn">Kelola</a>
		            </div>
		        </div>
		    </div>

		    <div class="col s12 m4 l4 light-green accent-1">
		        <div class="card blue-grey darken-1 center-align">
		            <div class="card-content white-text">
		              <span class="card-title">Detail Pesanan</span>
		              <img src="../gambar/anubias.jpg" class="responsive-img" alt="">
		            </div>
		            <div class="card-action">
		              <a href="pesanan.php" class="orange darken-4 waves-effect waves-light btn">Kelola</a>
		            </div>
		        </div>
		    </div>
			
		</div>
		<br>
	</div>
	<!-- Konten -->

	<!-- Footer -->
	<br>
	<br>
	<footer class="page-footer light-blue darken-3 black-text">
			<div class="footer-copyright">
				<div class="container center-align">
					&copy; Kebakkramat Elang Perkasa - materialize <?php echo date('Y'); ?>
					<br>
					Yudhistira Gilang
				</div>
			</div>
	</footer>
	<!-- Footer -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="../asset/js/materialize.min.js"></script>
	<script>
		$(document).ready(function(){
			$('.button-collapse').sideNav();
			$('.materialboxed').materialbox();
		})
	</script>
</body>
</html>