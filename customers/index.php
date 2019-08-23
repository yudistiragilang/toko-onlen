
<?php

	include('../config.php');

	session_start();

	if(!$_SESSION['user_firstname']){
		header("location: ../index.php");
		exit();
	}

	if($_SESSION['user_level']!=0){
		header("location: ../index.php");
		exit();
	}

	function rupiah($angka){
		$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
		return $hasil_rupiah;
	}

	$stmt = $conn->prepare("SELECT SUM(order_total) AS total FROM orderdetails WHERE user_id=:user_id AND order_status='ordered'");
	$stmt->execute(array(':user_id'=>$_SESSION['user_id']));
	$harga = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Customers Home</title>
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
					<li><a href="pesan.php">Data Pesan</a></li>
					<li><a href="belanja.php">Data Belanja</a></li>
					<li><a href="ordered.php">Data Order</a></li>
					<li><a href="pesanan_sebelumnya.php">Belanja Sebelumnya</a></li>
					<li><a href="profil.php">Profil</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>

				<ul class="side-nav" id="mobile-menu">
					<li class="active"><a href="index.php">Beranda</a></li>
					<li><a href="pesan.php">Data Pesan</a></li>
					<li><a href="belanja.php">Data Belanja</a></li>
					<li><a href="ordered.php">Data Order</a></li>
					<li><a href="pesanan_sebelumnya.php">Belanja Sebelumnya</a></li>
					<li><a href="profil.php">Profil</a></li>
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
			<div class="col s12 m8 l8 white">
				<h5>Hallo ! ! ! <?php echo $_SESSION['user_firstname']; ?> </h5>
				<p>
					<?php
			        	$Today=date('y:m:d');
			        	$new=date('l, F d, Y',strtotime($Today));
			        	echo $new;
		            ?>
				</p>
			</div>
			<div class="col s12 m4 l4 white">
				<h5>Total belanja</h5>
				<p><?php echo rupiah($harga['total']); ?></p>
			</div>
		</div>
		<div class="row">

			<div class="col s12 m3 l3 light-green accent-1">
				<div class="card blue-grey darken-1 center-align">
		            <div class="card-content white-text">
		              <span class="card-title">Data Pesan</span>
		              <img src="../gambar/dragonstone.jpg" class="responsive-img" alt="">
		            </div>
		            <div class="card-action">
		              <a href="pesan.php" class="orange darken-4 waves-effect waves-light btn">Kelola</a>
		            </div>
		        </div>
		    </div>

		    <div class="col s12 m3 l3 light-green accent-1">
		        <div class="card blue-grey darken-1 center-align">
		            <div class="card-content white-text">
		              <span class="card-title">Data Belanja</span>
		              <img src="../gambar/co2.png" class="responsive-img" alt="">
		            </div>
		            <div class="card-action">
		              <a href="belanja.php" class="orange darken-4 waves-effect waves-light btn">Kelola</a>
		            </div>
		        </div>
		    </div>

		    <div class="col s12 m3 l3 light-green accent-1">
		        <div class="card blue-grey darken-1 center-align">
		            <div class="card-content white-text">
		              <span class="card-title">Belanja Sebelumnya</span>
		              <img src="../gambar/co2.png" class="responsive-img" alt="">
		            </div>
		            <div class="card-action">
		              <a href="pesanan_sebelumnya.php" class="orange darken-4 waves-effect waves-light btn">Kelola</a>
		            </div>
		        </div>
		    </div>

		    <div class="col s12 m3 l3 light-green accent-1">
		        <div class="card blue-grey darken-1 center-align">
		            <div class="card-content white-text">
		              <span class="card-title">Profil</span>
		              <img src="../gambar/anubias.jpg" class="responsive-img" alt="">
		            </div>
		            <div class="card-action">
		              <a href="profil.php" class="orange darken-4 waves-effect waves-light btn">Kelola</a>
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