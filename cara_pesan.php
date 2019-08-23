
<!DOCTYPE html>
<html>
<head>
	<title>Kebakkramat Elang Perkasa</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="asset/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="asset/css_pribadi.css">
	<link rel="shortcut icon" href="favicon.ico" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		.link{
			color: white;
		}
		.link:active{
			color: red;
		}
		.link:hover{
			color: black;
		}
	</style>
</head>

<body>

	<!-- Menu -->
	<!-- <div class="navbar-fixed"> -->

		<nav class="light-blue darken-3">
		<div class="container_body">
			<div class="nav-wrapper">
				<a href="index.php" class="brand-logo">KEP</a>
				<a href="#" data-activates="mobile-menu" class="button-collapse">
					<i class="material-icons">menu</i>
				</a>

				<ul class="right hide-on-med-and-down">
					<li><a href="index.php">Home</a></li>
					<li><a href="tentang.php">Tentang Kami</a></li>
					<li class="active"><a href="cara_pesan.php">Cara Pesan</a></li>
				</ul>

				<ul class="side-nav" id="mobile-menu">
					<li><a href="index.php">Home</a></li>
					<li><a href="tentang.php">Tentang Kami</a></li>
					<li class="active"><a href="cara_pesan.php">Cara Pesan</a></li>
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
			<div>
				<img src="gambar/header.png" class="responsive-img">
			</div>	
		</div>
		<br>
		<div class="row">
			<div class="col s12 m8 l8">
				<h5>Apa sih itu Aquascape ?</h5>
				<img src="gambar/1.jpg" alt="" class="left materialboxed" width="300">
				<!-- <blockquote>
			       Seni mengatur tanaman, air, batu, karang, kayu dan lain sebagainya di akuarium. 
			    </blockquote> -->
			    <p class="">
			    	<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aquascape adalah seni mengatur tanaman air dan batu, batu karang, koral, atau kayu apung, secara alami dan indah di dalam akuarium sehingga memberikan efek seperti berkebun di bawah air.</span><br><br>
			    	<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tujuan utama dari aquascape adalah untuk menciptakan sebuah gambaran di bawah air, sehingga aspek teknis pemeliharaan tanaman air juga harus dipertimbangkan. Banyak faktor yang harus seimbang dalam ekosistem dari sebuah tangki akuarium untuk memastikan keberhasilan terciptanya sebuah keindahan dari seni aquascape.</span><br><br>
			    	<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Faktor-faktor ini meliputi penyaringan (filtrasi), mempertahankan kadar karbon dioksida (CO2) pada tingkat yang cukup untuk mendukung fotosintesis bawah air, substrat dan pemupukan, pencahayaan, dan kontrol alga (lumut).</span><br><br>
			    	<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Desain Aquascape sendiri mencakup sejumlah gaya yang berbeda-beda seperti dutch style, iwagumi, waterfall, dan nature style</span>
			    </p>
			</div>
			<div class="col s12 m4 l4">
				<div class="carousel">
					<h5>Galeri</h5>
					<a href="#!" class="carousel-item"><img src="gambar/1.jpg" alt=""></a>
					<a href="#!" class="carousel-item"><img src="gambar/2.jpg" alt=""></a>
					<a href="#!" class="carousel-item"><img src="gambar/3.jpg" alt=""></a>
					<a href="#!" class="carousel-item"><img src="gambar/4.jpg" alt=""></a>
					<a href="#!" class="carousel-item"><img src="gambar/5.jpg" alt=""></a>
				</div>
				<div>
					
				</div>
			</div>

		</div>
	</div>
	<!-- Konten -->

	<!-- Footer -->
	<br>
	<br>
	<footer class="page-footer light-blue darken-3 black-text">
		<div class="container_body">
			<div class="row">
				<div class="col s12 m4 l4">
					<h5>Daftar Menu</h5>
					<ul>
						<li><a class="link" href="#">Home</a></li>
						<li><a class="link" href="#">Tentang Kami</a></li>
						<li><a class="link" href="#">Cara Pesan</a></li>
					</ul>
				</div>

				<div class="col s12 m4 l4">
					<h5>Temukan Kami</h5>
					<ul>
						<li><a class="link" href="#">Facebook</a></li>
						<li><a class="link" href="#">Twetter</a></li>
						<li><a class="link" href="#">Instagram</a></li>
					</ul>
				</div>
				<div class="col s12 m4 l4 blue white">
					<h5>Saran</h5>

					<?php

						if (isset($_POST['nama']) and isset($_POST['pesan'])){
								
					
								$nama=$_POST["nama"];
								$saran=$_POST["pesan"];

								try {
								    	$sql = "INSERT INTO saran VALUES ('','$nama','$saran')";
									    $conn->exec($sql);
									    echo"<script>window.alert('DATA BERHASIL DISIMPAN');;window.location='index.php'</script>";
								    }
								catch(PDOException $e)
								    {
								    	echo $sql . "<br>" . $e->getMessage();
								    }
						}
					?>
					<form action="" method="POST">
						<div class="input-field ">
							<input type="text" name="nama" id="nama">
							<label for="nama">Nama</label>
						</div>
						<div class="input-field">
							<textarea id="pesan" name="pesan" class="materialize-textarea"></textarea>
          					<label for="pesan">Pesan</label>
						</div>
						<div class="input-field">
							<button class="btn waves-effect waves-light right" type="submit" name="kirim">Kirim</button>
						</div>
						<br>
					</form>
					<br>
				</div>
			</div>
		</div>
		<div class="footer-copyright">
			<div class="container_body center-align">
				&copy; Kebakkrramat Elang Perkasa - materialize <?php echo date('Y');?>
				<br>
				<a href="#!">Yudhistira Gilang</a>
			</div>
		</div>
	</footer>
	<!-- Footer -->

	<script src="asset/js/jquery.min.js"></script>
	<script src="asset/js/materialize.min.js"></script>
	<script>
		$(document).ready(function(){
			$('.dropdown-button').dropdown();
			$('.button-collapse').sideNav();
			$('.materialboxed').materialbox();
			$('select').material_select();
			$('.datepicker').pickadate({
				selectMonths : true,
				selectYears : 10
			});

			$('.carousel').carousel({
				dist: -70
			});
		})
	</script>
</body>
</html>