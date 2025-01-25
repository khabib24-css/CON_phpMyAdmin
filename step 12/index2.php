<?php 
session_start();
if ( !isset($_SESSION["login"]) )//jika tidak ada session login maka kembalikan user ke halaman login.php
{
	header("location: login.php");
	exit;
}
require 'functions/functions.php';

$wadah = query("SELECT* FROM kaset");//query ini berfungsi mendapatkan seluruh data yang ada di dalam functions lalu hasilnya dimasukkan ke dalam variabel wadah

// jika nanti tombol cari diklik maka kita akan timpa $wadah dengan data $wadah  sesuai pencariannya
// jadi kita tentukan user mau cari apa

if ( isset($_POST["cari"]) ) //// jika tombol cari ditekan
{
	// maka kita akan cari data wadah sesuai dengan inputan user yang dimasukkan
	// data $wadah nanti akan ditimpa/diganti 
	$wadah = cari($_POST["input"]); //dengan artian $wadah akan berisikan data dari hasil pencarian (dari function cari), lalu function cari mendapatkan data dari apapun yang diketikkan oleh user 
}
// ketika tombol cari dipencet ambil apapun yang diketikkan user ($_POST["cari"]) masukkan ke function cari baru function cari jalan  
?>


<!DOCTYPE html>
<html>
<head>
	<meta>
	<meta>
	<title>ADMIN TOKO KASET</title>
	<style>
		.loader{
			width: 100px;
			position: absolute;
			top: 65px;
			left: 346px;
			z-index: -1;
			display: none;
		}
	</style>
</head>
<body>
	<a href="logout.php" >log out</a>
	<H2>DAFTAR KASET</H2>

	<form action="" method="post">
		<!-- method ini menetukan, apakah datanya akan tampil di url atau tidak kalo ingin datanya tampil gunakan (get)  kalo tidak gunakan (post)   -->
		<!-- reminder itu nanti akan berpengarug ke  variabel super global mana yang akan menangani datanya, kalo menggunakan (post) maka yang menanganinya adalah ($_POST) kalo (get) maka yang menanganinya adalah ($_GET) -->
		<input type="text" name="input" size="50" autofocus placeholder="Cari disini... " autocomplete="off" id="keyword">
		<!-- autofocus biar langsung tertuju pada searching -->
		<!-- placeholder ada tulisan contoh di lingkaran search -->
		<!-- autocomplete untuk menghapus histori biar ilang -->
		<button type="submit" name="cari" id="tombol-cari">Cari</button>

		<img src="img/load.gif" class="loader">


	</form> 
	<a href="tambah.php">TAMBAH</a>
	<div id="container">
	<table border="1" cellpaddin="10" cellspacing="0">
	<tr>
		<th>NO.</th>
		<th>AKSI</th>
		<th>GAMBAR</th>
		<th>JUDUL KASET</th>
	</tr>
	<?php $i = 1 ?>
	<?php foreach ($wadah as $baris) : ?>
	<tr>
		<td> <?= $i ?> </td>
		<td>
			<a href="ubah.php?id=<?= $baris["id"]; ?>">EDIT</a>
			<a href="hapus.php?id=<?= $baris["id"]; ?>" onclick="return confirm('SERIUS ?');">DELETE</a>
			<!-- ? berfungsi untuk mengirimkan data dan datanya adalah id -->
			<!--idnya diisi dengan id yang ada di tabel database  -->
		</td>
		<td><img src="img/<?= $baris["gambar"]; ?>" width="70"></td>
		<td><?= $baris["judulkaset"]; ?></td>
	</tr>
	<?php $i++ ?>
		<?php endforeach; ?>
	</table>
	</div>
	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/script.js">





	</script>
</body>
</html>