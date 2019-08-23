
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

	$stmt = $conn->prepare('SELECT * FROM users WHERE user_email =:user_email');
	$stmt->execute(array(':user_email'=>$_SESSION['user_email']));
	$data_user = $stmt->fetch(PDO::FETCH_ASSOC);

	$stmt = $conn->prepare("SELECT SUM(order_total) AS total FROM orderdetails WHERE user_id=:user_id AND order_status='Ordered'");
	$stmt->execute(array(':user_id'=>$data_user['user_id']));
	$data_order = $stmt->fetch(PDO::FETCH_ASSOC);

	if(isset($_GET['id_item']) && !empty($_GET['id_item']))
	{
		$id = $_GET['id_item'];
		$stmt = $conn->prepare('SELECT * FROM items WHERE item_id =:item_id');
		$stmt->execute(array(':item_id'=>$id));
		$data_item = $stmt->fetch(PDO::FETCH_ASSOC);
	}
	else
	{
		header("location: pesan.php");
	}

	if(isset($_POST['order']))
	{
		$item_id = $_GET['id_item'];
		$user_id = $data_user['user_id'];
		$order_name = $data_item['item_name'];
		$order_price = $data_item['item_price'];
		$order_quantity = $_POST['jumlah'];
		$order_total=$order_price * $order_quantity;
		$order_status='pending';

		$sql = "INSERT INTO orderdetails (user_id, item_id, order_name, order_price, order_quantity, order_total, order_status, order_date) VALUES ('$user_id', '$item_id', '$order_name', '$order_price', '$order_quantity', '$order_total', '$order_status', CURDATE())";
		$conn->exec($sql);
		echo "<script>alert('Item successfully added to cart!')</script>";				
		echo "<script>window.open('pesan.php','_self')</script>";
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Data Pesan</title>
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
					<li class="active"><a href="pesan.php">Data Pesan</a></li>
					<li><a href="belanja.php">Data Belanja</a></li>
					<li><a href="ordered.php">Data Order</a></li>
					<li><a href="pesanan_sebelumnya.php">Belanja Sebelumnya</a></li>
					<li><a href="profil.php">Profil</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>

				<ul class="side-nav" id="mobile-menu">
					<li><a href="index.php">Beranda</a></li>
					<li class="active"><a href="pesan.php">Data Pesan</a></li>
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
				<h5>Tambah Pesanan</h5>
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
			<div class="col s12 m6 l6">
				<div class="row">
					<div class="col s12 m10 l10 offset-s1 offset-m1 offset-l1" style="width: 500px;">
						<img class="responsive-img" src="<?php echo '../gambar_barang/'.$data_item['item_image'];?>">
					</div>
				</div>
			</div>
			<div class="col s12 m6 l6">
				<form action="" method="POST"> 
					<table class="responsive-table">
						<tr>
							<td><b>Nama</b></td>
							<td><b>:</b></td>
							<td><b><?php echo $data_item['item_name']; ?></b></td>
						</tr>
						<tr>
							<td><b>Harga</b></td>
							<td><b>:</b></td>
							<td><b><?php echo rupiah($data_item['item_price']); ?></b></td>
						</tr>
						<tr>
							<td><b>Jumlah</b></td>
							<td><b>:</b></td>
							<td><input type="number" name="jumlah" value="1"></td>
						</tr>
						<tr>
							<td colspan="3" style="text-align: center;"><button onclick="return pesen()" class="btn green" type="submit" name="order">Pesan</button>&nbsp;<a href="pesan.php" class="btn red">Cencel</a></td>
						</tr>
					</table>
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