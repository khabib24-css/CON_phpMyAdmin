<?php 
session_start();
if ( !isset($_SESSION["login"]) )//jika tidak ada session login maka kembalikan user ke halaman login.php
{
	header("location: login.php");
	exit;
}
require 'functions/functions.php';
// ambil dulu idnya

// variabel id dibawah ini guna untuk yang menangkap id dr url 
$id = $_GET["id"];
// 
	if ( hapus($id) > 0)//kalo fungsi hapus berhasil berarti ada baris yang berpengaruh
	{
		echo "
				<script>
					alert('yuhuuu data berhasil dihapus');
					document.location.href = 'index2.php';
					</script>
			";
	}else{
		echo "
				<script>
					alert('dadadada');
					document.location.href = 'index2.php';
					</script>
			";
	}

?>