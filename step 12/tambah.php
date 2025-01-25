<?php 
session_start();
if ( !isset($_SESSION["login"]) )//jika tidak ada session login maka kembalikan user ke halaman login.php
{
	header("location: login.php");
	exit;
}
require 'functions/functions.php';

if( isset($_POST["submit"]) ) 
{
	// cek apakah data berhasil ditambahkan atau tidak
		if ( tambah($_POST) > 0) 
		{
			echo "
				<script>
					alert('yuhuuu data berhasil ditambahkan');
					document.location.href = 'index2.php';
					</script>
			";
		}else{
			echo "
				<script>
					alert('oooops data tidak berhasil ditambahkan');
					document.location.href = 'tambah.php';
					</script>
			";
		}
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>TAMBAH</title>
</head>
<body>
	<h1>Tambah Kaset</h1>
	
	<form action="" method="post" enctype="multipart/form-data">
		<!-- action dikosongkan agar menyimpan kehalamannya sendiri -->
		<ul>
			<li>
				<label for="gambar">GAMBAR</label>
				<input type="file" name="gambar" id="gambar">
			</li>
			<li>
				<label for="judulkaset">JUDUL KASET</label>
				<input type="text" name="judulkaset" id="judulkaset" required>
			</li>
			<li>
				<button type="submit" name="submit">Finish</button>
			</li>
		</ul>
	</form>
</body>
</html>

<!-- enctype="multipart/form-data": Ini berarti formulir ini dapat mengirimkan file, seperti gambar. Dalam kasus ini, pelanggan dapat mengunggah file gambar kaset yang ingin ditambahkan.

var_dump($_POST);
array(2) {
	["judulkaset"]=>
	string(7) "MASROOM"
	["submit"]=>
	string(0) ""
}
var_dump($_FILES);
	array(1) {
	["gambar"]=> (dimensi pertama adalah nama gambarnya) 
		array(5) {
		["name"]=> nama filenya 
		string(9) "jamur.jpg"
		["type"]=> tipenya
		string(10) "image/jpeg"
		["tmp_name"]=> tempat penyimpanan sementara
		string(24) "D:\xampp\tmp\php674D.tmp"
		["error"]=> nanti akan menghasilkan sebuah angka jika nilainya "0" itu artinya tidak ada error, jika lebih dari "0" maka ada eror tapi jikalau hasilnya itu "4" itu artinya adalah tidak ada file yang di upload 
		int(0)
		["size"]=> ukuran filenya
		int(63157)
}
}

