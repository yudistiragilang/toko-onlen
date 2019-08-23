
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

	function rupiah($angka){
		$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
		return $hasil_rupiah;
	}

	$user_id = $_GET['user_id'];

	$sql = "SELECT
				*
			FROM
				alamatdetails AS alamat
				JOIN bank_transfer AS bank ON bank.alamat_id=alamat.idalamat
				WHERE alamat.user_id =:user_id ORDER BY id_bank DESC LIMIT 1";
	$stmt = $conn->prepare($sql);
	$stmt->execute(array(':user_id'=>$user_id));
	$data_order_detail = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if(isset($_GET['order_id']))
	{
		$stmt = $conn->prepare('DELETE FROM orderdetails WHERE order_id =:order_id');
		$stmt->bindParam(':order_id',$_GET['order_id']);
		$stmt->execute();
		header("location: belanja.php");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Detail Pesanan</title>
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
					<li><a href="barang.php">Data Barang</a></li>
					<li><a href="pelanggan.php">Data Pelanggan</a></li>
					<li class="active"><a href="approve_pesanan.php">Approve Pesanan</a></li>
					<li><a href="pesanan.php">Detail Pesanan</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>

				<ul class="side-nav" id="mobile-menu">
					<li><a href="index.php">Beranda</a></li>
					<li><a href="barang.php">Data Barang</a></li>
					<li><a href="pelanggan.php">Data Pelanggan</a></li>
					<li class="active"><a href="approve_pesanan.php">Approve Pesanan</a></li>
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
			<div class="col s12 m8 l8 white">
				<h5>Detail Pesanan</h5>
				<p>
					<?php
			        	$Today=date('y:m:d');
			        	$new=date('l, F d, Y',strtotime($Today));
			        	echo $new;
		            ?>
				</p>
			</div>
		</div>
		<br>
		<hr>
		<br>

		<?php
		$stmt = $conn->prepare("SELECT * FROM orderdetails WHERE order_status='ordered' AND user_id='$user_id'");
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
		?>

		<div class="row" style="font-weight: bold;">
			<div class="col s12 m6 l6">
				<table class="responsive-table striped">
						<tr>
							<td>Nama Lengkap</td>
							<td>:</td>
							<td><?php echo $data_order_detail['name']; ?></td>
						</tr>
						<tr>
							<td>Alamat Lengkap</td>
							<td>:</td>
							<td><?php echo $data_order_detail['adress']; ?></td>
						</tr>
						<tr>
							<td>Nomor Telepon</td>
							<td>:</td>
							<td><?php echo $data_order_detail['phone']; ?></td>
						</tr>
						<tr>
							<td>Status Order</td>
							<td>:</td>
							<td style="color: green;">Ordered</td>
						</tr>
				</table>
			</div>
			<div class="col s12 m6 l6">
				<table class="responsive-table striped">
						<tr>
							<td>Nama Bank</td>
							<td>:</td>
							<td><?php echo $data_order_detail['bank_name']; ?></td>
						</tr>
						<tr>
							<td>Atas Nama Rek.</td>
							<td>:</td>
							<td><?php echo $data_order_detail['ats_nama']; ?></td>
						</tr>
						<tr>
							<td>Nomor Rek.</td>
							<td>:</td>
							<td><?php echo $data_order_detail['norek']; ?></td>
						</tr>
						<tr>
							<td>Jumlah Transfer</td>
							<td>:</td>
							<td><?php echo rupiah($data_order_detail['jumlah']); ?></td>
						</tr>
				</table>
			</div>
		</div>

		<?php
		} else {
		?>

		<div class="row center-align" style="font-weight: bold;">
			<h5 style="color: red;">Tidak ada orderan</h5>
		</div>

		<?php
		}		
		?>
		
		<hr>
		<br>
		<br>

		<div class="row">
			<table class="responsive-table">
				<thead>
					<tr>
						<th>No</th>
						<th>Item</th>
						<th>Harga</th>
						<th>Jumlah</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						$grand_total=0;
						$stmt = $conn->prepare("SELECT * FROM orderdetails WHERE order_status='ordered' AND user_id='$user_id'");
						$stmt->execute();
							
						if($stmt->rowCount() > 0)
						{
							while($row=$stmt->fetch(PDO::FETCH_ASSOC))
							{
					?>
								<tr>
											
									<td><?php echo $no; ?></td>
									<td><?php echo $row['order_name']; ?></td>
									<td><?php echo rupiah($row['order_price']); ?> </td>
									<td><?php echo $row['order_quantity']; ?></td>
									<td><?php echo rupiah($row['order_total']); ?> </td>
								</tr>
						<?php
								$no++;
								$grand_total +=$row['order_total'];
							}

						}
						?>
						<tr>
							<td colspan="2"><b>Grand Total</b></td>
							<td colspan="3"><b><?php echo rupiah($grand_total); ?></b></td>
						</tr>
				</tbody>
			</table>
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