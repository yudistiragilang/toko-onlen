
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

	$stmt = $conn->prepare('SELECT * FROM users WHERE user_email =:user_email');
	$stmt->execute(array(':user_email'=>$_SESSION['user_email']));
	$data_user = $stmt->fetch(PDO::FETCH_ASSOC);

	if (isset($_POST['edit'])) {
		
		$a=$_POST["email"];
		$b=$_POST["password"];
		$c=$_POST["first_name"];
		$d=$_POST["last_name"];
		$e=$_POST["address"];

		try {
			$stmt = $conn->prepare('UPDATE users SET user_email=:user_email, user_password=:user_password, user_firstname=:user_firstname, user_lastname=:user_lastname, user_address=:user_address WHERE user_id=:user_id');
			$stmt->bindParam(':user_email',$a);
			$stmt->bindParam(':user_password',$b);
			$stmt->bindParam(':user_firstname',$c);
			$stmt->bindParam(':user_lastname',$d);
			$stmt->bindParam(':user_address',$e);
			$stmt->bindParam(':user_id',$data_user['user_id']);
			if($stmt->execute()){
				echo "<script>alert('Account successfully updated!')</script>";
		        echo"<script>window.open('profil.php','_self')</script>";
			}
			else{
				echo "<script>alert('Error Found!')</script>";
			}
		}
		catch(PDOException $e){
			echo "Error: " . $e->getMessage();
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Profil</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../asset/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="../asset/css_pribadi.css">
	<link rel="shortcut icon" href="../favicon.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
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
					<li><a href="index.php">Beranda</a></li>
					<li><a href="pesan.php">Data Pesan</a></li>
					<li><a href="belanja.php">Data Belanja</a></li>
					<li><a href="ordered.php">Data Order</a></li>
					<li><a href="pesanan_sebelumnya.php">Belanja Sebelumnya</a></li>
					<li class="active"><a href="profil.php">Profil</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>

				<ul class="side-nav" id="mobile-menu">
					<li><a href="index.php">Beranda</a></li>
					<li><a href="pesan.php">Data Pesan</a></li>
					<li><a href="belanja.php">Data Belanja</a></li>
					<li><a href="ordered.php">Data Order</a></li>
					<li><a href="pesanan_sebelumnya.php">Belanja Sebelumnya</a></li>
					<li class="active"><a href="profil.php">Profil</a></li>
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
				<h5>Profil User</h5>
				<p>
					<?php
			        	$Today=date('y:m:d');
			        	$new=date('l, F d, Y',strtotime($Today));
			        	echo $new;
		            ?>
				</p>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col s12 m6 l6 offset-m3 offset-l3">
				<form method="POST" action="">
					<div class="row">
						<div class="col s12 m12 l12 input-field">
							<input type="text" name="first_name" value="<?php echo $data_user['user_firstname']; ?>" required>
							<label>Nama Depan</label>
						</div>
					</div>
					<div class="row">
						<div class="col s12 m12 l12 input-field">
							<input type="text" name="last_name" value="<?php echo $data_user['user_lastname']; ?>" required>
							<label>Nama Belakang</label>
						</div>
					</div>
					<div class="row">
						<div class="col s12 m12 l12 input-field">
							<input type="text" name="email" value="<?php echo $data_user['user_email']; ?>" required >
							<label>E-mail</label>
						</div>
					</div>
					<div class="row">
						<div class="col s12 m12 l12 input-field">
							<input type="text" name="password" value="<?php echo $data_user['user_password']; ?>" required >
							<label>Password</label>
						</div>
					</div>
					<div class="row">
						<div class="col s12 m12 l12 input-field">
							<input type="text" name="address" value="<?php echo $data_user['user_address']; ?>" required >
							<label>Alamat</label>
						</div>
					</div>
					<div class="row center-align">
						<div class="col s12 m12 l12 input-field">
							<button class="btn waves-effect waves-light" name="edit" type="submit">Edit</button>
						</div>
					</div>
				</form>
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
	<script src="../asset/js/jquery.dataTables.min.js"></script>
	<script src="../asset/datatables/datatables.min.js"></script>
	<script>
		$(document).ready(function(){
			$('.button-collapse').sideNav();
			$('select').material_select();
			$('.datepicker').pickadate({
				selectMonths : true,
				selectYears : 10
			});

			$('.modal').modal();
			$('#dataflora').DataTable();
		});
	</script>
	<script type="text/javascript" language="JavaScript">
		function hapus(){
			takon = confirm("Anda Yakin Akan Menghapus Data ?");
				if (takon == true) return true;
				else return false;
				}
	</script>
</body>
</html>