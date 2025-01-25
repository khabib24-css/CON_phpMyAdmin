<?php 
session_start();
if ( !isset($_SESSION["login"]) )//jika tidak ada session login maka kembalikan user ke halaman login.php
{
	header("location: login.php");
	exit;
}
require 'functions/functions.php';

// ambil data yang ada di url
$id = $_GET["id"];

// query data berdasarkan id
$datakaset = query("SELECT * FROM kaset WHERE id = $id")[0];
// var_dump($datakaset["judulkaset"]);
// cek apakah tombol submit sudah pernah dipencet apa belom
if( isset($_POST["submit"]) ) //artinya apakah $_post berarti (elemen yang ada didalam form dengan method post yang keynya submit)
{
	// cek apakah data berhasil diubah atau tidak
		if ( ubah($_POST) > 0) //fungsi tambah dengan parameternya adalah $_post(jadi data yang ada didalam form dengan method post dimasukkan kedalam tambah) nanti akan di tangkap oleh $data (jadi nanti data yang ada didalam $_post ditangkap oleh $data yang sebagai parameter)
		{
			echo "
				<script>
					alert('yuhuuu data berhasil diupdate');
					document.location.href = 'index2.php';
					</script>
			";
		}else{
			echo "
				<script>
					alert('oooops data tidak berhasil diupdate');
					document.location.href = 'index2.php';
					</script>
			";
		}
	
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>EDIT</title>
</head>
<body>
	<h1>Edit Kaset</h1>
	
	<form action="" method="post" enctype="multipart/form-data">
		<!-- action dikosongkan agar menyimpan kehalamannya sendiri -->
		<input type="hidden" name="id" value="<?= $datakaset["id"];?>">
		<input type="hidden" name="gambarLama" value="<?= $datakaset["gambar"];?>">
		<ul>
			<li>
				<label for="gambar">GAMBAR</label>
				<input type="file" name="gambar" id="gambar"> <br>
				<img src="img/<?= $datakaset['gambar'];?>" width="50"> <br>
			</li>
			<li>
				<label for="judulkaset">JUDUL KASET</label>
				<input type="text" name="judulkaset" id="judulkaset" required 
				value="<?= $datakaset["judulkaset"];?>">
			</li>
			<li>
				<button type="submit" name="submit">Finish</button>
			</li>
		</ul>
	</form>
</body>
</html>