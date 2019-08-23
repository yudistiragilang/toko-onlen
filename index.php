
<?php
	
	session_start();
    include("config.php");

?>

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

<body background="back.jpg">

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
					<li class="active"><a href="index.php">Home</a></li>
					<li><a href="tentang.php">Tentang Kami</a></li>
					<li><a href="cara_pesan.php">Cara Pesan</a></li>
				</ul>

				<ul class="side-nav" id="mobile-menu">
					<li class="active"><a href="index.php">Home</a></li>
					<li><a href="tentang.php">Tentang Kami</a></li>
					<li><a href="cara_pesan.php">Cara Pesan</a></li>
				</ul>
			</div>
		</div>
		</nav>
	<!-- </div> -->
	<!-- Menu -->

	<!-- Konten -->
	<br><br>
	<div class="container_body">

		<!-- MODAL -->
			<div id="modal1" class="modal">
			    <div class="modal-content">
					 <?php

						if(isset($_POST["simpan"])) {

							$a=$_POST["email"];
							$b=$_POST["password"];
							$c=$_POST["first_name"];
							$d=$_POST["last_name"];
							$e=$_POST["address"];

							try {
									$stmt = $conn->prepare("SELECT * FROM users WHERE user_email = '$a'"); 
								    $stmt->execute();
								    $count = $stmt->rowCount();
								    if ($count > 0) {
								    	echo "<script>alert('Customer is already exist, Please try another one!')</script>";
										echo"<script>window.open('index.php','_self')</script>";
										exit();
								    } else {

								    	try {
										    	$sql = "INSERT INTO users (user_email, user_password, user_firstname, user_lastname, user_address, user_level)VALUES ('$a', '$b', '$c', '$d', '$e', '0')";
											    $conn->exec($sql);
											    echo"<script>window.alert('DATA BERHASIL DISIMPAN');;window.location='index.php'</script>";
										    }
										catch(PDOException $e)
										    {
										    echo $sql . "<br>" . $e->getMessage();
										    }
								    }
								}
							catch(PDOException $e)
								{
								    echo "Error: " . $e->getMessage();
								}			
						}
					
					echo'
					<form method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<h4 class="center-align">
									Registrasi User
								</h4>
								<div class="row">
									<div class="col s12 m6 l6 input-field">
										<i class="material-icons prefix">account_circle</i>
										<input type="text" name="first_name" required id="icon_prefix">
										<label for="icon_prefix">Nama Depan</label>
									</div>
									<div class="col s12 m6 l6 input-field">
										<i class="material-icons prefix">account_circle</i>
										<input type="text" name="last_name" required id="icon_prefix">
										<label for="icon_prefix">Nama Belakang</label>
									</div>
								</div>

								<div class="row">
									<div class="col s12 m12 l12 input-field">
							        	<input id="email" type="email" name="email" class="validate">
							        	<label for="email">Email</label>
							    	</div>
								</div>

								<div class="row">
									<div class="col s12 m12 l12 input-field">
							    		<input id="password" type="password" name="password" class="validate">
										<label for="password">Password</label>
							    	</div>
							    </div>

							    <div class="row">
									<div class="col s12 m12 l12 input-field">
							        	<textarea id="textarea1" name="address" class="materialize-textarea"></textarea>
							        	<label for="textarea1">Alamat</label>
							    	</div>
							    </div>

							    <div class="row">
									<div class="input-field center-align">
										<button class="btn waves-effect waves-light" type="submit" name="simpan">Simpan<i class="material-icons right">send</i></button>
									</div>
								</div>
							</div>
					</form>
					';
					?>

				</div>
			</div>

			<div id="modal2" class="modal">
			    <div class="modal-content">
					 <?php

						if(isset($_POST['user_login']))
					    {
					        $user_email=$_POST['user_email'];
					        $user_password=$_POST['user_password'];

					        try {
					                $stmt = $conn->prepare("SELECT * FROM users WHERE user_email='$user_email' AND user_password='$user_password'");
					                $stmt->execute();
					                $count = $stmt->rowCount();
					                while ($row = $stmt->fetch()) {
					                    $user_id =  $row['user_id'];
					                    $user =  $row['user_firstname'];
					                    $level =  $row['user_level'];
					                }

					                if ($count > 0) {

					                    if ($level == 1) {
					                        echo "<script>window.open('admin/index.php','_self')</script>";
					                        $_SESSION['user_email']= $user_email;
					                        $_SESSION['user_id']= $user_id;
					                        $_SESSION['user_firstname']= $user;
					                        $_SESSION['user_level']= $level;
					                    } else {
					                        echo "<script>window.open('customers/index.php','_self')</script>";
					                        $_SESSION['user_email']= $user_email;
					                        $_SESSION['user_id']= $user_id;
					                        $_SESSION['user_firstname']= $user;
					                        $_SESSION['user_level']= $level;
					                    }
					                    
					                } else {
					                    echo "<script>alert('Email or password Salah!')</script>";
					                    echo "<script>window.open('index.php','_self')</script>";
					                    exit();
					                }
					            }
					        catch(PDOException $e)
					            {
					                echo "Error: " . $e->getMessage();
					            }
					    }
					
					echo'
					<form method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<h4 class="center-align">
									Login User
								</h4>
								<div class="row">
									<div class="col s12 m12 l12 input-field">
							        	<input id="email" type="email" name="user_email" class="validate">
							        	<label for="email">Email</label>
							    	</div>
								</div>

								<div class="row">
									<div class="col s12 m12 l12 input-field">
							    		<input id="password" type="password" name="user_password" class="validate">
										<label for="password">Password</label>
							    	</div>
							    </div>

							    <div class="row">
									<div class="input-field center-align">
										<button class="btn waves-effect waves-light" type="submit" name="user_login">Login<i class="material-icons right">send</i></button>
									</div>
								</div>
							</div>
					</form>
					';
					?>

				</div>
			</div>
		<!-- MODAL -->

		<div class="row">
			<div class="col s12 white">
				<h5>Hallo ! ! ! </h5>
				<p>
					<span>
						Gunakan dengan bijak ya 
					</span>
				</p>
			</div>
		</div>
		<div class="row">

			<div class="col s12 m2 l2"></div>
			<div class="col s12 m4 l4 light-green accent-1">
				<div class="card blue-grey darken-1 center-align">
		            <div class="card-content white-text">
		              <span class="card-title">Registrasi</span>
		              <img src="gambar/dragonstone.jpg" class="responsive-img" alt="">
		            </div>
		            <div class="card-action">
		              <a href="#modal1" class="orange darken-4 waves-effect waves-light modal-trigger btn">Kelola</a>
		            </div>
		        </div>
		    </div>

		    <div class="col s12 m4 l4 light-green accent-1">
		        <div class="card blue-grey darken-1 center-align">
		            <div class="card-content white-text">
		              <span class="card-title">Login</span>
		              <img src="gambar/co2.png" class="responsive-img" alt="">
		            </div>
		            <div class="card-action">
		              <a href="#modal2" class="orange darken-4 waves-effect waves-light modal-trigger btn">Kelola</a>
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
			$('.modal').modal();
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