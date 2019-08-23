
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

	$stmt = $conn->prepare('SELECT * FROM users WHERE user_email =:user_email');
	$stmt->execute(array(':user_email'=>$_SESSION['user_email']));
	$data_user = $stmt->fetch(PDO::FETCH_ASSOC);
	$user_id = $data_user['user_id'];

	$stmt = $conn->prepare("SELECT SUM(order_total) AS total FROM orderdetails WHERE user_id=:user_id AND order_status='ordered'");
	$stmt->execute(array(':user_id'=>$_SESSION['user_id']));
	$harga = $stmt->fetch(PDO::FETCH_ASSOC);

	if(isset($_POST['cekout']))
	{
		$name = $_POST['naleng'];
		$adress = $_POST['alamat'];
		$phone = $_POST['notel'];

		$bank_name = $_POST['nabank'];
		$akun = $_POST['atas_nama'];
		$norek = $_POST['norek'];
		$tot_transfer = $_POST['jumlah'];

		$sql = "INSERT INTO alamatdetails (user_id, name, adress, phone) VALUES ('$user_id','$name', '$adress', '$phone')";
		$conn->exec($sql);
		$last_id = $conn->lastInsertId();

		$sql = "INSERT INTO bank_transfer (alamat_id, user_id, bank_name, ats_nama, norek, jumlah) VALUES ('$last_id', '$user_id','$bank_name', '$akun', '$norek', '$tot_transfer')";
		$conn->exec($sql);

		echo "<script>window.open('ordered.php','_self')</script>";
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Checkout</title>
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
					<li class="active"><a href="belanja.php">Data Belanja</a></li>
					<li><a href="ordered.php">Data Order</a></li>
					<li><a href="pesanan_sebelumnya.php">Belanja Sebelumnya</a></li>
					<li><a href="profil.php">Profil</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>

				<ul class="side-nav" id="mobile-menu">
					<li><a href="index.php">Beranda</a></li>
					<li><a href="pesan.php">Data Pesan</a></li>
					<li class="active"><a href="belanja.php">Data Belanja</a></li>
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
				<h5>Checkout Belanja</h5>
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
		<br>
		<hr>
		<br>
		<div class="row">
			<div class="col s12 m8 l8 offset-m2 offset-l2">
				<form method="POST" action="">
					<h5>Data Penerima</h5>
					<div class="row">
						<div class="input-field col s12">
							<input type="text" class="validate" name="naleng" placeholder="Nama Lengkap. .">
							<label>Nama Lengkap</label>
						</div>
						<div class="input-field col s12">
							<input type="text" class="validate" name="alamat" placeholder="Alamat Lengkap. .">
							<label>Alamat Lengkap</label>
						</div>
						<div class="input-field col s12">
							<input type="text" class="validate" name="notel" placeholder="Nomor yang bisa dihubungi. .">
							<label>Nomor Telepon</label>
						</div>
					</div>
					<br>
					<h5>Bank Transfer</h5>
					<div class="row">
						<div class="input-field col s12">
							<input type="text" class="validate" name="nabank" placeholder="Nama Bank. .">
							<label>Nama Bank</label>
						</div>
						<div class="input-field col s12">
							<input type="text" class="validate" name="atas_nama" placeholder="Atas Nama Rekening. .">
							<label>Atas Nama Bank</label>
						</div>
						<div class="input-field col s12">
							<input type="text" class="validate" name="norek" placeholder="Nomor Rekening. .">
							<label>Nomor Rekening</label>
						</div>
						<div class="input-field col s12">
							<input type="text" class="validate" name="jumlah" placeholder="Total Transfer. .">
							<label>Nominal Transfer</label>
						</div>
						<div class="input-field col s12 center-align">
							<button class="btn waves-effect waves-light" type="submit" name="cekout">Checkout</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<br>
		<hr>
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
		function pesen(){
			pesen = confirm("Anda yakin akan memesan item ini ?");
				if (pesen == true) return true;
				else return false;
				}
	</script>
</body>
</html>