
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
	
	if(isset($_GET['order_id']))
	{
		$stmt = $conn->prepare('DELETE FROM orderdetails WHERE order_id =:order_id');
		$stmt->bindParam(':order_id',$_GET['order_id']);
		$stmt->execute();
		header("location: belanja.php");
	}
	
	if(isset($_GET['order']))
	{
		$stmt = $conn->prepare('UPDATE orderdetails SET order_status="ordered" WHERE order_status="pending" AND user_id =:user_id');
		$stmt->bindParam(':user_id',$_GET['order']);
		$stmt->execute();
		echo "<script>alert('Item's successfully ordered !')</script>";
		header("location: checkout.php");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Data Belanja</title>
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
				<h5>Daftar Belanja</h5>
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
			<table class="responsive-table">
				<thead>
					<tr>
						<th>No</th>
						<th>Item</th>
						<th>Harga</th>
						<th>Jumlah</th>
						<th>Total</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						$grand_total=0;
						$user_id = $data_user['user_id'];
						$stmt = $conn->prepare("SELECT * FROM orderdetails WHERE order_status='pending' AND user_id='$user_id'");
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
									<td>
										<a class="btn-floating waves-effect waves-light red" href="?order_id=<?php echo $row['order_id']; ?>" onclick="return confirm('Apakah Anda Yakin?')"><i class="large material-icons">delete</i></a>
									</td>
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
							<td><a href="?order=<?php echo $user_id; ?>" class="btn waves-effect waves-light green" onclick=" return confirm('Pastikan pesanan anda sudah benar !')">order</a></td>
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