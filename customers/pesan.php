
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

	$stmt = $conn->prepare("SELECT * FROM items");
	$stmt->execute();

	$perhalaman = 8;
  	$jumlahdata = $stmt->rowCount();
  	$jumhalaman = ceil($jumlahdata / $perhalaman);
  	$halamanaktif = (isset($_GET["halaman"])) ? $_GET["halaman"] :1;
 	$awaldata = ($perhalaman * $halamanaktif) - $perhalaman;
  	$no=$awaldata + 1;


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
				<h5>Data Pesan</h5>
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
			<?php
				$stmt = $conn->prepare('SELECT * FROM items');
                $stmt->execute();
				while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){;?>
				    <div class="col s12 m3 l3">
						<div class="card">
							<div class="card-image waves-effect waves-light">
							<?php echo'	<img src="../gambar_barang/'.$row['item_image'].'" class="activator responsive-img" style="width:280px; height:280px" />'; ?>
							</div>
							<div class="card-content">
							<?php echo'	<span class="card-title activator">'.$row['item_name'].'<i class="material-icons right">keyboard_arrow_up</i></span>'; ?>
							</div>
							<div class="card-reveal">
							<?php echo'	<div class="card-title">'.$row['item_name'].'<i class="material-icons right">close</i></div>';?>
							<?php echo'<p> Harga '.rupiah($row['item_price']).'</p>';?>
							<?php echo '<a href="add_to_cart.php?id_item='.$row['item_id'].'" class="red accent-3 waves-effect waves-light btn-small btn">Pesan</a>' ?>
							</div>
						</div>
					</div>
				<?php };?>
		</div>

		<!-- Paging -->  
		<div class="row">
          <ul class="pagination white">
            <?php if( $halamanaktif > 1) : ?>
              <li class="waves-effect"><a href="pesan.php?halaman=<?php echo $halamanaktif - 1; ?>"><i class="material-icons">skip_previous</i></a></li>
            <?php endif; ?>

            <?php for( $i = 1; $i <= $jumhalaman; $i++) : ?>
                <?php if( $i == $halamanaktif) : ?>
                  <li class="active lime accent-2"><a href="pesan.php?halaman=<?php echo $i ?>"><?php echo $i; ?></a></li>
                <?php else : ?>
                  <li class="waves-effect"><a href="pesan.php?halaman=<?php echo $i ?>"><?php echo $i; ?></a></li>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if( $halamanaktif < $jumhalaman) : ?>
              <li class="waves-effect"><a href="pesan.php?halaman=<?php echo $halamanaktif + 1; ?>"><i class="material-icons">skip_next</i></a></li>
            <?php endif; ?>
          </ul>
		</div>
        <!-- Paging -->

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